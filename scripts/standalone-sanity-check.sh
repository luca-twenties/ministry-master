#!/usr/bin/env bash
set -euo pipefail

DATA_DIR=${CHURCHCRM_DATA_DIR:-/tmp/churchcrm-standalone-sanity}
DB_PATH=${CHURCHCRM_DB_NAME:-$DATA_DIR/churchcrm.sqlite}
HOST=${CHURCHCRM_HOST:-localhost}
PORT=${CHURCHCRM_PORT:-8081}

rm -rf "$DATA_DIR"
mkdir -p "$DATA_DIR"

CHURCHCRM_MODE=standalone \
CHURCHCRM_DB_DRIVER=sqlite \
CHURCHCRM_SQLITE_EXPERIMENTAL=1 \
CHURCHCRM_DB_NAME="$DB_PATH" \
CHURCHCRM_HOST="$HOST" \
CHURCHCRM_PORT="$PORT" \
CHURCHCRM_STANDALONE_ADMIN_USER=Admin \
CHURCHCRM_STANDALONE_ADMIN_PASSWORD=capt4ain \
CHURCHCRM_DATA_DIR="$DATA_DIR" \
php -S "$HOST:$PORT" -t src src/router.php >/tmp/churchcrm-standalone-sanity.log 2>&1 &

SERVER_PID=$!
cleanup() {
  kill "$SERVER_PID" >/dev/null 2>&1 || true
}
trap cleanup EXIT

attempts=20
until curl -fsS "http://$HOST:$PORT/api/public/doctor" >/dev/null 2>&1; do
  attempts=$((attempts - 1))
  if [ "$attempts" -le 0 ]; then
    echo "doctor endpoint not ready"
    exit 1
  fi
  sleep 0.5
done

if [ ! -s "$DB_PATH" ]; then
  echo "sqlite db file missing or empty: $DB_PATH"
  exit 1
fi

tables=$(sqlite3 "$DB_PATH" ".tables" || true)
if [ -z "$tables" ]; then
  echo "sqlite db has no tables"
  exit 1
fi

echo "ok: sqlite db has tables"
echo "ok: doctor endpoint reachable"
