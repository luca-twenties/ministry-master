<?php

require_once __DIR__ . '/../Include/Config.php';
require_once __DIR__ . '/../Include/Functions.php';

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Reports\PdfGroupDirectory;
use ChurchCRM\Utils\InputUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function groupReportDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function groupReportDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function groupReportDbFetchArray(&$result)
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

function groupReportDbDataSeek(&$result, int $offset): void
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        $result['index'] = $offset;
        return;
    }

    mysqli_data_seek($result, $offset);
}

$bOnlyCartMembers = $_POST['OnlyCart'];
$iGroupID = InputUtils::legacyFilterInput($_POST['GroupID'], 'int');
$iMode = InputUtils::legacyFilterInput($_POST['ReportModel'], 'int');

if ($iMode == 1) {
    $iRoleID = InputUtils::legacyFilterInput($_POST['GroupRole'], 'int');
} else {
    $iRoleID = 0;
}

// Get the group name
$sSQL = 'SELECT grp_Name, grp_RoleListID FROM group_grp WHERE grp_ID = ' . $iGroupID;
$rsGroupName = groupReportDbQuery($sSQL);
$aRow = groupReportDbFetchArray($rsGroupName);
$sGroupName = $aRow[0];
$iRoleListID = $aRow[1];

// Get the selected role name
if ($iRoleID > 0) {
    $sSQL = 'SELECT lst_OptionName FROM list_lst WHERE lst_ID = ' . $iRoleListID . ' AND lst_OptionID = ' . $iRoleID;
    $rsTemp = groupReportDbQuery($sSQL);
    $aRow = groupReportDbFetchArray($rsTemp);
    $sRoleName = $aRow[0];
} elseif (isset($_POST['GroupRoleEnable'])) {
    $sSQL = 'SELECT lst_OptionName,lst_OptionID FROM list_lst WHERE lst_ID = ' . $iRoleListID;
    $rsTemp = groupReportDbQuery($sSQL);

    while ($aRow = groupReportDbFetchArray($rsTemp)) {
        $aRoleNames[$aRow[1]] = $aRow[0];
    }
}

$pdf = new PdfGroupDirectory();

// See if this group has special properties.
$sSQL = 'SELECT * FROM groupprop_master WHERE grp_ID = ' . $iGroupID . ' ORDER BY prop_ID';
$rsProps = groupReportDbQuery($sSQL);
$bHasProps = (groupReportDbNumRows($rsProps) > 0);

$sSQL = 'SELECT * FROM person_per
            LEFT JOIN family_fam ON per_fam_ID = fam_ID ';

if ($bHasProps) {
    $sSQL .= 'LEFT JOIN groupprop_' . $iGroupID . ' ON groupprop_' . $iGroupID . '.per_ID = person_per.per_ID ';
}

$sSQL .= 'LEFT JOIN person2group2role_p2g2r ON p2g2r_per_ID = person_per.per_ID
            WHERE p2g2r_grp_ID = ' . $iGroupID;

if ($iRoleID > 0) {
    $sSQL .= ' AND p2g2r_rle_ID = ' . $iRoleID;
}

if ($bOnlyCartMembers && count($_SESSION['aPeopleCart']) > 0) {
    $sSQL .= ' AND person_per.per_ID IN (' . convertCartToString($_SESSION['aPeopleCart']) . ')';
}

$sSQL .= ' ORDER BY per_LastName';

$rsRecords = groupReportDbQuery($sSQL);

while ($aRow = groupReportDbFetchArray($rsRecords)) {
    $OutStr = '';

    $pdf->sFamily = FormatFullName($aRow['per_Title'], $aRow['per_FirstName'], $aRow['per_MiddleName'], $aRow['per_LastName'], $aRow['per_Suffix'], 3);

    // Use person data only - each person must enter their own information
    $sAddress1 = $aRow['per_Address1'] ?? '';
    $sAddress2 = $aRow['per_Address2'] ?? '';
    $sCity = $aRow['per_City'] ?? '';
    $sState = $aRow['per_State'] ?? '';
    $sZip = $aRow['per_Zip'] ?? '';
    $sHomePhone = $aRow['per_HomePhone'] ?? '';
    $sWorkPhone = $aRow['per_WorkPhone'] ?? '';
    $sCellPhone = $aRow['per_CellPhone'] ?? '';
    $sEmail = $aRow['per_Email'] ?? '';

    if (isset($_POST['GroupRoleEnable'])) {
        $OutStr = gettext('Role') . ': ' . $aRoleNames[$aRow['p2g2r_rle_ID']] . "\n";
    }

    if (isset($_POST['AddressEnable'])) {
        if (strlen($sAddress1)) {
            $OutStr .= $sAddress1 . "\n";
        }
        if (strlen($sAddress2)) {
            $OutStr .= $sAddress2 . "\n";
        }
        if (strlen($sCity)) {
            $OutStr .= $sCity . ', ' . $sState . ' ' . $sZip . "\n";
        }
    }

    if (isset($_POST['HomePhoneEnable']) && strlen($sHomePhone)) {
        $TempStr = $sHomePhone;
        $OutStr .= '  ' . gettext('Phone') . ': ' . $TempStr . "\n";
    }

    if (isset($_POST['WorkPhoneEnable']) && strlen($sWorkPhone)) {
        $TempStr = $sWorkPhone;
        $OutStr .= '  ' . gettext('Work') . ': ' . $TempStr . "\n";
    }

    if (isset($_POST['CellPhoneEnable']) && strlen($sCellPhone)) {
        $TempStr = $sCellPhone;
        $OutStr .= '  ' . gettext('Cell') . ': ' . $TempStr . "\n";
    }

    if (isset($_POST['EmailEnable']) && strlen($sEmail)) {
        $OutStr .= '  ' . gettext('Email') . ': ' . $sEmail . "\n";
    }

    if (isset($_POST['OtherEmailEnable']) && strlen($aRow['per_WorkEmail'])) {
        $OutStr .= '  ' . gettext('Other Email') . ': ' . $aRow['per_WorkEmail'] .= "\n";
    }

    if ($bHasProps) {
        while ($aPropRow = groupReportDbFetchArray($rsProps)) {
            if (isset($_POST[$aPropRow['prop_Field'] . 'enable'])) {
                $currentData = trim($aRow[$aPropRow['prop_Field']]);
                $OutStr .= $aPropRow['prop_Name'] . ': ' . displayCustomField($aPropRow['type_ID'], $currentData, $aPropRow['prop_Special']) . "\n";
            }
        }
        groupReportDbDataSeek($rsProps, 0);
    }

    // Count the number of lines in the output string
    $numlines = 1;
    $offset = 0;
    while ($result = strpos($OutStr, "\n", $offset)) {
        $offset = $result + 1;
        $numlines++;
    }

    $pdf->addRecord($pdf->sFamily, $OutStr, $numlines);
}

if (SystemConfig::getIntValue('iPDFOutputType') === 1) {
    $pdf->Output('GroupDirectory-' . date(SystemConfig::getValue('sDateFilenameFormat')) . '.pdf', 'D');
} else {
    $pdf->Output();
}
