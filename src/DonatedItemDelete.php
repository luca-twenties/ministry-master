<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function donatedItemDeleteDbQuery(string $sql): void
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        RunQuery($sql);
        return;
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();
}

$iDonatedItemID = InputUtils::legacyFilterInput($_GET['DonatedItemID'], 'int');
$linkBack = RedirectUtils::getLinkBackFromRequest('FindFundRaiser.php');

$iFundRaiserID = $_SESSION['iCurrentFundraiser'];

$sSQL = "DELETE FROM donateditem_di WHERE di_id=$iDonatedItemID AND di_fr_id=$iFundRaiserID";
donatedItemDeleteDbQuery($sSQL);
RedirectUtils::redirect($linkBack);
