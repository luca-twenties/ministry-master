<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r;
use ChurchCRM\model\ChurchCRM\Person2group2roleP2g2r as ChildPerson2group2roleP2g2r;
use ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery;
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
 * This class defines the structure of the 'person2group2role_p2g2r' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class Person2group2roleP2g2rTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.Person2group2roleP2g2rTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'person2group2role_p2g2r';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Person2group2roleP2g2r';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Person2group2roleP2g2r';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Person2group2roleP2g2r';

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
     * the column name for the p2g2r_per_ID field
     */
    public const COL_P2G2R_PER_ID = 'person2group2role_p2g2r.p2g2r_per_ID';

    /**
     * the column name for the p2g2r_grp_ID field
     */
    public const COL_P2G2R_GRP_ID = 'person2group2role_p2g2r.p2g2r_grp_ID';

    /**
     * the column name for the p2g2r_rle_ID field
     */
    public const COL_P2G2R_RLE_ID = 'person2group2role_p2g2r.p2g2r_rle_ID';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['PersonId', 'GroupId', 'RoleId', ],
        self::TYPE_CAMELNAME     => ['personId', 'groupId', 'roleId', ],
        self::TYPE_COLNAME       => [Person2group2roleP2g2rTableMap::COL_P2G2R_PER_ID, Person2group2roleP2g2rTableMap::COL_P2G2R_GRP_ID, Person2group2roleP2g2rTableMap::COL_P2G2R_RLE_ID, ],
        self::TYPE_FIELDNAME     => ['p2g2r_per_ID', 'p2g2r_grp_ID', 'p2g2r_rle_ID', ],
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
        self::TYPE_PHPNAME       => ['PersonId' => 0, 'GroupId' => 1, 'RoleId' => 2, ],
        self::TYPE_CAMELNAME     => ['personId' => 0, 'groupId' => 1, 'roleId' => 2, ],
        self::TYPE_COLNAME       => [Person2group2roleP2g2rTableMap::COL_P2G2R_PER_ID => 0, Person2group2roleP2g2rTableMap::COL_P2G2R_GRP_ID => 1, Person2group2roleP2g2rTableMap::COL_P2G2R_RLE_ID => 2, ],
        self::TYPE_FIELDNAME     => ['p2g2r_per_ID' => 0, 'p2g2r_grp_ID' => 1, 'p2g2r_rle_ID' => 2, ],
        self::TYPE_NUM           => [0, 1, 2, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'PersonId' => 'P2G2R_PER_ID',
        'Person2group2roleP2g2r.PersonId' => 'P2G2R_PER_ID',
        'personId' => 'P2G2R_PER_ID',
        'person2group2roleP2g2r.personId' => 'P2G2R_PER_ID',
        'Person2group2roleP2g2rTableMap::COL_P2G2R_PER_ID' => 'P2G2R_PER_ID',
        'COL_P2G2R_PER_ID' => 'P2G2R_PER_ID',
        'p2g2r_per_ID' => 'P2G2R_PER_ID',
        'person2group2role_p2g2r.p2g2r_per_ID' => 'P2G2R_PER_ID',
        'GroupId' => 'P2G2R_GRP_ID',
        'Person2group2roleP2g2r.GroupId' => 'P2G2R_GRP_ID',
        'groupId' => 'P2G2R_GRP_ID',
        'person2group2roleP2g2r.groupId' => 'P2G2R_GRP_ID',
        'Person2group2roleP2g2rTableMap::COL_P2G2R_GRP_ID' => 'P2G2R_GRP_ID',
        'COL_P2G2R_GRP_ID' => 'P2G2R_GRP_ID',
        'p2g2r_grp_ID' => 'P2G2R_GRP_ID',
        'person2group2role_p2g2r.p2g2r_grp_ID' => 'P2G2R_GRP_ID',
        'RoleId' => 'P2G2R_RLE_ID',
        'Person2group2roleP2g2r.RoleId' => 'P2G2R_RLE_ID',
        'roleId' => 'P2G2R_RLE_ID',
        'person2group2roleP2g2r.roleId' => 'P2G2R_RLE_ID',
        'Person2group2roleP2g2rTableMap::COL_P2G2R_RLE_ID' => 'P2G2R_RLE_ID',
        'COL_P2G2R_RLE_ID' => 'P2G2R_RLE_ID',
        'p2g2r_rle_ID' => 'P2G2R_RLE_ID',
        'person2group2role_p2g2r.p2g2r_rle_ID' => 'P2G2R_RLE_ID',
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
        $this->setName('person2group2role_p2g2r');
        $this->setPhpName('Person2group2roleP2g2r');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Person2group2roleP2g2r');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('p2g2r_per_ID', 'PersonId', 'SMALLINT', 'person_per', 'per_ID', true, 8, 0);
        $this->addForeignPrimaryKey('p2g2r_grp_ID', 'GroupId', 'SMALLINT', 'group_grp', 'grp_ID', true, 8, 0);
        $this->addColumn('p2g2r_rle_ID', 'RoleId', 'SMALLINT', true, 8, 0);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Person',
            '\\ChurchCRM\\model\\ChurchCRM\\Person',
            RelationMap::MANY_TO_ONE,
            [[':p2g2r_per_ID', ':per_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'Group',
            '\\ChurchCRM\\model\\ChurchCRM\\Group',
            RelationMap::MANY_TO_ONE,
            [[':p2g2r_grp_ID', ':grp_ID']],
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
     * @param \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r $obj
     * @param string|null $key Key (optional) to use for instance map (for performance boost if key was already calculated externally).
     *
     * @return void
     */
    public static function addInstanceToPool(Person2group2roleP2g2r $obj, ?string $key = null): void
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([$obj->getPersonId() === null || is_scalar($obj->getPersonId()) || is_callable([$obj->getPersonId(), '__toString']) ? (string)$obj->getPersonId() : $obj->getPersonId(), $obj->getGroupId() === null || is_scalar($obj->getGroupId()) || is_callable([$obj->getGroupId(), '__toString']) ? (string)$obj->getGroupId() : $obj->getGroupId()]);
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
     * @param mixed $value A Person2group2roleP2g2r object or a primary key value.
     *
     * @return void
     */
    public static function removeInstanceFromPool($value): void
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof Person2group2roleP2g2r) {
                $key = serialize([$value->getPersonId() === null || is_scalar($value->getPersonId()) || is_callable([$value->getPersonId(), '__toString']) ? (string)$value->getPersonId() : $value->getPersonId(), $value->getGroupId() === null || is_scalar($value->getGroupId()) || is_callable([$value->getGroupId(), '__toString']) ? (string)$value->getGroupId() : $value->getGroupId()]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([$value[0] === null || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string)$value[0] : $value[0], $value[1] === null || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string)$value[1] : $value[1]]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)], $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)]]);
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
                : self::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? Person2group2roleP2g2rTableMap::CLASS_DEFAULT : Person2group2roleP2g2rTableMap::OM_CLASS;
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
     * @return array (ChildPerson2group2roleP2g2r object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = Person2group2roleP2g2rTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = Person2group2roleP2g2rTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + Person2group2roleP2g2rTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = Person2group2roleP2g2rTableMap::OM_CLASS;
            /** @var ChildPerson2group2roleP2g2r $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            Person2group2roleP2g2rTableMap::addInstanceToPool($obj, $key);
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
            $key = Person2group2roleP2g2rTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = Person2group2roleP2g2rTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new ChildPerson2group2roleP2g2r();
                $obj->hydrate($row);
                $results[] = $obj;
                Person2group2roleP2g2rTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'person2group2role_p2g2r';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['P2G2R_PER_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['P2G2R_GRP_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['P2G2R_RLE_ID']));
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
            $criteria->removeSelectColumn(Person2group2roleP2g2rTableMap::COL_P2G2R_PER_ID);
            $criteria->removeSelectColumn(Person2group2roleP2g2rTableMap::COL_P2G2R_GRP_ID);
            $criteria->removeSelectColumn(Person2group2roleP2g2rTableMap::COL_P2G2R_RLE_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.p2g2r_per_ID');
            $criteria->removeSelectColumn($alias . '.p2g2r_grp_ID');
            $criteria->removeSelectColumn($alias . '.p2g2r_rle_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(Person2group2roleP2g2rTableMap::DATABASE_NAME)->getTable(Person2group2roleP2g2rTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or Person2group2roleP2g2rQuery.
     *
     * Performs a DELETE on the database, given a ChildPerson2group2roleP2g2r or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or ChildPerson2group2roleP2g2r object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or Person2group2roleP2g2rQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(Person2group2roleP2g2rTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof ChildPerson2group2roleP2g2r) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(Person2group2roleP2g2rTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = [$values];
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(Person2group2roleP2g2rTableMap::COL_P2G2R_PER_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(Person2group2roleP2g2rTableMap::COL_P2G2R_GRP_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = Person2group2roleP2g2rQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            Person2group2roleP2g2rTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                Person2group2roleP2g2rTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the person2group2role_p2g2r table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return Person2group2roleP2g2rQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ChildPerson2group2roleP2g2r or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2r $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(Person2group2roleP2g2rTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ChildPerson2group2roleP2g2r object
        }

        // Set the correct dbName
        $query = Person2group2roleP2g2rQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
