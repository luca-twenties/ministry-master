<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\EventType as ChildEventType;
use ChurchCRM\model\ChurchCRM\EventTypeQuery as ChildEventTypeQuery;
use ChurchCRM\model\ChurchCRM\Map\EventTypeTableMap;
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
 * Base class that represents a query for the `event_types` table.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_id column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_name column
 * @method static orderByDefStartTime($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_defstarttime column
 * @method static orderByDefRecurType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_defrecurtype column
 * @method static orderByDefRecurDOW($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_defrecurDOW column
 * @method static orderByDefRecurDOM($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_defrecurDOM column
 * @method static orderByDefRecurDOY($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_defrecurDOY column
 * @method static orderByActive($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_active column
 * @method static orderByGroupId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_grpid column
 *
 * @method static groupById() Group by the type_id column
 * @method static groupByName() Group by the type_name column
 * @method static groupByDefStartTime() Group by the type_defstarttime column
 * @method static groupByDefRecurType() Group by the type_defrecurtype column
 * @method static groupByDefRecurDOW() Group by the type_defrecurDOW column
 * @method static groupByDefRecurDOM() Group by the type_defrecurDOM column
 * @method static groupByDefRecurDOY() Group by the type_defrecurDOY column
 * @method static groupByActive() Group by the type_active column
 * @method static groupByGroupId() Group by the type_grpid column
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
 * @method static leftJoinEventType($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventType relation
 * @method static rightJoinEventType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventType relation
 * @method static innerJoinEventType($relationAlias = null) Adds a INNER JOIN clause to the query using the EventType relation
 *
 * @method static joinWithEventType($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the EventType relation
 *
 * @method static leftJoinWithEventType() Adds a LEFT JOIN clause and with to the query using the EventType relation
 * @method static rightJoinWithEventType() Adds a RIGHT JOIN clause and with to the query using the EventType relation
 * @method static innerJoinWithEventType() Adds a INNER JOIN clause and with to the query using the EventType relation
 *
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventType matching the query
 * @method \ChurchCRM\model\ChurchCRM\EventType findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventType matching the query, or a new \ChurchCRM\model\ChurchCRM\EventType object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneById(int $type_id) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_id column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByName(string $type_name) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_name column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByDefStartTime(string $type_defstarttime) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defstarttime column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByDefRecurType(string $type_defrecurtype) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurtype column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByDefRecurDOW(string $type_defrecurDOW) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurDOW column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByDefRecurDOM(string $type_defrecurDOM) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurDOM column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByDefRecurDOY(string $type_defrecurDOY) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurDOY column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByActive(int $type_active) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_active column
 * @method \ChurchCRM\model\ChurchCRM\EventType|null findOneByGroupId(int $type_grpid) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_grpid column
 *
 * @method \ChurchCRM\model\ChurchCRM\EventType requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\EventType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneById(int $type_id) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByName(string $type_name) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByDefStartTime(string $type_defstarttime) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defstarttime column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByDefRecurType(string $type_defrecurtype) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurtype column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByDefRecurDOW(string $type_defrecurDOW) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurDOW column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByDefRecurDOM(string $type_defrecurDOM) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurDOM column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByDefRecurDOY(string $type_defrecurDOY) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_defrecurDOY column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByActive(int $type_active) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventType requireOneByGroupId(int $type_grpid) Return the first \ChurchCRM\model\ChurchCRM\EventType filtered by the type_grpid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection|array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\EventType objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\EventType objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findById(int|array<int> $type_id) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_id column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByName(string|array<string> $type_name) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_name column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByDefStartTime(string|array<string> $type_defstarttime) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_defstarttime column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByDefRecurType(string|array<string> $type_defrecurtype) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_defrecurtype column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByDefRecurDOW(string|array<string> $type_defrecurDOW) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_defrecurDOW column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByDefRecurDOM(string|array<string> $type_defrecurDOM) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_defrecurDOM column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByDefRecurDOY(string|array<string> $type_defrecurDOY) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_defrecurDOY column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByActive(int|array<int> $type_active) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_active column
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventType> findByGroupId(int|array<int> $type_grpid) Return \ChurchCRM\model\ChurchCRM\EventType objects filtered by the type_grpid column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventType>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class EventTypeQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of EventTypeQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\EventType',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventTypeQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\EventTypeQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildEventTypeQuery) {
            return $criteria;
        }
        $query = new ChildEventTypeQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventType|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventTypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = EventTypeTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\EventType|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildEventType
    {
        $sql = 'SELECT type_id, type_name, type_defstarttime, type_defrecurtype, type_defrecurDOW, type_defrecurDOM, type_defrecurDOY, type_active, type_grpid FROM event_types WHERE type_id = :p0';
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
            $obj = new ChildEventType();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            EventTypeTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventType|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventType>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('type_id');
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
        $resolvedColumn = $this->resolveLocalColumnByName('type_id');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the type_id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE type_id = 1234
     * $query->filterById(array(12, 34)); // WHERE type_id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE type_id > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('type_id');
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
     * Filter the query on the type_name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE type_name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE type_name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE type_name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_defstarttime column
     *
     * Example usage:
     * <code>
     * $query->filterByDefStartTime('2011-03-14'); // WHERE type_defstarttime = '2011-03-14'
     * $query->filterByDefStartTime('now'); // WHERE type_defstarttime = '2011-03-14'
     * $query->filterByDefStartTime(array('max' => 'yesterday')); // WHERE type_defstarttime > '2011-03-13'
     * </code>
     *
     * @param mixed $defStartTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefStartTime($defStartTime = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_defstarttime');
        if (is_array($defStartTime)) {
            $useMinMax = false;
            if (isset($defStartTime['min'])) {
                $this->addUsingOperator($resolvedColumn, $defStartTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defStartTime['max'])) {
                $this->addUsingOperator($resolvedColumn, $defStartTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $defStartTime, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_defrecurtype column
     *
     * Example usage:
     * <code>
     * $query->filterByDefRecurType('fooValue'); // WHERE type_defrecurtype = 'fooValue'
     * $query->filterByDefRecurType('%fooValue%', Criteria::LIKE); // WHERE type_defrecurtype LIKE '%fooValue%'
     * $query->filterByDefRecurType(['foo', 'bar']); // WHERE type_defrecurtype IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $defRecurType The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefRecurType($defRecurType = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_defrecurtype');
        if ($comparison === null && is_array($defRecurType)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $defRecurType, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_defrecurDOW column
     *
     * Example usage:
     * <code>
     * $query->filterByDefRecurDOW('fooValue'); // WHERE type_defrecurDOW = 'fooValue'
     * $query->filterByDefRecurDOW('%fooValue%', Criteria::LIKE); // WHERE type_defrecurDOW LIKE '%fooValue%'
     * $query->filterByDefRecurDOW(['foo', 'bar']); // WHERE type_defrecurDOW IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $defRecurDOW The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefRecurDOW($defRecurDOW = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_defrecurDOW');
        if ($comparison === null && is_array($defRecurDOW)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $defRecurDOW, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_defrecurDOM column
     *
     * Example usage:
     * <code>
     * $query->filterByDefRecurDOM('fooValue'); // WHERE type_defrecurDOM = 'fooValue'
     * $query->filterByDefRecurDOM('%fooValue%', Criteria::LIKE); // WHERE type_defrecurDOM LIKE '%fooValue%'
     * $query->filterByDefRecurDOM(['foo', 'bar']); // WHERE type_defrecurDOM IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $defRecurDOM The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefRecurDOM($defRecurDOM = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_defrecurDOM');
        if ($comparison === null && is_array($defRecurDOM)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $defRecurDOM, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_defrecurDOY column
     *
     * Example usage:
     * <code>
     * $query->filterByDefRecurDOY('2011-03-14'); // WHERE type_defrecurDOY = '2011-03-14'
     * $query->filterByDefRecurDOY('now'); // WHERE type_defrecurDOY = '2011-03-14'
     * $query->filterByDefRecurDOY(array('max' => 'yesterday')); // WHERE type_defrecurDOY > '2011-03-13'
     * </code>
     *
     * @param mixed $defRecurDOY The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefRecurDOY($defRecurDOY = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_defrecurDOY');
        if (is_array($defRecurDOY)) {
            $useMinMax = false;
            if (isset($defRecurDOY['min'])) {
                $this->addUsingOperator($resolvedColumn, $defRecurDOY['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defRecurDOY['max'])) {
                $this->addUsingOperator($resolvedColumn, $defRecurDOY['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $defRecurDOY, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(1234); // WHERE type_active = 1234
     * $query->filterByActive(array(12, 34)); // WHERE type_active IN (12, 34)
     * $query->filterByActive(array('min' => 12)); // WHERE type_active > 12
     * </code>
     *
     * @param mixed $active The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByActive($active = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_active');
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingOperator($resolvedColumn, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingOperator($resolvedColumn, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $active, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_grpid column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupId(1234); // WHERE type_grpid = 1234
     * $query->filterByGroupId(array(12, 34)); // WHERE type_grpid IN (12, 34)
     * $query->filterByGroupId(array('min' => 12)); // WHERE type_grpid > 12
     * </code>
     *
     * @see static::filterByGroup()
     *
     * @param mixed $groupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByGroupId($groupId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_grpid');
        if (is_array($groupId)) {
            $useMinMax = false;
            if (isset($groupId['min'])) {
                $this->addUsingOperator($resolvedColumn, $groupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupId['max'])) {
                $this->addUsingOperator($resolvedColumn, $groupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $groupId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Group object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Group|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Group> $group The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByGroup($group, ?string $comparison = null)
    {
        if ($group instanceof Group) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('type_grpid'), $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('type_grpid'), $group->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByGroup() only accepts arguments of type Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Group relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinGroup(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
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
    public function useGroupQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
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
        ?string $joinType = Criteria::LEFT_JOIN
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
     * Filter the query by a related EventType object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event> $event the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByEventType(Event|ObjectCollection $event, ?string $comparison = null)
    {
        if ($event instanceof Event) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('type_id'), $event->getType(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            $this
                ->useEventTypeQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventType() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Event or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the EventType relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinEventType(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventType');

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
            $this->addJoinObject($join, 'EventType');
        }

        return $this;
    }

    /**
     * Use the EventType relation Event object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> A secondary query class using the current class as primary query
     */
    public function useEventTypeQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $query */
        $query = $this->joinEventType($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'EventType', '\ChurchCRM\model\ChurchCRM\EventQuery');

        return $query;
    }

    /**
     * Use the EventType relation Event object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEventTypeQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useEventTypeQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the EventType relation to the Event table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the EXISTS statement
     */
    public function useEventTypeExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useExistsQuery('EventType', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the EventType relation to the Event table for a NOT EXISTS query.
     *
     * @see useEventTypeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useEventTypeNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q*/
        $q = $this->useExistsQuery('EventType', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the EventType relation to the Event table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the IN statement
     */
    public function useInEventTypeQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('EventType', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the EventType relation to the Event table for a NOT IN query.
     *
     * @see useEventTypeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInEventTypeQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('EventType', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\EventType|null $eventType Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildEventType $eventType = null)
    {
        if ($eventType) {
            $resolvedColumn = $this->resolveLocalColumnByName('type_id');
            $this->addUsingOperator($resolvedColumn, $eventType->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the event_types table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventTypeTableMap::clearInstancePool();
            EventTypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventTypeTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            EventTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
