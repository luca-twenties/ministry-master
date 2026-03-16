DROP TABLE IF EXISTS canvassdata_can;
-- SQLite DROP COLUMN support depends on version; skip to avoid rebuild.
-- ALTER TABLE family_fam DROP COLUMN fam_OkToCanvass;
-- ALTER TABLE family_fam DROP COLUMN fam_Canvasser;
DELETE FROM list_lst WHERE lst_OptionName = 'bCanvasser';
DELETE FROM query_qry WHERE qry_ID = '27';
-- SQLite DROP COLUMN support depends on version; skip to avoid rebuild.
-- ALTER TABLE user_usr DROP COLUMN usr_Canvasser;
DELETE FROM permissions WHERE permission_name = 'canvasser';
