<?php

require_once __DIR__ . '/../Include/Config.php';
require_once __DIR__ . '/../Include/Functions.php';

use ChurchCRM\dto\SystemConfig;
use ChurchCRM\model\ChurchCRM\FundRaiserQuery;
use ChurchCRM\Reports\PdfCertificatesReport;
use ChurchCRM\Utils\InputUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function frCertificatesDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function frCertificatesDbFetchArray(&$result)
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

$fundraiser = FundRaiserQuery::create()->findOneById($iCurrentFundraiser);
if ($fundraiser === null) {
    throw new \InvalidArgumentException('No results found for provided CurrentFundraiser parameter');
}

$curY = 0;

// Get all the donated items
$sSQL = 'SELECT * FROM donateditem_di LEFT JOIN person_per on per_ID=di_donor_ID WHERE di_FR_ID=' . $fundraiser->getId() . ' ORDER BY di_item';
$rsItems = frCertificatesDbQuery($sSQL);

$pdf = new PdfCertificatesReport();
$pdf->SetTitle($fundraiser->getTitle());

// Loop through items
while ($oneItem = frCertificatesDbFetchArray($rsItems)) {
    extract($oneItem);

    $pdf->addPage();

    $pdf->SetFont('Times', 'B', 24);
    $pdf->Write(8, $di_item . ":\t");
    $pdf->Write(8, stripslashes($di_title) . "\n\n");
    $pdf->SetFont('Times', '', 16);
    $pdf->Write(8, stripslashes($di_description) . "\n");
    if ($di_estprice > 0) {
        $pdf->Write(8, gettext('Estimated value ') . '$' . $di_estprice . '.  ');
    }
    if ($per_LastName !== '') {
        $pdf->Write(8, gettext('Donated by ') . $per_FirstName . ' ' . $per_LastName . ".\n\n");
    }
}

if (SystemConfig::getIntValue('iPDFOutputType') === 1) {
    $pdf->Output('FRCertificates' . date(SystemConfig::getValue('sDateFilenameFormat')) . '.pdf', 'D');
} else {
    $pdf->Output();
}
