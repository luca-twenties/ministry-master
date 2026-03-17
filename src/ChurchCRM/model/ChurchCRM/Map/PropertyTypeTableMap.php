<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\PropertyType;
use ChurchCRM\model\ChurchCRM\PropertyTypeQuery;
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
 * This class defines the structure of the 'propertytype_prt' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PropertyTypeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.PropertyTypeTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'propertytype_prt';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'PropertyType';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\PropertyType';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.PropertyType';

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
     * the column name for the prt_ID field
     */
    public const COL_PRT_ID = 'propertytype_prt.prt_ID';

    /**
     * the column name for the prt_Class field
     */
    public const COL_PRT_CLASS = 'propertytype_prt.prt_Class';

    /**
     * the column name for the prt_Name field
     */
    public const COL_PRT_NAME = 'propertytype_prt.prt_Name';

    /**
     * the column name for the prt_Description field
     */
    public const COL_PRT_DESCRIPTION = 'propertytype_prt.prt_Description';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\PropertyTypeCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\PropertyTypeCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['PrtId', 'PrtClass', 'PrtName', 'PrtDescription', ],
        self::TYPE_CAMELNAME     => ['prtId', 'prtClass', 'prtName', 'prtDescription', ],
        self::TYPE_COLNAME       => [PropertyTypeTableMap::COL_PRT_ID, PropertyTypeTableMap::COL_PRT_CLASS, PropertyTypeTableMap::COL_PRT_NAME, PropertyTypeTableMap::COL_PRT_DESCRIPTION, ],
        self::TYPE_FIELDNAME     => ['prt_ID', 'prt_Class', 'prt_Name', 'prt_Description', ],
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
        self::TYPE_PHPNAME       => ['PrtId' => 0, 'PrtClass' => 1, 'PrtName' => 2, 'PrtDescription' => 3, ],
        self::TYPE_CAMELNAME     => ['prtId' => 0, 'prtClass' => 1, 'prtName' => 2, 'prtDescription' => 3, ],
        self::TYPE_COLNAME       => [PropertyTypeTableMap::COL_PRT_ID => 0, PropertyTypeTableMap::COL_PRT_CLASS => 1, PropertyTypeTableMap::COL_PRT_NAME => 2, PropertyTypeTableMap::COL_PRT_DESCRIPTION => 3, ],
        self::TYPE_FIELDNAME     => ['prt_ID' => 0, 'prt_Class' => 1, 'prt_Name' => 2, 'prt_Description' => 3, ],
        self::TYPE_NUM           => [0, 1, 2, 3, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'PrtId' => 'PRT_ID',
        'PropertyType.PrtId' => 'PRT_ID',
        'prtId' => 'PRT_ID',
        'propertyType.prtId' => 'PRT_ID',
        'PropertyTypeTableMap::COL_PRT_ID' => 'PRT_ID',
        'COL_PRT_ID' => 'PRT_ID',
        'prt_ID' => 'PRT_ID',
        'propertytype_prt.prt_ID' => 'PRT_ID',
        'PrtClass' => 'PRT_CLASS',
        'PropertyType.PrtClass' => 'PRT_CLASS',
        'prtClass' => 'PRT_CLASS',
        'propertyType.prtClass' => 'PRT_CLASS',
        'PropertyTypeTableMap::COL_PRT_CLASS' => 'PRT_CLASS',
        'COL_PRT_CLASS' => 'PRT_CLASS',
        'prt_Class' => 'PRT_CLASS',
        'propertytype_prt.prt_Class' => 'PRT_CLASS',
        'PrtName' => 'PRT_NAME',
        'PropertyType.PrtName' => 'PRT_NAME',
        'prtName' => 'PRT_NAME',
        'propertyType.prtName' => 'PRT_NAME',
        'PropertyTypeTableMap::COL_PRT_NAME' => 'PRT_NAME',
        'COL_PRT_NAME' => 'PRT_NAME',
        'prt_Name' => 'PRT_NAME',
        'propertytype_prt.prt_Name' => 'PRT_NAME',
        'PrtDescription' => 'PRT_DESCRIPTION',
        'PropertyType.PrtDescription' => 'PRT_DESCRIPTION',
        'prtDescription' => 'PRT_DESCRIPTION',
        'propertyType.prtDescription' => 'PRT_DESCRIPTION',
        'PropertyTypeTableMap::COL_PRT_DESCRIPTION' => 'PRT_DESCRIPTION',
        'COL_PRT_DESCRIPTION' => 'PRT_DESCRIPTION',
        'prt_Description' => 'PRT_DESCRIPTION',
        'propertytype_prt.prt_Description' => 'PRT_DESCRIPTION',
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
        $this->setName('propertytype_prt');
        $this->setPhpName('PropertyType');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\PropertyType');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('prt_ID', 'PrtId', 'SMALLINT', true, 9, null);
        $this->addColumn('prt_Class', 'PrtClass', 'VARCHAR', true, 10, '');
        $this->addColumn('prt_Name', 'PrtName', 'VARCHAR', true, 50, '');
        $this->addColumn('prt_Description', 'PrtDescription', 'LONGVARCHAR', true, null, null);
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
            RelationMap::ONE_TO_MANY,
            [[':pro_prt_ID', ':prt_ID']],
            null,
            null,
            'Properties',
            false
        );
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $prtIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('PrtId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$prtIdIx];
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
        return $withPrefix ? PropertyTypeTableMap::CLASS_DEFAULT : PropertyTypeTableMap::OM_CLASS;
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
     * @return array (PropertyType object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PropertyTypeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = PropertyTypeTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PropertyTypeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PropertyTypeTableMap::OM_CLASS;
            /** @var PropertyType $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PropertyTypeTableMap::addInstanceToPool($obj, $key);
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
            $key = PropertyTypeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = PropertyTypeTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new PropertyType();
                $obj->hydrate($row);
                $results[] = $obj;
                PropertyTypeTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'propertytype_prt';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRT_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRT_CLASS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRT_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRT_DESCRIPTION']));
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
            $criteria->removeSelectColumn(PropertyTypeTableMap::COL_PRT_ID);
            $criteria->removeSelectColumn(PropertyTypeTableMap::COL_PRT_CLASS);
            $criteria->removeSelectColumn(PropertyTypeTableMap::COL_PRT_NAME);
            $criteria->removeSelectColumn(PropertyTypeTableMap::COL_PRT_DESCRIPTION);
        } else {
            $criteria->removeSelectColumn($alias . '.prt_ID');
            $criteria->removeSelectColumn($alias . '.prt_Class');
            $criteria->removeSelectColumn($alias . '.prt_Name');
            $criteria->removeSelectColumn($alias . '.prt_Description');
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
        return Propel::getServiceContainer()->getDatabaseMap(PropertyTypeTableMap::DATABASE_NAME)->getTable(PropertyTypeTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or PropertyTypeQuery.
     *
     * Performs a DELETE on the database, given a PropertyType or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or PropertyType object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or PropertyTypeQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof PropertyType) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PropertyTypeTableMap::DATABASE_NAME);
            $criteria->addAnd(PropertyTypeTableMap::COL_PRT_ID, (array)$values, Criteria::IN);
        }

        $query = PropertyTypeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PropertyTypeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                PropertyTypeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the propertytype_prt table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PropertyTypeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PropertyType or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\PropertyType $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PropertyType object
        }

        if ($criteria->hasUpdateValue(PropertyTypeTableMap::COL_PRT_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (PropertyTypeTableMap::COL_PRT_ID)');
        }

        // Set the correct dbName
        $query = PropertyTypeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
