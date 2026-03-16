

-- --NOTE-- removed in 4.4.0 so commenting out --
ALTER TABLE person_per ADD COLUMN per_Twitter varchar(50) default NULL;
ALTER TABLE person_per ADD COLUMN per_LinkedIn varchar(50) default NULL;

ALTER TABLE person_custom_master
  ADD PRIMARY KEY (custom_Field);

UPDATE menuconfig_mcf
  SET security_grp = 'bAddEvent'
  WHERE name = 'addevent';

DROP TABLE IF EXISTS `church_location`;
CREATE TABLE `church_location` (
  `location_id` INTEGER NOT NULL,
  `location_typeId` INTEGER NOT NULL,
  `location_name` VARCHAR(256) NOT NULL,
  `location_address` VARCHAR(45) NOT NULL,
  `location_city` VARCHAR(45) NOT NULL,
  `location_state` VARCHAR(45) NOT NULL,
  `location_zip` VARCHAR(45) NOT NULL,
  `location_country` VARCHAR(45) NOT NULL,
  `location_phone` VARCHAR(45) NULL,
  `location_email` VARCHAR(45) NULL,
  `location_timzezone` VARCHAR(45) NULL,
  PRIMARY KEY (`location_id`)
);

DROP TABLE IF EXISTS `church_location_person`;
CREATE TABLE `church_location_person` (
  `location_id` INTEGER NOT NULL,
  `person_id` INTEGER NOT NULL,
  `order` INTEGER NOT NULL,
  `person_location_role_id` INTEGER NOT NULL,  -- referenced to user-defined roles
  PRIMARY KEY (`location_id`, `person_id`)
);

DROP TABLE IF EXISTS `church_location_role`;
CREATE TABLE `church_location_role` (
  `location_id` INTEGER NOT NULL,
  `role_id` INTEGER NOT NULL,
  `role_order` INTEGER NOT NULL,
  `role_title` INTEGER NOT NULL,
  PRIMARY KEY (`location_id`, `role_id`)
);
