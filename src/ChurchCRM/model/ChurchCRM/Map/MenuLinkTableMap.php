<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\MenuLink;
use ChurchCRM\model\ChurchCRM\MenuLinkQuery;
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
 * This class defines the structure of the 'menu_links' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class MenuLinkTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.MenuLinkTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'menu_links';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'MenuLink';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\MenuLink';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.MenuLink';

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
     * the column name for the linkId field
     */
    public const COL_LINKID = 'menu_links.linkId';

    /**
     * the column name for the linkName field
     */
    public const COL_LINKNAME = 'menu_links.linkName';

    /**
     * the column name for the linkUri field
     */
    public const COL_LINKURI = 'menu_links.linkUri';

    /**
     * the column name for the linkOrder field
     */
    public const COL_LINKORDER = 'menu_links.linkOrder';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\MenuLinkCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\MenuLinkCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Name', 'Uri', 'Order', ],
        self::TYPE_CAMELNAME     => ['id', 'name', 'uri', 'order', ],
        self::TYPE_COLNAME       => [MenuLinkTableMap::COL_LINKID, MenuLinkTableMap::COL_LINKNAME, MenuLinkTableMap::COL_LINKURI, MenuLinkTableMap::COL_LINKORDER, ],
        self::TYPE_FIELDNAME     => ['linkId', 'linkName', 'linkUri', 'linkOrder', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Name' => 1, 'Uri' => 2, 'Order' => 3, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'name' => 1, 'uri' => 2, 'order' => 3, ],
        self::TYPE_COLNAME       => [MenuLinkTableMap::COL_LINKID => 0, MenuLinkTableMap::COL_LINKNAME => 1, MenuLinkTableMap::COL_LINKURI => 2, MenuLinkTableMap::COL_LINKORDER => 3, ],
        self::TYPE_FIELDNAME     => ['linkId' => 0, 'linkName' => 1, 'linkUri' => 2, 'linkOrder' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'LINKID',
        'MenuLink.Id' => 'LINKID',
        'id' => 'LINKID',
        'menuLink.id' => 'LINKID',
        'MenuLinkTableMap::COL_LINKID' => 'LINKID',
        'COL_LINKID' => 'LINKID',
        'linkId' => 'LINKID',
        'menu_links.linkId' => 'LINKID',
        'Name' => 'LINKNAME',
        'MenuLink.Name' => 'LINKNAME',
        'name' => 'LINKNAME',
        'menuLink.name' => 'LINKNAME',
        'MenuLinkTableMap::COL_LINKNAME' => 'LINKNAME',
        'COL_LINKNAME' => 'LINKNAME',
        'linkName' => 'LINKNAME',
        'menu_links.linkName' => 'LINKNAME',
        'Uri' => 'LINKURI',
        'MenuLink.Uri' => 'LINKURI',
        'uri' => 'LINKURI',
        'menuLink.uri' => 'LINKURI',
        'MenuLinkTableMap::COL_LINKURI' => 'LINKURI',
        'COL_LINKURI' => 'LINKURI',
        'linkUri' => 'LINKURI',
        'menu_links.linkUri' => 'LINKURI',
        'Order' => 'LINKORDER',
        'MenuLink.Order' => 'LINKORDER',
        'order' => 'LINKORDER',
        'menuLink.order' => 'LINKORDER',
        'MenuLinkTableMap::COL_LINKORDER' => 'LINKORDER',
        'COL_LINKORDER' => 'LINKORDER',
        'linkOrder' => 'LINKORDER',
        'menu_links.linkOrder' => 'LINKORDER',
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
        $this->setName('menu_links');
        $this->setPhpName('MenuLink');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\MenuLink');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('linkId', 'Id', 'SMALLINT', true, 9, null);
        $this->addColumn('linkName', 'Name', 'VARCHAR', false, 50, null);
        $this->addColumn('linkUri', 'Uri', 'VARCHAR', false, 500, null);
        $this->addColumn('linkOrder', 'Order', 'SMALLINT', false, null, null);
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
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array<string, array> Associative array (name => parameters) of behaviors
     */
    public function getBehaviors(): array
    {
        return [
            'validate' => ['rule1' => ['column' => 'linkname', 'validator' => 'NotNull'], 'rule2' => ['column' => 'linkname', 'validator' => 'NotBlank'], 'rule3' => ['column' => 'linkname', 'validator' => 'Length', 'options' => ['min' => 2, 'max' => 50]], 'rule4' => ['column' => 'linkuri', 'validator' => 'Url']],
        ];
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
        return $withPrefix ? MenuLinkTableMap::CLASS_DEFAULT : MenuLinkTableMap::OM_CLASS;
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
     * @return array (MenuLink object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = MenuLinkTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = MenuLinkTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MenuLinkTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MenuLinkTableMap::OM_CLASS;
            /** @var MenuLink $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MenuLinkTableMap::addInstanceToPool($obj, $key);
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
            $key = MenuLinkTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = MenuLinkTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new MenuLink();
                $obj->hydrate($row);
                $results[] = $obj;
                MenuLinkTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'menu_links';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LINKID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LINKNAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LINKURI']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['LINKORDER']));
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
            $criteria->removeSelectColumn(MenuLinkTableMap::COL_LINKID);
            $criteria->removeSelectColumn(MenuLinkTableMap::COL_LINKNAME);
            $criteria->removeSelectColumn(MenuLinkTableMap::COL_LINKURI);
            $criteria->removeSelectColumn(MenuLinkTableMap::COL_LINKORDER);
        } else {
            $criteria->removeSelectColumn($alias . '.linkId');
            $criteria->removeSelectColumn($alias . '.linkName');
            $criteria->removeSelectColumn($alias . '.linkUri');
            $criteria->removeSelectColumn($alias . '.linkOrder');
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
        return Propel::getServiceContainer()->getDatabaseMap(MenuLinkTableMap::DATABASE_NAME)->getTable(MenuLinkTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or MenuLinkQuery.
     *
     * Performs a DELETE on the database, given a MenuLink or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or MenuLink object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or MenuLinkQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuLinkTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof MenuLink) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MenuLinkTableMap::DATABASE_NAME);
            $criteria->addAnd(MenuLinkTableMap::COL_LINKID, (array)$values, Criteria::IN);
        }

        $query = MenuLinkQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MenuLinkTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                MenuLinkTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the menu_links table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return MenuLinkQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MenuLink or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\MenuLink $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(MenuLinkTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MenuLink object
        }

        if ($criteria->hasUpdateValue(MenuLinkTableMap::COL_LINKID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (MenuLinkTableMap::COL_LINKID)');
        }

        // Set the correct dbName
        $query = MenuLinkQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
