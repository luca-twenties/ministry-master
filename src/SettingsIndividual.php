<?php

require_once __DIR__ . '/Include/Config.php';
require_once __DIR__ . '/Include/Functions.php';

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\model\ChurchCRM\UserConfig;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\RedirectUtils;
use Propel\Runtime\Propel;

$dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
$isSqlite = $dbDriver === 'sqlite';
$dbConnection = $isSqlite ? Propel::getConnection() : null;

function settingsIndividualDbQuery(string $sql)
{
    global $isSqlite, $dbConnection;

    if (!$isSqlite) {
        return RunQuery($sql);
    }

    $stmt = $dbConnection->prepare($sql);
    $stmt->execute();

    return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
}

function settingsIndividualDbFetchRow(&$result)
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        if ($result['index'] >= count($result['rows'])) {
            return false;
        }
        $row = $result['rows'][$result['index']];
        $result['index']++;
        $numeric = [];
        foreach ($row as $key => $value) {
            if (is_int($key)) {
                $numeric[] = $value;
            }
        }
        return $numeric;
    }

    return mysqli_fetch_row($result);
}

function settingsIndividualDbNumRows($result): int
{
    if (is_array($result) && array_key_exists('rows', $result)) {
        return count($result['rows']);
    }

    return mysqli_num_rows($result);
}

$iPersonID = AuthenticationManager::getCurrentUser()->getId();

// Save Settings
if (isset($_POST['save'])) {
    $new_value = $_POST['new_value'];
    $type = $_POST['type'];
    ksort($type);
    reset($type);
    while ($current_type = current($type)) {
        $id = key($type);
        // Filter Input
        if ($current_type == 'text' || $current_type == 'textarea') {
            $value = InputUtils::legacyFilterInput($new_value[$id]);
        } elseif ($current_type == 'number') {
            $value = InputUtils::legacyFilterInput($new_value[$id], 'float');
        } elseif ($current_type == 'date') {
            $value = InputUtils::legacyFilterInput($new_value[$id], 'date');
        } elseif ($current_type == 'boolean') {
            if ($new_value[$id] != '1') {
                $value = '';
            } else {
                $value = '1';
            }
        }
        // We can't update unless values already exist.
        $sSQL = 'SELECT * FROM userconfig_ucfg '
            . "WHERE ucfg_id=$id AND ucfg_per_id=$iPersonID ";
        $bRowExists = true;
        $iNumRows = settingsIndividualDbNumRows(settingsIndividualDbQuery($sSQL));
        if ($iNumRows == 0) {
            $bRowExists = false;
        }

        if (!$bRowExists) { // If Row does not exist then insert default values.
            // Defaults will be replaced in the following Update
            $sSQL = 'SELECT * FROM userconfig_ucfg '
                . "WHERE ucfg_id=$id AND ucfg_per_id=0 ";
            $rsDefault = settingsIndividualDbQuery($sSQL);
            $aDefaultRow = settingsIndividualDbFetchRow($rsDefault);
            if ($aDefaultRow) {
                list(
                    $ucfg_per_id, $ucfg_id, $ucfg_name, $ucfg_value, $ucfg_type,
                    $ucfg_tooltip, $ucfg_permission
                ) = $aDefaultRow;

                $userConfig = new UserConfig();
                $userConfig
                    ->setPeronId($iPersonID)
                    ->setId($id)
                    ->setName($ucfg_name)
                    ->setValue($ucfg_value)
                    ->setType($ucfg_type)
                    ->setTooltip($ucfg_tooltip)
                    ->setPermission($ucfg_permission);
                $userConfig->save();
            } else {
                echo '<BR> Error: Software BUG 3216';
                exit;
            }
        }

        // Save new setting
        $sSQL = 'UPDATE userconfig_ucfg '
            . "SET ucfg_value='$value' "
            . "WHERE ucfg_id=$id AND ucfg_per_id=$iPersonID ";
        $rsUpdate = settingsIndividualDbQuery($sSQL);
        next($type);
    }

    RedirectUtils::redirect('SettingsIndividual.php'); // to reflect the tooltip change, we have to refresh the page
}

$sPageTitle = gettext('My User Settings');
require_once __DIR__ . '/Include/Header.php';

// Get settings
$sSQL = 'SELECT * FROM userconfig_ucfg WHERE ucfg_per_id=' . $iPersonID
    . ' ORDER BY ucfg_id';
$rsConfigs = settingsIndividualDbQuery($sSQL);
?>
<div class="card card-body">
    <form method=post action=SettingsIndividual.php>
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th><?= gettext('Variable name') ?></th>
                    <th><?= gettext('Current Value') ?></th>
                    <th><?= gettext('Notes') ?></h3>
                    </th>
                </tr>
                <?php
                $r = 1;
                // List Individual Settings
                while (list($ucfg_per_id, $ucfg_id, $ucfg_name, $ucfg_value, $ucfg_type, $ucfg_tooltip, $ucfg_permission) = settingsIndividualDbFetchRow($rsConfigs)) {
                    if (!(($ucfg_permission == 'TRUE') || AuthenticationManager::getCurrentUser()->isAdmin())) {
                        continue;
                    } // Don't show rows that can't be changed : BUG, you must continue the loop, and not break it PL

                    // Cancel, Save Buttons every 13 rows
                    if ($r == 13) {
                        echo "<tr><td>&nbsp;</td>
            <td><input type=submit class=btn name=save value='" . gettext('Save Settings') . "'>
            <input type=submit class=btn name=cancel value='" . gettext('Cancel') . "'>
            </td></tr>";
                        $r = 1;
                    }

                    // Variable Name & Type
                    echo '<tr><td class=LabelColumn>' . $ucfg_name;
                    echo '<input type=hidden name="type[' . $ucfg_id . ']" value="' . $ucfg_type . '"></td>';

                    // Current Value
                    if ($ucfg_type == 'text') {
                        echo "<td class=TextColumnWithBottomBorder>
            <input type=text size=30 maxlength=255 name='new_value[$ucfg_id]'
            value=\"" . InputUtils::escapeHTML($ucfg_value) . "\"></td>";
                    } elseif ($ucfg_type == 'textarea') {
                        echo "<td class=TextColumnWithBottomBorder>
            <textarea rows=4 cols=30 name='new_value[$ucfg_id]'>"
                            . InputUtils::escapeHTML($ucfg_value) . '</textarea></td>';
                    } elseif ($ucfg_type == 'number' || $ucfg_type == 'date') {
                        echo '<td class=TextColumnWithBottomBorder><input type=text size=15 maxlength=15 name='
                            . "'new_value[$ucfg_id]' value='$ucfg_value'></td>";
                    } elseif ($ucfg_type == 'boolean') {
                        if ($ucfg_value) {
                            $sel2 = 'SELECTED';
                            $sel1 = '';
                        } else {
                            $sel1 = 'SELECTED';
                            $sel2 = '';
                        }
                        echo "<td class=TextColumnWithBottomBorder><select name=\"new_value[$ucfg_id]\">";
                        echo "<option value='' $sel1>" . gettext('False');
                        echo "<option value='1' $sel2>" . gettext('True');
                        echo '</select></td>';
                    }

                    // Notes
                    echo '<td>' . gettext($ucfg_tooltip) . '</td>    </tr>';
                    $r++;
                }
                ?>

                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type=submit class='btn btn-primary' name=save value="<?= gettext('Save Settings') ?>">
                        <input type=submit class=btn name=cancel value="<?= gettext('Cancel') ?>">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<?php
require_once __DIR__ . '/Include/Footer.php';
