<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\PredefinedReportsTableMap;
use ChurchCRM\model\ChurchCRM\PredefinedReports as ChildPredefinedReports;
use ChurchCRM\model\ChurchCRM\PredefinedReportsQuery as ChildPredefinedReportsQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `query_qry` table.
 *
 * This contains all the predefined queries that appear in the queries page
 *
 * @method static orderByQryId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qry_ID column
 * @method static orderByQrySql($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qry_SQL column
 * @method static orderByQryName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qry_Name column
 * @method static orderByQryDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qry_Description column
 * @method static orderByQryCount($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qry_Count column
 *
 * @method static groupByQryId() Group by the qry_ID column
 * @method static groupByQrySql() Group by the qry_SQL column
 * @method static groupByQryName() Group by the qry_Name column
 * @method static groupByQryDescription() Group by the qry_Description column
 * @method static groupByQryCount() Group by the qry_Count column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports matching the query
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports matching the query, or a new \ChurchCRM\model\ChurchCRM\PredefinedReports object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports|null findOneByQryId(int $qry_ID) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_ID column
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports|null findOneByQrySql(string $qry_SQL) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_SQL column
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports|null findOneByQryName(string $qry_Name) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_Name column
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports|null findOneByQryDescription(string $qry_Description) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_Description column
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports|null findOneByQryCount(bool $qry_Count) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_Count column
 *
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\PredefinedReports by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requireOneByQryId(int $qry_ID) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requireOneByQrySql(string $qry_SQL) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_SQL column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requireOneByQryName(string $qry_Name) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requireOneByQryDescription(string $qry_Description) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PredefinedReports requireOneByQryCount(bool $qry_Count) Return the first \ChurchCRM\model\ChurchCRM\PredefinedReports filtered by the qry_Count column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PredefinedReportsCollection|array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PredefinedReports> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\PredefinedReports objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PredefinedReportsCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\PredefinedReports objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PredefinedReports> findByQryId(int|array<int> $qry_ID) Return \ChurchCRM\model\ChurchCRM\PredefinedReports objects filtered by the qry_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PredefinedReports> findByQrySql(string|array<string> $qry_SQL) Return \ChurchCRM\model\ChurchCRM\PredefinedReports objects filtered by the qry_SQL column
 * @method array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PredefinedReports> findByQryName(string|array<string> $qry_Name) Return \ChurchCRM\model\ChurchCRM\PredefinedReports objects filtered by the qry_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PredefinedReports> findByQryDescription(string|array<string> $qry_Description) Return \ChurchCRM\model\ChurchCRM\PredefinedReports objects filtered by the qry_Description column
 * @method array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PredefinedReports> findByQryCount(bool|array<bool> $qry_Count) Return \ChurchCRM\model\ChurchCRM\PredefinedReports objects filtered by the qry_Count column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\PredefinedReports>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class PredefinedReportsQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of PredefinedReportsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\PredefinedReports',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPredefinedReportsQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\PredefinedReportsQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPredefinedReportsQuery) {
            return $criteria;
        }
        $query = new ChildPredefinedReportsQuery();
        if ($modelAlias !== null) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(12, $con);
     * </code>
     *
     * @param int $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\PredefinedReports|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PredefinedReportsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = PredefinedReportsTableMap::getInstanceFromPool($poolKey);
        if ($obj !== null) {
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return \ChurchCRM\model\ChurchCRM\PredefinedReports|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildPredefinedReports
    {
        $sql = 'SELECT qry_ID, qry_SQL, qry_Name, qry_Description, qry_Count FROM query_qry WHERE qry_ID = :p0';
        $stmt = $con->prepare($sql);
        if (is_bool($stmt)) {
            throw new PropelException('Failed to initialize statement');
        }
        $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            $obj = new ChildPredefinedReports();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            PredefinedReportsTableMap::addInstanceToPool($obj, $poolKey);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface $con A connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\PredefinedReports|mixed|array|null the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     *
     * @param array $keys Primary keys to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\PredefinedReports>|mixed|array the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param mixed $key Primary key to use for the query
     *
     * @return $this
     */
    public function filterByPrimaryKey($key)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_ID');
        $this->addUsingOperator($resolvedColumn, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array $keys The list of primary key values to use for the query
     *
     * @return static
     */
    public function filterByPrimaryKeys(array $keys)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the qry_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByQryId(1234); // WHERE qry_ID = 1234
     * $query->filterByQryId(array(12, 34)); // WHERE qry_ID IN (12, 34)
     * $query->filterByQryId(array('min' => 12)); // WHERE qry_ID > 12
     * </code>
     *
     * @param mixed $qryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQryId($qryId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_ID');
        if (is_array($qryId)) {
            $useMinMax = false;
            if (isset($qryId['min'])) {
                $this->addUsingOperator($resolvedColumn, $qryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qryId['max'])) {
                $this->addUsingOperator($resolvedColumn, $qryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $qryId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qry_SQL column
     *
     * Example usage:
     * <code>
     * $query->filterByQrySql('fooValue'); // WHERE qry_SQL = 'fooValue'
     * $query->filterByQrySql('%fooValue%', Criteria::LIKE); // WHERE qry_SQL LIKE '%fooValue%'
     * $query->filterByQrySql(['foo', 'bar']); // WHERE qry_SQL IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $qrySql The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQrySql($qrySql = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_SQL');
        if ($comparison === null && is_array($qrySql)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $qrySql, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qry_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByQryName('fooValue'); // WHERE qry_Name = 'fooValue'
     * $query->filterByQryName('%fooValue%', Criteria::LIKE); // WHERE qry_Name LIKE '%fooValue%'
     * $query->filterByQryName(['foo', 'bar']); // WHERE qry_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $qryName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQryName($qryName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_Name');
        if ($comparison === null && is_array($qryName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $qryName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qry_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByQryDescription('fooValue'); // WHERE qry_Description = 'fooValue'
     * $query->filterByQryDescription('%fooValue%', Criteria::LIKE); // WHERE qry_Description LIKE '%fooValue%'
     * $query->filterByQryDescription(['foo', 'bar']); // WHERE qry_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $qryDescription The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQryDescription($qryDescription = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_Description');
        if ($comparison === null && is_array($qryDescription)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $qryDescription, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qry_Count column
     *
     * Example usage:
     * <code>
     * $query->filterByQryCount(true); // WHERE qry_Count = true
     * $query->filterByQryCount('yes'); // WHERE qry_Count = true
     * </code>
     *
     * @param string|bool|null $qryCount The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQryCount($qryCount = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qry_Count');
        if (is_string($qryCount)) {
            $qryCount = in_array(strtolower($qryCount), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $qryCount, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\PredefinedReports|null $predefinedReports Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildPredefinedReports $predefinedReports = null)
    {
        if ($predefinedReports) {
            $resolvedColumn = $this->resolveLocalColumnByName('qry_ID');
            $this->addUsingOperator($resolvedColumn, $predefinedReports->getQryId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the query_qry table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PredefinedReportsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PredefinedReportsTableMap::clearInstancePool();
            PredefinedReportsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver). This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PredefinedReportsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PredefinedReportsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PredefinedReportsTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            PredefinedReportsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
