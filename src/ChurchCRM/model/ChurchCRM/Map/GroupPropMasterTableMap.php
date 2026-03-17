<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\GroupPropMaster;
use ChurchCRM\model\ChurchCRM\GroupPropMasterQuery;
use Propel\Runtime\ActiveQuery\ColumnResolver\ColumnExpression\LocalColumnExpression;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use Propel\Runtime\Propel;


/**
 * This class defines the structure of the 'groupprop_master' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class GroupPropMasterTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.GroupPropMasterTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'groupprop_master';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'GroupPropMaster';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\GroupPropMaster';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.GroupPropMaster';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the grp_ID field
     */
    public const COL_GRP_ID = 'groupprop_master.grp_ID';

    /**
     * the column name for the prop_ID field
     */
    public const COL_PROP_ID = 'groupprop_master.prop_ID';

    /**
     * the column name for the prop_Field field
     */
    public const COL_PROP_FIELD = 'groupprop_master.prop_Field';

    /**
     * the column name for the prop_Name field
     */
    public const COL_PROP_NAME = 'groupprop_master.prop_Name';

    /**
     * the column name for the prop_Description field
     */
    public const COL_PROP_DESCRIPTION = 'groupprop_master.prop_Description';

    /**
     * the column name for the type_ID field
     */
    public const COL_TYPE_ID = 'groupprop_master.type_ID';

    /**
     * the column name for the prop_Special field
     */
    public const COL_PROP_SPECIAL = 'groupprop_master.prop_Special';

    /**
     * the column name for the prop_PersonDisplay field
     */
    public const COL_PROP_PERSONDISPLAY = 'groupprop_master.prop_PersonDisplay';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\GroupPropMasterCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\GroupPropMasterCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['GrpId', 'PropId', 'Field', 'Name', 'Description', 'TypeId', 'Special', 'PersonDisplay', ],
        self::TYPE_CAMELNAME     => ['grpId', 'propId', 'field', 'name', 'description', 'typeId', 'special', 'personDisplay', ],
        self::TYPE_COLNAME       => [GroupPropMasterTableMap::COL_GRP_ID, GroupPropMasterTableMap::COL_PROP_ID, GroupPropMasterTableMap::COL_PROP_FIELD, GroupPropMasterTableMap::COL_PROP_NAME, GroupPropMasterTableMap::COL_PROP_DESCRIPTION, GroupPropMasterTableMap::COL_TYPE_ID, GroupPropMasterTableMap::COL_PROP_SPECIAL, GroupPropMasterTableMap::COL_PROP_PERSONDISPLAY, ],
        self::TYPE_FIELDNAME     => ['grp_ID', 'prop_ID', 'prop_Field', 'prop_Name', 'prop_Description', 'type_ID', 'prop_Special', 'prop_PersonDisplay', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
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
        self::TYPE_PHPNAME       => ['GrpId' => 0, 'PropId' => 1, 'Field' => 2, 'Name' => 3, 'Description' => 4, 'TypeId' => 5, 'Special' => 6, 'PersonDisplay' => 7, ],
        self::TYPE_CAMELNAME     => ['grpId' => 0, 'propId' => 1, 'field' => 2, 'name' => 3, 'description' => 4, 'typeId' => 5, 'special' => 6, 'personDisplay' => 7, ],
        self::TYPE_COLNAME       => [GroupPropMasterTableMap::COL_GRP_ID => 0, GroupPropMasterTableMap::COL_PROP_ID => 1, GroupPropMasterTableMap::COL_PROP_FIELD => 2, GroupPropMasterTableMap::COL_PROP_NAME => 3, GroupPropMasterTableMap::COL_PROP_DESCRIPTION => 4, GroupPropMasterTableMap::COL_TYPE_ID => 5, GroupPropMasterTableMap::COL_PROP_SPECIAL => 6, GroupPropMasterTableMap::COL_PROP_PERSONDISPLAY => 7, ],
        self::TYPE_FIELDNAME     => ['grp_ID' => 0, 'prop_ID' => 1, 'prop_Field' => 2, 'prop_Name' => 3, 'prop_Description' => 4, 'type_ID' => 5, 'prop_Special' => 6, 'prop_PersonDisplay' => 7, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, 7, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'GrpId' => 'GRP_ID',
        'GroupPropMaster.GrpId' => 'GRP_ID',
        'grpId' => 'GRP_ID',
        'groupPropMaster.grpId' => 'GRP_ID',
        'GroupPropMasterTableMap::COL_GRP_ID' => 'GRP_ID',
        'COL_GRP_ID' => 'GRP_ID',
        'grp_ID' => 'GRP_ID',
        'groupprop_master.grp_ID' => 'GRP_ID',
        'PropId' => 'PROP_ID',
        'GroupPropMaster.PropId' => 'PROP_ID',
        'propId' => 'PROP_ID',
        'groupPropMaster.propId' => 'PROP_ID',
        'GroupPropMasterTableMap::COL_PROP_ID' => 'PROP_ID',
        'COL_PROP_ID' => 'PROP_ID',
        'prop_ID' => 'PROP_ID',
        'groupprop_master.prop_ID' => 'PROP_ID',
        'Field' => 'PROP_FIELD',
        'GroupPropMaster.Field' => 'PROP_FIELD',
        'field' => 'PROP_FIELD',
        'groupPropMaster.field' => 'PROP_FIELD',
        'GroupPropMasterTableMap::COL_PROP_FIELD' => 'PROP_FIELD',
        'COL_PROP_FIELD' => 'PROP_FIELD',
        'prop_Field' => 'PROP_FIELD',
        'groupprop_master.prop_Field' => 'PROP_FIELD',
        'Name' => 'PROP_NAME',
        'GroupPropMaster.Name' => 'PROP_NAME',
        'name' => 'PROP_NAME',
        'groupPropMaster.name' => 'PROP_NAME',
        'GroupPropMasterTableMap::COL_PROP_NAME' => 'PROP_NAME',
        'COL_PROP_NAME' => 'PROP_NAME',
        'prop_Name' => 'PROP_NAME',
        'groupprop_master.prop_Name' => 'PROP_NAME',
        'Description' => 'PROP_DESCRIPTION',
        'GroupPropMaster.Description' => 'PROP_DESCRIPTION',
        'description' => 'PROP_DESCRIPTION',
        'groupPropMaster.description' => 'PROP_DESCRIPTION',
        'GroupPropMasterTableMap::COL_PROP_DESCRIPTION' => 'PROP_DESCRIPTION',
        'COL_PROP_DESCRIPTION' => 'PROP_DESCRIPTION',
        'prop_Description' => 'PROP_DESCRIPTION',
        'groupprop_master.prop_Description' => 'PROP_DESCRIPTION',
        'TypeId' => 'TYPE_ID',
        'GroupPropMaster.TypeId' => 'TYPE_ID',
        'typeId' => 'TYPE_ID',
        'groupPropMaster.typeId' => 'TYPE_ID',
        'GroupPropMasterTableMap::COL_TYPE_ID' => 'TYPE_ID',
        'COL_TYPE_ID' => 'TYPE_ID',
        'type_ID' => 'TYPE_ID',
        'groupprop_master.type_ID' => 'TYPE_ID',
        'Special' => 'PROP_SPECIAL',
        'GroupPropMaster.Special' => 'PROP_SPECIAL',
        'special' => 'PROP_SPECIAL',
        'groupPropMaster.special' => 'PROP_SPECIAL',
        'GroupPropMasterTableMap::COL_PROP_SPECIAL' => 'PROP_SPECIAL',
        'COL_PROP_SPECIAL' => 'PROP_SPECIAL',
        'prop_Special' => 'PROP_SPECIAL',
        'groupprop_master.prop_Special' => 'PROP_SPECIAL',
        'PersonDisplay' => 'PROP_PERSONDISPLAY',
        'GroupPropMaster.PersonDisplay' => 'PROP_PERSONDISPLAY',
        'personDisplay' => 'PROP_PERSONDISPLAY',
        'groupPropMaster.personDisplay' => 'PROP_PERSONDISPLAY',
        'GroupPropMasterTableMap::COL_PROP_PERSONDISPLAY' => 'PROP_PERSONDISPLAY',
        'COL_PROP_PERSONDISPLAY' => 'PROP_PERSONDISPLAY',
        'prop_PersonDisplay' => 'PROP_PERSONDISPLAY',
        'groupprop_master.prop_PersonDisplay' => 'PROP_PERSONDISPLAY',
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
        $this->setName('groupprop_master');
        $this->setPhpName('GroupPropMaster');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\GroupPropMaster');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('grp_ID', 'GrpId', 'SMALLINT', true, 9, 0);
        $this->addColumn('prop_ID', 'PropId', 'TINYINT', true, 3, 0);
        $this->addColumn('prop_Field', 'Field', 'VARCHAR', true, 5, '0');
        $this->addColumn('prop_Name', 'Name', 'VARCHAR', false, 40, null);
        $this->addColumn('prop_Description', 'Description', 'VARCHAR', false, 60, null);
        $this->addColumn('type_ID', 'TypeId', 'SMALLINT', true, 5, 0);
        $this->addColumn('prop_Special', 'Special', 'SMALLINT', false, 9, null);
        $this->addColumn('prop_PersonDisplay', 'PersonDisplay', 'CHAR', true, null, 'false');
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
        return null;
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
        return '';
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
        return $withPrefix ? GroupPropMasterTableMap::CLASS_DEFAULT : GroupPropMasterTableMap::OM_CLASS;
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
     * @return array (GroupPropMaster object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = GroupPropMasterTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = GroupPropMasterTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + GroupPropMasterTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = GroupPropMasterTableMap::OM_CLASS;
            /** @var GroupPropMaster $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            GroupPropMasterTableMap::addInstanceToPool($obj, $key);
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
            $key = GroupPropMasterTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = GroupPropMasterTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new GroupPropMaster();
                $obj->hydrate($row);
                $results[] = $obj;
                GroupPropMasterTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'groupprop_master';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['GRP_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PROP_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PROP_FIELD']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PROP_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PROP_DESCRIPTION']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PROP_SPECIAL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PROP_PERSONDISPLAY']));
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
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_GRP_ID);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_PROP_ID);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_PROP_FIELD);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_PROP_NAME);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_PROP_DESCRIPTION);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_TYPE_ID);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_PROP_SPECIAL);
            $criteria->removeSelectColumn(GroupPropMasterTableMap::COL_PROP_PERSONDISPLAY);
        } else {
            $criteria->removeSelectColumn($alias . '.grp_ID');
            $criteria->removeSelectColumn($alias . '.prop_ID');
            $criteria->removeSelectColumn($alias . '.prop_Field');
            $criteria->removeSelectColumn($alias . '.prop_Name');
            $criteria->removeSelectColumn($alias . '.prop_Description');
            $criteria->removeSelectColumn($alias . '.type_ID');
            $criteria->removeSelectColumn($alias . '.prop_Special');
            $criteria->removeSelectColumn($alias . '.prop_PersonDisplay');
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
        return Propel::getServiceContainer()->getDatabaseMap(GroupPropMasterTableMap::DATABASE_NAME)->getTable(GroupPropMasterTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or GroupPropMasterQuery.
     *
     * Performs a DELETE on the database, given a GroupPropMaster or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or GroupPropMaster object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or GroupPropMasterQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupPropMasterTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof GroupPropMaster) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The GroupPropMaster object has no primary key');
        }

        $query = GroupPropMasterQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            GroupPropMasterTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                GroupPropMasterTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the groupprop_master table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return GroupPropMasterQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a GroupPropMaster or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\GroupPropMaster $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupPropMasterTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from GroupPropMaster object
        }

        // Set the correct dbName
        $query = GroupPropMasterQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
