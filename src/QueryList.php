<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function queryListDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function queryListDbFetchArray(&$result)
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

$sPageTitle = gettext('Query Listing');

$sSQL = 'SELECT * FROM query_qry ORDER BY qry_Name';
$rsQueries = queryListDbQuery($sSQL);

$aFinanceQueries = explode(',', $aFinanceQueries);

require_once __DIR__ . '/Include/Header.php';

?>
<div class="card card-primary">
    <div class="card-body">
        <p class="text-right">
        </p>

        <ul>
            <?php while ($aRow = queryListDbFetchArray($rsQueries)) : ?>
            <li>
                <p>
                <?php
                    extract($aRow);

                    // Filter out finance-related queries if the user doesn't have finance permissions
                if (AuthenticationManager::getCurrentUser()->isFinanceEnabled() || !in_array($qry_ID, $aFinanceQueries)) {
                    // Display the query name and description
                    echo '<a href="QueryView.php?QueryID=' . $qry_ID . '">' . gettext($qry_Name) . '</a>:';
                    echo '<br>';
                    echo gettext($qry_Description);
                }
                ?>
                </p>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>

</div>
<?php
require_once __DIR__ . '/Include/Footer.php';
