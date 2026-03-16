<?php

namespace ChurchCRM\Search;

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\dto\SystemConfig;
use ChurchCRM\dto\SystemURLs;
use ChurchCRM\model\ChurchCRM\DepositQuery;
use ChurchCRM\model\ChurchCRM\Map\DepositTableMap;
use ChurchCRM\Utils\LoggerUtils;
use Propel\Runtime\ActiveQuery\Criteria;

class FinanceDepositSearchResultProvider extends BaseSearchResultProvider
{
    public function __construct()
    {
        $this->pluralNoun = 'Deposits';
    }

    public function getSearchResults(string $SearchQuery): SearchResultGroup
    {
        if (AuthenticationManager::getCurrentUser()->isFinanceEnabled()) {
            if (SystemConfig::getBooleanValue('bSearchIncludeDeposits')) {
                $this->addSearchResults($this->getDepositSearchResults($SearchQuery));
            }
        }

        return $this->formatSearchGroup();
    }

    /**
     * @return SearchResult[]
     */
    private function getDepositSearchResults(string $SearchQuery): array
    {
        $searchResults = [];
        $id = 0;
        $dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
        $isSqlite = $dbDriver === 'sqlite';

        try {
            $Deposits = DepositQuery::create()->filterByComment("%$SearchQuery%", Criteria::LIKE)
                ->_or()
                ->filterById($SearchQuery)
                ->withColumn(
                    $isSqlite
                        ? "'#' || " . DepositTableMap::COL_DEP_ID . " || ' ' || " . DepositTableMap::COL_DEP_COMMENT
                        : 'CONCAT("#",' . DepositTableMap::COL_DEP_ID . '," ",' . DepositTableMap::COL_DEP_COMMENT . ')',
                    'displayName'
                )
                ->withColumn(
                    $isSqlite
                        ? "'" . SystemURLs::getRootPath() . "/DepositSlipEditor.php?DepositSlipID=' || " . DepositTableMap::COL_DEP_ID
                        : 'CONCAT("' . SystemURLs::getRootPath() . '/DepositSlipEditor.php?DepositSlipID=",' . DepositTableMap::COL_DEP_ID . ')',
                    'uri'
                )
                ->limit(SystemConfig::getValue('bSearchIncludeDepositsMax'))->find();

            if ($Deposits->count() > 0) {
                $id++;
                foreach ($Deposits->toArray() as $Deposit) {
                    $searchResults[] = new SearchResult('finance-deposit-' . $id, $Deposit['displayName'], $Deposit['uri']);
                }
            }
        } catch (\Exception $e) {
            LoggerUtils::getAppLogger()->warning($e->getMessage());
        }

        return $searchResults;
    }
}
