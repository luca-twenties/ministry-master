<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Base\UserSetting;
use ChurchCRM\model\ChurchCRM\UserSetting as ChildUserSetting;
use ChurchCRM\model\ChurchCRM\UserSettingQuery;
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
 * This class defines the structure of the 'user_settings' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class UserSettingTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.UserSettingTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'user_settings';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'UserSetting';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\UserSetting';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.UserSetting';

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
     * the column name for the user_id field
     */
    public const COL_USER_ID = 'user_settings.user_id';

    /**
     * the column name for the setting_name field
     */
    public const COL_SETTING_NAME = 'user_settings.setting_name';

    /**
     * the column name for the setting_value field
     */
    public const COL_SETTING_VALUE = 'user_settings.setting_value';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['UserId', 'Name', 'Value', ],
        self::TYPE_CAMELNAME     => ['userId', 'name', 'value', ],
        self::TYPE_COLNAME       => [UserSettingTableMap::COL_USER_ID, UserSettingTableMap::COL_SETTING_NAME, UserSettingTableMap::COL_SETTING_VALUE, ],
        self::TYPE_FIELDNAME     => ['user_id', 'setting_name', 'setting_value', ],
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
        self::TYPE_PHPNAME       => ['UserId' => 0, 'Name' => 1, 'Value' => 2, ],
        self::TYPE_CAMELNAME     => ['userId' => 0, 'name' => 1, 'value' => 2, ],
        self::TYPE_COLNAME       => [UserSettingTableMap::COL_USER_ID => 0, UserSettingTableMap::COL_SETTING_NAME => 1, UserSettingTableMap::COL_SETTING_VALUE => 2, ],
        self::TYPE_FIELDNAME     => ['user_id' => 0, 'setting_name' => 1, 'setting_value' => 2, ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'UserId' => 'USER_ID',
        'UserSetting.UserId' => 'USER_ID',
        'userId' => 'USER_ID',
        'userSetting.userId' => 'USER_ID',
        'UserSettingTableMap::COL_USER_ID' => 'USER_ID',
        'COL_USER_ID' => 'USER_ID',
        'user_id' => 'USER_ID',
        'user_settings.user_id' => 'USER_ID',
        'Name' => 'SETTING_NAME',
        'UserSetting.Name' => 'SETTING_NAME',
        'name' => 'SETTING_NAME',
        'userSetting.name' => 'SETTING_NAME',
        'UserSettingTableMap::COL_SETTING_NAME' => 'SETTING_NAME',
        'COL_SETTING_NAME' => 'SETTING_NAME',
        'setting_name' => 'SETTING_NAME',
        'user_settings.setting_name' => 'SETTING_NAME',
        'Value' => 'SETTING_VALUE',
        'UserSetting.Value' => 'SETTING_VALUE',
        'value' => 'SETTING_VALUE',
        'userSetting.value' => 'SETTING_VALUE',
        'UserSettingTableMap::COL_SETTING_VALUE' => 'SETTING_VALUE',
        'COL_SETTING_VALUE' => 'SETTING_VALUE',
        'setting_value' => 'SETTING_VALUE',
        'user_settings.setting_value' => 'SETTING_VALUE',
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
        $this->setName('user_settings');
        $this->setPhpName('UserSetting');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\UserSetting');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('user_id', 'UserId', 'SMALLINT', 'user_usr', 'usr_per_ID', true, 9, null);
        $this->addPrimaryKey('setting_name', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('setting_value', 'Value', 'VARCHAR', false, 50, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'User',
            '\\ChurchCRM\\model\\ChurchCRM\\User',
            RelationMap::MANY_TO_ONE,
            [[':user_id', ':usr_per_ID']],
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
     * @param \ChurchCRM\model\ChurchCRM\Base\UserSetting $obj
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(UserSetting $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([$obj->getUserId() === null || is_scalar($obj->getUserId()) || is_callable([$obj->getUserId(), '__toString']) ? (string)$obj->getUserId() : $obj->getUserId(), $obj->getName() === null || is_scalar($obj->getName()) || is_callable([$obj->getName(), '__toString']) ? (string)$obj->getName() : $obj->getName()]);
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
     * @param mixed $value A UserSetting object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof UserSetting) {
                $key = serialize([$value->getUserId() === null || is_scalar($value->getUserId()) || is_callable([$value->getUserId(), '__toString']) ? (string)$value->getUserId() : $value->getUserId(), $value->getName() === null || is_scalar($value->getName()) || is_callable([$value->getName(), '__toString']) ? (string)$value->getName() : $value->getName()]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([$value[0] === null || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string)$value[0] : $value[0], $value[1] === null || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string)$value[1] : $value[1]]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \ChurchCRM\model\ChurchCRM\Base\UserSetting object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)], $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)]]);
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
                : self::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UserSettingTableMap::CLASS_DEFAULT : UserSettingTableMap::OM_CLASS;
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
     * @return array (ChildUserSetting object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = UserSettingTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = UserSettingTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserSettingTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserSettingTableMap::OM_CLASS;
            /** @var ChildUserSetting $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserSettingTableMap::addInstanceToPool($obj, $key);
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
            $key = UserSettingTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = UserSettingTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new ChildUserSetting();
                $obj->hydrate($row);
                $results[] = $obj;
                UserSettingTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'user_settings';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['USER_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['SETTING_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['SETTING_VALUE']));
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
            $criteria->removeSelectColumn(UserSettingTableMap::COL_USER_ID);
            $criteria->removeSelectColumn(UserSettingTableMap::COL_SETTING_NAME);
            $criteria->removeSelectColumn(UserSettingTableMap::COL_SETTING_VALUE);
        } else {
            $criteria->removeSelectColumn($alias . '.user_id');
            $criteria->removeSelectColumn($alias . '.setting_name');
            $criteria->removeSelectColumn($alias . '.setting_value');
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
        return Propel::getServiceContainer()->getDatabaseMap(UserSettingTableMap::DATABASE_NAME)->getTable(UserSettingTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or UserSettingQuery.
     *
     * Performs a DELETE on the database, given a ChildUserSetting or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or ChildUserSetting object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or UserSettingQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSettingTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof ChildUserSetting) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserSettingTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(UserSettingTableMap::COL_USER_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(UserSettingTableMap::COL_SETTING_NAME, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = UserSettingQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserSettingTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                UserSettingTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_settings table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return UserSettingQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChildUserSetting or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\UserSetting $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserSettingTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChildUserSetting object
        }

        // Set the correct dbName
        $query = UserSettingQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
