<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\VolunteerOpportunity;
use ChurchCRM\model\ChurchCRM\VolunteerOpportunityQuery;
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
 * This class defines the structure of the 'volunteeropportunity_vol' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class VolunteerOpportunityTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.VolunteerOpportunityTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'volunteeropportunity_vol';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'VolunteerOpportunity';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\VolunteerOpportunity';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.VolunteerOpportunity';

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
     * the column name for the vol_ID field
     */
    public const COL_VOL_ID = 'volunteeropportunity_vol.vol_ID';

    /**
     * the column name for the vol_Order field
     */
    public const COL_VOL_ORDER = 'volunteeropportunity_vol.vol_Order';

    /**
     * the column name for the vol_Active field
     */
    public const COL_VOL_ACTIVE = 'volunteeropportunity_vol.vol_Active';

    /**
     * the column name for the vol_Name field
     */
    public const COL_VOL_NAME = 'volunteeropportunity_vol.vol_Name';

    /**
     * the column name for the vol_Description field
     */
    public const COL_VOL_DESCRIPTION = 'volunteeropportunity_vol.vol_Description';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\VolunteerOpportunityCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\VolunteerOpportunityCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Order', 'Active', 'Name', 'Description', ],
        self::TYPE_CAMELNAME     => ['id', 'order', 'active', 'name', 'description', ],
        self::TYPE_COLNAME       => [VolunteerOpportunityTableMap::COL_VOL_ID, VolunteerOpportunityTableMap::COL_VOL_ORDER, VolunteerOpportunityTableMap::COL_VOL_ACTIVE, VolunteerOpportunityTableMap::COL_VOL_NAME, VolunteerOpportunityTableMap::COL_VOL_DESCRIPTION, ],
        self::TYPE_FIELDNAME     => ['vol_ID', 'vol_Order', 'vol_Active', 'vol_Name', 'vol_Description', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Order' => 1, 'Active' => 2, 'Name' => 3, 'Description' => 4, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'order' => 1, 'active' => 2, 'name' => 3, 'description' => 4, ],
        self::TYPE_COLNAME       => [VolunteerOpportunityTableMap::COL_VOL_ID => 0, VolunteerOpportunityTableMap::COL_VOL_ORDER => 1, VolunteerOpportunityTableMap::COL_VOL_ACTIVE => 2, VolunteerOpportunityTableMap::COL_VOL_NAME => 3, VolunteerOpportunityTableMap::COL_VOL_DESCRIPTION => 4, ],
        self::TYPE_FIELDNAME     => ['vol_ID' => 0, 'vol_Order' => 1, 'vol_Active' => 2, 'vol_Name' => 3, 'vol_Description' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'VOL_ID',
        'VolunteerOpportunity.Id' => 'VOL_ID',
        'id' => 'VOL_ID',
        'volunteerOpportunity.id' => 'VOL_ID',
        'VolunteerOpportunityTableMap::COL_VOL_ID' => 'VOL_ID',
        'COL_VOL_ID' => 'VOL_ID',
        'vol_ID' => 'VOL_ID',
        'volunteeropportunity_vol.vol_ID' => 'VOL_ID',
        'Order' => 'VOL_ORDER',
        'VolunteerOpportunity.Order' => 'VOL_ORDER',
        'order' => 'VOL_ORDER',
        'volunteerOpportunity.order' => 'VOL_ORDER',
        'VolunteerOpportunityTableMap::COL_VOL_ORDER' => 'VOL_ORDER',
        'COL_VOL_ORDER' => 'VOL_ORDER',
        'vol_Order' => 'VOL_ORDER',
        'volunteeropportunity_vol.vol_Order' => 'VOL_ORDER',
        'Active' => 'VOL_ACTIVE',
        'VolunteerOpportunity.Active' => 'VOL_ACTIVE',
        'active' => 'VOL_ACTIVE',
        'volunteerOpportunity.active' => 'VOL_ACTIVE',
        'VolunteerOpportunityTableMap::COL_VOL_ACTIVE' => 'VOL_ACTIVE',
        'COL_VOL_ACTIVE' => 'VOL_ACTIVE',
        'vol_Active' => 'VOL_ACTIVE',
        'volunteeropportunity_vol.vol_Active' => 'VOL_ACTIVE',
        'Name' => 'VOL_NAME',
        'VolunteerOpportunity.Name' => 'VOL_NAME',
        'name' => 'VOL_NAME',
        'volunteerOpportunity.name' => 'VOL_NAME',
        'VolunteerOpportunityTableMap::COL_VOL_NAME' => 'VOL_NAME',
        'COL_VOL_NAME' => 'VOL_NAME',
        'vol_Name' => 'VOL_NAME',
        'volunteeropportunity_vol.vol_Name' => 'VOL_NAME',
        'Description' => 'VOL_DESCRIPTION',
        'VolunteerOpportunity.Description' => 'VOL_DESCRIPTION',
        'description' => 'VOL_DESCRIPTION',
        'volunteerOpportunity.description' => 'VOL_DESCRIPTION',
        'VolunteerOpportunityTableMap::COL_VOL_DESCRIPTION' => 'VOL_DESCRIPTION',
        'COL_VOL_DESCRIPTION' => 'VOL_DESCRIPTION',
        'vol_Description' => 'VOL_DESCRIPTION',
        'volunteeropportunity_vol.vol_Description' => 'VOL_DESCRIPTION',
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
        $this->setName('volunteeropportunity_vol');
        $this->setPhpName('VolunteerOpportunity');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\VolunteerOpportunity');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('vol_ID', 'Id', 'INTEGER', true, 3, null);
        $this->addColumn('vol_Order', 'Order', 'INTEGER', true, 3, 0);
        $this->addColumn('vol_Active', 'Active', 'CHAR', true, null, 'true');
        $this->addColumn('vol_Name', 'Name', 'VARCHAR', false, 30, null);
        $this->addColumn('vol_Description', 'Description', 'VARCHAR', false, 100, null);
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
        return $withPrefix ? VolunteerOpportunityTableMap::CLASS_DEFAULT : VolunteerOpportunityTableMap::OM_CLASS;
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
     * @return array (VolunteerOpportunity object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = VolunteerOpportunityTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = VolunteerOpportunityTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + VolunteerOpportunityTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = VolunteerOpportunityTableMap::OM_CLASS;
            /** @var VolunteerOpportunity $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            VolunteerOpportunityTableMap::addInstanceToPool($obj, $key);
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
            $key = VolunteerOpportunityTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = VolunteerOpportunityTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new VolunteerOpportunity();
                $obj->hydrate($row);
                $results[] = $obj;
                VolunteerOpportunityTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'volunteeropportunity_vol';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['VOL_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['VOL_ORDER']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['VOL_ACTIVE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['VOL_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['VOL_DESCRIPTION']));
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
            $criteria->removeSelectColumn(VolunteerOpportunityTableMap::COL_VOL_ID);
            $criteria->removeSelectColumn(VolunteerOpportunityTableMap::COL_VOL_ORDER);
            $criteria->removeSelectColumn(VolunteerOpportunityTableMap::COL_VOL_ACTIVE);
            $criteria->removeSelectColumn(VolunteerOpportunityTableMap::COL_VOL_NAME);
            $criteria->removeSelectColumn(VolunteerOpportunityTableMap::COL_VOL_DESCRIPTION);
        } else {
            $criteria->removeSelectColumn($alias . '.vol_ID');
            $criteria->removeSelectColumn($alias . '.vol_Order');
            $criteria->removeSelectColumn($alias . '.vol_Active');
            $criteria->removeSelectColumn($alias . '.vol_Name');
            $criteria->removeSelectColumn($alias . '.vol_Description');
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
        return Propel::getServiceContainer()->getDatabaseMap(VolunteerOpportunityTableMap::DATABASE_NAME)->getTable(VolunteerOpportunityTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or VolunteerOpportunityQuery.
     *
     * Performs a DELETE on the database, given a VolunteerOpportunity or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or VolunteerOpportunity object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or VolunteerOpportunityQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(VolunteerOpportunityTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof VolunteerOpportunity) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(VolunteerOpportunityTableMap::DATABASE_NAME);
            $criteria->addAnd(VolunteerOpportunityTableMap::COL_VOL_ID, (array)$values, Criteria::IN);
        }

        $query = VolunteerOpportunityQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            VolunteerOpportunityTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                VolunteerOpportunityTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the volunteeropportunity_vol table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return VolunteerOpportunityQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a VolunteerOpportunity or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\VolunteerOpportunity $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(VolunteerOpportunityTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from VolunteerOpportunity object
        }

        if ($criteria->hasUpdateValue(VolunteerOpportunityTableMap::COL_VOL_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (VolunteerOpportunityTableMap::COL_VOL_ID)');
        }

        // Set the correct dbName
        $query = VolunteerOpportunityQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
