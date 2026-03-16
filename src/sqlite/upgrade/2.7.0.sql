ALTER TABLE group_grp ADD COLUMN grp_active BOOLEAN DEFAULT 1 NOT NULL;
ALTER TABLE group_grp ADD COLUMN grp_include_email_export BOOLEAN DEFAULT 1 NOT NULL;

-- SQLite does not support MODIFY; no schema change required.

UPDATE queryparameteroptions_qpo SET qpo_Value = 'COALESCE(`per_FirstName`,'''') || COALESCE(`per_MiddleName`,'''') || COALESCE(`per_LastName`,'''')'
WHERE qpo_ID = 5;

UPDATE query_qry SET qry_SQL = 'SELECT per_ID as AddToCart, ''<a href=PersonView.php?PersonID='' || per_ID || ''>'' || COALESCE(`per_FirstName`,'''') || '' '' || COALESCE(`per_MiddleName`,'''') || '' '' || COALESCE(`per_LastName`,'''') || ''</a>'' AS Name, fam_City as City, fam_State as State, fam_Zip as ZIP, per_HomePhone as HomePhone, per_Email as Email, per_WorkEmail as WorkEmail FROM person_per LEFT JOIN family_fam ON family_fam.fam_id = person_per.per_fam_id WHERE ~searchwhat~ LIKE ''%~searchstring~%'''
WHERE qry_ID = 15;

DELETE FROM userconfig_ucfg where ucfg_name = 'sFromEmailAddress';
DELETE FROM userconfig_ucfg where ucfg_name = 'sFromName';
DELETE FROM userconfig_ucfg where ucfg_name = 'bSendPHPMail';

ALTER TABLE event_attend ADD COLUMN attend_id INTEGER;
CREATE UNIQUE INDEX IF NOT EXISTS event_attend_attend_id ON event_attend(attend_id);
