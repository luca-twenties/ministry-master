<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\model\ChurchCRM\GroupQuery;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function groupPropsFormRowOpsDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function groupPropsFormRowOpsDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function groupPropsFormRowOpsDbFetchArray(&$result)
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

// Security: user must be allowed to edit records to use this page.
AuthenticationManager::redirectHomeIfFalse(AuthenticationManager::getCurrentUser()->isManageGroupsEnabled(), 'ManageGroups');

// Get the Group, Property, and Action from the querystring
$iGroupID = InputUtils::legacyFilterInput($_GET['GroupID'], 'int');
$iPropID = InputUtils::legacyFilterInput($_GET['PropID'], 'int');
$sField = InputUtils::legacyFilterInput($_GET['Field']);
$sAction = InputUtils::legacyFilterInput($_GET['Action']);

// Get the group information
$group = GroupQuery::create()->findOneById($iGroupID);

// Abort if user tries to load with group having no special properties.
if (!$group->hasSpecialProps()) {
    RedirectUtils::redirect('GroupView.php?GroupID=' . $iGroupID);
}

switch ($sAction) {
    case 'up':
        $sSQL = "UPDATE groupprop_master SET prop_ID = '" . $iPropID . "' WHERE grp_ID = '" . $iGroupID . "' AND prop_ID = '" . ($iPropID - 1) . "'";
        groupPropsFormRowOpsDbQuery($sSQL);
        $sSQL = "UPDATE groupprop_master SET prop_ID = '" . ($iPropID - 1) . "' WHERE grp_ID = '" . $iGroupID . "' AND prop_Field = '" . $sField . "'";
        groupPropsFormRowOpsDbQuery($sSQL);
        break;
    case 'down':
        $sSQL = "UPDATE groupprop_master SET prop_ID = '" . $iPropID . "' WHERE grp_ID = '" . $iGroupID . "' AND prop_ID = '" . ($iPropID + 1) . "'";
        groupPropsFormRowOpsDbQuery($sSQL);
        $sSQL = "UPDATE groupprop_master SET prop_ID = '" . ($iPropID + 1) . "' WHERE grp_ID = '" . $iGroupID . "' AND prop_Field = '" . $sField . "'";
        groupPropsFormRowOpsDbQuery($sSQL);
        break;
    case 'delete':
        // Check if this field is a custom list type.  If so, the list needs to be deleted from list_lst.
        $sSQL = "SELECT type_ID,prop_Special FROM groupprop_master WHERE grp_ID = '" . $iGroupID . "' AND prop_Field = '" . $sField . "'";
        $rsTemp = groupPropsFormRowOpsDbQuery($sSQL);
        $aTemp = groupPropsFormRowOpsDbFetchArray($rsTemp);
        if ($aTemp[0] == 12) {
            $sSQL = "DELETE FROM list_lst WHERE lst_ID = $aTemp[1]";
            groupPropsFormRowOpsDbQuery($sSQL);
        }

        $sSQL = 'ALTER TABLE `groupprop_' . $iGroupID . '` DROP `' . $sField . '` ;';
        groupPropsFormRowOpsDbQuery($sSQL);

        $sSQL = "DELETE FROM groupprop_master WHERE grp_ID = '" . $iGroupID . "' AND prop_ID = '" . $iPropID . "'";
        groupPropsFormRowOpsDbQuery($sSQL);

        $sSQL = 'SELECT *    FROM groupprop_master WHERE grp_ID = ' . $iGroupID;
        $rsPropList = groupPropsFormRowOpsDbQuery($sSQL);
        $numRows = groupPropsFormRowOpsDbNumRows($rsPropList);

        // Shift the remaining rows up by one, unless we've just deleted the only row
        if ($numRows != 0) {
            for ($reorderRow = $iPropID + 1; $reorderRow <= $numRows + 1; $reorderRow++) {
                $sSQL = "UPDATE groupprop_master SET prop_ID = '" . ($reorderRow - 1) . "' WHERE grp_ID = '" . $iGroupID . "' AND prop_ID = '" . $reorderRow . "'";
                groupPropsFormRowOpsDbQuery($sSQL);
            }
        }
        break;
    default:
        RedirectUtils::redirect('GroupView.php?GroupID=' . $iGroupID);
        break;
}

// Reload the Form Editor page
RedirectUtils::redirect('GroupPropsFormEditor.php?GroupID=' . $iGroupID);
