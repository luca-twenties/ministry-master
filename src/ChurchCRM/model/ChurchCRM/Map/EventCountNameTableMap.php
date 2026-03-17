<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\EventCountName;
use ChurchCRM\model\ChurchCRM\EventCountNameQuery;
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
 * This class defines the structure of the 'eventcountnames_evctnm' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class EventCountNameTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.EventCountNameTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'eventcountnames_evctnm';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'EventCountName';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\EventCountName';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.EventCountName';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 3;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 3;

    /**
     * the column name for the evctnm_countid field
     */
    public const COL_EVCTNM_COUNTID = 'eventcountnames_evctnm.evctnm_countid';

    /**
     * the column name for the evctnm_eventtypeid field
     */
    public const COL_EVCTNM_EVENTTYPEID = 'eventcountnames_evctnm.evctnm_eventtypeid';

    /**
     * the column name for the evctnm_countname field
     */
    public const COL_EVCTNM_COUNTNAME = 'eventcountnames_evctnm.evctnm_countname';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\EventCountNameCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\EventCountNameCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'TypeId', 'Name', ],
        self::TYPE_CAMELNAME     => ['id', 'typeId', 'name', ],
        self::TYPE_COLNAME       => [EventCountNameTableMap::COL_EVCTNM_COUNTID, EventCountNameTableMap::COL_EVCTNM_EVENTTYPEID, EventCountNameTableMap::COL_EVCTNM_COUNTNAME, ],
        self::TYPE_FIELDNAME     => ['evctnm_countid', 'evctnm_eventtypeid', 'evctnm_countname', ],
        self::TYPE_NUM           => [0, 1, 2, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'TypeId' => 1, 'Name' => 2, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'typeId' => 1, 'name' => 2, ],
        self::TYPE_COLNAME       => [EventCountNameTableMap::COL_EVCTNM_COUNTID => 0, EventCountNameTableMap::COL_EVCTNM_EVENTTYPEID => 1, EventCountNameTableMap::COL_EVCTNM_COUNTNAME => 2, ],
        self::TYPE_FIELDNAME     => ['evctnm_countid' => 0, 'evctnm_eventtypeid' => 1, 'evctnm_countname' => 2, ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'EVCTNM_COUNTID',
        'EventCountName.Id' => 'EVCTNM_COUNTID',
        'id' => 'EVCTNM_COUNTID',
        'eventCountName.id' => 'EVCTNM_COUNTID',
        'EventCountNameTableMap::COL_EVCTNM_COUNTID' => 'EVCTNM_COUNTID',
        'COL_EVCTNM_COUNTID' => 'EVCTNM_COUNTID',
        'evctnm_countid' => 'EVCTNM_COUNTID',
        'eventcountnames_evctnm.evctnm_countid' => 'EVCTNM_COUNTID',
        'TypeId' => 'EVCTNM_EVENTTYPEID',
        'EventCountName.TypeId' => 'EVCTNM_EVENTTYPEID',
        'typeId' => 'EVCTNM_EVENTTYPEID',
        'eventCountName.typeId' => 'EVCTNM_EVENTTYPEID',
        'EventCountNameTableMap::COL_EVCTNM_EVENTTYPEID' => 'EVCTNM_EVENTTYPEID',
        'COL_EVCTNM_EVENTTYPEID' => 'EVCTNM_EVENTTYPEID',
        'evctnm_eventtypeid' => 'EVCTNM_EVENTTYPEID',
        'eventcountnames_evctnm.evctnm_eventtypeid' => 'EVCTNM_EVENTTYPEID',
        'Name' => 'EVCTNM_COUNTNAME',
        'EventCountName.Name' => 'EVCTNM_COUNTNAME',
        'name' => 'EVCTNM_COUNTNAME',
        'eventCountName.name' => 'EVCTNM_COUNTNAME',
        'EventCountNameTableMap::COL_EVCTNM_COUNTNAME' => 'EVCTNM_COUNTNAME',
        'COL_EVCTNM_COUNTNAME' => 'EVCTNM_COUNTNAME',
        'evctnm_countname' => 'EVCTNM_COUNTNAME',
        'eventcountnames_evctnm.evctnm_countname' => 'EVCTNM_COUNTNAME',
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
        $this->setName('eventcountnames_evctnm');
        $this->setPhpName('EventCountName');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\EventCountName');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('evctnm_countid', 'Id', 'INTEGER', true, 5, null);
        $this->addColumn('evctnm_eventtypeid', 'TypeId', 'SMALLINT', true, 5, 0);
        $this->addColumn('evctnm_countname', 'Name', 'VARCHAR', true, 20, '');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
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
        return $withPrefix ? EventCountNameTableMap::CLASS_DEFAULT : EventCountNameTableMap::OM_CLASS;
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
     * @return array (EventCountName object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = EventCountNameTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = EventCountNameTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventCountNameTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventCountNameTableMap::OM_CLASS;
            /** @var EventCountName $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventCountNameTableMap::addInstanceToPool($obj, $key);
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
            $key = EventCountNameTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = EventCountNameTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new EventCountName();
                $obj->hydrate($row);
                $results[] = $obj;
                EventCountNameTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'eventcountnames_evctnm';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['EVCTNM_COUNTID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['EVCTNM_EVENTTYPEID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['EVCTNM_COUNTNAME']));
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
            $criteria->removeSelectColumn(EventCountNameTableMap::COL_EVCTNM_COUNTID);
            $criteria->removeSelectColumn(EventCountNameTableMap::COL_EVCTNM_EVENTTYPEID);
            $criteria->removeSelectColumn(EventCountNameTableMap::COL_EVCTNM_COUNTNAME);
        } else {
            $criteria->removeSelectColumn($alias . '.evctnm_countid');
            $criteria->removeSelectColumn($alias . '.evctnm_eventtypeid');
            $criteria->removeSelectColumn($alias . '.evctnm_countname');
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
        return Propel::getServiceContainer()->getDatabaseMap(EventCountNameTableMap::DATABASE_NAME)->getTable(EventCountNameTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or EventCountNameQuery.
     *
     * Performs a DELETE on the database, given a EventCountName or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or EventCountName object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or EventCountNameQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventCountNameTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof EventCountName) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventCountNameTableMap::DATABASE_NAME);
            $criteria->addAnd(EventCountNameTableMap::COL_EVCTNM_COUNTID, (array)$values, Criteria::IN);
        }

        $query = EventCountNameQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventCountNameTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                EventCountNameTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the eventcountnames_evctnm table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return EventCountNameQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a EventCountName or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\EventCountName $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventCountNameTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from EventCountName object
        }

        if ($criteria->hasUpdateValue(EventCountNameTableMap::COL_EVCTNM_COUNTID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (EventCountNameTableMap::COL_EVCTNM_COUNTID)');
        }

        // Set the correct dbName
        $query = EventCountNameQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
