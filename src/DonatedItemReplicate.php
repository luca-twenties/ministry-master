<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Utils\LoggerUtils;
use Propel\Runtime\Propel;

$iFundRaiserID = $_SESSION['iCurrentFundraiser'];
$iDonatedItemID = InputUtils::legacyFilterInputArr($_GET, 'DonatedItemID', 'int');
$iCount = InputUtils::legacyFilterInputArr($_GET, 'Count', 'int');

$sLetter = 'a';

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function donatedItemReplicateDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    try {
        $stmt = $dbConnection->query($sql);
        if (!$stmt instanceof \PDOStatement) {
            return false;
        }
        $rows = $stmt->fetchAll(\PDO::FETCH_BOTH);
        return ['rows' => $rows, 'index' => 0];
    } catch (\Throwable $e) {
        LoggerUtils::getAppLogger()->error('SQLite query failed', ['sql' => $sql, 'exception' => $e]);
        return false;
    }
}

function donatedItemReplicateDbFetchArray(&$result, ?int $mode = null)
{
    if ($mode === null) {
        if (defined('MYSQLI_BOTH')) {
            $mode = MYSQLI_BOTH;
        } else {
            $mode = \PDO::FETCH_BOTH;
        }
    }

    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        return $row;
    }

    return mysqli_fetch_array($result, $mode);
}

$sSQL = "SELECT di_item FROM donateditem_di WHERE di_ID=$iDonatedItemID";
$rsItem = donatedItemReplicateDbQuery($sSQL);
$row = donatedItemReplicateDbFetchArray($rsItem);
$startItem = $row[0];

if (strlen($startItem) === 2) { // replicated items will sort better if they have a two-digit number
    $letter = mb_substr($startItem, 0, 1);
    $number = mb_substr($startItem, 1, 1);
    $startItem = $letter . '0' . $number;
}

$letterNum = ord('a');

for ($i = 0; $i < $iCount; $i++) {
    $sSQL = 'INSERT INTO donateditem_di (di_item,di_FR_ID,di_donor_ID,di_multibuy,di_title,di_description,di_sellprice,di_estprice,di_minimum,di_materialvalue,di_EnteredBy,di_EnteredDate,di_picture)';
    $sSQL .= "SELECT '" . $startItem . chr($letterNum) . "',di_FR_ID,di_donor_ID,di_multibuy,di_title,di_description,di_sellprice,di_estprice,di_minimum,di_materialvalue,";
    $sSQL .= AuthenticationManager::getCurrentUser()->getId() . ",'" . date('YmdHis') . "',";
    $sSQL .= 'di_picture';
    $sSQL .= " FROM donateditem_di WHERE di_ID=$iDonatedItemID";
    $ret = donatedItemReplicateDbQuery($sSQL);
    $letterNum += 1;
}
RedirectUtils::redirect("FundRaiserEditor.php?FundRaiserID=$iFundRaiserID");
