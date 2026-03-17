<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\QueryParameterOptionsTableMap;
use ChurchCRM\model\ChurchCRM\QueryParameterOptions as ChildQueryParameterOptions;
use ChurchCRM\model\ChurchCRM\QueryParameterOptionsQuery as ChildQueryParameterOptionsQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `queryparameteroptions_qpo` table.
 *
 * Defines the values for the parameters for each query
 *
 * @method static orderByQpoId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qpo_ID column
 * @method static orderByQpoQrpId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qpo_qrp_ID column
 * @method static orderByQpoDisplay($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qpo_Display column
 * @method static orderByQpoValue($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qpo_Value column
 *
 * @method static groupByQpoId() Group by the qpo_ID column
 * @method static groupByQpoQrpId() Group by the qpo_qrp_ID column
 * @method static groupByQpoDisplay() Group by the qpo_Display column
 * @method static groupByQpoValue() Group by the qpo_Value column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions matching the query
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions matching the query, or a new \ChurchCRM\model\ChurchCRM\QueryParameterOptions object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null findOneByQpoId(int $qpo_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_ID column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null findOneByQpoQrpId(int $qpo_qrp_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_qrp_ID column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null findOneByQpoDisplay(string $qpo_Display) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_Display column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null findOneByQpoValue(string $qpo_Value) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_Value column
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\QueryParameterOptions by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions requireOneByQpoId(int $qpo_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions requireOneByQpoQrpId(int $qpo_qrp_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_qrp_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions requireOneByQpoDisplay(string $qpo_Display) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_Display column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameterOptions requireOneByQpoValue(string $qpo_Value) Return the first \ChurchCRM\model\ChurchCRM\QueryParameterOptions filtered by the qpo_Value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\QueryParameterOptionsCollection|array<\ChurchCRM\model\ChurchCRM\QueryParameterOptions>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameterOptions> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\QueryParameterOptions objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\QueryParameterOptionsCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\QueryParameterOptions objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameterOptions>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameterOptions> findByQpoId(int|array<int> $qpo_ID) Return \ChurchCRM\model\ChurchCRM\QueryParameterOptions objects filtered by the qpo_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameterOptions>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameterOptions> findByQpoQrpId(int|array<int> $qpo_qrp_ID) Return \ChurchCRM\model\ChurchCRM\QueryParameterOptions objects filtered by the qpo_qrp_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameterOptions>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameterOptions> findByQpoDisplay(string|array<string> $qpo_Display) Return \ChurchCRM\model\ChurchCRM\QueryParameterOptions objects filtered by the qpo_Display column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameterOptions>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameterOptions> findByQpoValue(string|array<string> $qpo_Value) Return \ChurchCRM\model\ChurchCRM\QueryParameterOptions objects filtered by the qpo_Value column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameterOptions>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class QueryParameterOptionsQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of QueryParameterOptionsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\QueryParameterOptions',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildQueryParameterOptionsQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\QueryParameterOptionsQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildQueryParameterOptionsQuery) {
            return $criteria;
        }
        $query = new ChildQueryParameterOptionsQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\QueryParameterOptions|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(QueryParameterOptionsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = QueryParameterOptionsTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildQueryParameterOptions
    {
        $sql = 'SELECT qpo_ID, qpo_qrp_ID, qpo_Display, qpo_Value FROM queryparameteroptions_qpo WHERE qpo_ID = :p0';
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
            $obj = new ChildQueryParameterOptions();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            QueryParameterOptionsTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\QueryParameterOptions|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\QueryParameterOptions>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('qpo_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('qpo_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the qpo_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByQpoId(1234); // WHERE qpo_ID = 1234
     * $query->filterByQpoId(array(12, 34)); // WHERE qpo_ID IN (12, 34)
     * $query->filterByQpoId(array('min' => 12)); // WHERE qpo_ID > 12
     * </code>
     *
     * @param mixed $qpoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQpoId($qpoId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qpo_ID');
        if (is_array($qpoId)) {
            $useMinMax = false;
            if (isset($qpoId['min'])) {
                $this->addUsingOperator($resolvedColumn, $qpoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qpoId['max'])) {
                $this->addUsingOperator($resolvedColumn, $qpoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $qpoId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qpo_qrp_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByQpoQrpId(1234); // WHERE qpo_qrp_ID = 1234
     * $query->filterByQpoQrpId(array(12, 34)); // WHERE qpo_qrp_ID IN (12, 34)
     * $query->filterByQpoQrpId(array('min' => 12)); // WHERE qpo_qrp_ID > 12
     * </code>
     *
     * @param mixed $qpoQrpId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQpoQrpId($qpoQrpId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qpo_qrp_ID');
        if (is_array($qpoQrpId)) {
            $useMinMax = false;
            if (isset($qpoQrpId['min'])) {
                $this->addUsingOperator($resolvedColumn, $qpoQrpId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qpoQrpId['max'])) {
                $this->addUsingOperator($resolvedColumn, $qpoQrpId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $qpoQrpId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qpo_Display column
     *
     * Example usage:
     * <code>
     * $query->filterByQpoDisplay('fooValue'); // WHERE qpo_Display = 'fooValue'
     * $query->filterByQpoDisplay('%fooValue%', Criteria::LIKE); // WHERE qpo_Display LIKE '%fooValue%'
     * $query->filterByQpoDisplay(['foo', 'bar']); // WHERE qpo_Display IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $qpoDisplay The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQpoDisplay($qpoDisplay = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qpo_Display');
        if ($comparison === null && is_array($qpoDisplay)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $qpoDisplay, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qpo_Value column
     *
     * Example usage:
     * <code>
     * $query->filterByQpoValue('fooValue'); // WHERE qpo_Value = 'fooValue'
     * $query->filterByQpoValue('%fooValue%', Criteria::LIKE); // WHERE qpo_Value LIKE '%fooValue%'
     * $query->filterByQpoValue(['foo', 'bar']); // WHERE qpo_Value IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $qpoValue The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQpoValue($qpoValue = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qpo_Value');
        if ($comparison === null && is_array($qpoValue)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $qpoValue, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\QueryParameterOptions|null $queryParameterOptions Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildQueryParameterOptions $queryParameterOptions = null)
    {
        if ($queryParameterOptions) {
            $resolvedColumn = $this->resolveLocalColumnByName('qpo_ID');
            $this->addUsingOperator($resolvedColumn, $queryParameterOptions->getQpoId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the queryparameteroptions_qpo table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParameterOptionsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            QueryParameterOptionsTableMap::clearInstancePool();
            QueryParameterOptionsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParameterOptionsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(QueryParameterOptionsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            QueryParameterOptionsTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            QueryParameterOptionsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
