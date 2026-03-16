<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Utils\LoggerUtils;
use Propel\Runtime\Propel;

// Security: user must have MenuOptions permission to use this page
AuthenticationManager::redirectHomeIfFalse(AuthenticationManager::getCurrentUser()->isMenuOptionsEnabled(), 'MenuOptions');

// Get the type to display
$sType = InputUtils::legacyFilterInput($_GET['Type'], 'char', 1);

// Based on the type, set the TypeName
switch ($sType) {
    case 'p':
        $sTypeName = gettext('Person');
        break;

    case 'f':
        $sTypeName = gettext('Family');
        break;

    case 'g':
        $sTypeName = gettext('Group');
        break;

    default:
        RedirectUtils::redirect('v2/dashboard');
        break;
}

$sPageTitle = $sTypeName . ' ' . gettext('Property List');

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function propertyListDbQuery(string $sql)
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

function propertyListDbFetchArray(&$result, ?int $mode = null)
{
    if ($mode === null) {
        if (defined('MYSQLI_BOTH')) {
            $mode = MYSQLI_BOTH;
        } else {
            $mode = \PDO::FETCH_BOTH;
        }
    }

    if ($result === false || $result === true) {
        return false;
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

// Get the properties
$sSQL = "SELECT * FROM property_pro, propertytype_prt WHERE prt_ID = pro_prt_ID AND pro_Class = '" . $sType . "' ORDER BY prt_Name,pro_Name";
$rsProperties = propertyListDbQuery($sSQL);

require_once __DIR__ . '/Include/Header.php'; ?>

<div class="card card-body">
    <?php if (AuthenticationManager::getCurrentUser()->isMenuOptionsEnabled()) {
        //Display the new property link and property types link
        echo '<div class="mb-3">';
        echo '<a class="btn btn-primary" href="PropertyEditor.php?Type=' . InputUtils::escapeAttribute($sType) . '"><i class="fa-solid fa-plus"></i> ' . gettext('Add New') . ' ' . $sTypeName . ' ' . gettext('Property') . '</a> ';
        echo '<a class="btn btn-outline-secondary" href="PropertyTypeList.php?class=' . InputUtils::escapeAttribute($sType) . '"><i class="fa-solid fa-tags"></i> ' . gettext('Manage') . ' ' . $sTypeName . ' ' . gettext('Property Types') . '</a>';
        echo '</div>';
    }
    ?>

    <div class="table-responsive">
        <table class="table table-hover table-sm">
            <thead class="table-light">
                <tr>
                    <th><?= gettext('Name') ?></th>
                    <th><?= gettext('A') . ' ' . $sTypeName . ' ' . gettext('with this property...') ?></th>
                    <th><?= gettext('Prompt') ?></th>
                    <?php if (AuthenticationManager::getCurrentUser()->isMenuOptionsEnabled()) {
                        echo '<th class="text-center">' . gettext('Actions') . '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Initialize the row shading
                $iPreviousPropertyType = -1;
                $bIsFirstPropertyType = true;

                // Loop through the records
                while ($aRow = propertyListDbFetchArray($rsProperties)) {
                    $pro_Prompt = '';
                    $pro_Description = '';
                    extract($aRow);

                    // Did the Type change?
                    if ($iPreviousPropertyType != $prt_ID) {
                        //Write the header row
                        if (!$bIsFirstPropertyType) {
                            echo '</tbody></table></div>';
                        }
                        $bIsFirstPropertyType = false;
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info mt-3 mb-2">
                    <strong><?= InputUtils::escapeHTML($prt_Name) ?></strong>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th><?= gettext('Name') ?></th>
                                <th><?= gettext('A') . ' ' . $sTypeName . ' ' . gettext('with this property...') ?></th>
                                <th><?= gettext('Prompt') ?></th>
                                <?php if (AuthenticationManager::getCurrentUser()->isMenuOptionsEnabled()) {
                                    echo '<th class="text-center">' . gettext('Actions') . '</th>';
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    }

                    echo '<tr>';
                    echo '<td>' . InputUtils::escapeHTML($pro_Name) . '</td>';
                    echo '<td>';
                    if (strlen($pro_Description) > 0) {
                        echo '...' . InputUtils::escapeHTML($pro_Description);
                    }
                    echo '</td>';
                    echo '<td>' . InputUtils::escapeHTML($pro_Prompt) . '</td>';
                    if (AuthenticationManager::getCurrentUser()->isMenuOptionsEnabled()) {
                        echo '<td class="text-center"><div class="btn-group btn-group-sm" role="group">';
                        echo '<a class="btn btn-primary" href="PropertyEditor.php?PropertyID=' . InputUtils::escapeAttribute($pro_ID) . '&Type=' . InputUtils::escapeAttribute($sType) . '" title="' . gettext('Edit') . '"><i class="fa-solid fa-edit"></i></a>';
                        echo '<a class="btn btn-danger" href="PropertyDelete.php?PropertyID=' . InputUtils::escapeAttribute($pro_ID) . '&Type=' . InputUtils::escapeAttribute($sType) . '" title="' . gettext('Delete') . '"><i class="fa-solid fa-trash"></i></a>';
                        echo '</div></td>';
                    }
                    echo '</tr>';

                    // Store the PropertyType
                    $iPreviousPropertyType = $prt_ID;
                }

                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/Include/Footer.php';
