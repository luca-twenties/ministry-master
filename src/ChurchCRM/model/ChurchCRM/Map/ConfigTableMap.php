<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Config;
use ChurchCRM\model\ChurchCRM\ConfigQuery;
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
 * This class defines the structure of the 'config_cfg' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class ConfigTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.ConfigTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'config_cfg';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Config';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Config';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Config';

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
     * the column name for the cfg_id field
     */
    public const COL_CFG_ID = 'config_cfg.cfg_id';

    /**
     * the column name for the cfg_name field
     */
    public const COL_CFG_NAME = 'config_cfg.cfg_name';

    /**
     * the column name for the cfg_value field
     */
    public const COL_CFG_VALUE = 'config_cfg.cfg_value';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\ConfigCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\ConfigCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Name', 'Value', ],
        self::TYPE_CAMELNAME     => ['id', 'name', 'value', ],
        self::TYPE_COLNAME       => [ConfigTableMap::COL_CFG_ID, ConfigTableMap::COL_CFG_NAME, ConfigTableMap::COL_CFG_VALUE, ],
        self::TYPE_FIELDNAME     => ['cfg_id', 'cfg_name', 'cfg_value', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Name' => 1, 'Value' => 2, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'name' => 1, 'value' => 2, ],
        self::TYPE_COLNAME       => [ConfigTableMap::COL_CFG_ID => 0, ConfigTableMap::COL_CFG_NAME => 1, ConfigTableMap::COL_CFG_VALUE => 2, ],
        self::TYPE_FIELDNAME     => ['cfg_id' => 0, 'cfg_name' => 1, 'cfg_value' => 2, ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'CFG_ID',
        'Config.Id' => 'CFG_ID',
        'id' => 'CFG_ID',
        'config.id' => 'CFG_ID',
        'ConfigTableMap::COL_CFG_ID' => 'CFG_ID',
        'COL_CFG_ID' => 'CFG_ID',
        'cfg_id' => 'CFG_ID',
        'config_cfg.cfg_id' => 'CFG_ID',
        'Name' => 'CFG_NAME',
        'Config.Name' => 'CFG_NAME',
        'name' => 'CFG_NAME',
        'config.name' => 'CFG_NAME',
        'ConfigTableMap::COL_CFG_NAME' => 'CFG_NAME',
        'COL_CFG_NAME' => 'CFG_NAME',
        'cfg_name' => 'CFG_NAME',
        'config_cfg.cfg_name' => 'CFG_NAME',
        'Value' => 'CFG_VALUE',
        'Config.Value' => 'CFG_VALUE',
        'value' => 'CFG_VALUE',
        'config.value' => 'CFG_VALUE',
        'ConfigTableMap::COL_CFG_VALUE' => 'CFG_VALUE',
        'COL_CFG_VALUE' => 'CFG_VALUE',
        'cfg_value' => 'CFG_VALUE',
        'config_cfg.cfg_value' => 'CFG_VALUE',
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
        $this->setName('config_cfg');
        $this->setPhpName('Config');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Config');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('cfg_id', 'Id', 'INTEGER', true, null, 0);
        $this->addColumn('cfg_name', 'Name', 'VARCHAR', true, 50, '');
        $this->addColumn('cfg_value', 'Value', 'LONGVARCHAR', false, null, null);
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
        return $withPrefix ? ConfigTableMap::CLASS_DEFAULT : ConfigTableMap::OM_CLASS;
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
     * @return array (Config object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = ConfigTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = ConfigTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ConfigTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ConfigTableMap::OM_CLASS;
            /** @var Config $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ConfigTableMap::addInstanceToPool($obj, $key);
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
            $key = ConfigTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = ConfigTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Config();
                $obj->hydrate($row);
                $results[] = $obj;
                ConfigTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'config_cfg';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CFG_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CFG_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CFG_VALUE']));
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
            $criteria->removeSelectColumn(ConfigTableMap::COL_CFG_ID);
            $criteria->removeSelectColumn(ConfigTableMap::COL_CFG_NAME);
            $criteria->removeSelectColumn(ConfigTableMap::COL_CFG_VALUE);
        } else {
            $criteria->removeSelectColumn($alias . '.cfg_id');
            $criteria->removeSelectColumn($alias . '.cfg_name');
            $criteria->removeSelectColumn($alias . '.cfg_value');
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
        return Propel::getServiceContainer()->getDatabaseMap(ConfigTableMap::DATABASE_NAME)->getTable(ConfigTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or ConfigQuery.
     *
     * Performs a DELETE on the database, given a Config or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Config object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or ConfigQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConfigTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Config) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ConfigTableMap::DATABASE_NAME);
            $criteria->addAnd(ConfigTableMap::COL_CFG_ID, (array)$values, Criteria::IN);
        }

        $query = ConfigQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ConfigTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                ConfigTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the config_cfg table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return ConfigQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Config or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Config $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(ConfigTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Config object
        }

        // Set the correct dbName
        $query = ConfigQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
