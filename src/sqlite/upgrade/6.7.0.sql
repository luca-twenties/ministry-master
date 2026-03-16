-- Add order column to donation funds table for custom sorting
ALTER TABLE donationfund_fun ADD COLUMN fun_Order INTEGER NOT NULL DEFAULT 0;

-- Initialize order values based on current fund IDs
WITH ordered AS (
  SELECT fun_ID, ROW_NUMBER() OVER (ORDER BY fun_ID) AS rn
  FROM donationfund_fun
)
UPDATE donationfund_fun
SET fun_Order = (SELECT rn FROM ordered WHERE ordered.fun_ID = donationfund_fun.fun_ID);

-- SQLite DROP COLUMN support depends on version; skip to avoid rebuild.
-- ALTER TABLE eventcountnames_evctnm DROP COLUMN IF EXISTS evctnm_notes;

-- Remove obsolete pending email tables that were never fully implemented
DROP TABLE IF EXISTS `email_recipient_pending_erp`;
DROP TABLE IF EXISTS `email_message_pending_emp`;

-- Migrate Query ID 32 'Family Pledge by Fiscal Year' to Finance module MVC page
-- Remove query and related data (now available at /finance/pledge/dashboard)
DELETE FROM queryparameteroptions_qpo WHERE qpo_qrp_ID IN (SELECT qrp_ID FROM queryparameters_qrp WHERE qrp_qry_ID = 32);
DELETE FROM queryparameters_qrp WHERE qrp_qry_ID = 32;
DELETE FROM query_qry WHERE qry_ID = 32;

-- Update aFinanceQueries config to remove Query ID 32
UPDATE config_cfg SET cfg_value = '28,30' WHERE cfg_name = 'aFinanceQueries' AND cfg_value LIKE '%32%';
-- Remove query #21 ("Registered students") and all related child rows
-- Delete any parameter option rows that belong to parameters for query 21
DELETE FROM queryparameteroptions_qpo
WHERE qpo_qrp_ID IN (SELECT qrp_ID FROM queryparameters_qrp WHERE qrp_qry_ID = 21);

-- Delete query parameters for query 21
DELETE FROM queryparameters_qrp WHERE qrp_qry_ID = 21;

-- Finally delete the query definition itself
DELETE FROM query_qry WHERE qry_ID = 21;

-- Remove deprecated `sHeader` system config (was an XSS vector)
DELETE FROM config_cfg WHERE cfg_name = 'sHeader';
