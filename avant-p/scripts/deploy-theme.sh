#!/usr/bin/env bash
set -euo pipefail

THEME_NAME="${THEME_NAME:-avan-p}"
REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SOURCE_DIR="${REPO_ROOT}/app/public/wp-content/themes/${THEME_NAME}"
WP_ROOT="${WP_ROOT:-}"

if [[ -z "${WP_ROOT}" ]]; then
  echo "Error: WP_ROOT is required."
  echo "Example: WP_ROOT=/home/USER/public_html ./scripts/deploy-theme.sh"
  exit 1
fi

if [[ ! -d "${SOURCE_DIR}" ]]; then
  echo "Error: theme source not found: ${SOURCE_DIR}"
  exit 1
fi

if [[ ! -d "${WP_ROOT}/wp-content/themes" ]]; then
  echo "Error: WordPress themes directory not found: ${WP_ROOT}/wp-content/themes"
  exit 1
fi

DEST_DIR="${WP_ROOT}/wp-content/themes/${THEME_NAME}"

mkdir -p "${DEST_DIR}"
rsync -az --delete \
  --exclude=".DS_Store" \
  --exclude="node_modules/" \
  --exclude=".git/" \
  "${SOURCE_DIR}/" "${DEST_DIR}/"

echo "Deployed ${THEME_NAME} to ${DEST_DIR}"
