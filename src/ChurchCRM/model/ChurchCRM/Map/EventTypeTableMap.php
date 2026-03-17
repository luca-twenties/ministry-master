<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\EventType;
use ChurchCRM\model\ChurchCRM\EventTypeQuery;
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
 * This class defines the structure of the 'event_types' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class EventTypeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.EventTypeTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'event_types';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'EventType';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\EventType';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.EventType';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the type_id field
     */
    public const COL_TYPE_ID = 'event_types.type_id';

    /**
     * the column name for the type_name field
     */
    public const COL_TYPE_NAME = 'event_types.type_name';

    /**
     * the column name for the type_defstarttime field
     */
    public const COL_TYPE_DEFSTARTTIME = 'event_types.type_defstarttime';

    /**
     * the column name for the type_defrecurtype field
     */
    public const COL_TYPE_DEFRECURTYPE = 'event_types.type_defrecurtype';

    /**
     * the column name for the type_defrecurDOW field
     */
    public const COL_TYPE_DEFRECURDOW = 'event_types.type_defrecurDOW';

    /**
     * the column name for the type_defrecurDOM field
     */
    public const COL_TYPE_DEFRECURDOM = 'event_types.type_defrecurDOM';

    /**
     * the column name for the type_defrecurDOY field
     */
    public const COL_TYPE_DEFRECURDOY = 'event_types.type_defrecurDOY';

    /**
     * the column name for the type_active field
     */
    public const COL_TYPE_ACTIVE = 'event_types.type_active';

    /**
     * the column name for the type_grpid field
     */
    public const COL_TYPE_GRPID = 'event_types.type_grpid';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Name', 'DefStartTime', 'DefRecurType', 'DefRecurDOW', 'DefRecurDOM', 'DefRecurDOY', 'Active', 'GroupId', ],
        self::TYPE_CAMELNAME     => ['id', 'name', 'defStartTime', 'defRecurType', 'defRecurDOW', 'defRecurDOM', 'defRecurDOY', 'active', 'groupId', ],
        self::TYPE_COLNAME       => [EventTypeTableMap::COL_TYPE_ID, EventTypeTableMap::COL_TYPE_NAME, EventTypeTableMap::COL_TYPE_DEFSTARTTIME, EventTypeTableMap::COL_TYPE_DEFRECURTYPE, EventTypeTableMap::COL_TYPE_DEFRECURDOW, EventTypeTableMap::COL_TYPE_DEFRECURDOM, EventTypeTableMap::COL_TYPE_DEFRECURDOY, EventTypeTableMap::COL_TYPE_ACTIVE, EventTypeTableMap::COL_TYPE_GRPID, ],
        self::TYPE_FIELDNAME     => ['type_id', 'type_name', 'type_defstarttime', 'type_defrecurtype', 'type_defrecurDOW', 'type_defrecurDOM', 'type_defrecurDOY', 'type_active', 'type_grpid', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Name' => 1, 'DefStartTime' => 2, 'DefRecurType' => 3, 'DefRecurDOW' => 4, 'DefRecurDOM' => 5, 'DefRecurDOY' => 6, 'Active' => 7, 'GroupId' => 8, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'name' => 1, 'defStartTime' => 2, 'defRecurType' => 3, 'defRecurDOW' => 4, 'defRecurDOM' => 5, 'defRecurDOY' => 6, 'active' => 7, 'groupId' => 8, ],
        self::TYPE_COLNAME       => [EventTypeTableMap::COL_TYPE_ID => 0, EventTypeTableMap::COL_TYPE_NAME => 1, EventTypeTableMap::COL_TYPE_DEFSTARTTIME => 2, EventTypeTableMap::COL_TYPE_DEFRECURTYPE => 3, EventTypeTableMap::COL_TYPE_DEFRECURDOW => 4, EventTypeTableMap::COL_TYPE_DEFRECURDOM => 5, EventTypeTableMap::COL_TYPE_DEFRECURDOY => 6, EventTypeTableMap::COL_TYPE_ACTIVE => 7, EventTypeTableMap::COL_TYPE_GRPID => 8, ],
        self::TYPE_FIELDNAME     => ['type_id' => 0, 'type_name' => 1, 'type_defstarttime' => 2, 'type_defrecurtype' => 3, 'type_defrecurDOW' => 4, 'type_defrecurDOM' => 5, 'type_defrecurDOY' => 6, 'type_active' => 7, 'type_grpid' => 8, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, 8, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'TYPE_ID',
        'EventType.Id' => 'TYPE_ID',
        'id' => 'TYPE_ID',
        'eventType.id' => 'TYPE_ID',
        'EventTypeTableMap::COL_TYPE_ID' => 'TYPE_ID',
        'COL_TYPE_ID' => 'TYPE_ID',
        'type_id' => 'TYPE_ID',
        'event_types.type_id' => 'TYPE_ID',
        'Name' => 'TYPE_NAME',
        'EventType.Name' => 'TYPE_NAME',
        'name' => 'TYPE_NAME',
        'eventType.name' => 'TYPE_NAME',
        'EventTypeTableMap::COL_TYPE_NAME' => 'TYPE_NAME',
        'COL_TYPE_NAME' => 'TYPE_NAME',
        'type_name' => 'TYPE_NAME',
        'event_types.type_name' => 'TYPE_NAME',
        'DefStartTime' => 'TYPE_DEFSTARTTIME',
        'EventType.DefStartTime' => 'TYPE_DEFSTARTTIME',
        'defStartTime' => 'TYPE_DEFSTARTTIME',
        'eventType.defStartTime' => 'TYPE_DEFSTARTTIME',
        'EventTypeTableMap::COL_TYPE_DEFSTARTTIME' => 'TYPE_DEFSTARTTIME',
        'COL_TYPE_DEFSTARTTIME' => 'TYPE_DEFSTARTTIME',
        'type_defstarttime' => 'TYPE_DEFSTARTTIME',
        'event_types.type_defstarttime' => 'TYPE_DEFSTARTTIME',
        'DefRecurType' => 'TYPE_DEFRECURTYPE',
        'EventType.DefRecurType' => 'TYPE_DEFRECURTYPE',
        'defRecurType' => 'TYPE_DEFRECURTYPE',
        'eventType.defRecurType' => 'TYPE_DEFRECURTYPE',
        'EventTypeTableMap::COL_TYPE_DEFRECURTYPE' => 'TYPE_DEFRECURTYPE',
        'COL_TYPE_DEFRECURTYPE' => 'TYPE_DEFRECURTYPE',
        'type_defrecurtype' => 'TYPE_DEFRECURTYPE',
        'event_types.type_defrecurtype' => 'TYPE_DEFRECURTYPE',
        'DefRecurDOW' => 'TYPE_DEFRECURDOW',
        'EventType.DefRecurDOW' => 'TYPE_DEFRECURDOW',
        'defRecurDOW' => 'TYPE_DEFRECURDOW',
        'eventType.defRecurDOW' => 'TYPE_DEFRECURDOW',
        'EventTypeTableMap::COL_TYPE_DEFRECURDOW' => 'TYPE_DEFRECURDOW',
        'COL_TYPE_DEFRECURDOW' => 'TYPE_DEFRECURDOW',
        'type_defrecurDOW' => 'TYPE_DEFRECURDOW',
        'event_types.type_defrecurDOW' => 'TYPE_DEFRECURDOW',
        'DefRecurDOM' => 'TYPE_DEFRECURDOM',
        'EventType.DefRecurDOM' => 'TYPE_DEFRECURDOM',
        'defRecurDOM' => 'TYPE_DEFRECURDOM',
        'eventType.defRecurDOM' => 'TYPE_DEFRECURDOM',
        'EventTypeTableMap::COL_TYPE_DEFRECURDOM' => 'TYPE_DEFRECURDOM',
        'COL_TYPE_DEFRECURDOM' => 'TYPE_DEFRECURDOM',
        'type_defrecurDOM' => 'TYPE_DEFRECURDOM',
        'event_types.type_defrecurDOM' => 'TYPE_DEFRECURDOM',
        'DefRecurDOY' => 'TYPE_DEFRECURDOY',
        'EventType.DefRecurDOY' => 'TYPE_DEFRECURDOY',
        'defRecurDOY' => 'TYPE_DEFRECURDOY',
        'eventType.defRecurDOY' => 'TYPE_DEFRECURDOY',
        'EventTypeTableMap::COL_TYPE_DEFRECURDOY' => 'TYPE_DEFRECURDOY',
        'COL_TYPE_DEFRECURDOY' => 'TYPE_DEFRECURDOY',
        'type_defrecurDOY' => 'TYPE_DEFRECURDOY',
        'event_types.type_defrecurDOY' => 'TYPE_DEFRECURDOY',
        'Active' => 'TYPE_ACTIVE',
        'EventType.Active' => 'TYPE_ACTIVE',
        'active' => 'TYPE_ACTIVE',
        'eventType.active' => 'TYPE_ACTIVE',
        'EventTypeTableMap::COL_TYPE_ACTIVE' => 'TYPE_ACTIVE',
        'COL_TYPE_ACTIVE' => 'TYPE_ACTIVE',
        'type_active' => 'TYPE_ACTIVE',
        'event_types.type_active' => 'TYPE_ACTIVE',
        'GroupId' => 'TYPE_GRPID',
        'EventType.GroupId' => 'TYPE_GRPID',
        'groupId' => 'TYPE_GRPID',
        'eventType.groupId' => 'TYPE_GRPID',
        'EventTypeTableMap::COL_TYPE_GRPID' => 'TYPE_GRPID',
        'COL_TYPE_GRPID' => 'TYPE_GRPID',
        'type_grpid' => 'TYPE_GRPID',
        'event_types.type_grpid' => 'TYPE_GRPID',
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
        $this->setName('event_types');
        $this->setPhpName('EventType');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\EventType');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('type_id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('type_name', 'Name', 'VARCHAR', true, 255, '');
        $this->addColumn('type_defstarttime', 'DefStartTime', 'TIME', true, null, '00:00:00');
        $this->addColumn('type_defrecurtype', 'DefRecurType', 'CHAR', true, null, 'none');
        $this->addColumn('type_defrecurDOW', 'DefRecurDOW', 'CHAR', true, null, 'Sunday');
        $this->addColumn('type_defrecurDOM', 'DefRecurDOM', 'CHAR', true, 2, '0');
        $this->addColumn('type_defrecurDOY', 'DefRecurDOY', 'DATE', true, null, '2016-01-01');
        $this->addColumn('type_active', 'Active', 'INTEGER', true, 1, 1);
        $this->addForeignKey('type_grpid', 'GroupId', 'INTEGER', 'group_grp', 'grp_ID', false, null, 0);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Group',
            '\\ChurchCRM\\model\\ChurchCRM\\Group',
            RelationMap::MANY_TO_ONE,
            [[':type_grpid', ':grp_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'EventType',
            '\\ChurchCRM\\model\\ChurchCRM\\Event',
            RelationMap::ONE_TO_MANY,
            [[':event_type', ':type_id']],
            null,
            null,
            'EventTypes',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        $idIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$idIx];
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
        return $withPrefix ? EventTypeTableMap::CLASS_DEFAULT : EventTypeTableMap::OM_CLASS;
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
     * @return array (EventType object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = EventTypeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = EventTypeTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventTypeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventTypeTableMap::OM_CLASS;
            /** @var EventType $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventTypeTableMap::addInstanceToPool($obj, $key);
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
            $key = EventTypeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = EventTypeTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new EventType();
                $obj->hydrate($row);
                $results[] = $obj;
                EventTypeTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'event_types';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_DEFSTARTTIME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_DEFRECURTYPE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_DEFRECURDOW']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_DEFRECURDOM']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_DEFRECURDOY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_ACTIVE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_GRPID']));
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
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_ID);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_NAME);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_DEFSTARTTIME);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_DEFRECURTYPE);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_DEFRECURDOW);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_DEFRECURDOM);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_DEFRECURDOY);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_ACTIVE);
            $criteria->removeSelectColumn(EventTypeTableMap::COL_TYPE_GRPID);
        } else {
            $criteria->removeSelectColumn($alias . '.type_id');
            $criteria->removeSelectColumn($alias . '.type_name');
            $criteria->removeSelectColumn($alias . '.type_defstarttime');
            $criteria->removeSelectColumn($alias . '.type_defrecurtype');
            $criteria->removeSelectColumn($alias . '.type_defrecurDOW');
            $criteria->removeSelectColumn($alias . '.type_defrecurDOM');
            $criteria->removeSelectColumn($alias . '.type_defrecurDOY');
            $criteria->removeSelectColumn($alias . '.type_active');
            $criteria->removeSelectColumn($alias . '.type_grpid');
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
        return Propel::getServiceContainer()->getDatabaseMap(EventTypeTableMap::DATABASE_NAME)->getTable(EventTypeTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or EventTypeQuery.
     *
     * Performs a DELETE on the database, given a EventType or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or EventType object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or EventTypeQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTypeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof EventType) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventTypeTableMap::DATABASE_NAME);
            $criteria->addAnd(EventTypeTableMap::COL_TYPE_ID, (array)$values, Criteria::IN);
        }

        $query = EventTypeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventTypeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                EventTypeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the event_types table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return EventTypeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a EventType or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\EventType $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTypeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from EventType object
        }

        if ($criteria->hasUpdateValue(EventTypeTableMap::COL_TYPE_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (EventTypeTableMap::COL_TYPE_ID)');
        }

        // Set the correct dbName
        $query = EventTypeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
