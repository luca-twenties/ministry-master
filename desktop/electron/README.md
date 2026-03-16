# Desktop Shell (Electron)

This is a minimal Electron shell that starts a local PHP server and loads the ChurchCRM UI.
It is a Phase 4 scaffold and keeps all runtime changes isolated from the core app.

## Requirements

- Node.js (already required by the repo)
- PHP installed locally (for now)

## Run (dev)

From `desktop/electron`:

```
npm install
npm run dev
```

By default, this uses the system `php` binary.

## Package

1. Place PHP binaries in `desktop/electron/php/` per `php/README.md`.
2. From `desktop/electron`:

```
npm install
cd ../../src
composer install --no-dev --no-interaction --prefer-dist
cd ../desktop/electron
npm install
npm run dist
```

Artifacts will be in `desktop/electron/dist/`.

## Environment variables

- `CHURCHCRM_PHP_BIN` Path to PHP binary (if not on PATH)
- `CHURCHCRM_DATA_DIR` Override data directory (defaults to Electron userData)
- `CHURCHCRM_DB_NAME` Override SQLite file path

## Notes

- The app binds only to `127.0.0.1`.
- The server is considered "ready" when `/api/public/doctor` returns 200.
- This will evolve to embed platform PHP binaries and produce installers.
