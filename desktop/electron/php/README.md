# Bundled PHP Layout

Place platform PHP binaries here before packaging, split by OS and arch:

```
desktop/electron/php/
  linux-x64/php
  linux-arm64/php
  darwin-x64/php
  darwin-arm64/php
  win32-x64/php.exe
  win32-arm64/php.exe
```

The Electron launcher will prefer these when packaged. In dev it uses `php` from PATH.
