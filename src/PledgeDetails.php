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

function pledgeDetailsDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function pledgeDetailsDbFetchArray(&$result, $mode = null)
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

$sPageTitle = gettext('Electronic Transaction Details');

// Get the PledgeID out of the querystring
$iPledgeID = InputUtils::legacyFilterInput($_GET['PledgeID'], 'int');
$linkBack = RedirectUtils::getLinkBackFromRequest('v2/dashboard');

// Security: User must have Finance permission to use this form.
// Clean error handling: (such as somebody typing an incorrect URL ?PersonID= manually)
AuthenticationManager::redirectHomeIfFalse(AuthenticationManager::getCurrentUser()->isFinanceEnabled(), 'Finance');

// Is this the second pass?
if (isset($_POST['Back'])) {
    RedirectUtils::redirect($linkBack);
}

$sSQL = 'SELECT * FROM pledge_plg WHERE plg_plgID = ' . $iPledgeID;
$rsPledgeRec = pledgeDetailsDbQuery($sSQL);
extract(pledgeDetailsDbFetchArray($rsPledgeRec));

$sSQL = 'SELECT * FROM result_res WHERE res_ID=' . $plg_aut_ResultID;
$rsResultRec = pledgeDetailsDbQuery($sSQL);

require_once __DIR__ . '/Include/Header.php';

$resArr = pledgeDetailsDbFetchArray($rsResultRec);
if ($resArr) {
    extract($resArr);
    echo $res_echotype2;
}

?>

<div class="card card-body">
    <form method="post" action="PledgeDetails.php?<?= 'PledgeID=' . $iPledgeID . '&linkBack=' . $linkBack ?>" name="PledgeDelete">
        <input type="submit" class="btn btn-secondary" value="<?= gettext('Back') ?>" name="Back">
    </form>
</div>
<?php
require_once __DIR__ . '/Include/Footer.php';
