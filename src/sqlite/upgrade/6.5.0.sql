-- ChurchCRM 6.5.0 Database Upgrade
-- 
-- Changes:
-- 1. Remove eGive feature (deprecated, never tested)
-- 2. Remove Work Phone and Cell Phone from family table (belong to individuals, not families)

-- Migrate existing eGive deposits to Bank type
UPDATE `deposit_dep` SET `dep_Type`='Bank' WHERE `dep_Type`='eGive';

-- SQLite does not support ENUM/CHANGE COLUMN. dep_Type is stored as TEXT; values already normalized above.

-- Migrate existing EGIVE pledges to CHECK method
UPDATE `pledge_plg` SET `plg_method`='CHECK' WHERE `plg_method`='EGIVE';

-- SQLite does not support ENUM/CHANGE COLUMN. plg_method is stored as TEXT; values already normalized above.

-- Migrate family work phone and cell phone to person records before dropping columns
-- ONLY migrate WorkPhone and CellPhone since these are the only two fields being removed from family_fam
-- Migrate work phone and cell phone from family to person records
-- Copy values only when person fields are empty to preserve existing person-specific data
UPDATE person_per
SET
  per_WorkPhone = CASE
    WHEN per_WorkPhone = '' OR per_WorkPhone IS NULL
      THEN COALESCE((SELECT fam_WorkPhone FROM family_fam f WHERE f.fam_ID = person_per.per_fam_ID), per_WorkPhone)
    ELSE per_WorkPhone
  END,
  per_CellPhone = CASE
    WHEN per_CellPhone = '' OR per_CellPhone IS NULL
      THEN COALESCE((SELECT fam_CellPhone FROM family_fam f WHERE f.fam_ID = person_per.per_fam_ID), per_CellPhone)
    ELSE per_CellPhone
  END
WHERE per_fam_ID > 0;

-- Drop egive table (no longer used)
DROP TABLE IF EXISTS `egive_egv`;

-- Remove unused iLogFileThreshold config (never implemented)
DELETE FROM `config_cfg` WHERE `cfg_id` = 2077;

-- Remove integrity check background job configs (now runs only from admin pages)
DELETE FROM `config_cfg` WHERE `cfg_id` IN (1044, 1045, 1046);

-- Remove software update check timer configs (runs on admin login instead)
DELETE FROM `config_cfg` WHERE `cfg_id` IN (2063, 2064);

-- Remove church registration config (registration now via self-service Google Form)
DELETE FROM `config_cfg` WHERE `cfg_id` = 999;

-- Remove orphaned database tables (created but never fully implemented)
DROP TABLE IF EXISTS `church_location_person`;
DROP TABLE IF EXISTS `church_location_role`;
DROP TABLE IF EXISTS `person_permission`;
DROP TABLE IF EXISTS `person_roles`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;

-- Remove Work Phone and Cell Phone from family table
-- SQLite DROP COLUMN support depends on version; skip to avoid rebuild.
-- ALTER TABLE `family_fam` DROP COLUMN IF EXISTS `fam_WorkPhone`;
-- ALTER TABLE `family_fam` DROP COLUMN IF EXISTS `fam_CellPhone`;
