<?php

namespace ChurchCRM\Reports;

require_once __DIR__ . '/../Include/Config.php';
require_once __DIR__ . '/../Include/Functions.php';

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\model\ChurchCRM\FundRaiserQuery;
use ChurchCRM\Utils\InputUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function frBidSheetsDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function frBidSheetsDbFetchArray(&$result)
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

if (!isset($_GET['CurrentFundraiser'])) {
    throw new \InvalidArgumentException('Missing required CurrentFundraiser parameter');
}
$iCurrentFundraiser = (int) InputUtils::legacyFilterInput($_GET['CurrentFundraiser'], 'int');

class PdfFRBidSheetsReport extends ChurchInfoReport
{
    public function __construct()
    {
        parent::__construct('P', 'mm', $this->paperFormat);

        $this->SetFont('Times', '', 10);
        $this->SetMargins(15, 25);

        $this->SetAutoPageBreak(true, 25);
    }
}

// Get the information about this fundraiser
$fundraiser = FundRaiserQuery::create()->findOneById($iCurrentFundraiser);
if ($fundraiser === null) {
    throw new \InvalidArgumentException('No results found for provided CurrentFundraiser parameter');
}

// Get all the donated items
$sSQL = 'SELECT * FROM donateditem_di LEFT JOIN person_per on per_ID=di_donor_ID ' .
        ' WHERE di_FR_ID=' . $fundraiser->getId() .
        ' ORDER BY SUBSTR(di_item,1,1),cast(SUBSTR(di_item,2) as unsigned integer),SUBSTR(di_item,4)';

$rsItems = frBidSheetsDbQuery($sSQL);

$pdf = new PdfFRBidSheetsReport();
$pdf->SetTitle($fundraiser->getTitle());

// Loop through items
while ($oneItem = frBidSheetsDbFetchArray($rsItems)) {
    extract($oneItem);

    $pdf->addPage();

    $pdf->SetFont('Times', 'B', 24);
    $pdf->Write(5, $di_item . ":\t");
    $pdf->Write(5, stripslashes($di_title) . "\n\n");
    $pdf->SetFont('Times', '', 16);
    $pdf->Write(8, stripslashes($di_description) . "\n");
    if ($di_estprice > 0) {
        $pdf->Write(8, gettext('Estimated value ') . '$' . $di_estprice . '.  ');
    }
    if ($per_LastName != '') {
        $pdf->Write(8, gettext('Donated by ') . $per_FirstName . ' ' . $per_LastName . ".\n");
    }
    $pdf->Write(8, "\n");

    $widName = 100;
    $widPaddle = 30;
    $widBid = 40;
    $lineHeight = 7;

    $pdf->SetFont('Times', 'B', 16);
    $pdf->Cell($widName, $lineHeight, gettext('Name'), 1, 0);
    $pdf->Cell($widPaddle, $lineHeight, gettext('Paddle'), 1, 0);
    $pdf->Cell($widBid, $lineHeight, gettext('Bid'), 1, 1);

    if ($di_minimum > 0) {
        $pdf->Cell($widName, $lineHeight, '', 1, 0);
        $pdf->Cell($widPaddle, $lineHeight, '', 1, 0);
        $pdf->Cell($widBid, $lineHeight, '$' . $di_minimum, 1, 1);
    }
    for ($i = 0; $i < 20; $i += 1) {
        $pdf->Cell($widName, $lineHeight, '', 1, 0);
        $pdf->Cell($widPaddle, $lineHeight, '', 1, 0);
        $pdf->Cell($widBid, $lineHeight, '', 1, 1);
    }
}

if (SystemConfig::getIntValue('iPDFOutputType') === 1) {
    $pdf->Output('FRBidSheets' . date(SystemConfig::getValue('sDateFilenameFormat')) . '.pdf', 'D');
} else {
    $pdf->Output();
}
