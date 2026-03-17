<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\FamilyCustomMaster;
use ChurchCRM\model\ChurchCRM\FamilyCustomMasterQuery;
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
 * This class defines the structure of the 'family_custom_master' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class FamilyCustomMasterTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.FamilyCustomMasterTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'family_custom_master';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'FamilyCustomMaster';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\FamilyCustomMaster';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.FamilyCustomMaster';

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
     * the column name for the fam_custom_Order field
     */
    public const COL_FAM_CUSTOM_ORDER = 'family_custom_master.fam_custom_Order';

    /**
     * the column name for the fam_custom_Field field
     */
    public const COL_FAM_CUSTOM_FIELD = 'family_custom_master.fam_custom_Field';

    /**
     * the column name for the fam_custom_Name field
     */
    public const COL_FAM_CUSTOM_NAME = 'family_custom_master.fam_custom_Name';

    /**
     * the column name for the fam_custom_Special field
     */
    public const COL_FAM_CUSTOM_SPECIAL = 'family_custom_master.fam_custom_Special';

    /**
     * the column name for the fam_custom_FieldSec field
     */
    public const COL_FAM_CUSTOM_FIELDSEC = 'family_custom_master.fam_custom_FieldSec';

    /**
     * the column name for the type_ID field
     */
    public const COL_TYPE_ID = 'family_custom_master.type_ID';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCustomMasterCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCustomMasterCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Order', 'Field', 'Name', 'CustomSpecial', 'FieldSecurity', 'TypeId', ],
        self::TYPE_CAMELNAME     => ['order', 'field', 'name', 'customSpecial', 'fieldSecurity', 'typeId', ],
        self::TYPE_COLNAME       => [FamilyCustomMasterTableMap::COL_FAM_CUSTOM_ORDER, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELD, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_NAME, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_SPECIAL, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELDSEC, FamilyCustomMasterTableMap::COL_TYPE_ID, ],
        self::TYPE_FIELDNAME     => ['fam_custom_Order', 'fam_custom_Field', 'fam_custom_Name', 'fam_custom_Special', 'fam_custom_FieldSec', 'type_ID', ],
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
        self::TYPE_PHPNAME       => ['Order' => 0, 'Field' => 1, 'Name' => 2, 'CustomSpecial' => 3, 'FieldSecurity' => 4, 'TypeId' => 5, ],
        self::TYPE_CAMELNAME     => ['order' => 0, 'field' => 1, 'name' => 2, 'customSpecial' => 3, 'fieldSecurity' => 4, 'typeId' => 5, ],
        self::TYPE_COLNAME       => [FamilyCustomMasterTableMap::COL_FAM_CUSTOM_ORDER => 0, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELD => 1, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_NAME => 2, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_SPECIAL => 3, FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELDSEC => 4, FamilyCustomMasterTableMap::COL_TYPE_ID => 5, ],
        self::TYPE_FIELDNAME     => ['fam_custom_Order' => 0, 'fam_custom_Field' => 1, 'fam_custom_Name' => 2, 'fam_custom_Special' => 3, 'fam_custom_FieldSec' => 4, 'type_ID' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Order' => 'FAM_CUSTOM_ORDER',
        'FamilyCustomMaster.Order' => 'FAM_CUSTOM_ORDER',
        'order' => 'FAM_CUSTOM_ORDER',
        'familyCustomMaster.order' => 'FAM_CUSTOM_ORDER',
        'FamilyCustomMasterTableMap::COL_FAM_CUSTOM_ORDER' => 'FAM_CUSTOM_ORDER',
        'COL_FAM_CUSTOM_ORDER' => 'FAM_CUSTOM_ORDER',
        'fam_custom_Order' => 'FAM_CUSTOM_ORDER',
        'family_custom_master.fam_custom_Order' => 'FAM_CUSTOM_ORDER',
        'Field' => 'FAM_CUSTOM_FIELD',
        'FamilyCustomMaster.Field' => 'FAM_CUSTOM_FIELD',
        'field' => 'FAM_CUSTOM_FIELD',
        'familyCustomMaster.field' => 'FAM_CUSTOM_FIELD',
        'FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELD' => 'FAM_CUSTOM_FIELD',
        'COL_FAM_CUSTOM_FIELD' => 'FAM_CUSTOM_FIELD',
        'fam_custom_Field' => 'FAM_CUSTOM_FIELD',
        'family_custom_master.fam_custom_Field' => 'FAM_CUSTOM_FIELD',
        'Name' => 'FAM_CUSTOM_NAME',
        'FamilyCustomMaster.Name' => 'FAM_CUSTOM_NAME',
        'name' => 'FAM_CUSTOM_NAME',
        'familyCustomMaster.name' => 'FAM_CUSTOM_NAME',
        'FamilyCustomMasterTableMap::COL_FAM_CUSTOM_NAME' => 'FAM_CUSTOM_NAME',
        'COL_FAM_CUSTOM_NAME' => 'FAM_CUSTOM_NAME',
        'fam_custom_Name' => 'FAM_CUSTOM_NAME',
        'family_custom_master.fam_custom_Name' => 'FAM_CUSTOM_NAME',
        'CustomSpecial' => 'FAM_CUSTOM_SPECIAL',
        'FamilyCustomMaster.CustomSpecial' => 'FAM_CUSTOM_SPECIAL',
        'customSpecial' => 'FAM_CUSTOM_SPECIAL',
        'familyCustomMaster.customSpecial' => 'FAM_CUSTOM_SPECIAL',
        'FamilyCustomMasterTableMap::COL_FAM_CUSTOM_SPECIAL' => 'FAM_CUSTOM_SPECIAL',
        'COL_FAM_CUSTOM_SPECIAL' => 'FAM_CUSTOM_SPECIAL',
        'fam_custom_Special' => 'FAM_CUSTOM_SPECIAL',
        'family_custom_master.fam_custom_Special' => 'FAM_CUSTOM_SPECIAL',
        'FieldSecurity' => 'FAM_CUSTOM_FIELDSEC',
        'FamilyCustomMaster.FieldSecurity' => 'FAM_CUSTOM_FIELDSEC',
        'fieldSecurity' => 'FAM_CUSTOM_FIELDSEC',
        'familyCustomMaster.fieldSecurity' => 'FAM_CUSTOM_FIELDSEC',
        'FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELDSEC' => 'FAM_CUSTOM_FIELDSEC',
        'COL_FAM_CUSTOM_FIELDSEC' => 'FAM_CUSTOM_FIELDSEC',
        'fam_custom_FieldSec' => 'FAM_CUSTOM_FIELDSEC',
        'family_custom_master.fam_custom_FieldSec' => 'FAM_CUSTOM_FIELDSEC',
        'TypeId' => 'TYPE_ID',
        'FamilyCustomMaster.TypeId' => 'TYPE_ID',
        'typeId' => 'TYPE_ID',
        'familyCustomMaster.typeId' => 'TYPE_ID',
        'FamilyCustomMasterTableMap::COL_TYPE_ID' => 'TYPE_ID',
        'COL_TYPE_ID' => 'TYPE_ID',
        'type_ID' => 'TYPE_ID',
        'family_custom_master.type_ID' => 'TYPE_ID',
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
        $this->setName('family_custom_master');
        $this->setPhpName('FamilyCustomMaster');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\FamilyCustomMaster');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('fam_custom_Order', 'Order', 'SMALLINT', true, null, 0);
        $this->addPrimaryKey('fam_custom_Field', 'Field', 'VARCHAR', true, 5, '');
        $this->addColumn('fam_custom_Name', 'Name', 'VARCHAR', true, 40, '');
        $this->addColumn('fam_custom_Special', 'CustomSpecial', 'SMALLINT', false, 8, null);
        $this->addColumn('fam_custom_FieldSec', 'FieldSecurity', 'TINYINT', true, null, 1);
        $this->addColumn('type_ID', 'TypeId', 'TINYINT', true, null, 0);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType)];
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
        $fieldIx = $indexType === TableMap::TYPE_NUM
            ? 1 + $offset
            : self::translateFieldName('Field', TableMap::TYPE_PHPNAME, $indexType);

        return (string)$row[$fieldIx];
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
        return $withPrefix ? FamilyCustomMasterTableMap::CLASS_DEFAULT : FamilyCustomMasterTableMap::OM_CLASS;
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
     * @return array (FamilyCustomMaster object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = FamilyCustomMasterTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = FamilyCustomMasterTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FamilyCustomMasterTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FamilyCustomMasterTableMap::OM_CLASS;
            /** @var FamilyCustomMaster $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FamilyCustomMasterTableMap::addInstanceToPool($obj, $key);
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
            $key = FamilyCustomMasterTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = FamilyCustomMasterTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new FamilyCustomMaster();
                $obj->hydrate($row);
                $results[] = $obj;
                FamilyCustomMasterTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'family_custom_master';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_CUSTOM_ORDER']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_CUSTOM_FIELD']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_CUSTOM_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_CUSTOM_SPECIAL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['FAM_CUSTOM_FIELDSEC']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE_ID']));
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
            $criteria->removeSelectColumn(FamilyCustomMasterTableMap::COL_FAM_CUSTOM_ORDER);
            $criteria->removeSelectColumn(FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELD);
            $criteria->removeSelectColumn(FamilyCustomMasterTableMap::COL_FAM_CUSTOM_NAME);
            $criteria->removeSelectColumn(FamilyCustomMasterTableMap::COL_FAM_CUSTOM_SPECIAL);
            $criteria->removeSelectColumn(FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELDSEC);
            $criteria->removeSelectColumn(FamilyCustomMasterTableMap::COL_TYPE_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.fam_custom_Order');
            $criteria->removeSelectColumn($alias . '.fam_custom_Field');
            $criteria->removeSelectColumn($alias . '.fam_custom_Name');
            $criteria->removeSelectColumn($alias . '.fam_custom_Special');
            $criteria->removeSelectColumn($alias . '.fam_custom_FieldSec');
            $criteria->removeSelectColumn($alias . '.type_ID');
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
        return Propel::getServiceContainer()->getDatabaseMap(FamilyCustomMasterTableMap::DATABASE_NAME)->getTable(FamilyCustomMasterTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or FamilyCustomMasterQuery.
     *
     * Performs a DELETE on the database, given a FamilyCustomMaster or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or FamilyCustomMaster object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or FamilyCustomMasterQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyCustomMasterTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof FamilyCustomMaster) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FamilyCustomMasterTableMap::DATABASE_NAME);
            $criteria->addAnd(FamilyCustomMasterTableMap::COL_FAM_CUSTOM_FIELD, (array)$values, Criteria::IN);
        }

        $query = FamilyCustomMasterQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FamilyCustomMasterTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                FamilyCustomMasterTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the family_custom_master table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return FamilyCustomMasterQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a FamilyCustomMaster or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\FamilyCustomMaster $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyCustomMasterTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from FamilyCustomMaster object
        }

        // Set the correct dbName
        $query = FamilyCustomMasterQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
