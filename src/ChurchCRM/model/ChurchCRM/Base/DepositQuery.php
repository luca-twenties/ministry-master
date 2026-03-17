<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Deposit as ChildDeposit;
use ChurchCRM\model\ChurchCRM\DepositQuery as ChildDepositQuery;
use ChurchCRM\model\ChurchCRM\Map\DepositTableMap;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `deposit_dep` table.
 *
 * This records deposits / payments
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the dep_ID column
 * @method static orderByDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the dep_Date column
 * @method static orderByComment($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the dep_Comment column
 * @method static orderByEnteredby($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the dep_EnteredBy column
 * @method static orderByClosed($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the dep_Closed column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the dep_Type column
 *
 * @method static groupById() Group by the dep_ID column
 * @method static groupByDate() Group by the dep_Date column
 * @method static groupByComment() Group by the dep_Comment column
 * @method static groupByEnteredby() Group by the dep_EnteredBy column
 * @method static groupByClosed() Group by the dep_Closed column
 * @method static groupByType() Group by the dep_Type column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinPledge($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pledge relation
 * @method static rightJoinPledge($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pledge relation
 * @method static innerJoinPledge($relationAlias = null) Adds a INNER JOIN clause to the query using the Pledge relation
 *
 * @method static joinWithPledge($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pledge relation
 *
 * @method static leftJoinWithPledge() Adds a LEFT JOIN clause and with to the query using the Pledge relation
 * @method static rightJoinWithPledge() Adds a RIGHT JOIN clause and with to the query using the Pledge relation
 * @method static innerJoinWithPledge() Adds a INNER JOIN clause and with to the query using the Pledge relation
 *
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Deposit matching the query
 * @method \ChurchCRM\model\ChurchCRM\Deposit findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Deposit matching the query, or a new \ChurchCRM\model\ChurchCRM\Deposit object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOneById(int $dep_ID) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_ID column
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOneByDate(string $dep_Date) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Date column
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOneByComment(string $dep_Comment) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Comment column
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOneByEnteredby(int $dep_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_EnteredBy column
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOneByClosed(bool $dep_Closed) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Closed column
 * @method \ChurchCRM\model\ChurchCRM\Deposit|null findOneByType(string $dep_Type) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Type column
 *
 * @method \ChurchCRM\model\ChurchCRM\Deposit requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Deposit by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Deposit matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOneById(int $dep_ID) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOneByDate(string $dep_Date) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOneByComment(string $dep_Comment) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOneByEnteredby(int $dep_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_EnteredBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOneByClosed(bool $dep_Closed) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Closed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Deposit requireOneByType(string $dep_Type) Return the first \ChurchCRM\model\ChurchCRM\Deposit filtered by the dep_Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\DepositCollection|array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Deposit objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\DepositCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Deposit objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> findById(int|array<int> $dep_ID) Return \ChurchCRM\model\ChurchCRM\Deposit objects filtered by the dep_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> findByDate(string|array<string> $dep_Date) Return \ChurchCRM\model\ChurchCRM\Deposit objects filtered by the dep_Date column
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> findByComment(string|array<string> $dep_Comment) Return \ChurchCRM\model\ChurchCRM\Deposit objects filtered by the dep_Comment column
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> findByEnteredby(int|array<int> $dep_EnteredBy) Return \ChurchCRM\model\ChurchCRM\Deposit objects filtered by the dep_EnteredBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> findByClosed(bool|array<bool> $dep_Closed) Return \ChurchCRM\model\ChurchCRM\Deposit objects filtered by the dep_Closed column
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Deposit> findByType(string|array<string> $dep_Type) Return \ChurchCRM\model\ChurchCRM\Deposit objects filtered by the dep_Type column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Deposit>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class DepositQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of DepositQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Deposit',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDepositQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\DepositQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDepositQuery) {
            return $criteria;
        }
        $query = new ChildDepositQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Deposit|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DepositTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = DepositTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Deposit|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildDeposit
    {
        $sql = 'SELECT dep_ID, dep_Date, dep_Comment, dep_EnteredBy, dep_Closed, dep_Type FROM deposit_dep WHERE dep_ID = :p0';
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
            $obj = new ChildDeposit();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            DepositTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Deposit|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Deposit>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('dep_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('dep_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the dep_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE dep_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE dep_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE dep_ID > 12
     * </code>
     *
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('dep_ID');
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingOperator($resolvedColumn, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingOperator($resolvedColumn, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dep_Date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE dep_Date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE dep_Date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE dep_Date > '2011-03-13'
     * </code>
     *
     * @param mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDate($date = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('dep_Date');
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingOperator($resolvedColumn, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingOperator($resolvedColumn, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $date, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dep_Comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue'); // WHERE dep_Comment = 'fooValue'
     * $query->filterByComment('%fooValue%', Criteria::LIKE); // WHERE dep_Comment LIKE '%fooValue%'
     * $query->filterByComment(['foo', 'bar']); // WHERE dep_Comment IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $comment The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByComment($comment = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('dep_Comment');
        if ($comparison === null && is_array($comment)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $comment, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dep_EnteredBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredby(1234); // WHERE dep_EnteredBy = 1234
     * $query->filterByEnteredby(array(12, 34)); // WHERE dep_EnteredBy IN (12, 34)
     * $query->filterByEnteredby(array('min' => 12)); // WHERE dep_EnteredBy > 12
     * </code>
     *
     * @param mixed $enteredby The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnteredby($enteredby = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('dep_EnteredBy');
        if (is_array($enteredby)) {
            $useMinMax = false;
            if (isset($enteredby['min'])) {
                $this->addUsingOperator($resolvedColumn, $enteredby['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enteredby['max'])) {
                $this->addUsingOperator($resolvedColumn, $enteredby['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $enteredby, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dep_Closed column
     *
     * Example usage:
     * <code>
     * $query->filterByClosed(true); // WHERE dep_Closed = true
     * $query->filterByClosed('yes'); // WHERE dep_Closed = true
     * </code>
     *
     * @param string|bool|null $closed The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByClosed($closed = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('dep_Closed');
        if (is_string($closed)) {
            $closed = in_array(strtolower($closed), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $closed, $comparison);

        return $this;
    }

    /**
     * Filter the query on the dep_Type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue'); // WHERE dep_Type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE dep_Type LIKE '%fooValue%'
     * $query->filterByType(['foo', 'bar']); // WHERE dep_Type IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $type The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByType($type = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('dep_Type');
        if ($comparison === null && is_array($type)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $type, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Pledge object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Pledge|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Pledge> $pledge the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPledge(Pledge|ObjectCollection $pledge, ?string $comparison = null)
    {
        if ($pledge instanceof Pledge) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('dep_ID'), $pledge->getDepId(), $comparison);
        } elseif ($pledge instanceof ObjectCollection) {
            $this
                ->usePledgeQuery()
                ->filterByPrimaryKeys($pledge->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPledge() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Pledge or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the Pledge relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPledge(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pledge');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $leftAlias = $this->useAliasInSQL ? $this->getModelAlias() : null;
        $join->setupJoinCondition($this, $relationMap, $leftAlias, $relationAlias);
        $previousJoin = $this->getPreviousJoin();
        if ($previousJoin instanceof ModelJoin) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Pledge');
        }

        return $this;
    }

    /**
     * Use the Pledge relation Pledge object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> A secondary query class using the current class as primary query
     */
    public function usePledgeQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $query */
        $query = $this->joinPledge($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Pledge', '\ChurchCRM\model\ChurchCRM\PledgeQuery');

        return $query;
    }

    /**
     * Use the Pledge relation Pledge object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PledgeQuery<mixed>):\ChurchCRM\model\ChurchCRM\PledgeQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPledgeQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->usePledgeQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Pledge table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the EXISTS statement
     */
    public function usePledgeExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q */
        $q = $this->useExistsQuery('Pledge', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Pledge table for a NOT EXISTS query.
     *
     * @see usePledgeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePledgeNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q*/
        $q = $this->useExistsQuery('Pledge', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Pledge table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the IN statement
     */
    public function useInPledgeQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q */
        $q = $this->useInQuery('Pledge', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Pledge table for a NOT IN query.
     *
     * @see usePledgeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PledgeQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPledgeQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PledgeQuery<static> $q */
        $q = $this->useInQuery('Pledge', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Deposit|null $deposit Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildDeposit $deposit = null)
    {
        if ($deposit) {
            $resolvedColumn = $this->resolveLocalColumnByName('dep_ID');
            $this->addUsingOperator($resolvedColumn, $deposit->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the deposit_dep table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DepositTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DepositTableMap::clearInstancePool();
            DepositTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DepositTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DepositTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DepositTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            DepositTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
