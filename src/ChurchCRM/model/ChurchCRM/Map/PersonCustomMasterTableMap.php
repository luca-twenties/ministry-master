<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\PersonCustomMaster;
use ChurchCRM\model\ChurchCRM\PersonCustomMasterQuery;
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
 * This class defines the structure of the 'person_custom_master' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PersonCustomMasterTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.PersonCustomMasterTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'person_custom_master';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'PersonCustomMaster';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\PersonCustomMaster';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.PersonCustomMaster';

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
     * the column name for the custom_Order field
     */
    public const COL_CUSTOM_ORDER = 'person_custom_master.custom_Order';

    /**
     * the column name for the custom_Field field
     */
    public const COL_CUSTOM_FIELD = 'person_custom_master.custom_Field';

    /**
     * the column name for the custom_Name field
     */
    public const COL_CUSTOM_NAME = 'person_custom_master.custom_Name';

    /**
     * the column name for the custom_Special field
     */
    public const COL_CUSTOM_SPECIAL = 'person_custom_master.custom_Special';

    /**
     * the column name for the custom_FieldSec field
     */
    public const COL_CUSTOM_FIELDSEC = 'person_custom_master.custom_FieldSec';

    /**
     * the column name for the type_ID field
     */
    public const COL_TYPE_ID = 'person_custom_master.type_ID';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\PersonCustomMasterCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\PersonCustomMasterCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Order', 'Id', 'Name', 'Special', 'FieldSecurity', 'TypeId', ],
        self::TYPE_CAMELNAME     => ['order', 'id', 'name', 'special', 'fieldSecurity', 'typeId', ],
        self::TYPE_COLNAME       => [PersonCustomMasterTableMap::COL_CUSTOM_ORDER, PersonCustomMasterTableMap::COL_CUSTOM_FIELD, PersonCustomMasterTableMap::COL_CUSTOM_NAME, PersonCustomMasterTableMap::COL_CUSTOM_SPECIAL, PersonCustomMasterTableMap::COL_CUSTOM_FIELDSEC, PersonCustomMasterTableMap::COL_TYPE_ID, ],
        self::TYPE_FIELDNAME     => ['custom_Order', 'custom_Field', 'custom_Name', 'custom_Special', 'custom_FieldSec', 'type_ID', ],
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
        self::TYPE_PHPNAME       => ['Order' => 0, 'Id' => 1, 'Name' => 2, 'Special' => 3, 'FieldSecurity' => 4, 'TypeId' => 5, ],
        self::TYPE_CAMELNAME     => ['order' => 0, 'id' => 1, 'name' => 2, 'special' => 3, 'fieldSecurity' => 4, 'typeId' => 5, ],
        self::TYPE_COLNAME       => [PersonCustomMasterTableMap::COL_CUSTOM_ORDER => 0, PersonCustomMasterTableMap::COL_CUSTOM_FIELD => 1, PersonCustomMasterTableMap::COL_CUSTOM_NAME => 2, PersonCustomMasterTableMap::COL_CUSTOM_SPECIAL => 3, PersonCustomMasterTableMap::COL_CUSTOM_FIELDSEC => 4, PersonCustomMasterTableMap::COL_TYPE_ID => 5, ],
        self::TYPE_FIELDNAME     => ['custom_Order' => 0, 'custom_Field' => 1, 'custom_Name' => 2, 'custom_Special' => 3, 'custom_FieldSec' => 4, 'type_ID' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Order' => 'CUSTOM_ORDER',
        'PersonCustomMaster.Order' => 'CUSTOM_ORDER',
        'order' => 'CUSTOM_ORDER',
        'personCustomMaster.order' => 'CUSTOM_ORDER',
        'PersonCustomMasterTableMap::COL_CUSTOM_ORDER' => 'CUSTOM_ORDER',
        'COL_CUSTOM_ORDER' => 'CUSTOM_ORDER',
        'custom_Order' => 'CUSTOM_ORDER',
        'person_custom_master.custom_Order' => 'CUSTOM_ORDER',
        'Id' => 'CUSTOM_FIELD',
        'PersonCustomMaster.Id' => 'CUSTOM_FIELD',
        'id' => 'CUSTOM_FIELD',
        'personCustomMaster.id' => 'CUSTOM_FIELD',
        'PersonCustomMasterTableMap::COL_CUSTOM_FIELD' => 'CUSTOM_FIELD',
        'COL_CUSTOM_FIELD' => 'CUSTOM_FIELD',
        'custom_Field' => 'CUSTOM_FIELD',
        'person_custom_master.custom_Field' => 'CUSTOM_FIELD',
        'Name' => 'CUSTOM_NAME',
        'PersonCustomMaster.Name' => 'CUSTOM_NAME',
        'name' => 'CUSTOM_NAME',
        'personCustomMaster.name' => 'CUSTOM_NAME',
        'PersonCustomMasterTableMap::COL_CUSTOM_NAME' => 'CUSTOM_NAME',
        'COL_CUSTOM_NAME' => 'CUSTOM_NAME',
        'custom_Name' => 'CUSTOM_NAME',
        'person_custom_master.custom_Name' => 'CUSTOM_NAME',
        'Special' => 'CUSTOM_SPECIAL',
        'PersonCustomMaster.Special' => 'CUSTOM_SPECIAL',
        'special' => 'CUSTOM_SPECIAL',
        'personCustomMaster.special' => 'CUSTOM_SPECIAL',
        'PersonCustomMasterTableMap::COL_CUSTOM_SPECIAL' => 'CUSTOM_SPECIAL',
        'COL_CUSTOM_SPECIAL' => 'CUSTOM_SPECIAL',
        'custom_Special' => 'CUSTOM_SPECIAL',
        'person_custom_master.custom_Special' => 'CUSTOM_SPECIAL',
        'FieldSecurity' => 'CUSTOM_FIELDSEC',
        'PersonCustomMaster.FieldSecurity' => 'CUSTOM_FIELDSEC',
        'fieldSecurity' => 'CUSTOM_FIELDSEC',
        'personCustomMaster.fieldSecurity' => 'CUSTOM_FIELDSEC',
        'PersonCustomMasterTableMap::COL_CUSTOM_FIELDSEC' => 'CUSTOM_FIELDSEC',
        'COL_CUSTOM_FIELDSEC' => 'CUSTOM_FIELDSEC',
        'custom_FieldSec' => 'CUSTOM_FIELDSEC',
        'person_custom_master.custom_FieldSec' => 'CUSTOM_FIELDSEC',
        'TypeId' => 'TYPE_ID',
        'PersonCustomMaster.TypeId' => 'TYPE_ID',
        'typeId' => 'TYPE_ID',
        'personCustomMaster.typeId' => 'TYPE_ID',
        'PersonCustomMasterTableMap::COL_TYPE_ID' => 'TYPE_ID',
        'COL_TYPE_ID' => 'TYPE_ID',
        'type_ID' => 'TYPE_ID',
        'person_custom_master.type_ID' => 'TYPE_ID',
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
        $this->setName('person_custom_master');
        $this->setPhpName('PersonCustomMaster');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\PersonCustomMaster');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('custom_Order', 'Order', 'SMALLINT', true, null, 0);
        $this->addPrimaryKey('custom_Field', 'Id', 'VARCHAR', true, 5, '');
        $this->addColumn('custom_Name', 'Name', 'VARCHAR', true, 40, '');
        $this->addColumn('custom_Special', 'Special', 'SMALLINT', false, 8, null);
        $this->addColumn('custom_FieldSec', 'FieldSecurity', 'TINYINT', true, null, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
            ? 1 + $offset
            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);

        return (string)$row[$idIx];
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
        return $withPrefix ? PersonCustomMasterTableMap::CLASS_DEFAULT : PersonCustomMasterTableMap::OM_CLASS;
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
     * @return array (PersonCustomMaster object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PersonCustomMasterTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = PersonCustomMasterTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PersonCustomMasterTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PersonCustomMasterTableMap::OM_CLASS;
            /** @var PersonCustomMaster $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PersonCustomMasterTableMap::addInstanceToPool($obj, $key);
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
            $key = PersonCustomMasterTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = PersonCustomMasterTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new PersonCustomMaster();
                $obj->hydrate($row);
                $results[] = $obj;
                PersonCustomMasterTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'person_custom_master';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CUSTOM_ORDER']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CUSTOM_FIELD']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CUSTOM_NAME']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CUSTOM_SPECIAL']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['CUSTOM_FIELDSEC']));
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
            $criteria->removeSelectColumn(PersonCustomMasterTableMap::COL_CUSTOM_ORDER);
            $criteria->removeSelectColumn(PersonCustomMasterTableMap::COL_CUSTOM_FIELD);
            $criteria->removeSelectColumn(PersonCustomMasterTableMap::COL_CUSTOM_NAME);
            $criteria->removeSelectColumn(PersonCustomMasterTableMap::COL_CUSTOM_SPECIAL);
            $criteria->removeSelectColumn(PersonCustomMasterTableMap::COL_CUSTOM_FIELDSEC);
            $criteria->removeSelectColumn(PersonCustomMasterTableMap::COL_TYPE_ID);
        } else {
            $criteria->removeSelectColumn($alias . '.custom_Order');
            $criteria->removeSelectColumn($alias . '.custom_Field');
            $criteria->removeSelectColumn($alias . '.custom_Name');
            $criteria->removeSelectColumn($alias . '.custom_Special');
            $criteria->removeSelectColumn($alias . '.custom_FieldSec');
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
        return Propel::getServiceContainer()->getDatabaseMap(PersonCustomMasterTableMap::DATABASE_NAME)->getTable(PersonCustomMasterTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or PersonCustomMasterQuery.
     *
     * Performs a DELETE on the database, given a PersonCustomMaster or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or PersonCustomMaster object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or PersonCustomMasterQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonCustomMasterTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof PersonCustomMaster) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PersonCustomMasterTableMap::DATABASE_NAME);
            $criteria->addAnd(PersonCustomMasterTableMap::COL_CUSTOM_FIELD, (array)$values, Criteria::IN);
        }

        $query = PersonCustomMasterQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PersonCustomMasterTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                PersonCustomMasterTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the person_custom_master table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PersonCustomMasterQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PersonCustomMaster or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\PersonCustomMaster $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonCustomMasterTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PersonCustomMaster object
        }

        // Set the correct dbName
        $query = PersonCustomMasterQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
