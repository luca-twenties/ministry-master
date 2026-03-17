<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Deposit;
use ChurchCRM\model\ChurchCRM\DepositQuery;
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
 * This class defines the structure of the 'deposit_dep' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DepositTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.DepositTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'deposit_dep';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Deposit';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Deposit';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Deposit';

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
     * the column name for the dep_ID field
     */
    public const COL_DEP_ID = 'deposit_dep.dep_ID';

    /**
     * the column name for the dep_Date field
     */
    public const COL_DEP_DATE = 'deposit_dep.dep_Date';

    /**
     * the column name for the dep_Comment field
     */
    public const COL_DEP_COMMENT = 'deposit_dep.dep_Comment';

    /**
     * the column name for the dep_EnteredBy field
     */
    public const COL_DEP_ENTEREDBY = 'deposit_dep.dep_EnteredBy';

    /**
     * the column name for the dep_Closed field
     */
    public const COL_DEP_CLOSED = 'deposit_dep.dep_Closed';

    /**
     * the column name for the dep_Type field
     */
    public const COL_DEP_TYPE = 'deposit_dep.dep_Type';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\DepositCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\DepositCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Date', 'Comment', 'Enteredby', 'Closed', 'Type', ],
        self::TYPE_CAMELNAME     => ['id', 'date', 'comment', 'enteredby', 'closed', 'type', ],
        self::TYPE_COLNAME       => [DepositTableMap::COL_DEP_ID, DepositTableMap::COL_DEP_DATE, DepositTableMap::COL_DEP_COMMENT, DepositTableMap::COL_DEP_ENTEREDBY, DepositTableMap::COL_DEP_CLOSED, DepositTableMap::COL_DEP_TYPE, ],
        self::TYPE_FIELDNAME     => ['dep_ID', 'dep_Date', 'dep_Comment', 'dep_EnteredBy', 'dep_Closed', 'dep_Type', ],
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
        self::TYPE_PHPNAME       => ['Id' => 0, 'Date' => 1, 'Comment' => 2, 'Enteredby' => 3, 'Closed' => 4, 'Type' => 5, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'date' => 1, 'comment' => 2, 'enteredby' => 3, 'closed' => 4, 'type' => 5, ],
        self::TYPE_COLNAME       => [DepositTableMap::COL_DEP_ID => 0, DepositTableMap::COL_DEP_DATE => 1, DepositTableMap::COL_DEP_COMMENT => 2, DepositTableMap::COL_DEP_ENTEREDBY => 3, DepositTableMap::COL_DEP_CLOSED => 4, DepositTableMap::COL_DEP_TYPE => 5, ],
        self::TYPE_FIELDNAME     => ['dep_ID' => 0, 'dep_Date' => 1, 'dep_Comment' => 2, 'dep_EnteredBy' => 3, 'dep_Closed' => 4, 'dep_Type' => 5, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'DEP_ID',
        'Deposit.Id' => 'DEP_ID',
        'id' => 'DEP_ID',
        'deposit.id' => 'DEP_ID',
        'DepositTableMap::COL_DEP_ID' => 'DEP_ID',
        'COL_DEP_ID' => 'DEP_ID',
        'dep_ID' => 'DEP_ID',
        'deposit_dep.dep_ID' => 'DEP_ID',
        'Date' => 'DEP_DATE',
        'Deposit.Date' => 'DEP_DATE',
        'date' => 'DEP_DATE',
        'deposit.date' => 'DEP_DATE',
        'DepositTableMap::COL_DEP_DATE' => 'DEP_DATE',
        'COL_DEP_DATE' => 'DEP_DATE',
        'dep_Date' => 'DEP_DATE',
        'deposit_dep.dep_Date' => 'DEP_DATE',
        'Comment' => 'DEP_COMMENT',
        'Deposit.Comment' => 'DEP_COMMENT',
        'comment' => 'DEP_COMMENT',
        'deposit.comment' => 'DEP_COMMENT',
        'DepositTableMap::COL_DEP_COMMENT' => 'DEP_COMMENT',
        'COL_DEP_COMMENT' => 'DEP_COMMENT',
        'dep_Comment' => 'DEP_COMMENT',
        'deposit_dep.dep_Comment' => 'DEP_COMMENT',
        'Enteredby' => 'DEP_ENTEREDBY',
        'Deposit.Enteredby' => 'DEP_ENTEREDBY',
        'enteredby' => 'DEP_ENTEREDBY',
        'deposit.enteredby' => 'DEP_ENTEREDBY',
        'DepositTableMap::COL_DEP_ENTEREDBY' => 'DEP_ENTEREDBY',
        'COL_DEP_ENTEREDBY' => 'DEP_ENTEREDBY',
        'dep_EnteredBy' => 'DEP_ENTEREDBY',
        'deposit_dep.dep_EnteredBy' => 'DEP_ENTEREDBY',
        'Closed' => 'DEP_CLOSED',
        'Deposit.Closed' => 'DEP_CLOSED',
        'closed' => 'DEP_CLOSED',
        'deposit.closed' => 'DEP_CLOSED',
        'DepositTableMap::COL_DEP_CLOSED' => 'DEP_CLOSED',
        'COL_DEP_CLOSED' => 'DEP_CLOSED',
        'dep_Closed' => 'DEP_CLOSED',
        'deposit_dep.dep_Closed' => 'DEP_CLOSED',
        'Type' => 'DEP_TYPE',
        'Deposit.Type' => 'DEP_TYPE',
        'type' => 'DEP_TYPE',
        'deposit.type' => 'DEP_TYPE',
        'DepositTableMap::COL_DEP_TYPE' => 'DEP_TYPE',
        'COL_DEP_TYPE' => 'DEP_TYPE',
        'dep_Type' => 'DEP_TYPE',
        'deposit_dep.dep_Type' => 'DEP_TYPE',
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
        $this->setName('deposit_dep');
        $this->setPhpName('Deposit');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Deposit');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('dep_ID', 'Id', 'SMALLINT', true, 9, null);
        $this->addColumn('dep_Date', 'Date', 'DATE', false, null, null);
        $this->addColumn('dep_Comment', 'Comment', 'LONGVARCHAR', false, null, null);
        $this->addColumn('dep_EnteredBy', 'Enteredby', 'SMALLINT', false, 9, null);
        $this->addColumn('dep_Closed', 'Closed', 'BOOLEAN', true, 1, false);
        $this->addColumn('dep_Type', 'Type', 'CHAR', true, null, 'Bank');
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation(
            'Pledge',
            '\\ChurchCRM\\model\\ChurchCRM\\Pledge',
            RelationMap::ONE_TO_MANY,
            [[':plg_depID', ':dep_ID']],
            null,
            null,
            'Pledges',
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
        return $withPrefix ? DepositTableMap::CLASS_DEFAULT : DepositTableMap::OM_CLASS;
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
     * @return array (Deposit object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = DepositTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = DepositTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DepositTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DepositTableMap::OM_CLASS;
            /** @var Deposit $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DepositTableMap::addInstanceToPool($obj, $key);
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
            $key = DepositTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = DepositTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Deposit();
                $obj->hydrate($row);
                $results[] = $obj;
                DepositTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'deposit_dep';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['DEP_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['DEP_DATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['DEP_COMMENT']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['DEP_ENTEREDBY']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['DEP_CLOSED']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['DEP_TYPE']));
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
            $criteria->removeSelectColumn(DepositTableMap::COL_DEP_ID);
            $criteria->removeSelectColumn(DepositTableMap::COL_DEP_DATE);
            $criteria->removeSelectColumn(DepositTableMap::COL_DEP_COMMENT);
            $criteria->removeSelectColumn(DepositTableMap::COL_DEP_ENTEREDBY);
            $criteria->removeSelectColumn(DepositTableMap::COL_DEP_CLOSED);
            $criteria->removeSelectColumn(DepositTableMap::COL_DEP_TYPE);
        } else {
            $criteria->removeSelectColumn($alias . '.dep_ID');
            $criteria->removeSelectColumn($alias . '.dep_Date');
            $criteria->removeSelectColumn($alias . '.dep_Comment');
            $criteria->removeSelectColumn($alias . '.dep_EnteredBy');
            $criteria->removeSelectColumn($alias . '.dep_Closed');
            $criteria->removeSelectColumn($alias . '.dep_Type');
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
        return Propel::getServiceContainer()->getDatabaseMap(DepositTableMap::DATABASE_NAME)->getTable(DepositTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or DepositQuery.
     *
     * Performs a DELETE on the database, given a Deposit or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Deposit object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or DepositQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DepositTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Deposit) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DepositTableMap::DATABASE_NAME);
            $criteria->addAnd(DepositTableMap::COL_DEP_ID, (array)$values, Criteria::IN);
        }

        $query = DepositQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DepositTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                DepositTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the deposit_dep table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return DepositQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Deposit or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Deposit $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(DepositTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Deposit object
        }

        if ($criteria->hasUpdateValue(DepositTableMap::COL_DEP_ID)) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (DepositTableMap::COL_DEP_ID)');
        }

        // Set the correct dbName
        $query = DepositQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
