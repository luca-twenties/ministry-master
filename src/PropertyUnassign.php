<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function propertyUnassignDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function propertyUnassignDbFetchArray(&$result)
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        return $row;
    }

    return mysqli_fetch_array($result);
}

// Security: User must have Manage Groups or Edit Records permissions
// Otherwise, re-direct them to the main menu.
if (!AuthenticationManager::getCurrentUser()->isManageGroupsEnabled() && !AuthenticationManager::getCurrentUser()->isEditRecordsEnabled()) {
    RedirectUtils::redirect('v2/dashboard');
}

// Get the new property value from the post collection
$iPropertyID = InputUtils::legacyFilterInput($_GET['PropertyID'], 'int');

// Is there a PersonID in the querystring?
if (isset($_GET['PersonID']) && AuthenticationManager::getCurrentUser()->isEditRecordsEnabled()) {
    $iPersonID = InputUtils::legacyFilterInput($_GET['PersonID'], 'int');
    $iRecordID = $iPersonID;
    $sQuerystring = '?PersonID=' . $iPersonID;
    $sTypeName = 'Person';
    $sBackPage = 'PersonView.php?PersonID=' . $iPersonID;

    // Get the name of the person
    $sSQL = 'SELECT per_FirstName, per_LastName FROM person_per WHERE per_ID = ' . $iPersonID;
    $rsName = propertyUnassignDbQuery($sSQL);
    $aRow = propertyUnassignDbFetchArray($rsName);
    $sName = $aRow['per_LastName'] . ', ' . $aRow['per_FirstName'];
} elseif (isset($_GET['GroupID']) && AuthenticationManager::getCurrentUser()->isManageGroupsEnabled()) {
    // Is there a GroupID in the querystring?
    $iGroupID = InputUtils::legacyFilterInput($_GET['GroupID'], 'int');
    $iRecordID = $iGroupID;
    $sQuerystring = '?GroupID=' . $iGroupID;
    $sTypeName = 'Group';
    $sBackPage = 'GroupView.php?GroupID=' . $iGroupID;

    // Get the name of the group
    $sSQL = 'SELECT grp_Name FROM group_grp WHERE grp_ID = ' . $iGroupID;
    $rsName = propertyUnassignDbQuery($sSQL);
    $aRow = propertyUnassignDbFetchArray($rsName);
    $sName = $aRow['grp_Name'];
} elseif (isset($_GET['FamilyID']) && AuthenticationManager::getCurrentUser()->isEditRecordsEnabled()) {
    // Is there a FamilyID in the querystring?
    $iFamilyID = InputUtils::legacyFilterInput($_GET['FamilyID'], 'int');
    $iRecordID = $iFamilyID;
    $sQuerystring = '?FamilyID=' . $iFamilyID;
    $sTypeName = 'Family';
    $sBackPage = 'v2/family/' . $iFamilyID;

    // Get the name of the family
    $sSQL = 'SELECT fam_Name FROM family_fam WHERE fam_ID = ' . $iFamilyID;
    $rsName = propertyUnassignDbQuery($sSQL);
    $aRow = propertyUnassignDbFetchArray($rsName);
    $sName = $aRow['fam_Name'];
} else {
    // Somebody tried to call the script with no options
    RedirectUtils::redirect('v2/dashboard');
}

//Do we have confirmation?
if (isset($_GET['Confirmed'])) {
    $sSQL = 'DELETE FROM record2property_r2p WHERE r2p_record_ID = ' . $iRecordID . ' AND r2p_pro_ID = ' . $iPropertyID;
    propertyUnassignDbQuery($sSQL);
    RedirectUtils::redirect($sBackPage);
}

//Get the name of the property
$sSQL = 'SELECT pro_Name FROM property_pro WHERE pro_ID = ' . $iPropertyID;
$rsProperty = propertyUnassignDbQuery($sSQL);
$aRow = propertyUnassignDbFetchArray($rsProperty);
$sPropertyName = $aRow['pro_Name'];

$sPageTitle = $sTypeName . gettext(' Property Unassignment');

//Include the header
require_once __DIR__ . '/Include/Header.php';

?>

<div class="card card-body">
    <p class="lead"><?= gettext('Please confirm removal of this property from this') . ' ' . $sTypeName ?>:</p>

    <table class="table table-striped mb-4">
        <tr>
            <td class="font-weight-bold"><?= $sTypeName ?>:</td>
            <td><?= InputUtils::escapeHTML($sName) ?></td>
        </tr>
        <tr>
            <td class="font-weight-bold"><?= gettext('Unassigning') ?>:</td>
            <td><?= InputUtils::escapeHTML($sPropertyName) ?></td>
        </tr>
    </table>

    <div>
        <a class="btn btn-secondary" href="<?= $sBackPage ?>"><?= gettext('No, retain this assignment') ?></a>
        <a class="btn btn-danger ml-2" href="PropertyUnassign.php<?= $sQuerystring . '&PropertyID=' . $iPropertyID . '&Confirmed=Yes' ?>"><?= gettext('Yes, unassign this Property') ?></a>
    </div>
</div>
<?php
require_once __DIR__ . '/Include/Footer.php';
