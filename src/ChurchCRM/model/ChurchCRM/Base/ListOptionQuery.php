<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\ListOption as ChildListOption;
use ChurchCRM\model\ChurchCRM\ListOptionQuery as ChildListOptionQuery;
use ChurchCRM\model\ChurchCRM\Map\ListOptionTableMap;
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
 * Base class that represents a query for the `list_lst` table.
 *
 * This table stores the options for most of the drop down lists in churchCRM, including person classifications, family roles, group types, group roles, group-specific property types, and custom field value lists.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the lst_ID column
 * @method static orderByOptionId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the lst_OptionID column
 * @method static orderByOptionSequence($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the lst_OptionSequence column
 * @method static orderByOptionName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the lst_OptionName column
 *
 * @method static groupById() Group by the lst_ID column
 * @method static groupByOptionId() Group by the lst_OptionID column
 * @method static groupByOptionSequence() Group by the lst_OptionSequence column
 * @method static groupByOptionName() Group by the lst_OptionName column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method static rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method static innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method static joinWithGroup($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Group relation
 *
 * @method static leftJoinWithGroup() Adds a LEFT JOIN clause and with to the query using the Group relation
 * @method static rightJoinWithGroup() Adds a RIGHT JOIN clause and with to the query using the Group relation
 * @method static innerJoinWithGroup() Adds a INNER JOIN clause and with to the query using the Group relation
 *
 * @method \ChurchCRM\model\ChurchCRM\ListOption|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\ListOption matching the query
 * @method \ChurchCRM\model\ChurchCRM\ListOption findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\ListOption matching the query, or a new \ChurchCRM\model\ChurchCRM\ListOption object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\ListOption|null findOneById(int $lst_ID) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_ID column
 * @method \ChurchCRM\model\ChurchCRM\ListOption|null findOneByOptionId(int $lst_OptionID) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_OptionID column
 * @method \ChurchCRM\model\ChurchCRM\ListOption|null findOneByOptionSequence(int $lst_OptionSequence) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_OptionSequence column
 * @method \ChurchCRM\model\ChurchCRM\ListOption|null findOneByOptionName(string $lst_OptionName) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_OptionName column
 *
 * @method \ChurchCRM\model\ChurchCRM\ListOption requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\ListOption by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\ListOption requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\ListOption matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\ListOption requireOneById(int $lst_ID) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\ListOption requireOneByOptionId(int $lst_OptionID) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_OptionID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\ListOption requireOneByOptionSequence(int $lst_OptionSequence) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_OptionSequence column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\ListOption requireOneByOptionName(string $lst_OptionName) Return the first \ChurchCRM\model\ChurchCRM\ListOption filtered by the lst_OptionName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\ListOptionCollection|array<\ChurchCRM\model\ChurchCRM\ListOption>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\ListOption> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\ListOption objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\ListOptionCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\ListOption objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\ListOption>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\ListOption> findById(int|array<int> $lst_ID) Return \ChurchCRM\model\ChurchCRM\ListOption objects filtered by the lst_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\ListOption>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\ListOption> findByOptionId(int|array<int> $lst_OptionID) Return \ChurchCRM\model\ChurchCRM\ListOption objects filtered by the lst_OptionID column
 * @method array<\ChurchCRM\model\ChurchCRM\ListOption>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\ListOption> findByOptionSequence(int|array<int> $lst_OptionSequence) Return \ChurchCRM\model\ChurchCRM\ListOption objects filtered by the lst_OptionSequence column
 * @method array<\ChurchCRM\model\ChurchCRM\ListOption>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\ListOption> findByOptionName(string|array<string> $lst_OptionName) Return \ChurchCRM\model\ChurchCRM\ListOption objects filtered by the lst_OptionName column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\ListOption>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class ListOptionQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of ListOptionQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\ListOption',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildListOptionQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\ListOptionQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildListOptionQuery) {
            return $criteria;
        }
        $query = new ChildListOptionQuery();
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
     * $obj = $c->findPk([12, 34], $con);
     * </code>
     *
     * @param array{int|null, int|null} $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\ListOption|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ListOptionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
        $obj = ListOptionTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\ListOption|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildListOption
    {
        $sql = 'SELECT lst_ID, lst_OptionID, lst_OptionSequence, lst_OptionName FROM list_lst WHERE lst_ID = :p0 AND lst_OptionID = :p1';
        $stmt = $con->prepare($sql);
        if (is_bool($stmt)) {
            throw new PropelException('Failed to initialize statement');
        }
        $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
        $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            $obj = new ChildListOption();
            $obj->hydrate($row);
            $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
            ListOptionTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\ListOption|mixed|array|null the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     *
     * @param array $keys Primary keys to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\ListOption>|mixed|array the list of results, formatted by the current formatter
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
        $tableMap = ListOptionTableMap::getTableMap();
        $resolvedColumn = $this->resolveLocalColumnByName('lst_ID');
        $this->addUsingOperator($resolvedColumn, $key[0], Criteria::EQUAL);
        $resolvedColumn = $this->resolveLocalColumnByName('lst_OptionID');
        $this->addUsingOperator($resolvedColumn, $key[1], Criteria::EQUAL);

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
        if (!$keys) {
            return $this->addAnd('1<>1');
        }

        $resolvedColumn0 = $this->resolveLocalColumnByName('lst_ID');
        $resolvedColumn1 = $this->resolveLocalColumnByName('lst_OptionID');

        foreach ($keys as $key) {
            $filter0 = $this->buildFilter($resolvedColumn0, $key[0], Criteria::EQUAL);
            $this->addOr($filter0);

            $filter1 = $this->buildFilter($resolvedColumn1, $key[1], Criteria::EQUAL);
            $filter0->addAnd($filter1);
        }

        return $this;
    }

    /**
     * Filter the query on the lst_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE lst_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE lst_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE lst_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('lst_ID');
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
     * Filter the query on the lst_OptionID column
     *
     * Example usage:
     * <code>
     * $query->filterByOptionId(1234); // WHERE lst_OptionID = 1234
     * $query->filterByOptionId(array(12, 34)); // WHERE lst_OptionID IN (12, 34)
     * $query->filterByOptionId(array('min' => 12)); // WHERE lst_OptionID > 12
     * </code>
     *
     * @param mixed $optionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOptionId($optionId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('lst_OptionID');
        if (is_array($optionId)) {
            $useMinMax = false;
            if (isset($optionId['min'])) {
                $this->addUsingOperator($resolvedColumn, $optionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optionId['max'])) {
                $this->addUsingOperator($resolvedColumn, $optionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $optionId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the lst_OptionSequence column
     *
     * Example usage:
     * <code>
     * $query->filterByOptionSequence(1234); // WHERE lst_OptionSequence = 1234
     * $query->filterByOptionSequence(array(12, 34)); // WHERE lst_OptionSequence IN (12, 34)
     * $query->filterByOptionSequence(array('min' => 12)); // WHERE lst_OptionSequence > 12
     * </code>
     *
     * @param mixed $optionSequence The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOptionSequence($optionSequence = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('lst_OptionSequence');
        if (is_array($optionSequence)) {
            $useMinMax = false;
            if (isset($optionSequence['min'])) {
                $this->addUsingOperator($resolvedColumn, $optionSequence['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optionSequence['max'])) {
                $this->addUsingOperator($resolvedColumn, $optionSequence['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $optionSequence, $comparison);

        return $this;
    }

    /**
     * Filter the query on the lst_OptionName column
     *
     * Example usage:
     * <code>
     * $query->filterByOptionName('fooValue'); // WHERE lst_OptionName = 'fooValue'
     * $query->filterByOptionName('%fooValue%', Criteria::LIKE); // WHERE lst_OptionName LIKE '%fooValue%'
     * $query->filterByOptionName(['foo', 'bar']); // WHERE lst_OptionName IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $optionName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOptionName($optionName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('lst_OptionName');
        if ($comparison === null && is_array($optionName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $optionName, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Group object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Group|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Group> $group the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByGroup(Group|ObjectCollection $group, ?string $comparison = null)
    {
        if ($group instanceof Group) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('lst_ID'), $group->getRoleListId(), $comparison)
                ->addUsingOperator($this->resolveLocalColumnByName('lst_OptionID'), $group->getType(), $comparison);
        } else {
            throw new PropelException('filterByGroup() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Group');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the Group relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinGroup(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Group');

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
            $this->addJoinObject($join, 'Group');
        }

        return $this;
    }

    /**
     * Use the Group relation Group object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupQuery<static> A secondary query class using the current class as primary query
     */
    public function useGroupQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\GroupQuery<static> $query */
        $query = $this->joinGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Group', '\ChurchCRM\model\ChurchCRM\GroupQuery');

        return $query;
    }

    /**
     * Use the Group relation Group object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\GroupQuery<mixed>):\ChurchCRM\model\ChurchCRM\GroupQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withGroupQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useGroupQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Group table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupQuery<static> The inner query object of the EXISTS statement
     */
    public function useGroupExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\GroupQuery<static> $q */
        $q = $this->useExistsQuery('Group', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Group table for a NOT EXISTS query.
     *
     * @see useGroupExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useGroupNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\GroupQuery<static> $q*/
        $q = $this->useExistsQuery('Group', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Group table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupQuery<static> The inner query object of the IN statement
     */
    public function useInGroupQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\GroupQuery<static> $q */
        $q = $this->useInQuery('Group', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Group table for a NOT IN query.
     *
     * @see useGroupInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInGroupQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\GroupQuery<static> $q */
        $q = $this->useInQuery('Group', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\ListOption|null $listOption Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildListOption $listOption = null)
    {
        if ($listOption) {
            $pkFilter = $this->buildFilter($this->resolveLocalColumnByName('lst_ID'), $listOption->getId(), Criteria::NOT_EQUAL);
            $pkFilter->addOr($this->buildFilter($this->resolveLocalColumnByName('lst_OptionID'), $listOption->getOptionId(), Criteria::NOT_EQUAL));
            $this->addAnd($pkFilter);
        }

        return $this;
    }

    /**
     * Deletes all rows from the list_lst table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ListOptionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ListOptionTableMap::clearInstancePool();
            ListOptionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ListOptionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ListOptionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ListOptionTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            ListOptionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
