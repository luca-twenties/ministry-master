<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\PredefinedReports;
use ChurchCRM\model\ChurchCRM\PredefinedReportsQuery;
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
 * This class defines the structure of the 'query_qry' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PredefinedReportsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.PredefinedReportsTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'query_qry';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'PredefinedReports';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\PredefinedReports';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.PredefinedReports';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the qry_ID field
     */
    public const COL_QRY_ID = 'query_qry.qry_ID';

    /**
     * the column name for the qry_SQL field
     */
    public const COL_QRY_SQL = 'query_qry.qry_SQL';

    /**
     * the column name for the qry_Name field
     */
    public const COL_QRY_NAME = 'query_qry.qry_Name';

    /**
     * the column name for the qry_Description field
     */
    public const COL_QRY_DESCRIPTION = 'query_qry.qry_Description';

    /**
     * the column name for the qry_Count field
     */
    public const COL_QRY_COUNT = 'query_qry.qry_Count';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\PredefinedReportsCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\PredefinedReportsCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['QryId', 'QrySql', 'QryName', 'QryDescription', 'QryCount', ],
        self::TYPE_CAMELNAME     => ['qryId', 'qrySql', 'qryName', 'qryDescription', 'qryCount', ],
        self::TYPE_COLNAME       => [PredefinedReportsTableMap::COL_QRY_ID, PredefinedReportsTableMap::COL_QRY_SQL, PredefinedReportsTableMap::COL_QRY_NAME, PredefinedReportsTableMap::COL_QRY_DESCRIPTION, PredefinedReportsTableMap::COL_QRY_COUNT, ],
        self::TYPE_FIELDNAME     => ['qry_ID', 'qry_SQL', 'qry_Name', 'qry_Description', 'qry_Count', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
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
        self::TYPE_PHPNAME       => ['QryId' => 0, 'QrySql' => 1, 'QryName' => 2, 'QryDescription' => 3, 'QryCount' => 4, ],
        self::TYPE_CAMELNAME     => ['qryId' => 0, 'qrySql' => 1, 'qryName' => 2, 'qryDescription' => 3, 'qryCount' => 4, ],
        self::TYPE_COLNAME       => [PredefinedReportsTableMap::COL_QRY_ID => 0, PredefinedReportsTableMap::COL_QRY_SQL => 1, PredefinedReportsTableMap::COL_QRY_NAME => 2, PredefinedReportsTableMap::COL_QRY_DESCRIPTION => 3, PredefinedReportsTableMap::COL_QRY_COUNT => 4, ],
        self::TYPE_FIELDNAME     => ['qry_ID' => 0, 'qry_SQL' => 1, 'qry_Name' => 2, 'qry_Description' => 3, 'qry_Count' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'QryId' => 'QRY_ID',
        'PredefinedReports.QryId' => 'QRY_ID',
        'qryId' => 'QRY_ID',
        'predefinedReports.qryId' => 'QRY_ID',
        'PredefinedReportsTableMap::COL_QRY_ID' => 'QRY_ID',
        'COL_QRY_ID' => 'QRY_ID',
        'qry_ID' => 'QRY_ID',
        'query_qry.qry_ID' => 'QRY_ID',
        'QrySql' => 'QRY_SQL',
        'PredefinedReports.QrySql' => 'QRY_SQL',
        'qrySql' => 'QRY_SQL',
        'predefinedReports.qrySql' => 'QRY_SQL',
        'PredefinedReportsTableMap::COL_QRY_SQL' => 'QRY_SQL',
        'COL_QRY_SQL' => 'QRY_SQL',
        'qry_SQL' => 'QRY_SQL',
        'query_qry.qry_SQL' => 'QRY_SQL',
        'QryName' => 'QRY_NAME',
        'PredefinedReports.QryName' => 'QRY_NAME',
        'qryName' => 'QRY_NAME',
        'predefinedReports.qryName' => 'QRY_NAME',
        'PredefinedReportsTableMap::COL_QRY_NAME' => 'QRY_NAME',
        'COL_QRY_NAME' => 'QRY_NAME',
        'qry_Name' => 'QRY_NAME',
        'query_qry.qry_Name' => 'QRY_NAME',
        'QryDescription' => 'QRY_DESCRIPTION',
        'PredefinedReports.QryDescription' => 'QRY_DESCRIPTION',
        'qryDescription' => 'QRY_DESCRIPTION',
        'predefinedReports.qryDescription' => 'QRY_DESCRIPTION',
        'PredefinedReportsTableMap::COL_QRY_DESCRIPTION' => 'QRY_DESCRIPTION',
        'COL_QRY_DESCRIPTION' => 'QRY_DESCRIPTION',
        'qry_Description' => 'QRY_DESCRIPTION',
        'query_qry.qry_Description' => 'QRY_DESCRIPTION',
        'QryCount' => 'QRY_COUNT',
        'PredefinedReports.QryCount' => 'QRY_COUNT',
        'qryCount' => 'QRY_COUNT',
        'predefinedReports.qryCount' => 'QRY_COUNT',
        'PredefinedReportsTableMap::COL_QRY_COUNT' => 'QRY_COUNT',
        'COL_QRY_COUNT' => 'QRY_COUNT',
        'qry_Count' => 'QRY_COUNT',
        'query_qry.qry_Count' => 'QRY_COUNT',
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
        $this->setName('query_qry');
        $this->setPhpName('PredefinedReports');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\PredefinedReports');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('qry_ID', 'QryId', 'SMALLINT', true, 8, null);
        $this->addColumn('qry_SQL', 'QrySql', 'LONGVARCHAR', true, null, null);
        $this->addColumn('qry_Name', 'QryName', 'VARCHAR', true, 255, '');
        $this->addColumn('qry_Description', 'QryDescription', 'LONGVARCHAR', true, null, null);
        $this->addColumn('qry_Count', 'QryCount', 'BOOLEAN', true, 1, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $qryIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$qryIdIx];
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
        return $withPrefix ? PredefinedReportsTableMap::CLASS_DEFAULT : PredefinedReportsTableMap::OM_CLASS;
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
     * @return array (PredefinedReports object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PredefinedReportsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = PredefinedReportsTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PredefinedReportsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PredefinedReportsTableMap::OM_CLASS;
            /** @var PredefinedReports $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PredefinedReportsTableMap::addInstanceToPool($obj, $key);
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
            $key = PredefinedReportsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = PredefinedReportsTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new PredefinedReports();
                $obj->hydrate($row);
                $results[] = $obj;
                PredefinedReportsTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'query_qry';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRY_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRY_SQL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRY_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRY_DESCRIPTION']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['QRY_COUNT']));
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
            $criteria->removeSelectColumn(PredefinedReportsTableMap::COL_QRY_ID);
            $criteria->removeSelectColumn(PredefinedReportsTableMap::COL_QRY_SQL);
            $criteria->removeSelectColumn(PredefinedReportsTableMap::COL_QRY_NAME);
            $criteria->removeSelectColumn(PredefinedReportsTableMap::COL_QRY_DESCRIPTION);
            $criteria->removeSelectColumn(PredefinedReportsTableMap::COL_QRY_COUNT);
        } else {
            $criteria->removeSelectColumn($alias . '.qry_ID');
            $criteria->removeSelectColumn($alias . '.qry_SQL');
            $criteria->removeSelectColumn($alias . '.qry_Name');
            $criteria->removeSelectColumn($alias . '.qry_Description');
            $criteria->removeSelectColumn($alias . '.qry_Count');
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
        return Propel::getServiceContainer()->getDatabaseMap(PredefinedReportsTableMap::DATABASE_NAME)->getTable(PredefinedReportsTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or PredefinedReportsQuery.
     *
     * Performs a DELETE on the database, given a PredefinedReports or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or PredefinedReports object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or PredefinedReportsQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PredefinedReportsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof PredefinedReports) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PredefinedReportsTableMap::DATABASE_NAME);
            $criteria->addAnd(PredefinedReportsTableMap::COL_QRY_ID, (array)$values, Criteria::IN);
        }

        $query = PredefinedReportsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PredefinedReportsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                PredefinedReportsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the query_qry table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PredefinedReportsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PredefinedReports or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\PredefinedReports $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(PredefinedReportsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PredefinedReports object
        }

        if ($criteria->hasUpdateValue(PredefinedReportsTableMap::COL_QRY_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (PredefinedReportsTableMap::COL_QRY_ID)');
        }

        // Set the correct dbName
        $query = PredefinedReportsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
