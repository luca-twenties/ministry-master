<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\DonationFund as ChildDonationFund;
use ChurchCRM\model\ChurchCRM\DonationFundQuery as ChildDonationFundQuery;
use ChurchCRM\model\ChurchCRM\Map\DonationFundTableMap;
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
 * Base class that represents a query for the `donationfund_fun` table.
 *
 * This contains the defined donation funds
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fun_ID column
 * @method static orderByActive($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fun_Active column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fun_Name column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fun_Description column
 * @method static orderByOrder($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fun_Order column
 *
 * @method static groupById() Group by the fun_ID column
 * @method static groupByActive() Group by the fun_Active column
 * @method static groupByName() Group by the fun_Name column
 * @method static groupByDescription() Group by the fun_Description column
 * @method static groupByOrder() Group by the fun_Order column
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
 * @method \ChurchCRM\model\ChurchCRM\DonationFund|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\DonationFund matching the query
 * @method \ChurchCRM\model\ChurchCRM\DonationFund findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\DonationFund matching the query, or a new \ChurchCRM\model\ChurchCRM\DonationFund object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\DonationFund|null findOneById(int $fun_ID) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_ID column
 * @method \ChurchCRM\model\ChurchCRM\DonationFund|null findOneByActive(string $fun_Active) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Active column
 * @method \ChurchCRM\model\ChurchCRM\DonationFund|null findOneByName(string $fun_Name) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Name column
 * @method \ChurchCRM\model\ChurchCRM\DonationFund|null findOneByDescription(string $fun_Description) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Description column
 * @method \ChurchCRM\model\ChurchCRM\DonationFund|null findOneByOrder(int $fun_Order) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Order column
 *
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\DonationFund by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\DonationFund matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requireOneById(int $fun_ID) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requireOneByActive(string $fun_Active) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requireOneByName(string $fun_Name) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requireOneByDescription(string $fun_Description) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonationFund requireOneByOrder(int $fun_Order) Return the first \ChurchCRM\model\ChurchCRM\DonationFund filtered by the fun_Order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\DonationFundCollection|array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonationFund> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\DonationFund objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\DonationFundCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\DonationFund objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonationFund> findById(int|array<int> $fun_ID) Return \ChurchCRM\model\ChurchCRM\DonationFund objects filtered by the fun_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonationFund> findByActive(string|array<string> $fun_Active) Return \ChurchCRM\model\ChurchCRM\DonationFund objects filtered by the fun_Active column
 * @method array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonationFund> findByName(string|array<string> $fun_Name) Return \ChurchCRM\model\ChurchCRM\DonationFund objects filtered by the fun_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonationFund> findByDescription(string|array<string> $fun_Description) Return \ChurchCRM\model\ChurchCRM\DonationFund objects filtered by the fun_Description column
 * @method array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonationFund> findByOrder(int|array<int> $fun_Order) Return \ChurchCRM\model\ChurchCRM\DonationFund objects filtered by the fun_Order column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\DonationFund>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class DonationFundQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of DonationFundQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\DonationFund',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDonationFundQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\DonationFundQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDonationFundQuery) {
            return $criteria;
        }
        $query = new ChildDonationFundQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\DonationFund|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DonationFundTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = DonationFundTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\DonationFund|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildDonationFund
    {
        $sql = 'SELECT fun_ID, fun_Active, fun_Name, fun_Description, fun_Order FROM donationfund_fun WHERE fun_ID = :p0';
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
            $obj = new ChildDonationFund();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            DonationFundTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\DonationFund|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\DonationFund>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('fun_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('fun_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the fun_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE fun_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE fun_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE fun_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('fun_ID');
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
     * Filter the query on the fun_Active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive('fooValue'); // WHERE fun_Active = 'fooValue'
     * $query->filterByActive('%fooValue%', Criteria::LIKE); // WHERE fun_Active LIKE '%fooValue%'
     * $query->filterByActive(['foo', 'bar']); // WHERE fun_Active IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $active The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByActive($active = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fun_Active');
        if ($comparison === null && is_array($active)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $active, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fun_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE fun_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE fun_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE fun_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fun_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fun_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE fun_Description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE fun_Description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE fun_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fun_Description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fun_Order column
     *
     * Example usage:
     * <code>
     * $query->filterByOrder(1234); // WHERE fun_Order = 1234
     * $query->filterByOrder(array(12, 34)); // WHERE fun_Order IN (12, 34)
     * $query->filterByOrder(array('min' => 12)); // WHERE fun_Order > 12
     * </code>
     *
     * @param mixed $order The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOrder($order = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fun_Order');
        if (is_array($order)) {
            $useMinMax = false;
            if (isset($order['min'])) {
                $this->addUsingOperator($resolvedColumn, $order['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($order['max'])) {
                $this->addUsingOperator($resolvedColumn, $order['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $order, $comparison);

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
                ->addUsingOperator($this->resolveLocalColumnByName('fun_ID'), $pledge->getFundId(), $comparison);
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
     * @param \ChurchCRM\model\ChurchCRM\DonationFund|null $donationFund Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildDonationFund $donationFund = null)
    {
        if ($donationFund) {
            $resolvedColumn = $this->resolveLocalColumnByName('fun_ID');
            $this->addUsingOperator($resolvedColumn, $donationFund->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the donationfund_fun table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DonationFundTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DonationFundTableMap::clearInstancePool();
            DonationFundTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DonationFundTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DonationFundTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DonationFundTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            DonationFundTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
