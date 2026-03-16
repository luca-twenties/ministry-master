<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\LoggerUtils;
use Propel\Runtime\Propel;

$sPageTitle = gettext('Free-Text Query');

// Security: User must be an Admin to access this page.  It allows unrestricted database access!
// Otherwise, re-direct them to the main menu.
AuthenticationManager::redirectHomeIfNotAdmin();

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

if (isset($_POST['SQL'])) {
    // Assign the value locally
    $sSQL = stripslashes(trim($_POST['SQL']));
} else {
    $sSQL = '';
}

if (isset($_POST['CSV'])) {
    ExportQueryResults($sSQL, $rsQueryResults);
    exit;
}

require_once __DIR__ . '/Include/Header.php';
?>

<form method="post">
    <div class="text-center">
        <table>
            <tr>
                <td class="LabelColumn"> <?= gettext('Export Results to CSV file') ?> </td>
                <td class="TextColumn"><input name="CSV" type="checkbox" id="CSV" value="1"></td>
            </tr>
        </table>
    </div>

    <p class="text-center">
        <textarea style="font-family:courier,fixed; font-size:9pt; padding:1rem;" cols="60" rows="10" name="SQL"><?= $sSQL ?></textarea>
    </p>
    <p class="text-center">
        <input type="submit" class="btn btn-secondary" name="Submit" value="<?= gettext('Execute SQL') ?>">
    </p>

</form>

<?php
if (isset($_POST['SQL'])) {
    if (strtolower(mb_substr($sSQL, 0, 6)) === 'select') {
        RunFreeQuery($sSQL, $rsQueryResults);
    }
}

function querySqlDbQuery(string $sql, &$error = null)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    try {
        $stmt = $dbConnection->query($sql);
        if ($stmt === false) {
            $error = 'SQLite query failed';
            return false;
        }
        $rows = $stmt->fetchAll(\PDO::FETCH_BOTH);
        $columns = [];
        $count = $stmt->columnCount();
        for ($i = 0; $i < $count; $i++) {
            $meta = $stmt->getColumnMeta($i);
            $columns[] = $meta['name'] ?? ('col_' . $i);
        }
        return ['rows' => $rows, 'index' => 0, 'columns' => $columns];
    } catch (\Throwable $e) {
        $error = $e->getMessage();
        LoggerUtils::getAppLogger()->error('SQLite query failed', ['sql' => $sql, 'exception' => $e]);
        return false;
    }
}

function querySqlDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function querySqlDbFetchArray(&$result)
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

function querySqlDbNumFields($result): int
{
    if (is_array($result) && array_key_exists('columns', $result)) {
        return count($result['columns']);
    }

    return mysqli_num_fields($result);
}

function querySqlDbFetchFieldDirect($result, int $index)
{
    if (is_array($result) && array_key_exists('columns', $result)) {
        return (object) ['name' => $result['columns'][$index] ?? ('col_' . $index)];
    }

    return mysqli_fetch_field_direct($result, $index);
}

function ExportQueryResults(string $sSQL, &$rsQueryResults)
{
    global $isSqlite;

    $sCSVstring = '';

    //Run the SQL
    $error = null;
    $rsQueryResults = querySqlDbQuery($sSQL, $error);

    if ($rsQueryResults === false) {
        $sCSVstring = gettext('An error occurred') . ': ' . ($error ?? 'unknown error');
    } else {
        //Loop through the fields and write the header row
        for ($iCount = 0; $iCount < querySqlDbNumFields($rsQueryResults); $iCount++) {
            $fieldInfo = querySqlDbFetchFieldDirect($rsQueryResults, $iCount);
            $sCSVstring .= $fieldInfo->name . ',';
        }

        $sCSVstring .= "\n";

        //Loop through the recordset
        while ($aRow = querySqlDbFetchArray($rsQueryResults)) {
            //Loop through the fields and write each one
            for ($iCount = 0; $iCount < querySqlDbNumFields($rsQueryResults); $iCount++) {
                $outStr = str_replace('"', '""', $aRow[$iCount]);
                $sCSVstring .= '"' . $outStr . '",';
            }

            $sCSVstring .= "\n";
        }
    }

    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename=Query-' . date(SystemConfig::getValue("sDateFilenameFormat")) . '.csv');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo $sCSVstring;
    exit;
}

//Display the count of the recordset
if (isset($_POST['SQL'])) {
    echo '<p class="text-center">';
    echo querySqlDbNumRows($rsQueryResults) . gettext(' record(s) returned');
    echo '</p>';
}

function RunFreeQuery(string $sSQL, &$rsQueryResults)
{
    //Run the SQL
    $error = null;
    $rsQueryResults = querySqlDbQuery($sSQL, $error);

    if ($rsQueryResults === false) {
        echo gettext('An error occurred') . ': ' . ($error ?? 'unknown error');
    } else {
        echo '<table class="table table-striped mx-auto">';
        echo '<thead><tr class="table-light">';

        //Loop through the fields and write the header row
        for ($iCount = 0; $iCount < querySqlDbNumFields($rsQueryResults); $iCount++) {
            //If this field is called "AddToCart", don't display this field...
            $fieldInfo = querySqlDbFetchFieldDirect($rsQueryResults, $iCount);
            if ($fieldInfo->name != 'AddToCart') {
                echo '  <td class="text-center">
                            <b>' . $fieldInfo->name . '</b>
                            </td>';
            }
        }

        echo '</tr></thead><tbody>';

        //Loop through the recordset
        while ($aRow = querySqlDbFetchArray($rsQueryResults)) {
            echo '<tr>';

            //Loop through the fields and write each one
            for ($iCount = 0; $iCount < querySqlDbNumFields($rsQueryResults); $iCount++) {
                //If this field is called "AddToCart", add this to the hidden form field...
                $fieldInfo = querySqlDbFetchFieldDirect($rsQueryResults, $iCount);
                if ($fieldInfo->name === 'AddToCart') {
                    $aHiddenFormField[] = $aRow[$iCount];
                } else {  //...otherwise just render the field
                    //Write the actual value of this row
                    echo '<td class="text-center">' . InputUtils::escapeHTML($aRow[$iCount]) . '</td>';
                }
            }
            echo '</tr>';
        }

        echo '</table>';
        echo '<p class="text-center">';

        if ($aHiddenFormField && count($aHiddenFormField) > 0) {
?>
            <form method="post" action="CartView.php">
                <p class="text-center">
                    <input type="hidden" value="<?= implode(',', $aHiddenFormField) ?>" name="BulkAddToCart">
                    <input type="submit" class="btn btn-secondary" name="AddToCartSubmit" value="<?php echo gettext('Add Results To Cart'); ?>">&nbsp;
                    <input type="submit" class="btn btn-secondary" name="AndToCartSubmit" value="<?php echo gettext('Intersect Results With Cart'); ?>">&nbsp;
                    <input type="submit" class="btn btn-secondary" name="NotToCartSubmit" value="<?php echo gettext('Remove Results From Cart'); ?>">
                </p>
            </form>
<?php
        }

        echo '<p class="text-center"><a href="QueryList.php">' . gettext('Return to Query Menu') . '</a></p>';
        echo '<br><p class="card card-body" style="border-style: solid; margin-left: 50px; margin-right: 50px; border-width: 1px;"><span class="SmallText">' . str_replace(chr(13), '<br>', InputUtils::escapeHTML($sSQL)) . '</span></p>';
    }
}

require_once __DIR__ . '/Include/Footer.php';
