<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\LoggerUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$sPageTitle = gettext('Query View');

// Get the QueryID from the querystring
$iQueryID = InputUtils::legacyFilterInput($_GET['QueryID'], 'int');

$aFinanceQueries = explode(',', SystemConfig::getValue('aFinanceQueries'));

if (!AuthenticationManager::getCurrentUser()->isFinanceEnabled() && in_array($iQueryID, $aFinanceQueries)) {
    RedirectUtils::redirect('v2/dashboard');
}

require_once __DIR__ . '/Include/Header.php';

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;
$mysqlConnection = $isSqlite ? null : ($GLOBALS['cnInfoCentral'] ?? null);

function queryViewDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    try {
        $stmt = $dbConnection->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_BOTH);
        $columns = [];
        $count = $stmt->columnCount();
        for ($i = 0; $i < $count; $i++) {
            $meta = $stmt->getColumnMeta($i);
            $columns[] = $meta['name'] ?? ('col_' . $i);
        }
        return ['rows' => $rows, 'index' => 0, 'columns' => $columns];
    } catch (\Throwable $e) {
        LoggerUtils::getAppLogger()->error('SQLite query failed', ['sql' => $sql, 'exception' => $e]);
        return false;
    }
}

function queryViewDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function queryViewDbDataSeek(&$result, int $index): void
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        $result['index'] = max(0, $index);
        return;
    }

    mysqli_data_seek($result, $index);
}

function queryViewDbFetchArray(&$result)
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

function queryViewDbNumFields($result): int
{
    if (is_array($result) && array_key_exists('columns', $result)) {
        return count($result['columns']);
    }

    return mysqli_num_fields($result);
}

function queryViewDbFetchFieldDirect($result, int $index)
{
    if (is_array($result) && array_key_exists('columns', $result)) {
        return (object) ['name' => $result['columns'][$index] ?? ('col_' . $index)];
    }

    return mysqli_fetch_field_direct($result, $index);
}

function queryViewEscapeString(string $value): string
{
    global $isSqlite, $dbConnection, $mysqlConnection;

    if ($isSqlite) {
        $quoted = $dbConnection->quote($value);
        return $quoted === false ? str_replace("'", "''", $value) : trim($quoted, "'");
    }

    if ($mysqlConnection instanceof \mysqli) {
        return $mysqlConnection->real_escape_string($value);
    }

    return addslashes($value);
}

// Get the query information
$sSQL = 'SELECT * FROM query_qry WHERE qry_ID = ' . $iQueryID;
$rsSQL = queryViewDbQuery($sSQL);
extract(queryViewDbFetchArray($rsSQL));

if ($isSqlite) {
    // Ensure sqlite-compatible SQL for legacy queries that may still carry MySQL syntax.
    $sqliteQueryOverrides = [
        9 => 'SELECT 
per_ID as AddToCart, 
per_FirstName || \' \' || per_LastName AS Name, 
r2p_Value || \' \' AS Value
FROM person_per,record2property_r2p
WHERE per_ID = r2p_record_ID
AND r2p_pro_ID = ~PropertyID~
ORDER BY per_LastName',
        18 => 'SELECT per_ID as AddToCart, per_BirthDay as Day, per_FirstName || \' \' || per_LastName AS Name FROM person_per WHERE per_cls_ID=~percls~ AND per_BirthMonth=~birthmonth~ ORDER BY per_BirthDay',
        22 => 'SELECT per_ID as AddToCart, CAST(strftime(\'%d\', per_MembershipDate) AS INTEGER) as Day, per_MembershipDate AS DATE, per_FirstName || \' \' || per_LastName AS Name FROM person_per WHERE per_cls_ID=1 AND CAST(strftime(\'%m\', per_MembershipDate) AS INTEGER)=~membermonth~ ORDER BY per_MembershipDate',
        25 => 'SELECT per_ID as AddToCart, \'<a href=PersonView.php?PersonID=\' || per_ID || \'>\' || per_FirstName || \' \' || per_LastName || \'</a>\' AS Name FROM person_per LEFT JOIN person2volunteeropp_p2vo ON per_id = p2vo_per_ID WHERE p2vo_vol_ID = ~volopp~ ORDER BY per_LastName',
        26 => 'SELECT per_ID as AddToCart, per_FirstName || \' \' || per_LastName AS Name FROM person_per WHERE datetime(\'now\', \'-\' || ~friendmonths~ || \' months\')<per_FriendDate ORDER BY per_MembershipDate',
        30 => 'SELECT per_ID as AddToCart, per_FirstName || \' \' || per_LastName AS Name, fam_address1, fam_city, fam_state, fam_zip FROM person_per join family_fam on per_fam_id=fam_id where per_fmr_id<>3 and per_fam_id in (select fam_id from family_fam inner join pledge_plg a on a.plg_famID=fam_ID and a.plg_FYID=~fyid1~ and a.plg_amount>0) and per_fam_id not in (select fam_id from family_fam inner join pledge_plg b on b.plg_famID=fam_ID and b.plg_FYID=~fyid2~ and b.plg_amount>0)',
        100 => 'SELECT a.per_ID as AddToCart, \'<a href=PersonView.php?PersonID=\' || a.per_ID || \'>\' || a.per_FirstName || \' \' || a.per_LastName || \'</a>\' AS Name FROM person_per AS a LEFT JOIN person2volunteeropp_p2vo p2v1 ON (a.per_id = p2v1.p2vo_per_ID AND p2v1.p2vo_vol_ID = ~volopp1~) LEFT JOIN person2volunteeropp_p2vo p2v2 ON (a.per_id = p2v2.p2vo_per_ID AND p2v2.p2vo_vol_ID = ~volopp2~) WHERE p2v1.p2vo_per_ID=p2v2.p2vo_per_ID ORDER BY per_LastName',
        200 => 'SELECT a.per_ID as AddToCart, \'<a href=PersonView.php?PersonID=\' || a.per_ID || \'>\' || a.per_FirstName || \' \' || a.per_LastName || \'</a>\' AS Name FROM person_per AS a LEFT JOIN person_custom pc ON a.per_id = pc.per_ID WHERE pc.~custom~=\'~value~\' ORDER BY per_LastName',
        201 => 'SELECT per_ID as AddToCart, \'<a href=PersonView.php?PersonID=\' || per_ID || \'>\' || per_FirstName || \' \' || per_LastName || \'</a>\' AS Name, per_LastName AS Lastname FROM person_per LEFT OUTER JOIN (SELECT event_attend.attend_id, event_attend.person_id FROM event_attend WHERE event_attend.event_id IN (~event~)) a ON person_per.per_ID = a.person_id WHERE a.attend_id is NULL ORDER BY per_LastName, per_FirstName',
    ];

    if (isset($sqliteQueryOverrides[$iQueryID])) {
        $qry_SQL = $sqliteQueryOverrides[$iQueryID];
    }
}

// Get the parameters for this query
$sSQL = 'SELECT * FROM queryparameters_qrp WHERE qrp_qry_ID = ' . $iQueryID . ' ORDER BY qrp_ID';
$rsParameters = queryViewDbQuery($sSQL);

// If the form was submitted or there are no parameters, run the query
if (isset($_POST['Submit']) || queryViewDbNumRows($rsParameters) === 0) {
    //Check that all validation rules were followed
    ValidateInput();

    // Any errors?
    if (count($aErrorText) == 0) {
        // No errors; process the SQL, run the query, and display the results
        DisplayQueryInfo();
        ProcessSQL();
        DoQuery();
    } else {
        // Yes, there were errors; re-display the parameter form (the DisplayParameterForm function will
        // pick up and display any error messages)
        DisplayQueryInfo();
        DisplayParameterForm();
    }
} else {
    // Display the parameter form
    DisplayQueryInfo();
    DisplayParameterForm();
}

// Loops through all the parameters and ensures validation rules have been followed
function ValidateInput()
{
    global $rsParameters;
    global $_POST;
    global $vPOST;
    global $aErrorText;

    // Initialize the validated post array, error text array, and the error flag
    $vPOST = [];
    $aErrorText = [];
    $bError = false;

    // Are there any parameters to loop through?
    if (queryViewDbNumRows($rsParameters)) {
        queryViewDbDataSeek($rsParameters, 0);
    }

    while ($aRow = queryViewDbFetchArray($rsParameters)) {
        extract($aRow);

        // Is the value required?
        if ($qrp_Required && empty($_POST[$qrp_Alias])) {
            $bError = true;
            $aErrorText[$qrp_Alias] = gettext('This value is required.');
        } else {
            // Assuming there was no error above...
            // Validate differently depending on the contents of the qrp_Validation field
            switch ($qrp_Validation) {
                // Numeric validation
                case 'n':
                    // Is it a number?
                    if (!is_numeric($_POST[$qrp_Alias])) {
                        $bError = true;
                        $aErrorText[$qrp_Alias] = gettext('This value must be numeric.');
                    } else {
                        // Is it more than the minimum?
                        if ($_POST[$qrp_Alias] < $qrp_NumericMin) {
                            $bError = true;
                            $aErrorText[$qrp_Alias] = gettext('This value must be at least ') . $qrp_NumericMin;
                        } elseif ($_POST[$qrp_Alias] > $qrp_NumericMax) {
                            // Is it less than the maximum?
                            $bError = true;
                            $aErrorText[$qrp_Alias] = gettext('This value cannot be more than ') . $qrp_NumericMax;
                        }
                    }

                    $vPOST[$qrp_Alias] = InputUtils::legacyFilterInput($_POST[$qrp_Alias], 'int');
                    break;

                // Alpha validation
                case 'a':
                    // Is the length less than the maximum?
                    if (strlen($_POST[$qrp_Alias]) > $qrp_AlphaMaxLength) {
                        $bError = true;
                        $aErrorText[$qrp_Alias] = gettext('This value cannot be more than ') . $qrp_AlphaMaxLength . gettext(' characters long');
                    } elseif (strlen($_POST[$qrp_Alias]) < $qrp_AlphaMinLength) {
                        // Is the length more than the minimum?
                        $bError = true;
                        $aErrorText[$qrp_Alias] = gettext('This value cannot be less than ') . $qrp_AlphaMinLength . gettext(' characters long');
                    }

                    $vPOST[$qrp_Alias] = InputUtils::legacyFilterInput($_POST[$qrp_Alias]);
                    break;

                default:
                    // Sanitize input to prevent SQL injection
                    $vPOST[$qrp_Alias] = InputUtils::sanitizeText($_POST[$qrp_Alias]);
                    break;
            }
        }
    }
}

// Loops through the list of parameters and replaces their alias in the SQL with the value given for the parameter
function ProcessSQL()
{
    global $vPOST;
    global $qry_SQL;
    global $rsParameters;
    global $cnInfoCentral;

    // Loop through the list of parameters
    if (queryViewDbNumRows($rsParameters)) {
        queryViewDbDataSeek($rsParameters, 0);
    }
    while ($aRow = queryViewDbFetchArray($rsParameters)) {
        extract($aRow);

        // Debugging code
        // echo "--" . $qry_SQL . "<br>--" . "~" . $qrp_Alias . "~" . "<br>--" . $vPOST[$qrp_Alias] . "<p>";

        // Replace the placeholder with the parameter value
        // GHSA-qc2c-qmw4-52fp: Properly escape values before SQL substitution to prevent injection
        $qrp_Value = escapeQueryParameter($vPOST[$qrp_Alias], $cnInfoCentral);
        $qry_SQL = str_replace('~' . $qrp_Alias . '~', $qrp_Value, $qry_SQL);
    }
}

// Helper function to safely escape and format query parameters
function escapeQueryParameter($value, $connection)
{
    if (is_array($value)) {
        // For arrays, escape each element and quote it, then join with commas
        $escapedValues = array_map(function($val) use ($connection) {
            return "'" . queryViewEscapeString((string)$val) . "'";
        }, $value);
        return implode(',', $escapedValues);
    }
    
    // For single values, determine if numeric or string
    if (is_numeric($value)) {
        // Numeric values don't need quotes
        return (string)$value;
    }
    
    // String values need quotes and escaping
    return "'" . queryViewEscapeString((string)$value) . "'";
}

// Checks if a count is to be displayed, and displays it if required
function DisplayRecordCount()
{
    global $qry_Count;
    global $rsQueryResults;

    // Are we supposed to display a count for this query?
    if ($qry_Count == 1) {
        //Display the count of the recordset
        echo '<p class="text-center">';
        echo queryViewDbNumRows($rsQueryResults) . gettext(' record(s) returned');
        echo '</p>';
    }
}

// Runs the parameterized SQL and display the results
function DoQuery()
{
    global $cnInfoCentral;
    global $aRowClass;
    global $rsQueryResults;
    global $qry_SQL;
    global $iQueryID;
    global $qry_Name;
    global $qry_Count;

    // Run the SQL
    $rsQueryResults = queryViewDbQuery($qry_SQL); ?>
<div class="card card-primary">

    <div class="card-body">
        <p class="text-right">
            <?= $qry_Count ? queryViewDbNumRows($rsQueryResults) . gettext(' record(s) returned') : ''; ?>
        </p>

        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <?php
                    // Loop through the fields and write the header row
                for ($iCount = 0; $iCount < queryViewDbNumFields($rsQueryResults); $iCount++) {
                    // If this field is called "AddToCart", provision a headerless column to hold the cart action buttons
                    $fieldInfo = queryViewDbFetchFieldDirect($rsQueryResults, $iCount);
                    if ($fieldInfo->name != 'AddToCart') {
                        echo '<th>' . $fieldInfo->name . '</th>';
                    } else {
                        echo '<th></th>';
                    }
                } ?>
            </thead>
            <tbody>
    <?php
    $aAddToCartIDs = [];

    while ($aRow = queryViewDbFetchArray($rsQueryResults)) {
        echo '<tr>';

        // Loop through the fields and write each one
        for ($iCount = 0; $iCount < queryViewDbNumFields($rsQueryResults); $iCount++) {
            // If this field is called "AddToCart", add a cart button to the form
            $fieldInfo = queryViewDbFetchFieldDirect($rsQueryResults, $iCount);
            if ($fieldInfo->name === 'AddToCart') {
                ?>
                <td>
                    <button class="btn btn-sm btn-secondary AddToCart" data-cart-id="<?= $aRow[$iCount] ?>" data-cart-type="person">
                        <span class="fa-stack">
                        <i class="fa-solid fa-square fa-stack-2x"></i>
                        <i class="fa-solid fa-cart-plus fa-stack-1x fa-inverse"></i>
                        </span>
                    </button>
                </td>
                <?php

                $aAddToCartIDs[] = $aRow[$iCount];
            } else {
                // ...otherwise just render the field
                // Write the actual value of this row
                echo '<td>' . InputUtils::escapeHTML($aRow[$iCount]) . '</td>';
            }
        }

        echo '</tr>';
    } ?>
            </tbody>
        </table>
        </div>
    </div>

    <div class="card-footer">
        <p>
        <?php if (count($aAddToCartIDs)) { ?>
            <div class="col-sm-offset-1">
                <input type="hidden" value="<?= implode(',', $aAddToCartIDs) ?>" name="BulkAddToCart">
                <button type="button" id="addResultsToCart" class="btn btn-success" > <?= gettext('Add Results to Cart') ?></button>
                <button type="button" id="removeResultsFromCart" class="btn btn-danger" > <?= gettext('Remove Results from Cart') ?></button>
            </div>
            <script nonce="<?= SystemURLs::getCSPNonce() ?>">
                // Wait for locales to load before setting up cart handlers
                // CartManager uses i18next for notifications
                window.CRM.onLocalesReady(function() {
                    $("#addResultsToCart").click(function () {
                        var selectedPersons = <?= json_encode($aAddToCartIDs) ?>;
                        window.CRM.cartManager.addPerson(selectedPersons, {
                            showNotification: true
                        });
                    });

                    $("#removeResultsFromCart").click(function(){
                        var selectedPersons = <?= json_encode($aAddToCartIDs) ?>;
                        window.CRM.cartManager.removePerson(selectedPersons, {
                            confirm: true,
                            showNotification: true
                        });
                    });
                });
            </script>

        <?php } ?>
        </p>

        <p class="text-right">
            <?= '<a href="QueryView.php?QueryID=' . $iQueryID . '">' . gettext('Run Query Again') . '</a>'; ?>
        </p>
    </div>

</div>

<div class="card card-info">
    <div class="card-header">
        <div class="card-title">Query</div>
    </div>
    <div class="card-body">
        <code><?= str_replace(chr(13), '<br>', InputUtils::escapeHTML($qry_SQL)); ?></code>
    </div>
</div>
    <?php
}

// Displays the name and description of the query
function DisplayQueryInfo()
{
    global $qry_Name;
    global $qry_Description; ?>
<div class="card card-info">
    <div class="card-body">
        <p><strong><?= gettext($qry_Name); ?></strong></p>
        <p><?= gettext($qry_Description); ?></p>
    </div>
</div>
    <?php
}

function getQueryFormInput($queryParameters)
{
    global $aErrorText;

    extract($queryParameters);

    $input = '';
    $label = '<label>' . gettext($qrp_Name) . '</label>';
    $helpMsg = '<div>' . gettext($qrp_Description) . '</div>';

    switch ($qrp_Type) {
        // Standard INPUT box
        case 0:
            $input = '<input size="' . $qrp_InputBoxSize . '" name="' . $qrp_Alias . '" type="text" value="' . $qrp_Default . '" class="form-control">';
            break;

        // SELECT box with OPTION tags supplied in the queryparameteroptions_qpo table
        case 1:
            // Get the query parameter options for this parameter
            $sSQL = 'SELECT * FROM queryparameteroptions_qpo WHERE qpo_qrp_ID = ' . $qrp_ID;
            $rsParameterOptions = queryViewDbQuery($sSQL);

            $input = '<select name="' . $qrp_Alias . '" class="form-control">';
            $input .= '<option disabled selected value> -- ' . gettext("select an option") . ' -- </option>';

            // Loop through the parameter options
            while ($ThisRow = queryViewDbFetchArray($rsParameterOptions)) {
                extract($ThisRow);
                $input .= '<option value="' . $qpo_Value . '">' . gettext($qpo_Display) . '</option>';
            }

            $input .= '</select>';
            break;

        // SELECT box with OPTION tags provided via a SQL query
        case 2:
            // Run the SQL to get the options
            $rsParameterOptions = queryViewDbQuery($qrp_OptionSQL);

            $input .= '<select name="' . $qrp_Alias . '" class="form-control">';
            $input .= '<option disabled selected value> -- select an option -- </option>';

            while ($ThisRow = queryViewDbFetchArray($rsParameterOptions)) {
                extract($ThisRow);
                $input .= '<option value="' . $Value . '">' . $Display . '</option>';
            }

            $input .= '</select>';
            break;

        case 3:
            // Run the SQL to get the options
            $rsParameterOptions = queryViewDbQuery($qrp_OptionSQL);

            $input .= '<select name="' . $qrp_Alias . '[]" class="form-control" size="10" multiple="multiple">';
            $input .= '<option disabled selected value> -- select an option -- </option>';

            while ($ThisRow = queryViewDbFetchArray($rsParameterOptions)) {
                extract($ThisRow);
                $input .= '<option value="' . $Value . '">' . $Display . '</option>';
            }

            $input .= '</select>';
            break;
    }

    $helpBlock = '<div class="help-block">' . $helpMsg . '</div>';

    if ($aErrorText[$qrp_Alias]) {
        $errorMsg = '<div>' . $aErrorText[$qrp_Alias] . '</div>';
        $helpBlock = '<div class="help-block">' . $helpMsg . $errorMsg . '</div>';
        return '<div class="form-group has-error">' . $label . $input . $helpBlock . '</div>';
    }

    return '<div class="form-group">' . $label . $input . $helpBlock . '</div>';
}

// Displays a form to enter values for each parameter, creating INPUT boxes and SELECT drop-downs as necessary
function DisplayParameterForm()
{
    global $rsParameters;
    global $iQueryID; ?>
<div class="row">
    <div class="col-md-8">

        <div class="card card-primary">

            <div class="card-body">

                <form method="post" action="QueryView.php?QueryID=<?= $iQueryID ?>">
    <?php
// Loop through the parameters and display an entry box for each one
    if (queryViewDbNumRows($rsParameters)) {
        queryViewDbDataSeek($rsParameters, 0);
    }
    while ($aRow = queryViewDbFetchArray($rsParameters)) {
        echo getQueryFormInput($aRow);
    } ?>

                    <div class="form-group text-right">
                        <input class="btn btn-primary" type="Submit" value="<?= gettext("Execute Query") ?>" name="Submit">
                    </div>
                </form>

            </div>
        </div> <!-- box -->

    </div>

</div>

    <?php
}

require_once __DIR__ . '/Include/Footer.php';
