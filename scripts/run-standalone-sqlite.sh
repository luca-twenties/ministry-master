#!/usr/bin/env bash
set -euo pipefail

DATA_DIR=${CHURCHCRM_DATA_DIR:-$HOME/.local/share/ministry-master}
DB_PATH=${CHURCHCRM_DB_NAME:-$DATA_DIR/churchcrm.sqlite}
HOST=${CHURCHCRM_HOST:-localhost}
PORT=${CHURCHCRM_PORT:-8080}

if [ "${CHURCHCRM_RESET:-}" = "1" ]; then
  rm -rf "$DATA_DIR"
fi

mkdir -p "$DATA_DIR"

CHURCHCRM_MODE=standalone \
CHURCHCRM_DB_DRIVER=sqlite \
CHURCHCRM_SQLITE_EXPERIMENTAL=1 \
CHURCHCRM_DB_USER=sqlite \
CHURCHCRM_DB_PASS=sqlite \
CHURCHCRM_DB_NAME="$DB_PATH" \
CHURCHCRM_STANDALONE_ADMIN_USER=Admin \
CHURCHCRM_STANDALONE_ADMIN_PASSWORD=capt4ain \
CHURCHCRM_DATA_DIR="$DATA_DIR" \
php -S "$HOST:$PORT" -t src src/router.php
