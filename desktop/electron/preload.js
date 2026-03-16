const { contextBridge, ipcRenderer } = require("electron");

contextBridge.exposeInMainWorld("standalone", {
  continueToApp: () => ipcRenderer.invoke("standalone-first-run:continue"),
});
