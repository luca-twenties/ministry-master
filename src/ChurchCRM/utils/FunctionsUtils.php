<?php

namespace ChurchCRM\Utils;

use ChurchCRM\dto\SystemConfig;
use Propel\Runtime\Propel;

class FunctionsUtils
{
    /**
     * Runs an SQL query. Returns the result resource.
     * By default stop on error, unless a second (optional) argument is passed as false.
     *
     * @param string $sSQL SQL query to execute
     * @param bool $bStopOnError Whether to throw exception on error (default: true)
     * @return mixed Query result resource or false
     * @throws \Exception
     */
    public static function runQuery(string $sSQL, bool $bStopOnError = true)
    {
        global $cnInfoCentral;

        $dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
        if ($dbDriver === 'sqlite') {
            try {
                $stmt = Propel::getConnection()->prepare($sSQL);
                $stmt->execute();

                return ['rows' => $stmt->fetchAll(\PDO::FETCH_BOTH), 'index' => 0];
            } catch (\PDOException $e) {
                LoggerUtils::getAppLogger()->error(gettext('Cannot execute query.') . " " . $sSQL . " -|- " . $e->getMessage());
                if ($bStopOnError) {
                    if (SystemConfig::getValue('sLogLevel') == "100") { // debug level
                        throw new \Exception(gettext('Cannot execute query.') . "<p>$sSQL<p>" . $e->getMessage());
                    }
                    throw new \Exception('Database error or invalid data, change sLogLevel to debug to see more.');
                }
                return false;
            }
        }

        mysqli_query($cnInfoCentral, "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

        if ($result = mysqli_query($cnInfoCentral, $sSQL)) {
            return $result;
        }

        if ($bStopOnError) {
            LoggerUtils::getAppLogger()->error(gettext('Cannot execute query.') . " " . $sSQL . " -|- " . mysqli_error($cnInfoCentral));
            if (SystemConfig::getValue('sLogLevel') == "100") { // debug level
                throw new \Exception(gettext('Cannot execute query.') . "<p>$sSQL<p>" . mysqli_error($cnInfoCentral));
            }
            throw new \Exception('Database error or invalid data, change sLogLevel to debug to see more.');
        }

        return false;
    }
}
