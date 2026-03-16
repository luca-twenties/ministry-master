
DROP TABLE IF EXISTS `kioskdevice_kdev`;
CREATE TABLE `kioskdevice_kdev` (
  `kdev_ID` INTEGER PRIMARY KEY AUTOINCREMENT,
  `kdev_GUIDHash` char(64) DEFAULT NULL,
  `kdev_Name` varchar(50) DEFAULT NULL,
  `kdev_deviceType` INTEGER NOT NULL DEFAULT 0,
  `kdev_lastHeartbeat` TIMESTAMP,
  `kdev_Accepted` BOOLEAN,
  `kdev_PendingCommands` varchar(50)
);

DROP TABLE IF EXISTS `kioskassginment_kasm`;
CREATE TABLE `kioskassginment_kasm` (
  `kasm_ID` INTEGER PRIMARY KEY AUTOINCREMENT,
  `kasm_kdevId` INTEGER DEFAULT NULL,
  `kasm_AssignmentType` INTEGER DEFAULT NULL,
  `kasm_EventId` INTEGER DEFAULT 0
);

ALTER TABLE events_event ADD COLUMN event_grpid INTEGER;
ALTER TABLE event_types ADD COLUMN type_grpid INTEGER;

-- SQLite does not support CHANGE COLUMN; keep as-is.

/** This remove default values if it was set so that we can remove if checks  */
delete from config_cfg WHERE cfg_name = 'sToEmailAddress' and cfg_value = 'myReceiveEmailAddress';

/** strings **/
update config_cfg set cfg_name = 'sGoogleTrackingID' where cfg_name = 'googleTrackingID';
update config_cfg set cfg_name = 'sMailChimpApiKey' where cfg_name = 'mailChimpApiKey';

/** Boolean */
update config_cfg set cfg_name = 'bEnableSelfRegistration' where cfg_name = 'sEnableSelfRegistration';
update config_cfg set cfg_name = 'bForceUppercaseZip' where cfg_name = 'cfgForceUppercaseZip';
update config_cfg set cfg_name = 'bDebug' where cfg_name = 'debug';
update config_cfg set cfg_name = 'bSMTPAuth' where cfg_name = 'sSMTPAuth';
update config_cfg set cfg_name = 'bEnableGravatarPhotos' where cfg_name = 'sEnableGravatarPhotos';
update config_cfg set cfg_name = 'bEnableExternalBackupTarget' where cfg_name = 'sEnableExternalBackupTarget';
update config_cfg set cfg_name = 'bEnableIntegrityCheck' where cfg_name = 'sEnableIntegrityCheck';

/** int **/
update config_cfg set cfg_name = 'iMinPasswordLength' where cfg_name = 'sMinPasswordLength';
update config_cfg set cfg_name = 'iMinPasswordChange' where cfg_name = 'sMinPasswordChange';
update config_cfg set cfg_name = 'iSessionTimeout' where cfg_name = 'sSessionTimeout';
update config_cfg set cfg_name = 'iIntegrityCheckInterval' where cfg_name = 'sIntegrityCheckInterval';
update config_cfg set cfg_name = 'iChurchLatitude' where cfg_name = 'nChurchLatitude';
update config_cfg set cfg_name = 'iChurchLongitude' where cfg_name = 'nChurchLongitude';

/** array **/
update config_cfg set cfg_name = 'aDisallowedPasswords' where cfg_name = 'sDisallowedPasswords';
