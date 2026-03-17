<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Base\ListOption;
use ChurchCRM\model\ChurchCRM\ListOption as ChildListOption;
use ChurchCRM\model\ChurchCRM\ListOptionQuery;
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
 * This class defines the structure of the 'list_lst' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class ListOptionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.ListOptionTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'list_lst';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'ListOption';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\ListOption';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.ListOption';

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
     * the column name for the lst_ID field
     */
    public const COL_LST_ID = 'list_lst.lst_ID';

    /**
     * the column name for the lst_OptionID field
     */
    public const COL_LST_OPTIONID = 'list_lst.lst_OptionID';

    /**
     * the column name for the lst_OptionSequence field
     */
    public const COL_LST_OPTIONSEQUENCE = 'list_lst.lst_OptionSequence';

    /**
     * the column name for the lst_OptionName field
     */
    public const COL_LST_OPTIONNAME = 'list_lst.lst_OptionName';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\ListOptionCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\ListOptionCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'OptionId', 'OptionSequence', 'OptionName', ],
        self::TYPE_CAMELNAME     => ['id', 'optionId', 'optionSequence', 'optionName', ],
        self::TYPE_COLNAME       => [ListOptionTableMap::COL_LST_ID, ListOptionTableMap::COL_LST_OPTIONID, ListOptionTableMap::COL_LST_OPTIONSEQUENCE, ListOptionTableMap::COL_LST_OPTIONNAME, ],
        self::TYPE_FIELDNAME     => ['lst_ID', 'lst_OptionID', 'lst_OptionSequence', 'lst_OptionName', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'OptionId' => 1, 'OptionSequence' => 2, 'OptionName' => 3, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'optionId' => 1, 'optionSequence' => 2, 'optionName' => 3, ],
        self::TYPE_COLNAME       => [ListOptionTableMap::COL_LST_ID => 0, ListOptionTableMap::COL_LST_OPTIONID => 1, ListOptionTableMap::COL_LST_OPTIONSEQUENCE => 2, ListOptionTableMap::COL_LST_OPTIONNAME => 3, ],
        self::TYPE_FIELDNAME     => ['lst_ID' => 0, 'lst_OptionID' => 1, 'lst_OptionSequence' => 2, 'lst_OptionName' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'LST_ID',
        'ListOption.Id' => 'LST_ID',
        'id' => 'LST_ID',
        'listOption.id' => 'LST_ID',
        'ListOptionTableMap::COL_LST_ID' => 'LST_ID',
        'COL_LST_ID' => 'LST_ID',
        'lst_ID' => 'LST_ID',
        'list_lst.lst_ID' => 'LST_ID',
        'OptionId' => 'LST_OPTIONID',
        'ListOption.OptionId' => 'LST_OPTIONID',
        'optionId' => 'LST_OPTIONID',
        'listOption.optionId' => 'LST_OPTIONID',
        'ListOptionTableMap::COL_LST_OPTIONID' => 'LST_OPTIONID',
        'COL_LST_OPTIONID' => 'LST_OPTIONID',
        'lst_OptionID' => 'LST_OPTIONID',
        'list_lst.lst_OptionID' => 'LST_OPTIONID',
        'OptionSequence' => 'LST_OPTIONSEQUENCE',
        'ListOption.OptionSequence' => 'LST_OPTIONSEQUENCE',
        'optionSequence' => 'LST_OPTIONSEQUENCE',
        'listOption.optionSequence' => 'LST_OPTIONSEQUENCE',
        'ListOptionTableMap::COL_LST_OPTIONSEQUENCE' => 'LST_OPTIONSEQUENCE',
        'COL_LST_OPTIONSEQUENCE' => 'LST_OPTIONSEQUENCE',
        'lst_OptionSequence' => 'LST_OPTIONSEQUENCE',
        'list_lst.lst_OptionSequence' => 'LST_OPTIONSEQUENCE',
        'OptionName' => 'LST_OPTIONNAME',
        'ListOption.OptionName' => 'LST_OPTIONNAME',
        'optionName' => 'LST_OPTIONNAME',
        'listOption.optionName' => 'LST_OPTIONNAME',
        'ListOptionTableMap::COL_LST_OPTIONNAME' => 'LST_OPTIONNAME',
        'COL_LST_OPTIONNAME' => 'LST_OPTIONNAME',
        'lst_OptionName' => 'LST_OPTIONNAME',
        'list_lst.lst_OptionName' => 'LST_OPTIONNAME',
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
        $this->setName('list_lst');
        $this->setPhpName('ListOption');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\ListOption');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('lst_ID', 'Id', 'SMALLINT', true, 8, 0);
        $this->addPrimaryKey('lst_OptionID', 'OptionId', 'SMALLINT', true, 8, 0);
        $this->addColumn('lst_OptionSequence', 'OptionSequence', 'TINYINT', true, 3, 0);
        $this->addColumn('lst_OptionName', 'OptionName', 'VARCHAR', true, 50, '');
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
            RelationMap::ONE_TO_MANY,
            [[':grp_RoleListID', ':lst_ID'], [':grp_Type', ':lst_OptionID']],
            null,
            null,
            'Groups',
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
     * @param \ChurchCRM\model\ChurchCRM\Base\ListOption $obj
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(ListOption $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([$obj->getId() === null || is_scalar($obj->getId()) || is_callable([$obj->getId(), '__toString']) ? (string)$obj->getId() : $obj->getId(), $obj->getOptionId() === null || is_scalar($obj->getOptionId()) || is_callable([$obj->getOptionId(), '__toString']) ? (string)$obj->getOptionId() : $obj->getOptionId()]);
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
     * @param mixed $value A ListOption object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof ListOption) {
                $key = serialize([$value->getId() === null || is_scalar($value->getId()) || is_callable([$value->getId(), '__toString']) ? (string)$value->getId() : $value->getId(), $value->getOptionId() === null || is_scalar($value->getOptionId()) || is_callable([$value->getOptionId(), '__toString']) ? (string)$value->getOptionId() : $value->getOptionId()]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([$value[0] === null || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string)$value[0] : $value[0], $value[1] === null || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string)$value[1] : $value[1]]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \ChurchCRM\model\ChurchCRM\Base\ListOption object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)]]);
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
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ListOptionTableMap::CLASS_DEFAULT : ListOptionTableMap::OM_CLASS;
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
     * @return array (ChildListOption object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = ListOptionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = ListOptionTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ListOptionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ListOptionTableMap::OM_CLASS;
            /** @var ChildListOption $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ListOptionTableMap::addInstanceToPool($obj, $key);
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
            $key = ListOptionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = ListOptionTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new ChildListOption();
                $obj->hydrate($row);
                $results[] = $obj;
                ListOptionTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'list_lst';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LST_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LST_OPTIONID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LST_OPTIONSEQUENCE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LST_OPTIONNAME']));
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
            $criteria->removeSelectColumn(ListOptionTableMap::COL_LST_ID);
            $criteria->removeSelectColumn(ListOptionTableMap::COL_LST_OPTIONID);
            $criteria->removeSelectColumn(ListOptionTableMap::COL_LST_OPTIONSEQUENCE);
            $criteria->removeSelectColumn(ListOptionTableMap::COL_LST_OPTIONNAME);
        } else {
            $criteria->removeSelectColumn($alias . '.lst_ID');
            $criteria->removeSelectColumn($alias . '.lst_OptionID');
            $criteria->removeSelectColumn($alias . '.lst_OptionSequence');
            $criteria->removeSelectColumn($alias . '.lst_OptionName');
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
        return Propel::getServiceContainer()->getDatabaseMap(ListOptionTableMap::DATABASE_NAME)->getTable(ListOptionTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or ListOptionQuery.
     *
     * Performs a DELETE on the database, given a ChildListOption or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or ChildListOption object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or ListOptionQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListOptionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof ChildListOption) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ListOptionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(ListOptionTableMap::COL_LST_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(ListOptionTableMap::COL_LST_OPTIONID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = ListOptionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ListOptionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                ListOptionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the list_lst table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return ListOptionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChildListOption or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\ListOption $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(ListOptionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChildListOption object
        }

        // Set the correct dbName
        $query = ListOptionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
