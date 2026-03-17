<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\KioskAssignment;
use ChurchCRM\model\ChurchCRM\KioskAssignmentQuery;
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
 * This class defines the structure of the 'kioskassginment_kasm' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class KioskAssignmentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.KioskAssignmentTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'kioskassginment_kasm';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'KioskAssignment';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\KioskAssignment';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.KioskAssignment';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 4;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 4;

    /**
     * the column name for the kasm_ID field
     */
    public const COL_KASM_ID = 'kioskassginment_kasm.kasm_ID';

    /**
     * the column name for the kasm_kdevId field
     */
    public const COL_KASM_KDEVID = 'kioskassginment_kasm.kasm_kdevId';

    /**
     * the column name for the kasm_AssignmentType field
     */
    public const COL_KASM_ASSIGNMENTTYPE = 'kioskassginment_kasm.kasm_AssignmentType';

    /**
     * the column name for the kasm_EventId field
     */
    public const COL_KASM_EVENTID = 'kioskassginment_kasm.kasm_EventId';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'KioskId', 'AssignmentType', 'EventId', ],
        self::TYPE_CAMELNAME     => ['id', 'kioskId', 'assignmentType', 'eventId', ],
        self::TYPE_COLNAME       => [KioskAssignmentTableMap::COL_KASM_ID, KioskAssignmentTableMap::COL_KASM_KDEVID, KioskAssignmentTableMap::COL_KASM_ASSIGNMENTTYPE, KioskAssignmentTableMap::COL_KASM_EVENTID, ],
        self::TYPE_FIELDNAME     => ['kasm_ID', 'kasm_kdevId', 'kasm_AssignmentType', 'kasm_EventId', ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'KioskId' => 1, 'AssignmentType' => 2, 'EventId' => 3, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'kioskId' => 1, 'assignmentType' => 2, 'eventId' => 3, ],
        self::TYPE_COLNAME       => [KioskAssignmentTableMap::COL_KASM_ID => 0, KioskAssignmentTableMap::COL_KASM_KDEVID => 1, KioskAssignmentTableMap::COL_KASM_ASSIGNMENTTYPE => 2, KioskAssignmentTableMap::COL_KASM_EVENTID => 3, ],
        self::TYPE_FIELDNAME     => ['kasm_ID' => 0, 'kasm_kdevId' => 1, 'kasm_AssignmentType' => 2, 'kasm_EventId' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'KASM_ID',
        'KioskAssignment.Id' => 'KASM_ID',
        'id' => 'KASM_ID',
        'kioskAssignment.id' => 'KASM_ID',
        'KioskAssignmentTableMap::COL_KASM_ID' => 'KASM_ID',
        'COL_KASM_ID' => 'KASM_ID',
        'kasm_ID' => 'KASM_ID',
        'kioskassginment_kasm.kasm_ID' => 'KASM_ID',
        'KioskId' => 'KASM_KDEVID',
        'KioskAssignment.KioskId' => 'KASM_KDEVID',
        'kioskId' => 'KASM_KDEVID',
        'kioskAssignment.kioskId' => 'KASM_KDEVID',
        'KioskAssignmentTableMap::COL_KASM_KDEVID' => 'KASM_KDEVID',
        'COL_KASM_KDEVID' => 'KASM_KDEVID',
        'kasm_kdevId' => 'KASM_KDEVID',
        'kioskassginment_kasm.kasm_kdevId' => 'KASM_KDEVID',
        'AssignmentType' => 'KASM_ASSIGNMENTTYPE',
        'KioskAssignment.AssignmentType' => 'KASM_ASSIGNMENTTYPE',
        'assignmentType' => 'KASM_ASSIGNMENTTYPE',
        'kioskAssignment.assignmentType' => 'KASM_ASSIGNMENTTYPE',
        'KioskAssignmentTableMap::COL_KASM_ASSIGNMENTTYPE' => 'KASM_ASSIGNMENTTYPE',
        'COL_KASM_ASSIGNMENTTYPE' => 'KASM_ASSIGNMENTTYPE',
        'kasm_AssignmentType' => 'KASM_ASSIGNMENTTYPE',
        'kioskassginment_kasm.kasm_AssignmentType' => 'KASM_ASSIGNMENTTYPE',
        'EventId' => 'KASM_EVENTID',
        'KioskAssignment.EventId' => 'KASM_EVENTID',
        'eventId' => 'KASM_EVENTID',
        'kioskAssignment.eventId' => 'KASM_EVENTID',
        'KioskAssignmentTableMap::COL_KASM_EVENTID' => 'KASM_EVENTID',
        'COL_KASM_EVENTID' => 'KASM_EVENTID',
        'kasm_EventId' => 'KASM_EVENTID',
        'kioskassginment_kasm.kasm_EventId' => 'KASM_EVENTID',
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
        $this->setName('kioskassginment_kasm');
        $this->setPhpName('KioskAssignment');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\KioskAssignment');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('kasm_ID', 'Id', 'INTEGER', true, 9, null);
        $this->addForeignKey('kasm_kdevId', 'KioskId', 'INTEGER', 'kioskdevice_kdev', 'kdev_ID', false, 9, null);
        $this->addColumn('kasm_AssignmentType', 'AssignmentType', 'INTEGER', false, 9, null);
        $this->addForeignKey('kasm_EventId', 'EventId', 'INTEGER', 'events_event', 'event_id', false, 9, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'KioskDevice',
            '\\ChurchCRM\\model\\ChurchCRM\\KioskDevice',
            RelationMap::MANY_TO_ONE,
            [[':kasm_kdevId', ':kdev_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'Event',
            '\\ChurchCRM\\model\\ChurchCRM\\Event',
            RelationMap::MANY_TO_ONE,
            [[':kasm_EventId', ':event_id']],
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
        return $withPrefix ? KioskAssignmentTableMap::CLASS_DEFAULT : KioskAssignmentTableMap::OM_CLASS;
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
     * @return array (KioskAssignment object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = KioskAssignmentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = KioskAssignmentTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + KioskAssignmentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = KioskAssignmentTableMap::OM_CLASS;
            /** @var KioskAssignment $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            KioskAssignmentTableMap::addInstanceToPool($obj, $key);
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
            $key = KioskAssignmentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = KioskAssignmentTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new KioskAssignment();
                $obj->hydrate($row);
                $results[] = $obj;
                KioskAssignmentTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'kioskassginment_kasm';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KASM_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KASM_KDEVID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KASM_ASSIGNMENTTYPE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['KASM_EVENTID']));
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
            $criteria->removeSelectColumn(KioskAssignmentTableMap::COL_KASM_ID);
            $criteria->removeSelectColumn(KioskAssignmentTableMap::COL_KASM_KDEVID);
            $criteria->removeSelectColumn(KioskAssignmentTableMap::COL_KASM_ASSIGNMENTTYPE);
            $criteria->removeSelectColumn(KioskAssignmentTableMap::COL_KASM_EVENTID);
        } else {
            $criteria->removeSelectColumn($alias . '.kasm_ID');
            $criteria->removeSelectColumn($alias . '.kasm_kdevId');
            $criteria->removeSelectColumn($alias . '.kasm_AssignmentType');
            $criteria->removeSelectColumn($alias . '.kasm_EventId');
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
        return Propel::getServiceContainer()->getDatabaseMap(KioskAssignmentTableMap::DATABASE_NAME)->getTable(KioskAssignmentTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or KioskAssignmentQuery.
     *
     * Performs a DELETE on the database, given a KioskAssignment or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or KioskAssignment object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or KioskAssignmentQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(KioskAssignmentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof KioskAssignment) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(KioskAssignmentTableMap::DATABASE_NAME);
            $criteria->addAnd(KioskAssignmentTableMap::COL_KASM_ID, (array)$values, Criteria::IN);
        }

        $query = KioskAssignmentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            KioskAssignmentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                KioskAssignmentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the kioskassginment_kasm table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return KioskAssignmentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a KioskAssignment or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\KioskAssignment $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(KioskAssignmentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from KioskAssignment object
        }

        if ($criteria->hasUpdateValue(KioskAssignmentTableMap::COL_KASM_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (KioskAssignmentTableMap::COL_KASM_ID)');
        }

        // Set the correct dbName
        $query = KioskAssignmentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
