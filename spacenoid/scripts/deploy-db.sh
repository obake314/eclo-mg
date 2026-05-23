#!/usr/bin/env bash
set -euo pipefail

SITE_NAME="spacenoid"
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOCAL_WP_ROOT="${LOCAL_WP_ROOT:-${REPO_ROOT}/app/public}"
LOCAL_DB_SOCKET="${LOCAL_DB_SOCKET:-}"

SSH_HOST="${SPACENOID_SSH_HOST:-${SSH_HOST:-}}"
SSH_USER="${SPACENOID_SSH_USER:-${SSH_USER:-}}"
SSH_PORT="${SPACENOID_SSH_PORT:-${SSH_PORT:-2222}}"
SSH_KEY="${SPACENOID_SSH_KEY:-${SSH_KEY:-}}"
SSH_KEY_FILE="${SPACENOID_SSH_KEY_FILE:-${SSH_KEY_FILE:-}}"
WP_ROOT="${SPACENOID_WP_ROOT:-${WP_ROOT:-}}"
PROD_URL="${SPACENOID_PROD_URL:-${PROD_URL:-}}"
LOCAL_URL="${SPACENOID_LOCAL_URL:-${LOCAL_URL:-}}"
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
  echo "Error: SPACENOID_SSH_KEY_FILE or SPACENOID_SSH_KEY is required."
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

if [[ -z "${LOCAL_DB_SOCKET}" && -f "${HOME}/Library/Application Support/Local/sites.json" ]] && command -v node >/dev/null 2>&1; then
  LOCAL_DB_SOCKET="$(
    node - "${REPO_ROOT}" "${HOME}" <<'NODE'
const fs = require('fs');
const path = require('path');
const repoRoot = path.resolve(process.argv[2]);
const home = process.argv[3];
const sitesPath = path.join(home, 'Library/Application Support/Local/sites.json');
const sites = JSON.parse(fs.readFileSync(sitesPath, 'utf8'));
for (const [id, site] of Object.entries(sites)) {
  const sitePath = path.resolve(site.path.replace(/^~/, home));
  if (sitePath === repoRoot) {
    const socketPath = path.join(home, 'Library/Application Support/Local/run', id, 'mysql/mysqld.sock');
    if (fs.existsSync(socketPath)) {
      process.stdout.write(socketPath);
    }
    break;
  }
}
NODE
  )"
fi

WP_BIN="$(command -v wp)"
WP_CMD=(php -d error_reporting=8191 -d display_errors=stderr "${WP_BIN}")
if [[ -n "${LOCAL_DB_SOCKET}" ]]; then
  if [[ ! -S "${LOCAL_DB_SOCKET}" ]]; then
    echo "Error: Local DB socket not found: ${LOCAL_DB_SOCKET}"
    echo "Start this site in Local, then retry."
    exit 1
  fi
  WP_CMD=(php -d error_reporting=8191 -d display_errors=stderr -d "mysqli.default_socket=${LOCAL_DB_SOCKET}" -d "pdo_mysql.default_socket=${LOCAL_DB_SOCKET}" "${WP_BIN}")
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
SCP_OPTS=(
  -o BatchMode=yes
  -o ConnectTimeout=20
  -o ServerAliveInterval=15
  -i "${KEY_FILE}"
  -P "${SSH_PORT}"
)

if [[ -z "${LOCAL_URL}" ]]; then
  LOCAL_URL="$("${WP_CMD[@]}" --path="${LOCAL_WP_ROOT}" option get home --skip-plugins --skip-themes 2>/dev/null || true)"
fi

if [[ -z "${LOCAL_URL}" ]]; then
  echo "Error: could not determine local URL. Set SPACENOID_LOCAL_URL."
  exit 1
fi

LOCAL_TABLE_PREFIX="$("${WP_CMD[@]}" --path="${LOCAL_WP_ROOT}" db prefix --skip-plugins --skip-themes 2>/dev/null || true)"
if [[ -z "${LOCAL_TABLE_PREFIX}" ]]; then
  echo "Error: could not determine local table prefix."
  exit 1
fi

STAMP="$(date +%Y%m%d%H%M%S)"
LOCAL_SQL="${TMP_DIR}/${SITE_NAME}-db-${STAMP}.sql"
LOCAL_SQL_GZ="${LOCAL_SQL}.gz"
REMOTE_SQL_GZ="/tmp/${SITE_NAME}-db-${STAMP}.sql.gz"

echo "Exporting local database with URL replacement:"
echo "  ${LOCAL_URL} -> ${PROD_URL}"
"${WP_CMD[@]}" --path="${LOCAL_WP_ROOT}" search-replace "${LOCAL_URL}" "${PROD_URL}" \
  --all-tables-with-prefix \
  --precise \
  --recurse-objects \
  --skip-columns=guid \
  --export="${LOCAL_SQL}" \
  --skip-plugins \
  --skip-themes

gzip -9 "${LOCAL_SQL}"

echo "Uploading database dump to ${SSH_HOST}:${REMOTE_SQL_GZ}"
scp "${SCP_OPTS[@]}" "${LOCAL_SQL_GZ}" "${SSH_USER}@${SSH_HOST}:${REMOTE_SQL_GZ}"

echo "Importing database on production. A backup will be created first."
ssh "${SSH_OPTS[@]}" "${SSH_USER}@${SSH_HOST}" bash -s -- "${WP_ROOT}" "${REMOTE_SQL_GZ}" "${PROD_URL}" "${LOCAL_TABLE_PREFIX}" <<'REMOTE_SCRIPT'
set -euo pipefail

WP_ROOT="$1"
REMOTE_SQL_GZ="$2"
PROD_URL="$3"
LOCAL_TABLE_PREFIX="$4"
STAMP="$(date +%Y%m%d%H%M%S)"
BACKUP_DIR="${WP_ROOT}/wp-content/db-backups"
BACKUP_SQL="${BACKUP_DIR}/pre-db-deploy-${STAMP}.sql"
BACKUP_CONFIG="${BACKUP_DIR}/pre-db-deploy-${STAMP}-wp-config.php"
IMPORT_SQL="/tmp/import-db-${STAMP}.sql"

if [[ ! -f "${WP_ROOT}/wp-config.php" ]]; then
  echo "Remote wp-config.php not found: ${WP_ROOT}/wp-config.php"
  exit 1
fi

mkdir -p "${BACKUP_DIR}"
cp "${WP_ROOT}/wp-config.php" "${BACKUP_CONFIG}"

PHP_BIN="$(command -v php || true)"
if [[ -z "${PHP_BIN}" ]]; then
  for candidate in /usr/local/bin/php8.5 /usr/local/bin/php8.4 /usr/local/bin/php8.3 /usr/local/bin/php8.2 /usr/local/bin/php8.1 /usr/local/bin/php8.0 /usr/bin/php; do
    if [[ -x "${candidate}" ]]; then
      PHP_BIN="${candidate}"
      break
    fi
  done
fi
if [[ -z "${PHP_BIN}" ]]; then
  echo "Could not find php command on remote server."
  exit 1
fi

update_table_prefix() {
  local config_file="$1"
  local prefix="$2"
  local prefix_updater="/tmp/update-wp-prefix-${STAMP}.php"
  local original_mode=""

  original_mode="$(stat -c '%a' "${config_file}" 2>/dev/null || true)"
  chmod u+w "${config_file}"

  cat > "${prefix_updater}" <<'PHP'
<?php
$file = $argv[1];
$prefix = $argv[2];
$config = file_get_contents($file);
$quoted = var_export($prefix, true);
$count = 0;
$config = preg_replace('/\$table_prefix\s*=\s*[\'"][^\'"]*[\'"]\s*;/', '$table_prefix = ' . $quoted . ';', $config, 1, $count);
if ($count !== 1) {
    fwrite(STDERR, "Could not update table_prefix in wp-config.php\n");
    exit(1);
}
if (file_put_contents($file, $config) === false) {
    fwrite(STDERR, "Could not write wp-config.php\n");
    exit(1);
}
PHP

  "${PHP_BIN}" "${prefix_updater}" "${config_file}" "${prefix}"
  rm -f "${prefix_updater}"
  if [[ -n "${original_mode}" ]]; then
    chmod "${original_mode}" "${config_file}" || true
  fi
}

if command -v wp >/dev/null 2>&1; then
  wp --path="${WP_ROOT}" db export "${BACKUP_SQL}" --quiet
  gunzip -c "${REMOTE_SQL_GZ}" > "${IMPORT_SQL}"
  wp --path="${WP_ROOT}" db import "${IMPORT_SQL}" --quiet
  update_table_prefix "${WP_ROOT}/wp-config.php" "${LOCAL_TABLE_PREFIX}"
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
    echo $key . "='" . str_replace("'", "'\"'\"'", $matches[1]) . "'\n";
}
PHP
  "${PHP_BIN}" "${CONFIG_READER}" "${WP_ROOT}/wp-config.php" > /tmp/wp-db-env-${STAMP}
  rm -f "${CONFIG_READER}"

  # shellcheck disable=SC1090
  source /tmp/wp-db-env-${STAMP}

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
  update_table_prefix "${WP_ROOT}/wp-config.php" "${LOCAL_TABLE_PREFIX}"

  rm -f /tmp/wp-db-env-${STAMP}
fi

rm -f "${REMOTE_SQL_GZ}" "${IMPORT_SQL}"

echo "Imported database."
echo "Backup: ${BACKUP_SQL}"
echo "Config backup: ${BACKUP_CONFIG}"
REMOTE_SCRIPT

echo "Database deploy completed."
