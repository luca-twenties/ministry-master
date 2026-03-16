<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\model\ChurchCRM\Family;
use ChurchCRM\model\ChurchCRM\PersonQuery;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Utils\LoggerUtils;
use Propel\Runtime\Propel;

// Security
AuthenticationManager::redirectHomeIfNotAdmin();

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function convertIndividualDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    try {
        $stmt = $dbConnection->query($sql);
        if (!$stmt instanceof \PDOStatement) {
            return false;
        }
        $rows = $stmt->fetchAll(\PDO::FETCH_BOTH);
        return ['rows' => $rows, 'index' => 0];
    } catch (\Throwable $e) {
        LoggerUtils::getAppLogger()->error('SQLite query failed', ['sql' => $sql, 'exception' => $e]);
        return false;
    }
}

function convertIndividualDbFetchArray(&$result, ?int $mode = null)
{
    if ($mode === null) {
        if (defined('MYSQLI_BOTH')) {
            $mode = MYSQLI_BOTH;
        } else {
            $mode = \PDO::FETCH_BOTH;
        }
    }

    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        return $row;
    }

    return mysqli_fetch_array($result, $mode);
}

function convertIndividualDbEscape(string $value): string
{
    global $isSqlite, $cnInfoCentral;

    if ($isSqlite && class_exists('\\SQLite3')) {
        return \SQLite3::escapeString($value);
    }

    return mysqli_real_escape_string($cnInfoCentral, $value);
}

if ($_GET['all'] == 'true') {
    $bDoAll = true;
}

$sPageTitle = gettext('Convert Individuals to Families');

require_once __DIR__ . '/Include/Header.php';

echo '<div class="card card-body"><pre class="pre-compact">';

$curUserId = AuthenticationManager::getCurrentUser()->getId();

// find the family ID so we can associate to person record
$sSQL = 'SELECT MAX(fam_ID) AS iFamilyID FROM family_fam';
$rsLastEntry = convertIndividualDbQuery($sSQL);
extract(convertIndividualDbFetchArray($rsLastEntry));

// Get list of people that are not assigned to a family
$sSQL = "SELECT * FROM person_per WHERE per_fam_ID='0' ORDER BY per_LastName, per_FirstName";
$rsList = convertIndividualDbQuery($sSQL);
while ($aRow = convertIndividualDbFetchArray($rsList)) {
    extract($aRow);

    echo '<br><br><br>';
    echo '*****************************************';

    $per_LastName = convertIndividualDbEscape($per_LastName);
    $per_Address1 = convertIndividualDbEscape($per_Address1);
    $per_Address2 = convertIndividualDbEscape($per_Address2);
    $per_City = convertIndividualDbEscape($per_City);
    $per_State = convertIndividualDbEscape($per_State);
    $per_Zip = convertIndividualDbEscape($per_Zip);
    $per_Country = convertIndividualDbEscape($per_Country);
    $per_HomePhone = convertIndividualDbEscape($per_HomePhone);

    $family = new Family();
    $family
        ->setName($per_LastName)
        ->setAddress1($per_Address1)
        ->setAddress2($per_Address2)
        ->setCity($per_City)
        ->setState($per_State)
        ->setZip($per_Zip)
        ->setCountry($per_Country)
        ->setHomePhone($per_HomePhone)
        ->setDateEntered(new DateTimeImmutable())
        ->setEnteredBy($curUserId);
    $family->save();

    echo '<br>' . $sSQL;
    // RunQuery to add family record
    convertIndividualDbQuery($sSQL);
    $iFamilyID++; // increment family ID

    //Get the key back
    $sSQL = 'SELECT MAX(fam_ID) AS iNewFamilyID FROM family_fam';
    $rsLastEntry = convertIndividualDbQuery($sSQL);
    extract(convertIndividualDbFetchArray($rsLastEntry));

    if ($iNewFamilyID != $iFamilyID) {
        echo '<br><br>Error with family ID';

        break;
    }

    echo '<br><br>';

    // Now update person record
    $person = PersonQuery::create()->findOneById($per_ID);
    $person
        ->setFamId($iFamilyID)
        ->setAddress1(null)
        ->setAddress2(null)
        ->setCity(null)
        ->setState(null)
        ->setZip(null)
        ->setCountry(null)
        ->setHomePhone(null)
        ->setDateLastEdited(new \DateTimeImmutable())
        ->setEditedBy($curUserId);
    $person->save();

    echo '<br><br><br>';
    echo InputUtils::escapeHTML($per_FirstName) . ' ' . InputUtils::escapeHTML($per_LastName) . ' (per_ID = ' . (int)$per_ID . ') is now part of the ';
    echo InputUtils::escapeHTML($per_LastName) . ' Family (fam_ID = ' . (int)$iFamilyID . ')<br>';
    echo '*****************************************';

    if (!$bDoAll) {
        break;
    }
}
echo '</pre>';
echo '<div class="mt-3">';
echo '<a href="ConvertIndividualToFamily.php" class="btn btn-primary mr-2">' . gettext('Convert Next') . '</a>';
echo '<a href="ConvertIndividualToFamily.php?all=true" class="btn btn-warning">' . gettext('Convert All') . '</a>';
echo '</div>';
echo '</div>';

require_once __DIR__ . '/Include/Footer.php';
