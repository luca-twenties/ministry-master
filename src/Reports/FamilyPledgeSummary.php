<?php

namespace ChurchCRM\Reports;

require_once __DIR__ . '/../Include/Config.php';
require_once __DIR__ . '/../Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Utils\FiscalYearUtils;
use ChurchCRM\Utils\InputUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function familyPledgeSummaryDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function familyPledgeSummaryDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

function familyPledgeSummaryDbFetchArray(&$result)
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

function familyPledgeSummaryDbDataSeek(&$result, int $offset): void
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        $result['index'] = $offset;
        return;
    }

    mysqli_data_seek($result, $offset);
}

// Security
AuthenticationManager::redirectHomeIfFalse(AuthenticationManager::getCurrentUser()->isFinanceEnabled(), 'Finance');

if (!empty($_POST['classList'])) {
    $classList = $_POST['classList'];

    if ($classList[0]) {
        $sSQL = 'SELECT * FROM list_lst WHERE lst_ID = 1 ORDER BY lst_OptionSequence';
        $rsClassifications = familyPledgeSummaryDbQuery($sSQL);

        $inClassList = '(';
        $notInClassList = '(';

        while ($aRow = familyPledgeSummaryDbFetchArray($rsClassifications)) {
            extract($aRow);
            if (in_array($lst_OptionID, $classList)) {
                if ($inClassList === '(') {
                    $inClassList .= $lst_OptionID;
                } else {
                    $inClassList .= ',' . $lst_OptionID;
                }
            } else {
                if ($notInClassList === '(') {
                    $notInClassList .= $lst_OptionID;
                } else {
                    $notInClassList .= ',' . $lst_OptionID;
                }
            }
        }
        $inClassList .= ')';
        $notInClassList .= ')';
    }
}

// Get the Fiscal Year ID out of the query string
$iFYID = InputUtils::legacyFilterInput($_POST['FYID'], 'int');
if (!$iFYID) {
    $iFYID = FiscalYearUtils::getCurrentFiscalYearId();
}
// Remember the chosen Fiscal Year ID
$_SESSION['idefaultFY'] = $iFYID;
$output = InputUtils::legacyFilterInput($_POST['output']);
$pledge_filter = '';
if (array_key_exists('pledge_filter', $_POST)) {
    $pledge_filter = InputUtils::legacyFilterInput($_POST['pledge_filter']);
}
$only_owe = '';
if (array_key_exists('only_owe', $_POST)) {
    $only_owe = InputUtils::legacyFilterInput($_POST['only_owe']);
}

// Get all the families
$sSQL = 'SELECT DISTINCT fam_ID, fam_Name FROM family_fam';

if ($classList[0]) {
    $sSQL .= ' LEFT JOIN person_per ON fam_ID=per_fam_ID';
}
$sSQL .= ' WHERE';

$criteria = '';
if ($classList[0]) {
    $q = ' per_cls_ID IN ' . $inClassList . ' AND per_fam_ID NOT IN (SELECT DISTINCT per_fam_ID FROM person_per WHERE per_cls_ID IN ' . $notInClassList . ')';
    if ($criteria) {
        $criteria .= ' AND' . $q;
    } else {
        $criteria = $q;
    }
}

if (!$criteria) {
    $criteria = ' 1';
}
$sSQL .= $criteria . ' ORDER BY fam_Name';

// Filter by Family
if (!empty($_POST['family'])) {
    $count = 0;
    foreach ($_POST['family'] as $famID) {
        $fam[$count++] = InputUtils::legacyFilterInput($famID, 'int');
    }
    if ($count === 1) {
        if ($fam[0]) {
            $sSQL .= " AND fam_ID='$fam[0]' ";
        }
    } else {
        $sSQL .= " AND (fam_ID='$fam[0]'";
        for ($i = 1; $i < $count; $i++) {
            $sSQL .= " OR fam_ID='$fam[$i]'";
        }
        $sSQL .= ') ';
    }
}
$rsFamilies = familyPledgeSummaryDbQuery($sSQL);

$sSQLFundCriteria = '';

// Build criteria string for funds
if (!empty($_POST['funds'])) {
    $fundCount = 0;
    foreach ($_POST['funds'] as $fundID) {
        $fund[$fundCount++] = InputUtils::legacyFilterInput($fundID, 'int');
    }
    if ($fundCount === 1) {
        if ($fund[0]) {
            $sSQLFundCriteria .= " AND plg_fundID='$fund[0]' ";
        }
    } else {
        $sSQLFundCriteria .= " AND (plg_fundID ='$fund[0]'";
        for ($i = 1; $i < $fundCount; $i++) {
            $sSQLFundCriteria .= " OR plg_fundID='$fund[$i]'";
        }
        $sSQLFundCriteria .= ') ';
    }
}

// Make the string describing the fund filter
if ($fundCount > 0) {
    if ($fundCount === 1) {
        if ($fund[0] == gettext('All Funds')) {
            $fundOnlyString = gettext(' for all funds');
        } else {
            $fundOnlyString = gettext(' for fund ');
        }
    } else {
        $fundOnlyString = gettext('for funds ');
    }
    for ($i = 0; $i < $fundCount; $i++) {
        $sSQL = 'SELECT fun_Name FROM donationfund_fun WHERE fun_ID=' . $fund[$i];
        $rsOneFund = familyPledgeSummaryDbQuery($sSQL);
        $aFundName = familyPledgeSummaryDbFetchArray($rsOneFund);
        $fundOnlyString .= $aFundName['fun_Name'];
        if ($i < $fundCount - 1) {
            $fundOnlyString .= ', ';
        }
    }
}

// Get the list of funds
$sSQL = 'SELECT fun_ID,fun_Name,fun_Description,fun_Active FROM donationfund_fun';
$rsFunds = familyPledgeSummaryDbQuery($sSQL);

$fundPaymentTotal = [];
$fundPledgeTotal = [];
while ($row = familyPledgeSummaryDbFetchArray($rsFunds)) {
    $fun_name = $row['fun_Name'];
    $fundPaymentTotal[$fun_name] = 0;
    $fundPledgeTotal[$fun_name] = 0;
}

// Create PDF Report
class PdfFamilyPledgeSummaryReport extends ChurchInfoReport
{
    // Constructor
    public function __construct()
    {
        parent::__construct('P', 'mm', $this->paperFormat);

        $this->SetFont('Times', '', 10);
        $this->SetMargins(20, 20);

        $this->SetAutoPageBreak(false);
    }
}

// Instantiate the directory class and build the report.
$pdf = new PdfFamilyPledgeSummaryReport();
$pdf->addPage();

$leftX = 10;
$famNameX = 10;
$famMethodX = 90;
$famFundX = 120;
$famPledgeX = 150;
$famPayX = 170;
$famOweX = 190;

$famNameWid = $famMethodX - $famNameX;
$famMethodWid = $famFundX - $famMethodX;
$famFundWid = $famPledgeX - $famFundX;
$famPledgeWid = $famPayX - $famPledgeX;
$famPayWid = $famOweX - $famPayX;
$famOweWid = $famPayWid;

$pageTop = 10;
$y = $pageTop;
$lineInc = 4;

$pdf->writeAt($leftX, $y, gettext('Pledge Summary By Family'));
$y += $lineInc;

$pdf->writeAtCell($famNameX, $y, $famNameWid, gettext('Name'));
$pdf->writeAtCell($famMethodX, $y, $famMethodWid, gettext('Method'));
$pdf->writeAtCell($famFundX, $y, $famFundWid, gettext('Fund'));
$pdf->writeAtCell($famPledgeX, $y, $famPledgeWid, gettext('Pledge'));
$pdf->writeAtCell($famPayX, $y, $famPayWid, gettext('Paid'));
$pdf->writeAtCell($famOweX, $y, $famOweWid, gettext('Owe'));
$y += $lineInc;

// Loop through families
while ($aFam = familyPledgeSummaryDbFetchArray($rsFamilies)) {
    extract($aFam);

    // Check for pledges if filtering by pledges
    if ($pledge_filter === 'pledge') {
        $temp = "SELECT plg_plgID FROM pledge_plg
            WHERE plg_FamID='$fam_ID' AND plg_PledgeOrPayment='Pledge' AND plg_FYID=$iFYID" . $sSQLFundCriteria;
        $rsPledgeCheck = familyPledgeSummaryDbQuery($temp);
        if (familyPledgeSummaryDbNumRows($rsPledgeCheck) === 0) {
            continue;
        }
    }

    // Get pledges and payments for this family and this fiscal year
    $sSQL = 'SELECT *, b.fun_Name AS fundName FROM pledge_plg
             LEFT JOIN donationfund_fun b ON plg_fundID = b.fun_ID
             WHERE plg_FamID = ' . $fam_ID . ' AND plg_FYID = ' . $iFYID . $sSQLFundCriteria . ' ORDER BY plg_date';

    $rsPledges = familyPledgeSummaryDbQuery($sSQL);

    // If there is no pledge or a payment go to next family
    if (familyPledgeSummaryDbNumRows($rsPledges) === 0) {
        continue;
    }

    if ($only_owe === 'yes') {
        // Run through pledges and payments for this family to see if there are any unpaid pledges
        $oweByFund = [];
        $bOwe = 0;
        while ($aRow = familyPledgeSummaryDbFetchArray($rsPledges)) {
            extract($aRow);
            if ($plg_PledgeOrPayment === 'Pledge') {
                $oweByFund[$plg_fundID] -= $plg_amount;
            } else {
                $oweByFund[$plg_fundID] += $plg_amount;
            }
        }
        foreach ($oweByFund as $oweRow) {
            if ($oweRow < 0) {
                $bOwe = 1;
            }
        }
        if (!$bOwe) {
            continue;
        }
    }

    // Get pledges only
    $sSQL = 'SELECT *, b.fun_Name AS fundName FROM pledge_plg
             LEFT JOIN donationfund_fun b ON plg_fundID = b.fun_ID
             WHERE plg_FamID = ' . $fam_ID . ' AND plg_FYID = ' . $iFYID . $sSQLFundCriteria . " AND plg_PledgeOrPayment = 'Pledge' ORDER BY plg_date";
    $rsPledges = familyPledgeSummaryDbQuery($sSQL);

    $totalAmountPledges = 0;

    if (familyPledgeSummaryDbNumRows($rsPledges) !== 0) {
        $totalAmount = 0;
        $cnt = 0;
        while ($aRow = familyPledgeSummaryDbFetchArray($rsPledges)) {
            extract($aRow);

            if (strlen($fundName) > 19) {
                $fundName = mb_substr($fundName, 0, 18) . '...';
            }

            $fundPledgeTotal[$fundName] += $plg_amount;
            $fundPledgeMethod[$fundName] = $plg_method;
            $totalAmount += $plg_amount;
            $cnt += 1;
        }
        $pdf->SetFont('Times', '', 10);
        $totalAmountPledges = $totalAmount;
    }

    // Get payments only
    $sSQL = 'SELECT *, b.fun_Name AS fundName FROM pledge_plg
             LEFT JOIN donationfund_fun b ON plg_fundID = b.fun_ID
             WHERE plg_FamID = ' . $fam_ID . ' AND plg_FYID = ' . $iFYID . $sSQLFundCriteria . " AND plg_PledgeOrPayment = 'Payment' ORDER BY plg_date";
    $rsPledges = familyPledgeSummaryDbQuery($sSQL);

    $totalAmountPayments = 0;
    if (familyPledgeSummaryDbNumRows($rsPledges) !== 0) {
        $totalAmount = 0;
        $cnt = 0;
        while ($aRow = familyPledgeSummaryDbFetchArray($rsPledges)) {
            extract($aRow);

            $totalAmount += $plg_amount;
            $fundPaymentTotal[$fundName] += $plg_amount;
            $cnt += 1;
        }
        $totalAmountPayments = $totalAmount;
    }

    if (familyPledgeSummaryDbNumRows($rsFunds) > 0) {
        familyPledgeSummaryDbDataSeek($rsFunds, 0);
        while ($row = familyPledgeSummaryDbFetchArray($rsFunds)) {
            $fun_name = $row['fun_Name'];
            if ($fundPledgeTotal[$fun_name] > 0) {
                $amountDue = $fundPledgeTotal[$fun_name] - $fundPaymentTotal[$fun_name];
                if ($amountDue < 0) {
                    $amountDue = 0;
                }

                $pdf->writeAtCell($famNameX, $y, $famNameWid, $pdf->makeSalutation($fam_ID));
                $pdf->writeAtCell($famPledgeX, $y, $famPledgeWid, $fundPledgeTotal[$fun_name]);
                $pdf->writeAtCell($famMethodX, $y, $famMethodWid, $fundPledgeMethod[$fun_name]);
                $pdf->writeAtCell($famFundX, $y, $famFundWid, $fun_name);
                $pdf->writeAtCell($famPayX, $y, $famPayWid, $fundPaymentTotal[$fun_name]);
                $pdf->writeAtCell($famOweX, $y, $famOweWid, $amountDue);
                $y += $lineInc;
                if ($y > 250) {
                    $pdf->addPage();
                    $y = $pageTop;
                }
            }
            // Clear the array for the next person
            $fundPledgeTotal[$fun_name] = 0;
            $fundPaymentTotal[$fun_name] = 0;
        }
    }
}

if (SystemConfig::getIntValue('iPDFOutputType') === 1) {
    $pdf->Output('FamilyPledgeSummary' . date(SystemConfig::getValue('sDateFilenameFormat')) . '.pdf', 'D');
} else {
    $pdf->Output();
}
