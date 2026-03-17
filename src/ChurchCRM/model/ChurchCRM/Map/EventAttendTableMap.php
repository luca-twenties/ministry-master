<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\EventAttend;
use ChurchCRM\model\ChurchCRM\EventAttendQuery;
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
 * This class defines the structure of the 'event_attend' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class EventAttendTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.EventAttendTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'event_attend';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'EventAttend';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\EventAttend';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.EventAttend';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the attend_id field
     */
    public const COL_ATTEND_ID = 'event_attend.attend_id';

    /**
     * the column name for the event_id field
     */
    public const COL_EVENT_ID = 'event_attend.event_id';

    /**
     * the column name for the person_id field
     */
    public const COL_PERSON_ID = 'event_attend.person_id';

    /**
     * the column name for the checkin_date field
     */
    public const COL_CHECKIN_DATE = 'event_attend.checkin_date';

    /**
     * the column name for the checkin_id field
     */
    public const COL_CHECKIN_ID = 'event_attend.checkin_id';

    /**
     * the column name for the checkout_date field
     */
    public const COL_CHECKOUT_DATE = 'event_attend.checkout_date';

    /**
     * the column name for the checkout_id field
     */
    public const COL_CHECKOUT_ID = 'event_attend.checkout_id';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['AttendId', 'EventId', 'PersonId', 'CheckinDate', 'CheckinId', 'CheckoutDate', 'CheckoutId', ],
        self::TYPE_CAMELNAME     => ['attendId', 'eventId', 'personId', 'checkinDate', 'checkinId', 'checkoutDate', 'checkoutId', ],
        self::TYPE_COLNAME       => [EventAttendTableMap::COL_ATTEND_ID, EventAttendTableMap::COL_EVENT_ID, EventAttendTableMap::COL_PERSON_ID, EventAttendTableMap::COL_CHECKIN_DATE, EventAttendTableMap::COL_CHECKIN_ID, EventAttendTableMap::COL_CHECKOUT_DATE, EventAttendTableMap::COL_CHECKOUT_ID, ],
        self::TYPE_FIELDNAME     => ['attend_id', 'event_id', 'person_id', 'checkin_date', 'checkin_id', 'checkout_date', 'checkout_id', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
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
        self::TYPE_PHPNAME       => ['AttendId' => 0, 'EventId' => 1, 'PersonId' => 2, 'CheckinDate' => 3, 'CheckinId' => 4, 'CheckoutDate' => 5, 'CheckoutId' => 6, ],
        self::TYPE_CAMELNAME     => ['attendId' => 0, 'eventId' => 1, 'personId' => 2, 'checkinDate' => 3, 'checkinId' => 4, 'checkoutDate' => 5, 'checkoutId' => 6, ],
        self::TYPE_COLNAME       => [EventAttendTableMap::COL_ATTEND_ID => 0, EventAttendTableMap::COL_EVENT_ID => 1, EventAttendTableMap::COL_PERSON_ID => 2, EventAttendTableMap::COL_CHECKIN_DATE => 3, EventAttendTableMap::COL_CHECKIN_ID => 4, EventAttendTableMap::COL_CHECKOUT_DATE => 5, EventAttendTableMap::COL_CHECKOUT_ID => 6, ],
        self::TYPE_FIELDNAME     => ['attend_id' => 0, 'event_id' => 1, 'person_id' => 2, 'checkin_date' => 3, 'checkin_id' => 4, 'checkout_date' => 5, 'checkout_id' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'AttendId' => 'ATTEND_ID',
        'EventAttend.AttendId' => 'ATTEND_ID',
        'attendId' => 'ATTEND_ID',
        'eventAttend.attendId' => 'ATTEND_ID',
        'EventAttendTableMap::COL_ATTEND_ID' => 'ATTEND_ID',
        'COL_ATTEND_ID' => 'ATTEND_ID',
        'attend_id' => 'ATTEND_ID',
        'event_attend.attend_id' => 'ATTEND_ID',
        'EventId' => 'EVENT_ID',
        'EventAttend.EventId' => 'EVENT_ID',
        'eventId' => 'EVENT_ID',
        'eventAttend.eventId' => 'EVENT_ID',
        'EventAttendTableMap::COL_EVENT_ID' => 'EVENT_ID',
        'COL_EVENT_ID' => 'EVENT_ID',
        'event_id' => 'EVENT_ID',
        'event_attend.event_id' => 'EVENT_ID',
        'PersonId' => 'PERSON_ID',
        'EventAttend.PersonId' => 'PERSON_ID',
        'personId' => 'PERSON_ID',
        'eventAttend.personId' => 'PERSON_ID',
        'EventAttendTableMap::COL_PERSON_ID' => 'PERSON_ID',
        'COL_PERSON_ID' => 'PERSON_ID',
        'person_id' => 'PERSON_ID',
        'event_attend.person_id' => 'PERSON_ID',
        'CheckinDate' => 'CHECKIN_DATE',
        'EventAttend.CheckinDate' => 'CHECKIN_DATE',
        'checkinDate' => 'CHECKIN_DATE',
        'eventAttend.checkinDate' => 'CHECKIN_DATE',
        'EventAttendTableMap::COL_CHECKIN_DATE' => 'CHECKIN_DATE',
        'COL_CHECKIN_DATE' => 'CHECKIN_DATE',
        'checkin_date' => 'CHECKIN_DATE',
        'event_attend.checkin_date' => 'CHECKIN_DATE',
        'CheckinId' => 'CHECKIN_ID',
        'EventAttend.CheckinId' => 'CHECKIN_ID',
        'checkinId' => 'CHECKIN_ID',
        'eventAttend.checkinId' => 'CHECKIN_ID',
        'EventAttendTableMap::COL_CHECKIN_ID' => 'CHECKIN_ID',
        'COL_CHECKIN_ID' => 'CHECKIN_ID',
        'checkin_id' => 'CHECKIN_ID',
        'event_attend.checkin_id' => 'CHECKIN_ID',
        'CheckoutDate' => 'CHECKOUT_DATE',
        'EventAttend.CheckoutDate' => 'CHECKOUT_DATE',
        'checkoutDate' => 'CHECKOUT_DATE',
        'eventAttend.checkoutDate' => 'CHECKOUT_DATE',
        'EventAttendTableMap::COL_CHECKOUT_DATE' => 'CHECKOUT_DATE',
        'COL_CHECKOUT_DATE' => 'CHECKOUT_DATE',
        'checkout_date' => 'CHECKOUT_DATE',
        'event_attend.checkout_date' => 'CHECKOUT_DATE',
        'CheckoutId' => 'CHECKOUT_ID',
        'EventAttend.CheckoutId' => 'CHECKOUT_ID',
        'checkoutId' => 'CHECKOUT_ID',
        'eventAttend.checkoutId' => 'CHECKOUT_ID',
        'EventAttendTableMap::COL_CHECKOUT_ID' => 'CHECKOUT_ID',
        'COL_CHECKOUT_ID' => 'CHECKOUT_ID',
        'checkout_id' => 'CHECKOUT_ID',
        'event_attend.checkout_id' => 'CHECKOUT_ID',
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
        $this->setName('event_attend');
        $this->setPhpName('EventAttend');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\EventAttend');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('attend_id', 'AttendId', 'INTEGER', true, null, null);
        $this->addForeignKey('event_id', 'EventId', 'INTEGER', 'events_event', 'event_id', true, null, 0);
        $this->addForeignKey('person_id', 'PersonId', 'INTEGER', 'person_per', 'per_ID', true, null, 0);
        $this->addColumn('checkin_date', 'CheckinDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('checkin_id', 'CheckinId', 'INTEGER', false, null, null);
        $this->addColumn('checkout_date', 'CheckoutDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('checkout_id', 'CheckoutId', 'INTEGER', false, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
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
        $this->addRelation(
            'Person',
            '\\ChurchCRM\\model\\ChurchCRM\\Person',
            RelationMap::MANY_TO_ONE,
            [[':person_id', ':per_ID']],
            null,
            null,
            null,
            false
        );
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $attendIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$attendIdIx];
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
        return $withPrefix ? EventAttendTableMap::CLASS_DEFAULT : EventAttendTableMap::OM_CLASS;
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
     * @return array (EventAttend object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = EventAttendTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = EventAttendTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventAttendTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventAttendTableMap::OM_CLASS;
            /** @var EventAttend $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventAttendTableMap::addInstanceToPool($obj, $key);
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
            $key = EventAttendTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = EventAttendTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new EventAttend();
                $obj->hydrate($row);
                $results[] = $obj;
                EventAttendTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'event_attend';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['ATTEND_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['EVENT_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PERSON_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CHECKIN_DATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CHECKIN_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CHECKOUT_DATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CHECKOUT_ID']));
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
            $criteria->removeSelectColumn(EventAttendTableMap::COL_ATTEND_ID);
            $criteria->removeSelectColumn(EventAttendTableMap::COL_EVENT_ID);
            $criteria->removeSelectColumn(EventAttendTableMap::COL_PERSON_ID);
            $criteria->removeSelectColumn(EventAttendTableMap::COL_CHECKIN_DATE);
            $criteria->removeSelectColumn(EventAttendTableMap::COL_CHECKIN_ID);
            $criteria->removeSelectColumn(EventAttendTableMap::COL_CHECKOUT_DATE);
            $criteria->removeSelectColumn(EventAttendTableMap::COL_CHECKOUT_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.attend_id');
            $criteria->removeSelectColumn($alias . '.event_id');
            $criteria->removeSelectColumn($alias . '.person_id');
            $criteria->removeSelectColumn($alias . '.checkin_date');
            $criteria->removeSelectColumn($alias . '.checkin_id');
            $criteria->removeSelectColumn($alias . '.checkout_date');
            $criteria->removeSelectColumn($alias . '.checkout_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(EventAttendTableMap::DATABASE_NAME)->getTable(EventAttendTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or EventAttendQuery.
     *
     * Performs a DELETE on the database, given a EventAttend or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or EventAttend object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or EventAttendQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventAttendTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof EventAttend) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventAttendTableMap::DATABASE_NAME);
            $criteria->addAnd(EventAttendTableMap::COL_ATTEND_ID, (array)$values, Criteria::IN);
        }

        $query = EventAttendQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventAttendTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                EventAttendTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the event_attend table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return EventAttendQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a EventAttend or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\EventAttend $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventAttendTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from EventAttend object
        }

        if ($criteria->hasUpdateValue(EventAttendTableMap::COL_ATTEND_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (EventAttendTableMap::COL_ATTEND_ID)');
        }

        // Set the correct dbName
        $query = EventAttendQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
