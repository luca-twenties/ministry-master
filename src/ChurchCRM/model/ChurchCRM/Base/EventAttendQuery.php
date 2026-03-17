<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\EventAttend as ChildEventAttend;
use ChurchCRM\model\ChurchCRM\EventAttendQuery as ChildEventAttendQuery;
use ChurchCRM\model\ChurchCRM\Map\EventAttendTableMap;
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
 * Base class that represents a query for the `event_attend` table.
 *
 * this indicates which people attended which events
 *
 * @method static orderByAttendId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the attend_id column
 * @method static orderByEventId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_id column
 * @method static orderByPersonId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the person_id column
 * @method static orderByCheckinDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the checkin_date column
 * @method static orderByCheckinId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the checkin_id column
 * @method static orderByCheckoutDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the checkout_date column
 * @method static orderByCheckoutId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the checkout_id column
 *
 * @method static groupByAttendId() Group by the attend_id column
 * @method static groupByEventId() Group by the event_id column
 * @method static groupByPersonId() Group by the person_id column
 * @method static groupByCheckinDate() Group by the checkin_date column
 * @method static groupByCheckinId() Group by the checkin_id column
 * @method static groupByCheckoutDate() Group by the checkout_date column
 * @method static groupByCheckoutId() Group by the checkout_id column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method static rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method static innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method static joinWithEvent($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method static leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method static rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method static innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
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
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventAttend matching the query
 * @method \ChurchCRM\model\ChurchCRM\EventAttend findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventAttend matching the query, or a new \ChurchCRM\model\ChurchCRM\EventAttend object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByAttendId(int $attend_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the attend_id column
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByEventId(int $event_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the event_id column
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByPersonId(int $person_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the person_id column
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByCheckinDate(string $checkin_date) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkin_date column
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByCheckinId(int $checkin_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkin_id column
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByCheckoutDate(string $checkout_date) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkout_date column
 * @method \ChurchCRM\model\ChurchCRM\EventAttend|null findOneByCheckoutId(int $checkout_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkout_id column
 *
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\EventAttend by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventAttend matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByAttendId(int $attend_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the attend_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByEventId(int $event_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByPersonId(int $person_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByCheckinDate(string $checkin_date) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkin_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByCheckinId(int $checkin_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkin_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByCheckoutDate(string $checkout_date) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkout_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventAttend requireOneByCheckoutId(int $checkout_id) Return the first \ChurchCRM\model\ChurchCRM\EventAttend filtered by the checkout_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection|array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\EventAttend objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\EventAttend objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByAttendId(int|array<int> $attend_id) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the attend_id column
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByEventId(int|array<int> $event_id) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the event_id column
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByPersonId(int|array<int> $person_id) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the person_id column
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByCheckinDate(string|array<string> $checkin_date) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the checkin_date column
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByCheckinId(int|array<int> $checkin_id) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the checkin_id column
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByCheckoutDate(string|array<string> $checkout_date) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the checkout_date column
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventAttend> findByCheckoutId(int|array<int> $checkout_id) Return \ChurchCRM\model\ChurchCRM\EventAttend objects filtered by the checkout_id column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventAttend>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class EventAttendQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of EventAttendQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\EventAttend',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventAttendQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildEventAttendQuery) {
            return $criteria;
        }
        $query = new ChildEventAttendQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventAttend|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventAttendTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = EventAttendTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\EventAttend|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildEventAttend
    {
        $sql = 'SELECT attend_id, event_id, person_id, checkin_date, checkin_id, checkout_date, checkout_id FROM event_attend WHERE attend_id = :p0';
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
            $obj = new ChildEventAttend();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            EventAttendTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventAttend|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventAttend>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('attend_id');
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
        $resolvedColumn = $this->resolveLocalColumnByName('attend_id');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the attend_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAttendId(1234); // WHERE attend_id = 1234
     * $query->filterByAttendId(array(12, 34)); // WHERE attend_id IN (12, 34)
     * $query->filterByAttendId(array('min' => 12)); // WHERE attend_id > 12
     * </code>
     *
     * @param mixed $attendId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAttendId($attendId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('attend_id');
        if (is_array($attendId)) {
            $useMinMax = false;
            if (isset($attendId['min'])) {
                $this->addUsingOperator($resolvedColumn, $attendId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($attendId['max'])) {
                $this->addUsingOperator($resolvedColumn, $attendId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $attendId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEventId(1234); // WHERE event_id = 1234
     * $query->filterByEventId(array(12, 34)); // WHERE event_id IN (12, 34)
     * $query->filterByEventId(array('min' => 12)); // WHERE event_id > 12
     * </code>
     *
     * @see static::filterByEvent()
     *
     * @param mixed $eventId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEventId($eventId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_id');
        if (is_array($eventId)) {
            $useMinMax = false;
            if (isset($eventId['min'])) {
                $this->addUsingOperator($resolvedColumn, $eventId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventId['max'])) {
                $this->addUsingOperator($resolvedColumn, $eventId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $eventId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the person_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonId(1234); // WHERE person_id = 1234
     * $query->filterByPersonId(array(12, 34)); // WHERE person_id IN (12, 34)
     * $query->filterByPersonId(array('min' => 12)); // WHERE person_id > 12
     * </code>
     *
     * @see static::filterByPerson()
     *
     * @param mixed $personId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPersonId($personId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('person_id');
        if (is_array($personId)) {
            $useMinMax = false;
            if (isset($personId['min'])) {
                $this->addUsingOperator($resolvedColumn, $personId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($personId['max'])) {
                $this->addUsingOperator($resolvedColumn, $personId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $personId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the checkin_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCheckinDate('2011-03-14'); // WHERE checkin_date = '2011-03-14'
     * $query->filterByCheckinDate('now'); // WHERE checkin_date = '2011-03-14'
     * $query->filterByCheckinDate(array('max' => 'yesterday')); // WHERE checkin_date > '2011-03-13'
     * </code>
     *
     * @param mixed $checkinDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCheckinDate($checkinDate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('checkin_date');
        if (is_array($checkinDate)) {
            $useMinMax = false;
            if (isset($checkinDate['min'])) {
                $this->addUsingOperator($resolvedColumn, $checkinDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($checkinDate['max'])) {
                $this->addUsingOperator($resolvedColumn, $checkinDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $checkinDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the checkin_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCheckinId(1234); // WHERE checkin_id = 1234
     * $query->filterByCheckinId(array(12, 34)); // WHERE checkin_id IN (12, 34)
     * $query->filterByCheckinId(array('min' => 12)); // WHERE checkin_id > 12
     * </code>
     *
     * @param mixed $checkinId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCheckinId($checkinId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('checkin_id');
        if (is_array($checkinId)) {
            $useMinMax = false;
            if (isset($checkinId['min'])) {
                $this->addUsingOperator($resolvedColumn, $checkinId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($checkinId['max'])) {
                $this->addUsingOperator($resolvedColumn, $checkinId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $checkinId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the checkout_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCheckoutDate('2011-03-14'); // WHERE checkout_date = '2011-03-14'
     * $query->filterByCheckoutDate('now'); // WHERE checkout_date = '2011-03-14'
     * $query->filterByCheckoutDate(array('max' => 'yesterday')); // WHERE checkout_date > '2011-03-13'
     * </code>
     *
     * @param mixed $checkoutDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCheckoutDate($checkoutDate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('checkout_date');
        if (is_array($checkoutDate)) {
            $useMinMax = false;
            if (isset($checkoutDate['min'])) {
                $this->addUsingOperator($resolvedColumn, $checkoutDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($checkoutDate['max'])) {
                $this->addUsingOperator($resolvedColumn, $checkoutDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $checkoutDate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the checkout_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCheckoutId(1234); // WHERE checkout_id = 1234
     * $query->filterByCheckoutId(array(12, 34)); // WHERE checkout_id IN (12, 34)
     * $query->filterByCheckoutId(array('min' => 12)); // WHERE checkout_id > 12
     * </code>
     *
     * @param mixed $checkoutId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCheckoutId($checkoutId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('checkout_id');
        if (is_array($checkoutId)) {
            $useMinMax = false;
            if (isset($checkoutId['min'])) {
                $this->addUsingOperator($resolvedColumn, $checkoutId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($checkoutId['max'])) {
                $this->addUsingOperator($resolvedColumn, $checkoutId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $checkoutId, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Event object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event> $event The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByEvent($event, ?string $comparison = null)
    {
        if ($event instanceof Event) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_id'), $event->getId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_id'), $event->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByEvent() only accepts arguments of type Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Event relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinEvent(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Event');

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
            $this->addJoinObject($join, 'Event');
        }

        return $this;
    }

    /**
     * Use the Event relation Event object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> A secondary query class using the current class as primary query
     */
    public function useEventQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $query */
        $query = $this->joinEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Event', '\ChurchCRM\model\ChurchCRM\EventQuery');

        return $query;
    }

    /**
     * Use the Event relation Event object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEventQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useEventQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Event table for an EXISTS query.
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
    public function useEventExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useExistsQuery('Event', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Event table for a NOT EXISTS query.
     *
     * @see useEventExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useEventNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q*/
        $q = $this->useExistsQuery('Event', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Event table for an IN query.
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
    public function useInEventQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('Event', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Event table for a NOT IN query.
     *
     * @see useEventInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInEventQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventQuery<static> $q */
        $q = $this->useInQuery('Event', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
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
                ->addUsingOperator($this->resolveLocalColumnByName('person_id'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('person_id'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

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
     * @param \ChurchCRM\model\ChurchCRM\EventAttend|null $eventAttend Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildEventAttend $eventAttend = null)
    {
        if ($eventAttend) {
            $resolvedColumn = $this->resolveLocalColumnByName('attend_id');
            $this->addUsingOperator($resolvedColumn, $eventAttend->getAttendId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the event_attend table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventAttendTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventAttendTableMap::clearInstancePool();
            EventAttendTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventAttendTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventAttendTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventAttendTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            EventAttendTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
