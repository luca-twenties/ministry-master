<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\QueryParameterOptions;
use ChurchCRM\model\ChurchCRM\QueryParameterOptionsQuery;
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
 * This class defines the structure of the 'queryparameteroptions_qpo' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class QueryParameterOptionsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.QueryParameterOptionsTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'queryparameteroptions_qpo';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'QueryParameterOptions';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\QueryParameterOptions';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.QueryParameterOptions';

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
     * the column name for the qpo_ID field
     */
    public const COL_QPO_ID = 'queryparameteroptions_qpo.qpo_ID';

    /**
     * the column name for the qpo_qrp_ID field
     */
    public const COL_QPO_QRP_ID = 'queryparameteroptions_qpo.qpo_qrp_ID';

    /**
     * the column name for the qpo_Display field
     */
    public const COL_QPO_DISPLAY = 'queryparameteroptions_qpo.qpo_Display';

    /**
     * the column name for the qpo_Value field
     */
    public const COL_QPO_VALUE = 'queryparameteroptions_qpo.qpo_Value';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\QueryParameterOptionsCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\QueryParameterOptionsCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['QpoId', 'QpoQrpId', 'QpoDisplay', 'QpoValue', ],
        self::TYPE_CAMELNAME     => ['qpoId', 'qpoQrpId', 'qpoDisplay', 'qpoValue', ],
        self::TYPE_COLNAME       => [QueryParameterOptionsTableMap::COL_QPO_ID, QueryParameterOptionsTableMap::COL_QPO_QRP_ID, QueryParameterOptionsTableMap::COL_QPO_DISPLAY, QueryParameterOptionsTableMap::COL_QPO_VALUE, ],
        self::TYPE_FIELDNAME     => ['qpo_ID', 'qpo_qrp_ID', 'qpo_Display', 'qpo_Value', ],
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
        self::TYPE_PHPNAME       => ['QpoId' => 0, 'QpoQrpId' => 1, 'QpoDisplay' => 2, 'QpoValue' => 3, ],
        self::TYPE_CAMELNAME     => ['qpoId' => 0, 'qpoQrpId' => 1, 'qpoDisplay' => 2, 'qpoValue' => 3, ],
        self::TYPE_COLNAME       => [QueryParameterOptionsTableMap::COL_QPO_ID => 0, QueryParameterOptionsTableMap::COL_QPO_QRP_ID => 1, QueryParameterOptionsTableMap::COL_QPO_DISPLAY => 2, QueryParameterOptionsTableMap::COL_QPO_VALUE => 3, ],
        self::TYPE_FIELDNAME     => ['qpo_ID' => 0, 'qpo_qrp_ID' => 1, 'qpo_Display' => 2, 'qpo_Value' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'QpoId' => 'QPO_ID',
        'QueryParameterOptions.QpoId' => 'QPO_ID',
        'qpoId' => 'QPO_ID',
        'queryParameterOptions.qpoId' => 'QPO_ID',
        'QueryParameterOptionsTableMap::COL_QPO_ID' => 'QPO_ID',
        'COL_QPO_ID' => 'QPO_ID',
        'qpo_ID' => 'QPO_ID',
        'queryparameteroptions_qpo.qpo_ID' => 'QPO_ID',
        'QpoQrpId' => 'QPO_QRP_ID',
        'QueryParameterOptions.QpoQrpId' => 'QPO_QRP_ID',
        'qpoQrpId' => 'QPO_QRP_ID',
        'queryParameterOptions.qpoQrpId' => 'QPO_QRP_ID',
        'QueryParameterOptionsTableMap::COL_QPO_QRP_ID' => 'QPO_QRP_ID',
        'COL_QPO_QRP_ID' => 'QPO_QRP_ID',
        'qpo_qrp_ID' => 'QPO_QRP_ID',
        'queryparameteroptions_qpo.qpo_qrp_ID' => 'QPO_QRP_ID',
        'QpoDisplay' => 'QPO_DISPLAY',
        'QueryParameterOptions.QpoDisplay' => 'QPO_DISPLAY',
        'qpoDisplay' => 'QPO_DISPLAY',
        'queryParameterOptions.qpoDisplay' => 'QPO_DISPLAY',
        'QueryParameterOptionsTableMap::COL_QPO_DISPLAY' => 'QPO_DISPLAY',
        'COL_QPO_DISPLAY' => 'QPO_DISPLAY',
        'qpo_Display' => 'QPO_DISPLAY',
        'queryparameteroptions_qpo.qpo_Display' => 'QPO_DISPLAY',
        'QpoValue' => 'QPO_VALUE',
        'QueryParameterOptions.QpoValue' => 'QPO_VALUE',
        'qpoValue' => 'QPO_VALUE',
        'queryParameterOptions.qpoValue' => 'QPO_VALUE',
        'QueryParameterOptionsTableMap::COL_QPO_VALUE' => 'QPO_VALUE',
        'COL_QPO_VALUE' => 'QPO_VALUE',
        'qpo_Value' => 'QPO_VALUE',
        'queryparameteroptions_qpo.qpo_Value' => 'QPO_VALUE',
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
        $this->setName('queryparameteroptions_qpo');
        $this->setPhpName('QueryParameterOptions');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\QueryParameterOptions');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('qpo_ID', 'QpoId', 'SMALLINT', true, 5, null);
        $this->addColumn('qpo_qrp_ID', 'QpoQrpId', 'SMALLINT', true, 8, 0);
        $this->addColumn('qpo_Display', 'QpoDisplay', 'VARCHAR', true, 50, '');
        $this->addColumn('qpo_Value', 'QpoValue', 'VARCHAR', true, 50, '');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $qpoIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('QpoId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$qpoIdIx];
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
        return $withPrefix ? QueryParameterOptionsTableMap::CLASS_DEFAULT : QueryParameterOptionsTableMap::OM_CLASS;
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
     * @return array (QueryParameterOptions object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = QueryParameterOptionsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = QueryParameterOptionsTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + QueryParameterOptionsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = QueryParameterOptionsTableMap::OM_CLASS;
            /** @var QueryParameterOptions $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            QueryParameterOptionsTableMap::addInstanceToPool($obj, $key);
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
            $key = QueryParameterOptionsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = QueryParameterOptionsTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new QueryParameterOptions();
                $obj->hydrate($row);
                $results[] = $obj;
                QueryParameterOptionsTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'queryparameteroptions_qpo';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QPO_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QPO_QRP_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QPO_DISPLAY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QPO_VALUE']));
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
            $criteria->removeSelectColumn(QueryParameterOptionsTableMap::COL_QPO_ID);
            $criteria->removeSelectColumn(QueryParameterOptionsTableMap::COL_QPO_QRP_ID);
            $criteria->removeSelectColumn(QueryParameterOptionsTableMap::COL_QPO_DISPLAY);
            $criteria->removeSelectColumn(QueryParameterOptionsTableMap::COL_QPO_VALUE);
        } else {
            $criteria->removeSelectColumn($alias . '.qpo_ID');
            $criteria->removeSelectColumn($alias . '.qpo_qrp_ID');
            $criteria->removeSelectColumn($alias . '.qpo_Display');
            $criteria->removeSelectColumn($alias . '.qpo_Value');
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
        return Propel::getServiceContainer()->getDatabaseMap(QueryParameterOptionsTableMap::DATABASE_NAME)->getTable(QueryParameterOptionsTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or QueryParameterOptionsQuery.
     *
     * Performs a DELETE on the database, given a QueryParameterOptions or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or QueryParameterOptions object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or QueryParameterOptionsQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParameterOptionsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof QueryParameterOptions) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(QueryParameterOptionsTableMap::DATABASE_NAME);
            $criteria->addAnd(QueryParameterOptionsTableMap::COL_QPO_ID, (array)$values, Criteria::IN);
        }

        $query = QueryParameterOptionsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            QueryParameterOptionsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                QueryParameterOptionsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the queryparameteroptions_qpo table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return QueryParameterOptionsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a QueryParameterOptions or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\QueryParameterOptions $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParameterOptionsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from QueryParameterOptions object
        }

        if ($criteria->hasUpdateValue(QueryParameterOptionsTableMap::COL_QPO_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (QueryParameterOptionsTableMap::COL_QPO_ID)');
        }

        // Set the correct dbName
        $query = QueryParameterOptionsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
