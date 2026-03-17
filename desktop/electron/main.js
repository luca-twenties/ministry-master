const { app, BrowserWindow, ipcMain } = require("electron");
const { spawn, spawnSync } = require("child_process");
const crypto = require("crypto");
const fs = require("fs");
const http = require("http");
const net = require("net");
const path = require("path");

const DEV_APP_ROOT = path.resolve(__dirname, "..", "..");
const HOST = "127.0.0.1";
const STARTUP_TIMEOUT_MS = 20_000;

let phpProcess = null;
let pendingAppUrl = null;
let firstRunWindow = null;

function getPhpBinary() {
  if (process.env.CHURCHCRM_PHP_BIN) {
    return process.env.CHURCHCRM_PHP_BIN;
  }

  if (app.isPackaged) {
    const platform = process.platform;
    const arch = process.arch;
    const binName = platform === "win32" ? "php.exe" : "php";
    const bundledDir = `${platform}-${arch}`;
    const bundled = path.join(process.resourcesPath, "php", bundledDir, binName);
    return bundled;
  }

  return "php";
}

function getDataDir() {
  return process.env.CHURCHCRM_DATA_DIR || app.getPath("userData");
}

function getStandaloneAdminFilePath() {
  return path.join(getDataDir(), "standalone-admin.json");
}

function ensureStandaloneAdminCredentials() {
  const filePath = getStandaloneAdminFilePath();
  if (fs.existsSync(filePath)) {
    return { firstRun: false, credentials: JSON.parse(fs.readFileSync(filePath, "utf8")) };
  }

  const credentials = {
    username: "Admin",
    password: crypto.randomBytes(9).toString("base64url"),
    createdAt: new Date().toISOString(),
  };

  fs.mkdirSync(getDataDir(), { recursive: true });
  fs.writeFileSync(filePath, JSON.stringify(credentials, null, 2), "utf8");
  return { firstRun: true, credentials };
}

function getAppRoot() {
  if (app.isPackaged) {
    return path.join(process.resourcesPath, "app");
  }
  return DEV_APP_ROOT;
}

function logMissingPhpExtensions(message) {
  const logLine = `[startup] ${new Date().toISOString()} ${message}`;
  console.error(logLine);

  try {
    const logPath = path.join(getDataDir(), "startup.log");
    fs.appendFileSync(logPath, `${logLine}\n`, "utf8");
  } catch (error) {
    console.error(`[startup] Failed to write startup log: ${error.message}`);
  }
}

function showErrorDialog(title, message) {
  const { dialog } = require("electron");
  dialog.showErrorBox(title, message);
}

function verifyPhpExtensions() {
  const required = [
    "gettext",
    "mbstring",
    "intl",
    "pdo",
    "pdo_sqlite",
    "sqlite3",
    "session",
    "filter",
    "curl",
    "gd",
    "zip",
    "openssl",
  ];

  const result = spawnSync(getPhpBinary(), ["-m"], { encoding: "utf8" });
  if (result.status !== 0 || !result.stdout) {
    const message = "Failed to read PHP extensions. Ensure the bundled PHP binary is executable.";
    logMissingPhpExtensions(message);
    throw new Error(message);
  }

  const available = new Set(
    result.stdout
      .split(/\r?\n/)
      .map((line) => line.trim().toLowerCase())
      .filter(Boolean)
  );

  const missing = required.filter((ext) => !available.has(ext));
  if (missing.length > 0) {
    const message = `Bundled PHP is missing extensions: ${missing.join(", ")}`;
    logMissingPhpExtensions(message);
    throw new Error(message);
  }
}

function pickFreePort() {
  return new Promise((resolve, reject) => {
    const server = net.createServer();
    server.unref();
    server.on("error", reject);
    server.listen(0, HOST, () => {
      const { port } = server.address();
      server.close(() => resolve(port));
    });
  });
}

function waitForDoctor(port) {
  const start = Date.now();
  const url = `http://${HOST}:${port}/api/public/doctor`;

  return new Promise((resolve, reject) => {
    const attempt = () => {
      const req = http.get(url, (res) => {
        res.resume();
        if (res.statusCode === 200) {
          resolve();
        } else {
          retry();
        }
      });

      req.on("error", retry);
    };

    const retry = () => {
      if (Date.now() - start > STARTUP_TIMEOUT_MS) {
        reject(new Error("Doctor endpoint did not become ready in time."));
        return;
      }
      setTimeout(attempt, 300);
    };

    attempt();
  });
}

async function startPhpServer(credentials) {
  const port = await pickFreePort();
  const dataDir = getDataDir();
  const dbPath = process.env.CHURCHCRM_DB_NAME || path.join(dataDir, "churchcrm.sqlite");
  const appRoot = getAppRoot();

  verifyPhpExtensions();

  const env = {
    ...process.env,
    CHURCHCRM_MODE: "standalone",
    CHURCHCRM_DB_DRIVER: "sqlite",
    CHURCHCRM_SQLITE_EXPERIMENTAL: "1",
    CHURCHCRM_DB_NAME: dbPath,
    CHURCHCRM_DATA_DIR: dataDir,
    CHURCHCRM_HOST: HOST,
    CHURCHCRM_PORT: String(port),
    CHURCHCRM_STANDALONE_ADMIN_USER: credentials.username,
    CHURCHCRM_STANDALONE_ADMIN_PASSWORD: credentials.password,
  };

  phpProcess = spawn(getPhpBinary(), ["-S", `${HOST}:${port}`, "-t", path.join(appRoot, "src"), path.join(appRoot, "src", "router.php")], {
    cwd: appRoot,
    env,
    stdio: "ignore",
  });

  phpProcess.on("exit", (code) => {
    if (code !== 0) {
      // Non-zero exit likely indicates PHP missing or crashed.
      // The app will fail to load if the server dies.
      // We keep this silent to avoid blocking Electron startup.
    }
  });

  await waitForDoctor(port);
  return port;
}

async function createWindow() {
  try {
    const { firstRun, credentials } = ensureStandaloneAdminCredentials();
    const port = await startPhpServer(credentials);
    const appUrl = `http://${HOST}:${port}/`;

    const win = new BrowserWindow({
      width: 1280,
      height: 800,
      webPreferences: {
        contextIsolation: true,
        nodeIntegration: false,
        preload: path.join(__dirname, "preload.js"),
      },
    });

    if (firstRun) {
      pendingAppUrl = appUrl;
      firstRunWindow = win;
      await win.loadFile(path.join(__dirname, "first-run.html"), {
        query: {
          username: credentials.username,
          password: credentials.password,
          dataDir: getDataDir(),
        },
      });
    } else {
      await win.loadURL(appUrl);
    }
  } catch (error) {
    logMissingPhpExtensions(`Failed to start application: ${error.message}`);
    showErrorDialog("Ministry Master - Startup Failed", 
      `Failed to start Ministry Master:\n\n${error.message}\n\n` +
      `Check the startup log at:\n${path.join(getDataDir(), "startup.log")}\n\n` +
      `Common fixes:\n` +
      `• Ensure all PHP extensions are available\n` +
      `• Check antivirus isn't blocking the app\n` +
      `• Run as administrator if needed`);
    app.quit();
  }
}

app.whenReady().then(createWindow);

app.on("window-all-closed", () => {
  if (phpProcess) {
    phpProcess.kill();
    phpProcess = null;
  }
  if (process.platform !== "darwin") {
    app.quit();
  }
});

app.on("before-quit", () => {
  if (phpProcess) {
    phpProcess.kill();
    phpProcess = null;
  }
});

ipcMain.handle("standalone-first-run:continue", async () => {
  if (!firstRunWindow || !pendingAppUrl) {
    return;
  }
  await firstRunWindow.loadURL(pendingAppUrl);
  firstRunWindow = null;
  pendingAppUrl = null;
});
