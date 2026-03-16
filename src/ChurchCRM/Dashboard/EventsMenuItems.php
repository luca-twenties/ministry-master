<?php

namespace ChurchCRM\Dashboard;

use ChurchCRM\model\ChurchCRM\EventQuery;
use ChurchCRM\model\ChurchCRM\FamilyQuery;
use ChurchCRM\model\ChurchCRM\Map\FamilyTableMap;
use ChurchCRM\model\ChurchCRM\PersonQuery;
use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Provides counts of today's events, birthdays, and anniversaries
 * for menu badge display
 */
class EventsMenuItems
{
    public static function getDashboardItemValue(): array
    {
        return [
            'Events'        => self::getNumberEventsOfToday(),
            'Birthdays'     => self::getNumberBirthDates(),
            'Anniversaries' => self::getNumberAnniversaries(),
        ];
    }

    private static function getNumberEventsOfToday(): int
    {
        $start_date = date('Y-m-d ') . ' 00:00:00';
        $end_date = date('Y-m-d H:i:s', strtotime($start_date . ' +1 day'));

        return EventQuery::create()
            ->where("event_start <= '" . $start_date . "' AND event_end >= '" . $end_date . "'") /* the large events */
            ->_or()->where("event_start>='" . $start_date . "' AND event_end <= '" . $end_date . "'") /* the events of the day */
            ->count();
    }

    private static function getNumberBirthDates(): int
    {
        return PersonQuery::create()
            ->filterByBirthMonth(date('m'))
            ->filterByBirthDay(date('d'))
            ->count();
    }

    private static function getNumberAnniversaries(): int
    {
        $dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: ($GLOBALS['sDATABASEDriver'] ?? 'mysql')));
        $isSqlite = $dbDriver === 'sqlite';
        $month = date('m');
        $day = date('d');
        $monthExpr = $isSqlite
            ? "strftime('%m', " . FamilyTableMap::COL_FAM_WEDDINGDATE . ") = '{$month}'"
            : 'MONTH(' . FamilyTableMap::COL_FAM_WEDDINGDATE . ") = {$month}";
        $dayExpr = $isSqlite
            ? "strftime('%d', " . FamilyTableMap::COL_FAM_WEDDINGDATE . ") = '{$day}'"
            : 'DAY(' . FamilyTableMap::COL_FAM_WEDDINGDATE . ") = {$day}";

        return $families = FamilyQuery::create()
            ->filterByDateDeactivated(null)
            ->filterByWeddingdate(null, Criteria::ISNOTNULL)
            ->addUsingAlias(FamilyTableMap::COL_FAM_WEDDINGDATE, $monthExpr, Criteria::CUSTOM)
            ->addUsingAlias(FamilyTableMap::COL_FAM_WEDDINGDATE, $dayExpr, Criteria::CUSTOM)
            ->orderByWeddingdate('DESC')
            ->count();
    }
}
