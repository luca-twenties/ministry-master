<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function paddleNumDeleteDbQuery(string $sql): void
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        RunQuery($sql);
        return;
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();
}

$iPaddleNumID = InputUtils::legacyFilterInput($_GET['PaddleNumID'], 'int');
$linkBack = RedirectUtils::getLinkBackFromRequest('FindFundRaiser.php');

$iFundRaiserID = $_SESSION['iCurrentFundraiser'];

$sSQL = "DELETE FROM paddlenum_pn WHERE pn_id=$iPaddleNumID AND pn_fr_id=$iFundRaiserID";
paddleNumDeleteDbQuery($sSQL);
RedirectUtils::redirect($linkBack);
