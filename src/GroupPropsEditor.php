<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\LoggerUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

// Security: user must be allowed to edit records to use this page.
AuthenticationManager::redirectHomeIfFalse(AuthenticationManager::getCurrentUser()->isEditRecordsEnabled(), 'EditRecords');

// Initialize logger for error tracking
$logger = LoggerUtils::getAppLogger();

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function groupPropsEditorDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function groupPropsEditorDbNormalizeRow(array $row, ?int $mode)
{
    if ($mode === null) {
        if (defined('MYSQLI_BOTH')) {
            $mode = MYSQLI_BOTH;
        } else {
            $mode = \PDO::FETCH_BOTH;
        }
    }

    if (defined('MYSQLI_ASSOC') && $mode === MYSQLI_ASSOC) {
        $assoc = [];
        foreach ($row as $key => $value) {
            if (is_string($key)) {
                $assoc[$key] = $value;
            }
        }
        return $assoc;
    }
    if (defined('MYSQLI_NUM') && $mode === MYSQLI_NUM) {
        $numeric = [];
        foreach ($row as $key => $value) {
            if (is_int($key)) {
                $numeric[] = $value;
            }
        }
        return $numeric;
    }

    return $row;
}

function groupPropsEditorDbFetchArray(&$result, ?int $mode = null)
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        return groupPropsEditorDbNormalizeRow($row, $mode);
    }

    if ($mode === null) {
        $mode = defined('MYSQLI_BOTH') ? MYSQLI_BOTH : \PDO::FETCH_BOTH;
    }

    return mysqli_fetch_array($result, $mode);
}

function groupPropsEditorDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function groupPropsEditorDbDataSeek(&$result, int $index): void
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        $result['index'] = $index;
        return;
    }

    mysqli_data_seek($result, $index);
}

$sPageTitle = gettext('Group Member Properties Editor');

// Get the Group and Person IDs from the querystring
$iGroupID = InputUtils::legacyFilterInput($_GET['GroupID'], 'int');
$iPersonID = InputUtils::legacyFilterInput($_GET['PersonID'], 'int');

// Get some info about this person.  per_Country is needed in case there are phone numbers.
$sSQL = 'SELECT per_FirstName, per_LastName, per_Country, per_fam_ID FROM person_per WHERE per_ID = ' . $iPersonID;
$rsPersonInfo = groupPropsEditorDbQuery($sSQL);
extract(groupPropsEditorDbFetchArray($rsPersonInfo));

$fam_Country = '';

$sPhoneCountry = $per_Country ?? '';

// Get the name of this group.
$sSQL = 'SELECT grp_Name FROM group_grp WHERE grp_ID = ' . $iGroupID;
$rsGroupInfo = groupPropsEditorDbQuery($sSQL);
extract(groupPropsEditorDbFetchArray($rsGroupInfo));

// We assume that the group selected has a special properties table and that it is populated
// with values for each group member.

// Get the properties list for this group: names, descriptions, types and prop_ID for ordering;  will process later..

$sSQL = 'SELECT groupprop_master.* FROM groupprop_master
            WHERE grp_ID = ' . $iGroupID . ' ORDER BY prop_ID';
$rsPropList = groupPropsEditorDbQuery($sSQL);

$aPropErrors = [];

// Is this the second pass?
if (isset($_POST['GroupPropSubmit'])) {
    // Process all HTTP post data based upon the list of properties data we are expecting
    // If there is an error message, it gets assigned to an array of strings, $aPropErrors, for use in the form.

    $bErrorFlag = false;

    while ($rowPropList = groupPropsEditorDbFetchArray($rsPropList)) {
        extract($rowPropList);

        $currentFieldData = InputUtils::legacyFilterInput($_POST[$prop_Field]);

        $bErrorFlag |= !validateCustomField($type_ID, $currentFieldData, $prop_Field, $aPropErrors);

        // assign processed value locally to $aPersonProps so we can use it to generate the form later
        $aPersonProps[$prop_Field] = $currentFieldData;
    }

    // If no errors, then update.
    if (!$bErrorFlag) {
        groupPropsEditorDbDataSeek($rsPropList, 0);

        $sSQL = 'UPDATE groupprop_' . $iGroupID . ' SET ';

        while ($rowPropList = groupPropsEditorDbFetchArray($rsPropList)) {
            extract($rowPropList);
            $currentFieldData = trim($aPersonProps[$prop_Field]);

            sqlCustomField($sSQL, $type_ID, $currentFieldData, $prop_Field, $sPhoneCountry);
        }

        // chop off the last 2 characters (comma and space) added in the last while loop iteration.
        $sSQL = mb_substr($sSQL, 0, -2);

        $sSQL .= ' WHERE per_ID = ' . $iPersonID;

        //Execute the SQL
        $updateResult = groupPropsEditorDbQuery($sSQL);
        
        if (!$updateResult) {
            $logger->error('Failed to update group properties', [
                'person_id' => $iPersonID,
                'group_id' => $iGroupID,
            ]);
            $bErrorFlag = true;
        } else {
            // Return to the Person View
            RedirectUtils::redirect('PersonView.php?PersonID=' . $iPersonID);
        }
    }
} else {
    // First Pass
    // Verify that the groupprop_X table exists
    $tableExists = false;
    if ($isSqlite) {
        $checkTableSQL = "SELECT name FROM sqlite_master WHERE type='table' AND name='groupprop_" . $iGroupID . "'";
        $tableCheckResult = groupPropsEditorDbQuery($checkTableSQL);
        $tableExists = groupPropsEditorDbNumRows($tableCheckResult) > 0;
    } else {
        $checkTableSQL = 'SHOW TABLES LIKE "groupprop_' . $iGroupID . '"';
        $tableCheckResult = groupPropsEditorDbQuery($checkTableSQL);
        $tableExists = groupPropsEditorDbNumRows($tableCheckResult) > 0;
    }

    if (!$tableExists) {
        // Table does not exist - create it with initial per_ID column
        if ($isSqlite) {
            $createTableSQL = 'CREATE TABLE IF NOT EXISTS groupprop_' . $iGroupID . ' (
                per_ID INTEGER NOT NULL DEFAULT 0,
                PRIMARY KEY (per_ID)
            )';
        } else {
            $createTableSQL = 'CREATE TABLE IF NOT EXISTS groupprop_' . $iGroupID . ' (
                per_ID INTEGER NOT NULL default "0",
                PRIMARY KEY (per_ID),
                UNIQUE KEY per_ID (per_ID)
            )';
        }
        $createResult = groupPropsEditorDbQuery($createTableSQL);
        
        if (!$createResult) {
            $logger->error('Failed to create group properties table', ['group_id' => $iGroupID]);
            $bErrorFlag = true;
        }
    }
    
    // Get the existing data for this group member
    $sSQL = 'SELECT * FROM groupprop_' . $iGroupID . ' WHERE per_ID = ' . $iPersonID;
    $rsPersonProps = groupPropsEditorDbQuery($sSQL);
    
    // Check if a record exists for this person in the group properties table
    if (groupPropsEditorDbNumRows($rsPersonProps) === 0) {
        // No record exists - insert one with just the per_ID
        // This handles cases where the person was added before properties were enabled
        $insertPrefix = $isSqlite ? 'INSERT OR IGNORE' : 'INSERT';
        $sSQL = $insertPrefix . ' INTO groupprop_' . $iGroupID . ' (per_ID) VALUES (' . $iPersonID . ')';
        groupPropsEditorDbQuery($sSQL);
        
        // Now fetch the newly created record
        $sSQL = 'SELECT * FROM groupprop_' . $iGroupID . ' WHERE per_ID = ' . $iPersonID;
        $rsPersonProps = groupPropsEditorDbQuery($sSQL);
    }
    
    $aPersonProps = groupPropsEditorDbFetchArray($rsPersonProps);
}

require_once __DIR__ . '/Include/Header.php';

if (groupPropsEditorDbNumRows($rsPropList) === 0) {
?>
    <form>
        <h3><?= gettext('This group currently has no properties!  You can add them in the Group Editor.') ?></h3>
        <BR>
        <input type="button" class="btn btn-secondary" value="<?= gettext('Return to Person Record') ?>" Name="Cancel" onclick="javascript:document.location='PersonView.php?PersonID=<?= $iPersonID ?>';">
    </form>
<?php
} else {
?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= gettext('Editing') ?> <i> <?= $grp_Name ?> </i> <?= gettext('data for member') ?> <i> <?= $per_FirstName . ' ' . $per_LastName ?> </i></h3>
        </div>
        <div class="card-body">
            <form method="post" action="GroupPropsEditor.php?<?= 'PersonID=' . $iPersonID . '&GroupID=' . $iGroupID ?>" name="GroupPropEditor">

                <table class="table">
                    <?php

                    // Make sure we're at the beginning of the properties list resource (2nd pass code used it)
                    groupPropsEditorDbDataSeek($rsPropList, 0);

                    while ($rowPropList = groupPropsEditorDbFetchArray($rsPropList)) {
                        extract($rowPropList); ?>
                        <tr>
                            <td><?= InputUtils::escapeHTML($prop_Name) ?>: </td>
                            <td>
                                <?php
                                $currentFieldData = trim($aPersonProps[$prop_Field]);

                                if ($type_ID == 11) {
                                    $prop_Special = null;
                                }  // ugh.. an argument with special cases!

                                formCustomField($type_ID, $prop_Field, $currentFieldData, $prop_Special, !isset($_POST['GroupPropSubmit']));

                                if (array_key_exists($prop_Field, $aPropErrors)) {
                                    echo '<span class="text-error">' . InputUtils::escapeHTML($aPropErrors[$prop_Field]) . '</span>';
                                } ?>
                            </td>
                            <td><?= InputUtils::escapeHTML($prop_Description) ?></td>
                        </tr>
                    <?php
                    } ?>
                    <tr>
                        <td class="text-center" colspan="3">
                            <br><br>
                            <input type="submit" class="btn btn-primary" value="<?= gettext('Save') ?>" Name="GroupPropSubmit">
                            &nbsp;
                            <input type="button" class="btn btn-secondary" value="<?= gettext('Cancel') ?>" Name="Cancel" onclick="javascript:document.location='PersonView.php?PersonID=<?= $iPersonID ?>';">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
}
?>
<script>
    // Initialize all phone mask toggles for custom fields (guarded)
    document.addEventListener('DOMContentLoaded', function() {
        if (window.CRM && window.CRM.formUtils && typeof window.CRM.formUtils.initializeAllPhoneMaskToggles === 'function') {
            try {
                window.CRM.formUtils.initializeAllPhoneMaskToggles();
            } catch (e) {
                // silent
            }
        }
    });
</script>
<?php
require_once __DIR__ . '/Include/Footer.php';
?>
