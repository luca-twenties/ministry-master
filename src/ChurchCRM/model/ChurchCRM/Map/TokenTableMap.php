<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Map;

use ChurchCRM\model\ChurchCRM\Token;
use ChurchCRM\model\ChurchCRM\TokenQuery;
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
 * This class defines the structure of the 'tokens' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class TokenTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'ChurchCRM.model.ChurchCRM.Map.TokenTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'tokens';

    /**
     * The PHP name of this class (PascalCase)
     */
    public const TABLE_PHP_NAME = 'Token';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\ChurchCRM\\model\\ChurchCRM\\Token';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'ChurchCRM.model.ChurchCRM.Token';

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
     * the column name for the token field
     */
    public const COL_TOKEN = 'tokens.token';

    /**
     * the column name for the type field
     */
    public const COL_TYPE = 'tokens.type';

    /**
     * the column name for the valid_until_date field
     */
    public const COL_VALID_UNTIL_DATE = 'tokens.valid_until_date';

    /**
     * the column name for the reference_id field
     */
    public const COL_REFERENCE_ID = 'tokens.reference_id';

    /**
     * the column name for the remainingUses field
     */
    public const COL_REMAININGUSES = 'tokens.remainingUses';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * @var class-string<\ChurchCRM\model\ChurchCRM\Base\Collection\TokenCollection>
     */
    public const DEFAULT_OBJECT_COLLECTION = '\ChurchCRM\model\ChurchCRM\Base\Collection\TokenCollection';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Token', 'Type', 'ValidUntilDate', 'ReferenceId', 'RemainingUses', ],
        self::TYPE_CAMELNAME     => ['token', 'type', 'validUntilDate', 'referenceId', 'remainingUses', ],
        self::TYPE_COLNAME       => [TokenTableMap::COL_TOKEN, TokenTableMap::COL_TYPE, TokenTableMap::COL_VALID_UNTIL_DATE, TokenTableMap::COL_REFERENCE_ID, TokenTableMap::COL_REMAININGUSES, ],
        self::TYPE_FIELDNAME     => ['token', 'type', 'valid_until_date', 'reference_id', 'remainingUses', ],
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
        self::TYPE_PHPNAME       => ['Token' => 0, 'Type' => 1, 'ValidUntilDate' => 2, 'ReferenceId' => 3, 'RemainingUses' => 4, ],
        self::TYPE_CAMELNAME     => ['token' => 0, 'type' => 1, 'validUntilDate' => 2, 'referenceId' => 3, 'remainingUses' => 4, ],
        self::TYPE_COLNAME       => [TokenTableMap::COL_TOKEN => 0, TokenTableMap::COL_TYPE => 1, TokenTableMap::COL_VALID_UNTIL_DATE => 2, TokenTableMap::COL_REFERENCE_ID => 3, TokenTableMap::COL_REMAININGUSES => 4, ],
        self::TYPE_FIELDNAME     => ['token' => 0, 'type' => 1, 'valid_until_date' => 2, 'reference_id' => 3, 'remainingUses' => 4, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string, string>
     */
    protected $normalizedColumnNameMap = [
        'Token' => 'TOKEN',
        'Token.Token' => 'TOKEN',
        'token' => 'TOKEN',
        'token.token' => 'TOKEN',
        'TokenTableMap::COL_TOKEN' => 'TOKEN',
        'COL_TOKEN' => 'TOKEN',
        'tokens.token' => 'TOKEN',
        'Type' => 'TYPE',
        'Token.Type' => 'TYPE',
        'type' => 'TYPE',
        'token.type' => 'TYPE',
        'TokenTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
        'tokens.type' => 'TYPE',
        'ValidUntilDate' => 'VALID_UNTIL_DATE',
        'Token.ValidUntilDate' => 'VALID_UNTIL_DATE',
        'validUntilDate' => 'VALID_UNTIL_DATE',
        'token.validUntilDate' => 'VALID_UNTIL_DATE',
        'TokenTableMap::COL_VALID_UNTIL_DATE' => 'VALID_UNTIL_DATE',
        'COL_VALID_UNTIL_DATE' => 'VALID_UNTIL_DATE',
        'valid_until_date' => 'VALID_UNTIL_DATE',
        'tokens.valid_until_date' => 'VALID_UNTIL_DATE',
        'ReferenceId' => 'REFERENCE_ID',
        'Token.ReferenceId' => 'REFERENCE_ID',
        'referenceId' => 'REFERENCE_ID',
        'token.referenceId' => 'REFERENCE_ID',
        'TokenTableMap::COL_REFERENCE_ID' => 'REFERENCE_ID',
        'COL_REFERENCE_ID' => 'REFERENCE_ID',
        'reference_id' => 'REFERENCE_ID',
        'tokens.reference_id' => 'REFERENCE_ID',
        'RemainingUses' => 'REMAININGUSES',
        'Token.RemainingUses' => 'REMAININGUSES',
        'remainingUses' => 'REMAININGUSES',
        'token.remainingUses' => 'REMAININGUSES',
        'TokenTableMap::COL_REMAININGUSES' => 'REMAININGUSES',
        'COL_REMAININGUSES' => 'REMAININGUSES',
        'tokens.remainingUses' => 'REMAININGUSES',
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
        $this->setName('tokens');
        $this->setPhpName('Token');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ChurchCRM\\model\\ChurchCRM\\Token');
        $this->setPackage('ChurchCRM.model.ChurchCRM');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('token', 'Token', 'VARCHAR', true, 255, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 255, null);
        $this->addColumn('valid_until_date', 'ValidUntilDate', 'DATE', false, null, null);
        $this->addColumn('reference_id', 'ReferenceId', 'INTEGER', false, null, );
        $this->addColumn('remainingUses', 'RemainingUses', 'INTEGER', false, null, 0);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType)] === null || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string)$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType)];
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
        $tokenIx = $indexType === TableMap::TYPE_NUM
            ? 0 + $offset
            : self::translateFieldName('Token', TableMap::TYPE_PHPNAME, $indexType);

        return (string)$row[$tokenIx];
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
        return $withPrefix ? TokenTableMap::CLASS_DEFAULT : TokenTableMap::OM_CLASS;
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
     * @return array (Token object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = TokenTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (($obj = TokenTableMap::getInstanceFromPool($key)) !== null) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TokenTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TokenTableMap::OM_CLASS;
            /** @var Token $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TokenTableMap::addInstanceToPool($obj, $key);
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
            $key = TokenTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (($obj = TokenTableMap::getInstanceFromPool($key)) !== null) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new Token();
                $obj->hydrate($row);
                $results[] = $obj;
                TokenTableMap::addInstanceToPool($obj, $key);
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
        $tableAlias = $alias ?: 'tokens';
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TOKEN']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['TYPE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['VALID_UNTIL_DATE']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['REFERENCE_ID']));
        $criteria->addSelectColumn(new LocalColumnExpression($criteria, $tableAlias, $tableMap->columns['REMAININGUSES']));
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
            $criteria->removeSelectColumn(TokenTableMap::COL_TOKEN);
            $criteria->removeSelectColumn(TokenTableMap::COL_TYPE);
            $criteria->removeSelectColumn(TokenTableMap::COL_VALID_UNTIL_DATE);
            $criteria->removeSelectColumn(TokenTableMap::COL_REFERENCE_ID);
            $criteria->removeSelectColumn(TokenTableMap::COL_REMAININGUSES);
        } else {
            $criteria->removeSelectColumn($alias . '.token');
            $criteria->removeSelectColumn($alias . '.type');
            $criteria->removeSelectColumn($alias . '.valid_until_date');
            $criteria->removeSelectColumn($alias . '.reference_id');
            $criteria->removeSelectColumn($alias . '.remainingUses');
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
        return Propel::getServiceContainer()->getDatabaseMap(TokenTableMap::DATABASE_NAME)->getTable(TokenTableMap::TABLE_NAME);
    }

    /**
     * @deprecated Delete via model or TokenQuery.
     *
     * Performs a DELETE on the database, given a Token or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Token object or primary key or array of primary keys
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
        trigger_deprecation('Propel', '2.0', 'TableMap::doDelete() should not be used anymore, delete via model or TokenQuery');

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            $criteria = $values;
        } elseif ($values instanceof Token) { // it's a model object
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TokenTableMap::DATABASE_NAME);
            $criteria->addAnd(TokenTableMap::COL_TOKEN, (array)$values, Criteria::IN);
        }

        $query = TokenQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TokenTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array)$values as $singleval) {
                TokenTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the tokens table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return TokenQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Token or Criteria object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|\ChurchCRM\model\ChurchCRM\Token $criteria
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
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria;
            $criteria->turnFiltersToUpdateValues();
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Token object
        }

        // Set the correct dbName
        $query = TokenQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }
}
