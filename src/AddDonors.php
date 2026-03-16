<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function addDonorsDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function addDonorsDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function addDonorsDbFetchArray(&$result, $mode = null)
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        return $row;
    }

    if ($mode === null) {
        $mode = defined('MYSQLI_BOTH') ? MYSQLI_BOTH : \PDO::FETCH_BOTH;
    }

    return mysqli_fetch_array($result, $mode);
}

$linkBack = RedirectUtils::getLinkBackFromRequest('');
$iFundRaiserID = InputUtils::filterInt($_GET['FundRaiserID']);

if ($linkBack === '') {
    $linkBack = "PaddleNumList.php?FundRaiserID=$iFundRaiserID";
}

if ($iFundRaiserID > 0) {
    // Set current fundraiser
    $_SESSION['iCurrentFundraiser'] = $iFundRaiserID;
} else {
    RedirectUtils::redirect($linkBack);
}

// Get all the people listed as donors for this fundraiser
$sSQL = "SELECT a.per_id as donorID FROM donateditem_di
             LEFT JOIN person_per a ON di_donor_ID=a.per_ID
         WHERE di_FR_ID = '" . $iFundRaiserID . "' ORDER BY a.per_id";
$rsDonors = addDonorsDbQuery($sSQL);

$extraPaddleNum = 1;
$sSQL = "SELECT MAX(pn_NUM) AS pn_max FROM paddlenum_pn WHERE pn_FR_ID = '" . $iFundRaiserID . "'";
$rsMaxPaddle = addDonorsDbQuery($sSQL);
if (addDonorsDbNumRows($rsMaxPaddle) > 0) {
    $oneRow = addDonorsDbFetchArray($rsMaxPaddle);
    $pn_max = $oneRow['pn_max'];
    $extraPaddleNum = $pn_max + 1;
}

// Go through the donors, add buyer records for any who don't have one yet
while ($donorRow = addDonorsDbFetchArray($rsDonors)) {
    $donorID = $donorRow['donorID'];

    $sSQL = "SELECT pn_per_id FROM paddlenum_pn WHERE pn_per_id='$donorID' AND pn_FR_ID = '$iFundRaiserID'";
    $rsBuyer = addDonorsDbQuery($sSQL);

    if ($donorID > 0 && addDonorsDbNumRows($rsBuyer) === 0) {
        $sSQL = "INSERT INTO paddlenum_pn (pn_Num, pn_fr_ID, pn_per_ID)
                        VALUES ('$extraPaddleNum', '$iFundRaiserID', '$donorID')";
        addDonorsDbQuery($sSQL);
        $extraPaddleNum = $extraPaddleNum + 1;
    }
}
RedirectUtils::redirect($linkBack);
