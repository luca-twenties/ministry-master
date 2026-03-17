<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Base\RecordProperty;
use ChurchCRM\model\ChurchCRM\RecordProperty as ChildRecordProperty;
use ChurchCRM\model\ChurchCRM\RecordPropertyQuery;
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
 * This class defines the structure of the 'record2property_r2p' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class RecordPropertyTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.RecordPropertyTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'record2property_r2p';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'RecordProperty';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\RecordProperty';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.RecordProperty';

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
     * the column name for the r2p_pro_ID field
     */
    public const COL_R2P_PRO_ID = 'record2property_r2p.r2p_pro_ID';

    /**
     * the column name for the r2p_record_ID field
     */
    public const COL_R2P_RECORD_ID = 'record2property_r2p.r2p_record_ID';

    /**
     * the column name for the r2p_Value field
     */
    public const COL_R2P_VALUE = 'record2property_r2p.r2p_Value';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['PropertyId', 'RecordId', 'PropertyValue', ],
        self::TYPE_CAMELNAME     => ['propertyId', 'recordId', 'propertyValue', ],
        self::TYPE_COLNAME       => [RecordPropertyTableMap::COL_R2P_PRO_ID, RecordPropertyTableMap::COL_R2P_RECORD_ID, RecordPropertyTableMap::COL_R2P_VALUE, ],
        self::TYPE_FIELDNAME     => ['r2p_pro_ID', 'r2p_record_ID', 'r2p_Value', ],
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
        self::TYPE_PHPNAME       => ['PropertyId' => 0, 'RecordId' => 1, 'PropertyValue' => 2, ],
        self::TYPE_CAMELNAME     => ['propertyId' => 0, 'recordId' => 1, 'propertyValue' => 2, ],
        self::TYPE_COLNAME       => [RecordPropertyTableMap::COL_R2P_PRO_ID => 0, RecordPropertyTableMap::COL_R2P_RECORD_ID => 1, RecordPropertyTableMap::COL_R2P_VALUE => 2, ],
        self::TYPE_FIELDNAME     => ['r2p_pro_ID' => 0, 'r2p_record_ID' => 1, 'r2p_Value' => 2, ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'PropertyId' => 'R2P_PRO_ID',
        'RecordProperty.PropertyId' => 'R2P_PRO_ID',
        'propertyId' => 'R2P_PRO_ID',
        'recordProperty.propertyId' => 'R2P_PRO_ID',
        'RecordPropertyTableMap::COL_R2P_PRO_ID' => 'R2P_PRO_ID',
        'COL_R2P_PRO_ID' => 'R2P_PRO_ID',
        'r2p_pro_ID' => 'R2P_PRO_ID',
        'record2property_r2p.r2p_pro_ID' => 'R2P_PRO_ID',
        'RecordId' => 'R2P_RECORD_ID',
        'RecordProperty.RecordId' => 'R2P_RECORD_ID',
        'recordId' => 'R2P_RECORD_ID',
        'recordProperty.recordId' => 'R2P_RECORD_ID',
        'RecordPropertyTableMap::COL_R2P_RECORD_ID' => 'R2P_RECORD_ID',
        'COL_R2P_RECORD_ID' => 'R2P_RECORD_ID',
        'r2p_record_ID' => 'R2P_RECORD_ID',
        'record2property_r2p.r2p_record_ID' => 'R2P_RECORD_ID',
        'PropertyValue' => 'R2P_VALUE',
        'RecordProperty.PropertyValue' => 'R2P_VALUE',
        'propertyValue' => 'R2P_VALUE',
        'recordProperty.propertyValue' => 'R2P_VALUE',
        'RecordPropertyTableMap::COL_R2P_VALUE' => 'R2P_VALUE',
        'COL_R2P_VALUE' => 'R2P_VALUE',
        'r2p_Value' => 'R2P_VALUE',
        'record2property_r2p.r2p_Value' => 'R2P_VALUE',
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
        $this->setName('record2property_r2p');
        $this->setPhpName('RecordProperty');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\RecordProperty');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('r2p_pro_ID', 'PropertyId', 'SMALLINT', 'property_pro', 'pro_ID', true, 8, null);
        $this->addPrimaryKey('r2p_record_ID', 'RecordId', 'SMALLINT', true, 8, null);
        $this->addColumn('r2p_Value', 'PropertyValue', 'LONGVARCHAR', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Property',
            '\\ChurchCRM\\model\\ChurchCRM\\Property',
            RelationMap::MANY_TO_ONE,
            [[':r2p_pro_ID', ':pro_ID']],
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
     * @param \ChurchCRM\model\ChurchCRM\Base\RecordProperty $obj
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(RecordProperty $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([$obj->getPropertyId() === null || is_scalar($obj->getPropertyId()) || is_callable([$obj->getPropertyId(), '__toString']) ? (string)$obj->getPropertyId() : $obj->getPropertyId(), $obj->getRecordId() === null || is_scalar($obj->getRecordId()) || is_callable([$obj->getRecordId(), '__toString']) ? (string)$obj->getRecordId() : $obj->getRecordId()]);
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
     * @param mixed $value A RecordProperty object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof RecordProperty) {
                $key = serialize([$value->getPropertyId() === null || is_scalar($value->getPropertyId()) || is_callable([$value->getPropertyId(), '__toString']) ? (string)$value->getPropertyId() : $value->getPropertyId(), $value->getRecordId() === null || is_scalar($value->getRecordId()) || is_callable([$value->getRecordId(), '__toString']) ? (string)$value->getRecordId() : $value->getRecordId()]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([$value[0] === null || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string)$value[0] : $value[0], $value[1] === null || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string)$value[1] : $value[1]]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \ChurchCRM\model\ChurchCRM\Base\RecordProperty object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)], $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)]]);
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
                : self::translateFieldName('PropertyId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('RecordId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? RecordPropertyTableMap::CLASS_DEFAULT : RecordPropertyTableMap::OM_CLASS;
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
     * @return array (ChildRecordProperty object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = RecordPropertyTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = RecordPropertyTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RecordPropertyTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RecordPropertyTableMap::OM_CLASS;
            /** @var ChildRecordProperty $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RecordPropertyTableMap::addInstanceToPool($obj, $key);
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
            $key = RecordPropertyTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = RecordPropertyTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new ChildRecordProperty();
                $obj->hydrate($row);
                $results[] = $obj;
                RecordPropertyTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'record2property_r2p';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['R2P_PRO_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['R2P_RECORD_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['R2P_VALUE']));
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
            $criteria->removeSelectColumn(RecordPropertyTableMap::COL_R2P_PRO_ID);
            $criteria->removeSelectColumn(RecordPropertyTableMap::COL_R2P_RECORD_ID);
            $criteria->removeSelectColumn(RecordPropertyTableMap::COL_R2P_VALUE);
        } else {
            $criteria->removeSelectColumn($alias . '.r2p_pro_ID');
            $criteria->removeSelectColumn($alias . '.r2p_record_ID');
            $criteria->removeSelectColumn($alias . '.r2p_Value');
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
        return Propel::getServiceContainer()->getDatabaseMap(RecordPropertyTableMap::DATABASE_NAME)->getTable(RecordPropertyTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or RecordPropertyQuery.
     *
     * Performs a DELETE on the database, given a ChildRecordProperty or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or ChildRecordProperty object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or RecordPropertyQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecordPropertyTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof ChildRecordProperty) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RecordPropertyTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(RecordPropertyTableMap::COL_R2P_PRO_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(RecordPropertyTableMap::COL_R2P_RECORD_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = RecordPropertyQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RecordPropertyTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                RecordPropertyTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the record2property_r2p table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return RecordPropertyQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChildRecordProperty or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\RecordProperty $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(RecordPropertyTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChildRecordProperty object
        }

        // Set the correct dbName
        $query = RecordPropertyQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
