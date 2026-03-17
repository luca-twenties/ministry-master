<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Base\CalendarEvent;
use ChurchCRM\model\ChurchCRM\CalendarEvent as ChildCalendarEvent;
use ChurchCRM\model\ChurchCRM\CalendarEventQuery;
use Propel\Runtime\ActiveQuery\ColumnResolver\ColumnExpression\LocalColumnExpression;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Propel\Runtime\Propel;


/**
 * This class defines the structure of the 'calendar_events' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class CalendarEventTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.CalendarEventTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'calendar_events';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'CalendarEvent';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\CalendarEvent';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.CalendarEvent';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 2;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 2;

    /**
     * the column name for the calendar_id field
     */
    public const COL_CALENDAR_ID = 'calendar_events.calendar_id';

    /**
     * the column name for the event_id field
     */
    public const COL_EVENT_ID = 'calendar_events.event_id';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['CalendarId', 'EventId', ],
        self::TYPE_CAMELNAME     => ['calendarId', 'eventId', ],
        self::TYPE_COLNAME       => [CalendarEventTableMap::COL_CALENDAR_ID, CalendarEventTableMap::COL_EVENT_ID, ],
        self::TYPE_FIELDNAME     => ['calendar_id', 'event_id', ],
        self::TYPE_NUM           => [0, 1, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['CalendarId' => 0, 'EventId' => 1, ],
        self::TYPE_CAMELNAME     => ['calendarId' => 0, 'eventId' => 1, ],
        self::TYPE_COLNAME       => [CalendarEventTableMap::COL_CALENDAR_ID => 0, CalendarEventTableMap::COL_EVENT_ID => 1, ],
        self::TYPE_FIELDNAME     => ['calendar_id' => 0, 'event_id' => 1, ],
        self::TYPE_NUM           => [0, 1, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'CalendarId' => 'CALENDAR_ID',
        'CalendarEvent.CalendarId' => 'CALENDAR_ID',
        'calendarId' => 'CALENDAR_ID',
        'calendarEvent.calendarId' => 'CALENDAR_ID',
        'CalendarEventTableMap::COL_CALENDAR_ID' => 'CALENDAR_ID',
        'COL_CALENDAR_ID' => 'CALENDAR_ID',
        'calendar_id' => 'CALENDAR_ID',
        'calendar_events.calendar_id' => 'CALENDAR_ID',
        'EventId' => 'EVENT_ID',
        'CalendarEvent.EventId' => 'EVENT_ID',
        'eventId' => 'EVENT_ID',
        'calendarEvent.eventId' => 'EVENT_ID',
        'CalendarEventTableMap::COL_EVENT_ID' => 'EVENT_ID',
        'COL_EVENT_ID' => 'EVENT_ID',
        'event_id' => 'EVENT_ID',
        'calendar_events.event_id' => 'EVENT_ID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('calendar_events');
        $this->setPhpName('CalendarEvent');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\CalendarEvent');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('calendar_id', 'CalendarId', 'SMALLINT', 'calendars', 'calendar_id', true, 8, null);
        $this->addForeignPrimaryKey('event_id', 'EventId', 'SMALLINT', 'events_event', 'event_id', true, 8, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Calendar',
            '\\ChurchCRM\\model\\ChurchCRM\\Calendar',
            RelationMap::MANY_TO_ONE,
            [[':calendar_id', ':calendar_id']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'Event',
            '\\ChurchCRM\\model\\ChurchCRM\\Event',
            RelationMap::MANY_TO_ONE,
            [[':event_id', ':event_id']],
            null,
            null,
            null,
            false
        );
    }

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\CalendarEvent $obj
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(CalendarEvent $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([$obj->getCalendarId() === null || is_scalar($obj->getCalendarId()) || is_callable([$obj->getCalendarId(), '__toString']) ? (string)$obj->getCalendarId() : $obj->getCalendarId(), $obj->getEventId() === null || is_scalar($obj->getEventId()) || is_callable([$obj->getEventId(), '__toString']) ? (string)$obj->getEventId() : $obj->getEventId()]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A CalendarEvent object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof CalendarEvent) {
                $key = serialize([$value->getCalendarId() === null || is_scalar($value->getCalendarId()) || is_callable([$value->getCalendarId(), '__toString']) ? (string)$value->getCalendarId() : $value->getCalendarId(), $value->getEventId() === null || is_scalar($value->getEventId()) || is_callable([$value->getEventId(), '__toString']) ? (string)$value->getEventId() : $value->getEventId()]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([$value[0] === null || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string)$value[0] : $value[0], $value[1] === null || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string)$value[1] : $value[1]]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \ChurchCRM\model\ChurchCRM\Base\CalendarEvent object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)], $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)]]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.
     * For tables with a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('CalendarId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     *
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? CalendarEventTableMap::CLASS_DEFAULT : CalendarEventTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
     *                           One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return array (ChildCalendarEvent object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = CalendarEventTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = CalendarEventTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CalendarEventTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CalendarEventTableMap::OM_CLASS;
            /** @var ChildCalendarEvent $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CalendarEventTableMap::addInstanceToPool($obj, $key);
        }

        return [$obj, $col];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param \Propel\Runtime\DataFetcher\DataFetcherInterface $dataFetcher
     *
     * @return array<object>
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CalendarEventTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = CalendarEventTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new ChildCalendarEvent();
                $obj->hydrate($row);
                $results[] = $obj;
                CalendarEventTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     *
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        $tableMap = static::getTableMap();
        $tableAlias = $alias ?: 'calendar_events';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CALENDAR_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['EVENT_ID']));
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     *
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if ($alias === null) {
            $criteria->removeSelectColumn(CalendarEventTableMap::COL_CALENDAR_ID);
            $criteria->removeSelectColumn(CalendarEventTableMap::COL_EVENT_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.calendar_id');
            $criteria->removeSelectColumn($alias . '.event_id');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     *
     * @return static
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(CalendarEventTableMap::DATABASE_NAME)->getTable(CalendarEventTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or CalendarEventQuery.
     *
     * Performs a DELETE on the database, given a ChildCalendarEvent or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or ChildCalendarEvent object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     *
     * @return int The number of affected rows (if supported by underlying database driver). This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     */
    public static function doDelete($values, ?ConnectionInterface $con = null): int
    {
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or CalendarEventQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarEventTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof ChildCalendarEvent) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CalendarEventTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(CalendarEventTableMap::COL_CALENDAR_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(CalendarEventTableMap::COL_EVENT_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = CalendarEventQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CalendarEventTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                CalendarEventTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the calendar_events table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return CalendarEventQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChildCalendarEvent or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\CalendarEvent $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     *
     * @return mixed The new primary key.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarEventTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChildCalendarEvent object
        }

        // Set the correct dbName
        $query = CalendarEventQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
