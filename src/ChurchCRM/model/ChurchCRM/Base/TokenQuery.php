<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\TokenTableMap;
use ChurchCRM\model\ChurchCRM\Token as ChildToken;
use ChurchCRM\model\ChurchCRM\TokenQuery as ChildTokenQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `tokens` table.
 *
 * @method static orderByToken($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the token column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type column
 * @method static orderByValidUntilDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the valid_until_date column
 * @method static orderByReferenceId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the reference_id column
 * @method static orderByRemainingUses($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the remainingUses column
 *
 * @method static groupByToken() Group by the token column
 * @method static groupByType() Group by the type column
 * @method static groupByValidUntilDate() Group by the valid_until_date column
 * @method static groupByReferenceId() Group by the reference_id column
 * @method static groupByRemainingUses() Group by the remainingUses column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\Token|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Token matching the query
 * @method \ChurchCRM\model\ChurchCRM\Token findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Token matching the query, or a new \ChurchCRM\model\ChurchCRM\Token object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Token|null findOneByToken(string $token) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the token column
 * @method \ChurchCRM\model\ChurchCRM\Token|null findOneByType(string $type) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the type column
 * @method \ChurchCRM\model\ChurchCRM\Token|null findOneByValidUntilDate(string $valid_until_date) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the valid_until_date column
 * @method \ChurchCRM\model\ChurchCRM\Token|null findOneByReferenceId(int $reference_id) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the reference_id column
 * @method \ChurchCRM\model\ChurchCRM\Token|null findOneByRemainingUses(int $remainingUses) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the remainingUses column
 *
 * @method \ChurchCRM\model\ChurchCRM\Token requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Token by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Token requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Token matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Token requireOneByToken(string $token) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Token requireOneByType(string $type) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Token requireOneByValidUntilDate(string $valid_until_date) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the valid_until_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Token requireOneByReferenceId(int $reference_id) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the reference_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Token requireOneByRemainingUses(int $remainingUses) Return the first \ChurchCRM\model\ChurchCRM\Token filtered by the remainingUses column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\TokenCollection|array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Token> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Token objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\TokenCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Token objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Token> findByToken(string|array<string> $token) Return \ChurchCRM\model\ChurchCRM\Token objects filtered by the token column
 * @method array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Token> findByType(string|array<string> $type) Return \ChurchCRM\model\ChurchCRM\Token objects filtered by the type column
 * @method array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Token> findByValidUntilDate(string|array<string> $valid_until_date) Return \ChurchCRM\model\ChurchCRM\Token objects filtered by the valid_until_date column
 * @method array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Token> findByReferenceId(int|array<int> $reference_id) Return \ChurchCRM\model\ChurchCRM\Token objects filtered by the reference_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Token> findByRemainingUses(int|array<int> $remainingUses) Return \ChurchCRM\model\ChurchCRM\Token objects filtered by the remainingUses column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Token>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class TokenQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of TokenQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Token',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTokenQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\TokenQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildTokenQuery) {
            return $criteria;
        }
        $query = new ChildTokenQuery();
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
     * @param string $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Token|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TokenTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = TokenTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Token|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildToken
    {
        $sql = 'SELECT token, type, valid_until_date, reference_id, remainingUses FROM tokens WHERE token = :p0';
        $stmt = $con->prepare($sql);
        if (is_bool($stmt)) {
            throw new PropelException('Failed to initialize statement');
        }
        $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            $obj = new ChildToken();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            TokenTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Token|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Token>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('token');
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
        $resolvedColumn = $this->resolveLocalColumnByName('token');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the token column
     *
     * Example usage:
     * <code>
     * $query->filterByToken('fooValue'); // WHERE token = 'fooValue'
     * $query->filterByToken('%fooValue%', Criteria::LIKE); // WHERE token LIKE '%fooValue%'
     * $query->filterByToken(['foo', 'bar']); // WHERE token IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $token The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByToken($token = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('token');
        if ($comparison === null && is_array($token)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $token, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue'); // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * $query->filterByType(['foo', 'bar']); // WHERE type IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $type The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByType($type = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type');
        if ($comparison === null && is_array($type)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $type, $comparison);

        return $this;
    }

    /**
     * Filter the query on the valid_until_date column
     *
     * Example usage:
     * <code>
     * $query->filterByValidUntilDate('2011-03-14'); // WHERE valid_until_date = '2011-03-14'
     * $query->filterByValidUntilDate('now'); // WHERE valid_until_date = '2011-03-14'
     * $query->filterByValidUntilDate(array('max' => 'yesterday')); // WHERE valid_until_date > '2011-03-13'
     * </code>
     *
     * @param mixed $validUntilDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByValidUntilDate($validUntilDate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('valid_until_date');
        if (is_array($validUntilDate)) {
            $useMinMax = false;
            if (isset($validUntilDate['min'])) {
                $this->addUsingOperator($resolvedColumn, $validUntilDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($validUntilDate['max'])) {
                $this->addUsingOperator($resolvedColumn, $validUntilDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $validUntilDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the reference_id column
     *
     * Example usage:
     * <code>
     * $query->filterByReferenceId(1234); // WHERE reference_id = 1234
     * $query->filterByReferenceId(array(12, 34)); // WHERE reference_id IN (12, 34)
     * $query->filterByReferenceId(array('min' => 12)); // WHERE reference_id > 12
     * </code>
     *
     * @param mixed $referenceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByReferenceId($referenceId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('reference_id');
        if (is_array($referenceId)) {
            $useMinMax = false;
            if (isset($referenceId['min'])) {
                $this->addUsingOperator($resolvedColumn, $referenceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($referenceId['max'])) {
                $this->addUsingOperator($resolvedColumn, $referenceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $referenceId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the remainingUses column
     *
     * Example usage:
     * <code>
     * $query->filterByRemainingUses(1234); // WHERE remainingUses = 1234
     * $query->filterByRemainingUses(array(12, 34)); // WHERE remainingUses IN (12, 34)
     * $query->filterByRemainingUses(array('min' => 12)); // WHERE remainingUses > 12
     * </code>
     *
     * @param mixed $remainingUses The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByRemainingUses($remainingUses = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('remainingUses');
        if (is_array($remainingUses)) {
            $useMinMax = false;
            if (isset($remainingUses['min'])) {
                $this->addUsingOperator($resolvedColumn, $remainingUses['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($remainingUses['max'])) {
                $this->addUsingOperator($resolvedColumn, $remainingUses['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $remainingUses, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Token|null $token Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildToken $token = null)
    {
        if ($token) {
            $resolvedColumn = $this->resolveLocalColumnByName('token');
            $this->addUsingOperator($resolvedColumn, $token->getToken(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the tokens table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TokenTableMap::clearInstancePool();
            TokenTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TokenTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TokenTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            TokenTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
