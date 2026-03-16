ALTER TABLE events_event ADD COLUMN location_id INTEGER DEFAULT NULL;
ALTER TABLE events_event ADD COLUMN primary_contact_person_id INTEGER DEFAULT NULL;
ALTER TABLE events_event ADD COLUMN secondary_contact_person_id INTEGER DEFAULT NULL;
ALTER TABLE events_event ADD COLUMN event_url text DEFAULT NULL;

DROP TABLE IF EXISTS `event_audience`;
# This is a join-table to link an event with a prospective audience for the purpose of advertising / outreach.
CREATE TABLE `event_audience` (
  `event_id` INTEGER NOT NULL,
  `group_id` INTEGER NOT NULL,
  PRIMARY KEY (`event_id`,`group_id`)
);

DROP TABLE IF EXISTS `calendars`;
CREATE TABLE `calendars` (
  `calendar_id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` VARCHAR(128) NOT NULL,
  `accesstoken` VARCHAR(255),
  `foregroundColor` VARCHAR(6),
  `backgroundColor` VARCHAR(6),
  UNIQUE (`accesstoken`)
);

DROP TABLE IF EXISTS `calendar_events`;
# This is a join-table to link an event with a calendar
CREATE TABLE `calendar_events` (
  `calendar_id` INTEGER NOT NULL,
  `event_id` INTEGER NOT NULL,
  PRIMARY KEY (`calendar_id`,`event_id`)
);

DROP TABLE IF EXISTS `locations`;
ALTER TABLE church_location RENAME TO locations;

ALTER TABLE user_usr
  ADD COLUMN usr_apiKey VARCHAR(255);
CREATE UNIQUE INDEX IF NOT EXISTS usr_apiKey_unique ON user_usr(usr_apiKey);

DROP TABLE IF EXISTS menuconfig_mcf;

DROP TABLE IF EXISTS `menu_links`;
CREATE TABLE `menu_links` (
  `linkId` INTEGER PRIMARY KEY AUTOINCREMENT,
  `linkName` varchar(50) DEFAULT NULL,
  `linkUri` text NOT NULL,
  `linkOrder` INTEGER NOT NULL
);
