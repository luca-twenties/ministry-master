<?php

namespace ChurchCRM\Reports;

require_once __DIR__ . '/../Include/Config.php';
require_once __DIR__ . '/../Include/Functions.php';

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\Utils\FiscalYearUtils;
use ChurchCRM\Utils\InputUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function votingMembersDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function votingMembersDbNormalizeRow(array $row, ?int $mode)
{
    if ($mode === null) {
        if (defined('MYSQLI_BOTH')) {
            $mode = MYSQLI_BOTH;
        } else {
            $mode = \PDO::FETCH_BOTH;
        }
    }

    if (defined('MYSQLI_ASSOC') && $mode === MYSQLI_ASSOC) {
        $assoc = [];
        foreach ($row as $key => $value) {
            if (is_string($key)) {
                $assoc[$key] = $value;
            }
        }
        return $assoc;
    }
    if (defined('MYSQLI_NUM') && $mode === MYSQLI_NUM) {
        $numeric = [];
        foreach ($row as $key => $value) {
            if (is_int($key)) {
                $numeric[] = $value;
            }
        }
        return $numeric;
    }

    return $row;
}

function votingMembersDbFetchArray(&$result, ?int $mode = null)
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        return votingMembersDbNormalizeRow($row, $mode);
    }

    if ($mode === null) {
        $mode = defined('MYSQLI_BOTH') ? MYSQLI_BOTH : \PDO::FETCH_BOTH;
    }

    return mysqli_fetch_array($result, $mode);
}

function votingMembersDbFetchRow(&$result)
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return votingMembersDbFetchArray($result, defined('MYSQLI_NUM') ? MYSQLI_NUM : \PDO::FETCH_NUM);
    }

    return mysqli_fetch_row($result);
}

function votingMembersDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

// Get the Fiscal Year ID out of the query string
$iFYID = (int) InputUtils::legacyFilterInput($_POST['FYID'], 'int');
if (!$iFYID) {
    $iFYID = FiscalYearUtils::getCurrentFiscalYearId();
}
// Remember the chosen Fiscal Year ID
$_SESSION['idefaultFY'] = $iFYID;
$iRequireDonationYears = InputUtils::legacyFilterInput($_POST['RequireDonationYears'], 'int');
$output = InputUtils::legacyFilterInput($_POST['output']);

class PdfVotingMembers extends ChurchInfoReport
{
    // Constructor
    public function __construct()
    {
        parent::__construct('P', 'mm', $this->paperFormat);

        $this->SetFont('Times', '', 10);
        $this->SetMargins(20, 20);

        $this->SetAutoPageBreak(false);
        $this->addPage();
    }
}

$pdf = new PdfVotingMembers();

$topY = 10;
$curY = $topY;

$pdf->writeAt(
    SystemConfig::getValue('leftX'),
    $curY,
    gettext('Voting Members') . ' ' . MakeFYString($iFYID)
);
$curY += 10;

$votingMemberCount = 0;

// Get all the families
$sSQL = 'SELECT fam_ID, fam_Name FROM family_fam WHERE 1 ORDER BY fam_Name';
$rsFamilies = votingMembersDbQuery($sSQL);

// Loop through families
while ($aFam = votingMembersDbFetchArray($rsFamilies)) {
    extract($aFam);

    // Get pledge date ranges
    $donation = 'no';
    if ($iRequireDonationYears > 0) {
        $startdate = $iFYID + 1995 - $iRequireDonationYears;
        $startdate .= '-' . SystemConfig::getValue('iFYMonth') . '-' . '01';
        $enddate = $iFYID + 1995 + 1;
        $enddate .= '-' . SystemConfig::getValue('iFYMonth') . '-' . '01';

        // Get payments only
        $sSQL = 'SELECT COUNT(plg_plgID) AS count FROM pledge_plg
            WHERE plg_FamID = ' . $fam_ID . " AND plg_PledgeOrPayment = 'Payment' AND
                 plg_date >= '$startdate' AND plg_date < '$enddate'";
        $rsPledges = votingMembersDbQuery($sSQL);
        [$count] = votingMembersDbFetchRow($rsPledges);
        if ($count > 0) {
            $donation = 'yes';
        }
    }

    if (($iRequireDonationYears == 0) || $donation === 'yes') {
        $pdf->writeAt(SystemConfig::getValue('leftX'), $curY, $fam_Name);

        //Get the family members for this family
        $sSQL = 'SELECT per_FirstName, per_LastName, cls.lst_OptionName AS sClassName
                FROM person_per
                INNER JOIN list_lst cls ON per_cls_ID = cls.lst_OptionID AND cls.lst_ID = 1
                WHERE per_fam_ID = ' . $fam_ID . " AND cls.lst_OptionName='" . gettext('Member') . "'";

        $rsFamilyMembers = votingMembersDbQuery($sSQL);

        if (votingMembersDbNumRows($rsFamilyMembers) === 0) {
            $curY += 5;
        }

        while ($aMember = votingMembersDbFetchArray($rsFamilyMembers)) {
            extract($aMember);
            $pdf->writeAt(SystemConfig::getValue('leftX') + 30, $curY, $per_FirstName . ' ' . $per_LastName);
            $curY += 5;
            if ($curY > 245) {
                $pdf->addPage();
                $curY = $topY;
            }
            $votingMemberCount += 1;
        }
        if ($curY > 245) {
            $pdf->addPage();
            $curY = $topY;
        }
    }
}

$curY += 5;
$pdf->writeAt(SystemConfig::getValue('leftX'), $curY, 'Number of Voting Members: ' . $votingMemberCount);

if (SystemConfig::getIntValue('iPDFOutputType') === 1) {
    $pdf->Output('VotingMembers' . date(SystemConfig::getValue('sDateFilenameFormat')) . '.pdf', 'D');
} else {
    $pdf->Output();
}
