#!/usr/bin/env bash
set -euo pipefail

SITE_NAME="avant-p"
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_WP_ROOT="${LOCAL_WP_ROOT:-${REPO_ROOT}/app/public}"

SSH_HOST="${AVANT_P_SSH_HOST:-${SSH_HOST:-}}"
SSH_USER="${AVANT_P_SSH_USER:-${SSH_USER:-}}"
SSH_PORT="${AVANT_P_SSH_PORT:-${SSH_PORT:-22}}"
SSH_KEY="${AVANT_P_SSH_KEY:-${SSH_KEY:-}}"
SSH_KEY_FILE="${AVANT_P_SSH_KEY_FILE:-${SSH_KEY_FILE:-}}"
WP_ROOT="${AVANT_P_WP_ROOT:-${WP_ROOT:-}}"
PROD_URL="${AVANT_P_PROD_URL:-${PROD_URL:-}}"
LOCAL_URL="${AVANT_P_LOCAL_URL:-${LOCAL_URL:-}}"
CONFIRM="${CONFIRM_DB_DEPLOY:-}"

required=(
  "SSH_HOST"
  "SSH_USER"
  "WP_ROOT"
  "PROD_URL"
)

for name in "${required[@]}"; do
  if [[ -z "${!name}" ]]; then
    echo "Error: ${name} is required."
    exit 1
  fi
done

if [[ -z "${SSH_KEY_FILE}" && -z "${SSH_KEY}" ]]; then
  echo "Error: AVANT_P_SSH_KEY_FILE or AVANT_P_SSH_KEY is required."
  exit 1
fi

if [[ "${CONFIRM}" != "deploy-${SITE_NAME}-db" ]]; then
  echo "Error: this overwrites the production database."
  echo "Set CONFIRM_DB_DEPLOY=deploy-${SITE_NAME}-db to continue."
  exit 1
fi

if ! command -v wp >/dev/null 2>&1; then
  echo "Error: wp-cli is required locally."
  exit 1
fi

if [[ ! -f "${LOCAL_WP_ROOT}/wp-config.php" ]]; then
  echo "Error: local WordPress root not found: ${LOCAL_WP_ROOT}"
  exit 1
fi

TMP_DIR="$(mktemp -d)"
trap 'rm -rf "${TMP_DIR}"' EXIT

KEY_FILE="${SSH_KEY_FILE}"
if [[ -z "${KEY_FILE}" ]]; then
  KEY_FILE="${TMP_DIR}/deploy_key"
  printf '%s\n' "${SSH_KEY}" > "${KEY_FILE}"
  chmod 600 "${KEY_FILE}"
fi

SSH_OPTS=(
  -o BatchMode=yes
  -o ConnectTimeout=20
  -o ServerAliveInterval=15
  -i "${KEY_FILE}"
  -p "${SSH_PORT}"
)

if [[ -z "${LOCAL_URL}" ]]; then
  LOCAL_URL="$(wp --path="${LOCAL_WP_ROOT}" option get home --skip-plugins --skip-themes 2>/dev/null || true)"
fi

if [[ -z "${LOCAL_URL}" ]]; then
  echo "Error: could not determine local URL. Set AVANT_P_LOCAL_URL."
  exit 1
fi

STAMP="$(date +%Y%m%d%H%M%S)"
LOCAL_SQL="${TMP_DIR}/${SITE_NAME}-db-${STAMP}.sql"
LOCAL_SQL_GZ="${LOCAL_SQL}.gz"
REMOTE_SQL_GZ="/tmp/${SITE_NAME}-db-${STAMP}.sql.gz"

echo "Exporting local database with URL replacement:"
echo "  ${LOCAL_URL} -> ${PROD_URL}"
wp --path="${LOCAL_WP_ROOT}" search-replace "${LOCAL_URL}" "${PROD_URL}" \
  --all-tables-with-prefix \
  --precise \
  --recurse-objects \
  --skip-columns=guid \
  --export="${LOCAL_SQL}" \
  --skip-plugins \
  --skip-themes

gzip -9 "${LOCAL_SQL}"

echo "Uploading database dump to ${SSH_HOST}:${REMOTE_SQL_GZ}"
scp "${SSH_OPTS[@]}" "${LOCAL_SQL_GZ}" "${SSH_USER}@${SSH_HOST}:${REMOTE_SQL_GZ}"

echo "Importing database on production. A backup will be created first."
ssh "${SSH_OPTS[@]}" "${SSH_USER}@${SSH_HOST}" bash -s -- "${WP_ROOT}" "${REMOTE_SQL_GZ}" "${PROD_URL}" <<'REMOTE_SCRIPT'
set -euo pipefail

WP_ROOT="$1"
REMOTE_SQL_GZ="$2"
PROD_URL="$3"
STAMP="$(date +%Y%m%d%H%M%S)"
BACKUP_DIR="${WP_ROOT}/wp-content/db-backups"
BACKUP_SQL="${BACKUP_DIR}/pre-db-deploy-${STAMP}.sql"
IMPORT_SQL="/tmp/import-db-${STAMP}.sql"

if [[ ! -f "${WP_ROOT}/wp-config.php" ]]; then
  echo "Remote wp-config.php not found: ${WP_ROOT}/wp-config.php"
  exit 1
fi

mkdir -p "${BACKUP_DIR}"

if command -v wp >/dev/null 2>&1; then
  wp --path="${WP_ROOT}" db export "${BACKUP_SQL}" --quiet
  gunzip -c "${REMOTE_SQL_GZ}" > "${IMPORT_SQL}"
  wp --path="${WP_ROOT}" db import "${IMPORT_SQL}" --quiet
  wp --path="${WP_ROOT}" option update home "${PROD_URL}" --quiet
  wp --path="${WP_ROOT}" option update siteurl "${PROD_URL}" --quiet
  wp --path="${WP_ROOT}" cache flush >/dev/null 2>&1 || true
else
  CONFIG_READER="/tmp/read-wp-config-${STAMP}.php"
  cat > "${CONFIG_READER}" <<'PHP'
<?php
$config = file_get_contents($argv[1]);
foreach (["DB_NAME", "DB_USER", "DB_PASSWORD", "DB_HOST"] as $key) {
    $pattern = "/define\s*\(\s*['\"]" . preg_quote($key, "/") . "['\"]\s*,\s*['\"](.*?)['\"]\s*\)\s*;/";
    if (!preg_match($pattern, $config, $matches)) {
        fwrite(STDERR, "Could not read {$key} from wp-config.php\n");
        exit(1);
    }
    echo $key . "=" . base64_encode($matches[1]) . "\n";
}
PHP
  php "${CONFIG_READER}" "${WP_ROOT}/wp-config.php" > /tmp/wp-db-env-${STAMP}
  rm -f "${CONFIG_READER}"

  # shellcheck disable=SC1090
  source /tmp/wp-db-env-${STAMP}
  DB_NAME="$(printf '%s' "${DB_NAME}" | base64 --decode)"
  DB_USER="$(printf '%s' "${DB_USER}" | base64 --decode)"
  DB_PASSWORD="$(printf '%s' "${DB_PASSWORD}" | base64 --decode)"
  DB_HOST="$(printf '%s' "${DB_HOST}" | base64 --decode)"

  MYSQL_PWD="${DB_PASSWORD}" mysqldump \
    --default-character-set=utf8mb4 \
    --single-transaction \
    -h "${DB_HOST}" \
    -u "${DB_USER}" \
    "${DB_NAME}" > "${BACKUP_SQL}"

  gunzip -c "${REMOTE_SQL_GZ}" > "${IMPORT_SQL}"
  MYSQL_PWD="${DB_PASSWORD}" mysql \
    --default-character-set=utf8mb4 \
    -h "${DB_HOST}" \
    -u "${DB_USER}" \
    "${DB_NAME}" < "${IMPORT_SQL}"

  rm -f /tmp/wp-db-env-${STAMP}
fi

rm -f "${REMOTE_SQL_GZ}" "${IMPORT_SQL}"

echo "Imported database."
echo "Backup: ${BACKUP_SQL}"
REMOTE_SCRIPT

echo "Database deploy completed."
