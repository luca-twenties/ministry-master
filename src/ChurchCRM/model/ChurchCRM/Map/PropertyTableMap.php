<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Property;
use ChurchCRM\model\ChurchCRM\PropertyQuery;
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
 * This class defines the structure of the 'property_pro' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PropertyTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.PropertyTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'property_pro';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Property';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Property';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Property';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the pro_ID field
     */
    public const COL_PRO_ID = 'property_pro.pro_ID';

    /**
     * the column name for the pro_Class field
     */
    public const COL_PRO_CLASS = 'property_pro.pro_Class';

    /**
     * the column name for the pro_prt_ID field
     */
    public const COL_PRO_PRT_ID = 'property_pro.pro_prt_ID';

    /**
     * the column name for the pro_Name field
     */
    public const COL_PRO_NAME = 'property_pro.pro_Name';

    /**
     * the column name for the pro_Description field
     */
    public const COL_PRO_DESCRIPTION = 'property_pro.pro_Description';

    /**
     * the column name for the pro_Prompt field
     */
    public const COL_PRO_PROMPT = 'property_pro.pro_Prompt';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\PropertyCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\PropertyCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['ProId', 'ProClass', 'ProPrtId', 'ProName', 'ProDescription', 'ProPrompt', ],
        self::TYPE_CAMELNAME     => ['proId', 'proClass', 'proPrtId', 'proName', 'proDescription', 'proPrompt', ],
        self::TYPE_COLNAME       => [PropertyTableMap::COL_PRO_ID, PropertyTableMap::COL_PRO_CLASS, PropertyTableMap::COL_PRO_PRT_ID, PropertyTableMap::COL_PRO_NAME, PropertyTableMap::COL_PRO_DESCRIPTION, PropertyTableMap::COL_PRO_PROMPT, ],
        self::TYPE_FIELDNAME     => ['pro_ID', 'pro_Class', 'pro_prt_ID', 'pro_Name', 'pro_Description', 'pro_Prompt', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
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
        self::TYPE_PHPNAME       => ['ProId' => 0, 'ProClass' => 1, 'ProPrtId' => 2, 'ProName' => 3, 'ProDescription' => 4, 'ProPrompt' => 5, ],
        self::TYPE_CAMELNAME     => ['proId' => 0, 'proClass' => 1, 'proPrtId' => 2, 'proName' => 3, 'proDescription' => 4, 'proPrompt' => 5, ],
        self::TYPE_COLNAME       => [PropertyTableMap::COL_PRO_ID => 0, PropertyTableMap::COL_PRO_CLASS => 1, PropertyTableMap::COL_PRO_PRT_ID => 2, PropertyTableMap::COL_PRO_NAME => 3, PropertyTableMap::COL_PRO_DESCRIPTION => 4, PropertyTableMap::COL_PRO_PROMPT => 5, ],
        self::TYPE_FIELDNAME     => ['pro_ID' => 0, 'pro_Class' => 1, 'pro_prt_ID' => 2, 'pro_Name' => 3, 'pro_Description' => 4, 'pro_Prompt' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'ProId' => 'PRO_ID',
        'Property.ProId' => 'PRO_ID',
        'proId' => 'PRO_ID',
        'property.proId' => 'PRO_ID',
        'PropertyTableMap::COL_PRO_ID' => 'PRO_ID',
        'COL_PRO_ID' => 'PRO_ID',
        'pro_ID' => 'PRO_ID',
        'property_pro.pro_ID' => 'PRO_ID',
        'ProClass' => 'PRO_CLASS',
        'Property.ProClass' => 'PRO_CLASS',
        'proClass' => 'PRO_CLASS',
        'property.proClass' => 'PRO_CLASS',
        'PropertyTableMap::COL_PRO_CLASS' => 'PRO_CLASS',
        'COL_PRO_CLASS' => 'PRO_CLASS',
        'pro_Class' => 'PRO_CLASS',
        'property_pro.pro_Class' => 'PRO_CLASS',
        'ProPrtId' => 'PRO_PRT_ID',
        'Property.ProPrtId' => 'PRO_PRT_ID',
        'proPrtId' => 'PRO_PRT_ID',
        'property.proPrtId' => 'PRO_PRT_ID',
        'PropertyTableMap::COL_PRO_PRT_ID' => 'PRO_PRT_ID',
        'COL_PRO_PRT_ID' => 'PRO_PRT_ID',
        'pro_prt_ID' => 'PRO_PRT_ID',
        'property_pro.pro_prt_ID' => 'PRO_PRT_ID',
        'ProName' => 'PRO_NAME',
        'Property.ProName' => 'PRO_NAME',
        'proName' => 'PRO_NAME',
        'property.proName' => 'PRO_NAME',
        'PropertyTableMap::COL_PRO_NAME' => 'PRO_NAME',
        'COL_PRO_NAME' => 'PRO_NAME',
        'pro_Name' => 'PRO_NAME',
        'property_pro.pro_Name' => 'PRO_NAME',
        'ProDescription' => 'PRO_DESCRIPTION',
        'Property.ProDescription' => 'PRO_DESCRIPTION',
        'proDescription' => 'PRO_DESCRIPTION',
        'property.proDescription' => 'PRO_DESCRIPTION',
        'PropertyTableMap::COL_PRO_DESCRIPTION' => 'PRO_DESCRIPTION',
        'COL_PRO_DESCRIPTION' => 'PRO_DESCRIPTION',
        'pro_Description' => 'PRO_DESCRIPTION',
        'property_pro.pro_Description' => 'PRO_DESCRIPTION',
        'ProPrompt' => 'PRO_PROMPT',
        'Property.ProPrompt' => 'PRO_PROMPT',
        'proPrompt' => 'PRO_PROMPT',
        'property.proPrompt' => 'PRO_PROMPT',
        'PropertyTableMap::COL_PRO_PROMPT' => 'PRO_PROMPT',
        'COL_PRO_PROMPT' => 'PRO_PROMPT',
        'pro_Prompt' => 'PRO_PROMPT',
        'property_pro.pro_Prompt' => 'PRO_PROMPT',
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
        $this->setName('property_pro');
        $this->setPhpName('Property');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Property');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('pro_ID', 'ProId', 'SMALLINT', true, 8, null);
        $this->addColumn('pro_Class', 'ProClass', 'VARCHAR', true, 10, '');
        $this->addForeignKey('pro_prt_ID', 'ProPrtId', 'SMALLINT', 'propertytype_prt', 'prt_ID', true, 8, 0);
        $this->addColumn('pro_Name', 'ProName', 'VARCHAR', true, 200, '0');
        $this->addColumn('pro_Description', 'ProDescription', 'LONGVARCHAR', true, null, null);
        $this->addColumn('pro_Prompt', 'ProPrompt', 'VARCHAR', false, 255, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'PropertyType',
            '\\ChurchCRM\\model\\ChurchCRM\\PropertyType',
            RelationMap::MANY_TO_ONE,
            [[':pro_prt_ID', ':prt_ID']],
            null,
            null,
            null,
            false
        );
        $this->addRelation(
            'RecordProperty',
            '\\ChurchCRM\\model\\ChurchCRM\\RecordProperty',
            RelationMap::ONE_TO_MANY,
            [[':r2p_pro_ID', ':pro_ID']],
            null,
            null,
            'RecordProperties',
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType)];
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
        $proIdIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType);

        return (int)$row[$proIdIx];
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
        return $withPrefix ? PropertyTableMap::CLASS_DEFAULT : PropertyTableMap::OM_CLASS;
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
     * @return array (Property object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PropertyTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = PropertyTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PropertyTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PropertyTableMap::OM_CLASS;
            /** @var Property $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PropertyTableMap::addInstanceToPool($obj, $key);
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
            $key = PropertyTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = PropertyTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Property();
                $obj->hydrate($row);
                $results[] = $obj;
                PropertyTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'property_pro';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRO_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRO_CLASS']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRO_PRT_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRO_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRO_DESCRIPTION']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['PRO_PROMPT']));
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
            $criteria->removeSelectColumn(PropertyTableMap::COL_PRO_ID);
            $criteria->removeSelectColumn(PropertyTableMap::COL_PRO_CLASS);
            $criteria->removeSelectColumn(PropertyTableMap::COL_PRO_PRT_ID);
            $criteria->removeSelectColumn(PropertyTableMap::COL_PRO_NAME);
            $criteria->removeSelectColumn(PropertyTableMap::COL_PRO_DESCRIPTION);
            $criteria->removeSelectColumn(PropertyTableMap::COL_PRO_PROMPT);
        } else {
            $criteria->removeSelectColumn($alias . '.pro_ID');
            $criteria->removeSelectColumn($alias . '.pro_Class');
            $criteria->removeSelectColumn($alias . '.pro_prt_ID');
            $criteria->removeSelectColumn($alias . '.pro_Name');
            $criteria->removeSelectColumn($alias . '.pro_Description');
            $criteria->removeSelectColumn($alias . '.pro_Prompt');
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
        return Propel::getServiceContainer()->getDatabaseMap(PropertyTableMap::DATABASE_NAME)->getTable(PropertyTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or PropertyQuery.
     *
     * Performs a DELETE on the database, given a Property or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Property object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or PropertyQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Property) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PropertyTableMap::DATABASE_NAME);
            $criteria->addAnd(PropertyTableMap::COL_PRO_ID, (array)$values, Criteria::IN);
        }

        $query = PropertyQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PropertyTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                PropertyTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the property_pro table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PropertyQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Property or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Property $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Property object
        }

        if ($criteria->hasUpdateValue(PropertyTableMap::COL_PRO_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (PropertyTableMap::COL_PRO_ID)');
        }

        // Set the correct dbName
        $query = PropertyQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
