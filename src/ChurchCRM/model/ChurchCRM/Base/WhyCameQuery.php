<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\WhyCameTableMap;
use ChurchCRM\model\ChurchCRM\WhyCame as ChildWhyCame;
use ChurchCRM\model\ChurchCRM\WhyCameQuery as ChildWhyCameQuery;
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
 * Base class that represents a query for the `whycame_why` table.
 *
 * This contains the comments related to why people came
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the why_ID column
 * @method static orderByPerId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the why_per_ID column
 * @method static orderByJoin($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the why_join column
 * @method static orderByCome($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the why_come column
 * @method static orderBySuggest($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the why_suggest column
 * @method static orderByHearOfUs($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the why_hearOfUs column
 *
 * @method static groupById() Group by the why_ID column
 * @method static groupByPerId() Group by the why_per_ID column
 * @method static groupByJoin() Group by the why_join column
 * @method static groupByCome() Group by the why_come column
 * @method static groupBySuggest() Group by the why_suggest column
 * @method static groupByHearOfUs() Group by the why_hearOfUs column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method static rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method static innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method static joinWithPerson($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method static leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method static rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method static innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\WhyCame matching the query
 * @method \ChurchCRM\model\ChurchCRM\WhyCame findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\WhyCame matching the query, or a new \ChurchCRM\model\ChurchCRM\WhyCame object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOneById(int $why_ID) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_ID column
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOneByPerId(int $why_per_ID) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_per_ID column
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOneByJoin(string $why_join) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_join column
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOneByCome(string $why_come) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_come column
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOneBySuggest(string $why_suggest) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_suggest column
 * @method \ChurchCRM\model\ChurchCRM\WhyCame|null findOneByHearOfUs(string $why_hearOfUs) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_hearOfUs column
 *
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\WhyCame by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\WhyCame matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOneById(int $why_ID) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOneByPerId(int $why_per_ID) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_per_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOneByJoin(string $why_join) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_join column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOneByCome(string $why_come) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_come column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOneBySuggest(string $why_suggest) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_suggest column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\WhyCame requireOneByHearOfUs(string $why_hearOfUs) Return the first \ChurchCRM\model\ChurchCRM\WhyCame filtered by the why_hearOfUs column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\WhyCameCollection|array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\WhyCame objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\WhyCameCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\WhyCame objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> findById(int|array<int> $why_ID) Return \ChurchCRM\model\ChurchCRM\WhyCame objects filtered by the why_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> findByPerId(int|array<int> $why_per_ID) Return \ChurchCRM\model\ChurchCRM\WhyCame objects filtered by the why_per_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> findByJoin(string|array<string> $why_join) Return \ChurchCRM\model\ChurchCRM\WhyCame objects filtered by the why_join column
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> findByCome(string|array<string> $why_come) Return \ChurchCRM\model\ChurchCRM\WhyCame objects filtered by the why_come column
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> findBySuggest(string|array<string> $why_suggest) Return \ChurchCRM\model\ChurchCRM\WhyCame objects filtered by the why_suggest column
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\WhyCame> findByHearOfUs(string|array<string> $why_hearOfUs) Return \ChurchCRM\model\ChurchCRM\WhyCame objects filtered by the why_hearOfUs column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\WhyCame>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class WhyCameQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of WhyCameQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\WhyCame',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWhyCameQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\WhyCameQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildWhyCameQuery) {
            return $criteria;
        }
        $query = new ChildWhyCameQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\WhyCame|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WhyCameTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = WhyCameTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\WhyCame|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildWhyCame
    {
        $sql = 'SELECT why_ID, why_per_ID, why_join, why_come, why_suggest, why_hearOfUs FROM whycame_why WHERE why_ID = :p0';
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
            $obj = new ChildWhyCame();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            WhyCameTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\WhyCame|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\WhyCame>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('why_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('why_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the why_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE why_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE why_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE why_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('why_ID');
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
     * Filter the query on the why_per_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByPerId(1234); // WHERE why_per_ID = 1234
     * $query->filterByPerId(array(12, 34)); // WHERE why_per_ID IN (12, 34)
     * $query->filterByPerId(array('min' => 12)); // WHERE why_per_ID > 12
     * </code>
     *
     * @see static::filterByPerson()
     *
     * @param mixed $perId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPerId($perId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('why_per_ID');
        if (is_array($perId)) {
            $useMinMax = false;
            if (isset($perId['min'])) {
                $this->addUsingOperator($resolvedColumn, $perId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perId['max'])) {
                $this->addUsingOperator($resolvedColumn, $perId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $perId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the why_join column
     *
     * Example usage:
     * <code>
     * $query->filterByJoin('fooValue'); // WHERE why_join = 'fooValue'
     * $query->filterByJoin('%fooValue%', Criteria::LIKE); // WHERE why_join LIKE '%fooValue%'
     * $query->filterByJoin(['foo', 'bar']); // WHERE why_join IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $join The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByJoin($join = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('why_join');
        if ($comparison === null && is_array($join)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $join, $comparison);

        return $this;
    }

    /**
     * Filter the query on the why_come column
     *
     * Example usage:
     * <code>
     * $query->filterByCome('fooValue'); // WHERE why_come = 'fooValue'
     * $query->filterByCome('%fooValue%', Criteria::LIKE); // WHERE why_come LIKE '%fooValue%'
     * $query->filterByCome(['foo', 'bar']); // WHERE why_come IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $come The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCome($come = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('why_come');
        if ($comparison === null && is_array($come)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $come, $comparison);

        return $this;
    }

    /**
     * Filter the query on the why_suggest column
     *
     * Example usage:
     * <code>
     * $query->filterBySuggest('fooValue'); // WHERE why_suggest = 'fooValue'
     * $query->filterBySuggest('%fooValue%', Criteria::LIKE); // WHERE why_suggest LIKE '%fooValue%'
     * $query->filterBySuggest(['foo', 'bar']); // WHERE why_suggest IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $suggest The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySuggest($suggest = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('why_suggest');
        if ($comparison === null && is_array($suggest)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $suggest, $comparison);

        return $this;
    }

    /**
     * Filter the query on the why_hearOfUs column
     *
     * Example usage:
     * <code>
     * $query->filterByHearOfUs('fooValue'); // WHERE why_hearOfUs = 'fooValue'
     * $query->filterByHearOfUs('%fooValue%', Criteria::LIKE); // WHERE why_hearOfUs LIKE '%fooValue%'
     * $query->filterByHearOfUs(['foo', 'bar']); // WHERE why_hearOfUs IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $hearOfUs The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByHearOfUs($hearOfUs = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('why_hearOfUs');
        if ($comparison === null && is_array($hearOfUs)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $hearOfUs, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Person object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person> $person The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByPerson($person, ?string $comparison = null)
    {
        if ($person instanceof Person) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('why_per_ID'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('why_per_ID'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Person relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPerson(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person');

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
            $this->addJoinObject($join, 'Person');
        }

        return $this;
    }

    /**
     * Use the Person relation Person object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> A secondary query class using the current class as primary query
     */
    public function usePersonQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $query */
        $query = $this->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Person', '\ChurchCRM\model\ChurchCRM\PersonQuery');

        return $query;
    }

    /**
     * Use the Person relation Person object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PersonQuery<mixed>):\ChurchCRM\model\ChurchCRM\PersonQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPersonQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePersonQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Person table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the EXISTS statement
     */
    public function usePersonExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useExistsQuery('Person', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Person table for a NOT EXISTS query.
     *
     * @see usePersonExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePersonNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q*/
        $q = $this->useExistsQuery('Person', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Person table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the IN statement
     */
    public function useInPersonQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('Person', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Person table for a NOT IN query.
     *
     * @see usePersonInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPersonQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('Person', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\WhyCame|null $whyCame Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildWhyCame $whyCame = null)
    {
        if ($whyCame) {
            $resolvedColumn = $this->resolveLocalColumnByName('why_ID');
            $this->addUsingOperator($resolvedColumn, $whyCame->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the whycame_why table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WhyCameTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WhyCameTableMap::clearInstancePool();
            WhyCameTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WhyCameTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WhyCameTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WhyCameTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            WhyCameTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
