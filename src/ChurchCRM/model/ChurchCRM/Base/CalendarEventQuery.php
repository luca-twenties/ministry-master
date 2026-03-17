<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\CalendarEvent as ChildCalendarEvent;
use ChurchCRM\model\ChurchCRM\CalendarEventQuery as ChildCalendarEventQuery;
use ChurchCRM\model\ChurchCRM\Map\CalendarEventTableMap;
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
 * Base class that represents a query for the `calendar_events` table.
 *
 * This is a join-table to link an event with a calendar
 *
 * @method static orderByCalendarId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the calendar_id column
 * @method static orderByEventId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_id column
 *
 * @method static groupByCalendarId() Group by the calendar_id column
 * @method static groupByEventId() Group by the event_id column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinCalendar($relationAlias = null) Adds a LEFT JOIN clause to the query using the Calendar relation
 * @method static rightJoinCalendar($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Calendar relation
 * @method static innerJoinCalendar($relationAlias = null) Adds a INNER JOIN clause to the query using the Calendar relation
 *
 * @method static joinWithCalendar($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Calendar relation
 *
 * @method static leftJoinWithCalendar() Adds a LEFT JOIN clause and with to the query using the Calendar relation
 * @method static rightJoinWithCalendar() Adds a RIGHT JOIN clause and with to the query using the Calendar relation
 * @method static innerJoinWithCalendar() Adds a INNER JOIN clause and with to the query using the Calendar relation
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
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent matching the query
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent matching the query, or a new \ChurchCRM\model\ChurchCRM\CalendarEvent object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent|null findOneByCalendarId(int $calendar_id) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent filtered by the calendar_id column
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent|null findOneByEventId(int $event_id) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent filtered by the event_id column
 *
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\CalendarEvent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent requireOneByCalendarId(int $calendar_id) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent filtered by the calendar_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\CalendarEvent requireOneByEventId(int $event_id) Return the first \ChurchCRM\model\ChurchCRM\CalendarEvent filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection|array<\ChurchCRM\model\ChurchCRM\CalendarEvent>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\CalendarEvent> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\CalendarEvent objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\CalendarEvent objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\CalendarEvent>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\CalendarEvent> findByCalendarId(int|array<int> $calendar_id) Return \ChurchCRM\model\ChurchCRM\CalendarEvent objects filtered by the calendar_id column
 * @method array<\ChurchCRM\model\ChurchCRM\CalendarEvent>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\CalendarEvent> findByEventId(int|array<int> $event_id) Return \ChurchCRM\model\ChurchCRM\CalendarEvent objects filtered by the event_id column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\CalendarEvent>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class CalendarEventQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of CalendarEventQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\CalendarEvent',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCalendarEventQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarEventQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCalendarEventQuery) {
            return $criteria;
        }
        $query = new ChildCalendarEventQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\CalendarEvent|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CalendarEventTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
        $obj = CalendarEventTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\CalendarEvent|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildCalendarEvent
    {
        $sql = 'SELECT calendar_id, event_id FROM calendar_events WHERE calendar_id = :p0 AND event_id = :p1';
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
            $obj = new ChildCalendarEvent();
            $obj->hydrate($row);
            $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
            CalendarEventTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\CalendarEvent|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\CalendarEvent>|mixed|array the list of results, formatted by the current formatter
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
        $tableMap = CalendarEventTableMap::getTableMap();
        $resolvedColumn = $this->resolveLocalColumnByName('calendar_id');
        $this->addUsingOperator($resolvedColumn, $key[0], Criteria::EQUAL);
        $resolvedColumn = $this->resolveLocalColumnByName('event_id');
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

        $resolvedColumn0 = $this->resolveLocalColumnByName('calendar_id');
        $resolvedColumn1 = $this->resolveLocalColumnByName('event_id');

        foreach ($keys as $key) {
            $filter0 = $this->buildFilter($resolvedColumn0, $key[0], Criteria::EQUAL);
            $this->addOr($filter0);

            $filter1 = $this->buildFilter($resolvedColumn1, $key[1], Criteria::EQUAL);
            $filter0->addAnd($filter1);
        }

        return $this;
    }

    /**
     * Filter the query on the calendar_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCalendarId(1234); // WHERE calendar_id = 1234
     * $query->filterByCalendarId(array(12, 34)); // WHERE calendar_id IN (12, 34)
     * $query->filterByCalendarId(array('min' => 12)); // WHERE calendar_id > 12
     * </code>
     *
     * @see static::filterByCalendar()
     *
     * @param mixed $calendarId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCalendarId($calendarId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('calendar_id');
        if (is_array($calendarId)) {
            $useMinMax = false;
            if (isset($calendarId['min'])) {
                $this->addUsingOperator($resolvedColumn, $calendarId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($calendarId['max'])) {
                $this->addUsingOperator($resolvedColumn, $calendarId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $calendarId, $comparison);

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
     * Filter the query by a related Calendar object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Calendar|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Calendar> $calendar The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByCalendar($calendar, ?string $comparison = null)
    {
        if ($calendar instanceof Calendar) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('calendar_id'), $calendar->getId(), $comparison);
        } elseif ($calendar instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('calendar_id'), $calendar->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByCalendar() only accepts arguments of type Calendar or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Calendar relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinCalendar(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Calendar');

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
            $this->addJoinObject($join, 'Calendar');
        }

        return $this;
    }

    /**
     * Use the Calendar relation Calendar object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarQuery<static> A secondary query class using the current class as primary query
     */
    public function useCalendarQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarQuery<static> $query */
        $query = $this->joinCalendar($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Calendar', '\ChurchCRM\model\ChurchCRM\CalendarQuery');

        return $query;
    }

    /**
     * Use the Calendar relation Calendar object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\CalendarQuery<mixed>):\ChurchCRM\model\ChurchCRM\CalendarQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCalendarQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCalendarQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Calendar table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarQuery<static> The inner query object of the EXISTS statement
     */
    public function useCalendarExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarQuery<static> $q */
        $q = $this->useExistsQuery('Calendar', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Calendar table for a NOT EXISTS query.
     *
     * @see useCalendarExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useCalendarNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarQuery<static> $q*/
        $q = $this->useExistsQuery('Calendar', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Calendar table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarQuery<static> The inner query object of the IN statement
     */
    public function useInCalendarQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarQuery<static> $q */
        $q = $this->useInQuery('Calendar', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Calendar table for a NOT IN query.
     *
     * @see useCalendarInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInCalendarQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarQuery<static> $q */
        $q = $this->useInQuery('Calendar', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
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
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\CalendarEvent|null $calendarEvent Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildCalendarEvent $calendarEvent = null)
    {
        if ($calendarEvent) {
            $pkFilter = $this->buildFilter($this->resolveLocalColumnByName('calendar_id'), $calendarEvent->getCalendarId(), Criteria::NOT_EQUAL);
            $pkFilter->addOr($this->buildFilter($this->resolveLocalColumnByName('event_id'), $calendarEvent->getEventId(), Criteria::NOT_EQUAL));
            $this->addAnd($pkFilter);
        }

        return $this;
    }

    /**
     * Deletes all rows from the calendar_events table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarEventTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CalendarEventTableMap::clearInstancePool();
            CalendarEventTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarEventTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CalendarEventTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CalendarEventTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            CalendarEventTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
