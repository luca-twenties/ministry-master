<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function paddleNumListDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function paddleNumListDbFetchArray(&$result)
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

$linkBack = RedirectUtils::getLinkBackFromRequest('');

$iFundRaiserID = $_SESSION['iCurrentFundraiser'];

if ($iFundRaiserID > 0) {
    //Get the paddlenum records for this fundraiser
    $sSQL = "SELECT pn_ID, pn_fr_ID, pn_Num, pn_per_ID,
                    a.per_FirstName as buyerFirstName, a.per_LastName as buyerLastName
             FROM paddlenum_pn
             LEFT JOIN person_per a ON pn_per_ID=a.per_ID
             WHERE pn_FR_ID = '" . $iFundRaiserID . "' ORDER BY pn_Num";
    $rsPaddleNums = paddleNumListDbQuery($sSQL);
} else {
    $rsPaddleNums = 0;
}

$sPageTitle = gettext('Buyers for this fundraiser:');
require_once __DIR__ . '/Include/Header.php';
?>
<div class="card card-body">
    <?php
    echo "<form method=\"post\" action=\"Reports/FundRaiserStatement.php?CurrentFundraiser=$iFundRaiserID&linkBack=FundRaiserEditor.php?FundRaiserID=$iFundRaiserID&CurrentFundraiser=$iFundRaiserID\">\n";
    if ($iFundRaiserID > 0) {
        echo '<input type=button class=btn value="' . gettext('Select all') . "\" name=SelectAll onclick=\"javascript:document.location='PaddleNumList.php?CurrentFundraiser=$iFundRaiserID&SelectAll=1&linkBack=PaddleNumList.php?FundRaiserID=$iFundRaiserID&CurrentFundraiser=$iFundRaiserID';\">\n";
    }
    echo '<input type=button class=btn value="' . gettext('Select none') . "\" name=SelectNone onclick=\"javascript:document.location='PaddleNumList.php?CurrentFundraiser=$iFundRaiserID&linkBack=PaddleNumList.php?FundRaiserID=$iFundRaiserID&CurrentFundraiser=$iFundRaiserID';\">\n";
    echo '<input type=button class=btn value="' . gettext('Add Buyer') . "\" name=AddBuyer onclick=\"javascript:document.location='PaddleNumEditor.php?CurrentFundraiser=$iFundRaiserID&linkBack=PaddleNumList.php?FundRaiserID=$iFundRaiserID&CurrentFundraiser=$iFundRaiserID';\">\n";
    echo '<input type=submit class=btn value="' . gettext('Generate Statements for Selected') . "\" name=GenerateStatements>\n";
    ?>
</div>
<div class="card card-body">

    <table class="table table-striped">

        <tr class="TableHeader">
            <td><?= gettext('Select') ?></td>
            <td><?= gettext('Number') ?></td>
            <td><?= gettext('Buyer') ?></td>
            <td><?= gettext('Delete') ?></td>
        </tr>

        <?php
        $tog = 0;

        //Loop through all buyers
        if ($rsPaddleNums) {
            while ($aRow = paddleNumListDbFetchArray($rsPaddleNums)) {
                extract($aRow);

                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="Chk<?= (int)$pn_ID . '"';
                        if (isset($_GET['SelectAll'])) {
                            echo ' checked="yes"';
                        } ?>></input>
            </td>
            <td>
                <?= '<a href="PaddleNumEditor.php?PaddleNumID=' . (int)$pn_ID . '&linkBack=PaddleNumList.php"> ' . (int)$pn_Num . "</a>\n" ?>
            </td>

            <td>
                <?= InputUtils::escapeHTML($buyerFirstName) . ' ' . InputUtils::escapeHTML($buyerLastName) ?>&nbsp;
            </td>
            <td>
                <a href=" PaddleNumDelete.php?PaddleNumID=<?= (int)$pn_ID . '&linkBack=PaddleNumList.php?FundRaiserID=' . (int)$iFundRaiserID ?>">Delete</a>
                    </td>
                </tr>
                <?php
            } // while
        } // if
        ?>

    </table>
</div>
</form>
<?php
require_once __DIR__ . '/Include/Footer.php';
