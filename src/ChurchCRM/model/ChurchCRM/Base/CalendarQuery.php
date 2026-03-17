<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Calendar as ChildCalendar;
use ChurchCRM\model\ChurchCRM\CalendarQuery as ChildCalendarQuery;
use ChurchCRM\model\ChurchCRM\Map\CalendarTableMap;
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
 * Base class that represents a query for the `calendars` table.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the calendar_id column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the name column
 * @method static orderByAccessToken($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the accesstoken column
 * @method static orderByBackgroundColor($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the backgroundColor column
 * @method static orderByForegroundColor($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the foregroundColor column
 *
 * @method static groupById() Group by the calendar_id column
 * @method static groupByName() Group by the name column
 * @method static groupByAccessToken() Group by the accesstoken column
 * @method static groupByBackgroundColor() Group by the backgroundColor column
 * @method static groupByForegroundColor() Group by the foregroundColor column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinCalendarEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the CalendarEvent relation
 * @method static rightJoinCalendarEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CalendarEvent relation
 * @method static innerJoinCalendarEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the CalendarEvent relation
 *
 * @method static joinWithCalendarEvent($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the CalendarEvent relation
 *
 * @method static leftJoinWithCalendarEvent() Adds a LEFT JOIN clause and with to the query using the CalendarEvent relation
 * @method static rightJoinWithCalendarEvent() Adds a RIGHT JOIN clause and with to the query using the CalendarEvent relation
 * @method static innerJoinWithCalendarEvent() Adds a INNER JOIN clause and with to the query using the CalendarEvent relation
 *
 * @method \ChurchCRM\model\ChurchCRM\Calendar|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Calendar matching the query
 * @method \ChurchCRM\model\ChurchCRM\Calendar findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Calendar matching the query, or a new \ChurchCRM\model\ChurchCRM\Calendar object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Calendar|null findOneById(int $calendar_id) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the calendar_id column
 * @method \ChurchCRM\model\ChurchCRM\Calendar|null findOneByName(string $name) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the name column
 * @method \ChurchCRM\model\ChurchCRM\Calendar|null findOneByAccessToken(string $accesstoken) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the accesstoken column
 * @method \ChurchCRM\model\ChurchCRM\Calendar|null findOneByBackgroundColor(string $backgroundColor) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the backgroundColor column
 * @method \ChurchCRM\model\ChurchCRM\Calendar|null findOneByForegroundColor(string $foregroundColor) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the foregroundColor column
 *
 * @method \ChurchCRM\model\ChurchCRM\Calendar requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Calendar by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Calendar requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Calendar matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Calendar requireOneById(int $calendar_id) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the calendar_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Calendar requireOneByName(string $name) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Calendar requireOneByAccessToken(string $accesstoken) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the accesstoken column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Calendar requireOneByBackgroundColor(string $backgroundColor) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the backgroundColor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Calendar requireOneByForegroundColor(string $foregroundColor) Return the first \ChurchCRM\model\ChurchCRM\Calendar filtered by the foregroundColor column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarCollection|array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Calendar> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Calendar objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Calendar objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Calendar> findById(int|array<int> $calendar_id) Return \ChurchCRM\model\ChurchCRM\Calendar objects filtered by the calendar_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Calendar> findByName(string|array<string> $name) Return \ChurchCRM\model\ChurchCRM\Calendar objects filtered by the name column
 * @method array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Calendar> findByAccessToken(string|array<string> $accesstoken) Return \ChurchCRM\model\ChurchCRM\Calendar objects filtered by the accesstoken column
 * @method array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Calendar> findByBackgroundColor(string|array<string> $backgroundColor) Return \ChurchCRM\model\ChurchCRM\Calendar objects filtered by the backgroundColor column
 * @method array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Calendar> findByForegroundColor(string|array<string> $foregroundColor) Return \ChurchCRM\model\ChurchCRM\Calendar objects filtered by the foregroundColor column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Calendar>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class CalendarQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of CalendarQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Calendar',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCalendarQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCalendarQuery) {
            return $criteria;
        }
        $query = new ChildCalendarQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Calendar|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CalendarTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = CalendarTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Calendar|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildCalendar
    {
        $sql = 'SELECT calendar_id, name, accesstoken, backgroundColor, foregroundColor FROM calendars WHERE calendar_id = :p0';
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
            $obj = new ChildCalendar();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            CalendarTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Calendar|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Calendar>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('calendar_id');
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
        $resolvedColumn = $this->resolveLocalColumnByName('calendar_id');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the calendar_id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE calendar_id = 1234
     * $query->filterById(array(12, 34)); // WHERE calendar_id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE calendar_id > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('calendar_id');
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
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the accesstoken column
     *
     * Example usage:
     * <code>
     * $query->filterByAccessToken('fooValue'); // WHERE accesstoken = 'fooValue'
     * $query->filterByAccessToken('%fooValue%', Criteria::LIKE); // WHERE accesstoken LIKE '%fooValue%'
     * $query->filterByAccessToken(['foo', 'bar']); // WHERE accesstoken IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $accessToken The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAccessToken($accessToken = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('accesstoken');
        if ($comparison === null && is_array($accessToken)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $accessToken, $comparison);

        return $this;
    }

    /**
     * Filter the query on the backgroundColor column
     *
     * Example usage:
     * <code>
     * $query->filterByBackgroundColor('fooValue'); // WHERE backgroundColor = 'fooValue'
     * $query->filterByBackgroundColor('%fooValue%', Criteria::LIKE); // WHERE backgroundColor LIKE '%fooValue%'
     * $query->filterByBackgroundColor(['foo', 'bar']); // WHERE backgroundColor IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $backgroundColor The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByBackgroundColor($backgroundColor = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('backgroundColor');
        if ($comparison === null && is_array($backgroundColor)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $backgroundColor, $comparison);

        return $this;
    }

    /**
     * Filter the query on the foregroundColor column
     *
     * Example usage:
     * <code>
     * $query->filterByForegroundColor('fooValue'); // WHERE foregroundColor = 'fooValue'
     * $query->filterByForegroundColor('%fooValue%', Criteria::LIKE); // WHERE foregroundColor LIKE '%fooValue%'
     * $query->filterByForegroundColor(['foo', 'bar']); // WHERE foregroundColor IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $foregroundColor The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByForegroundColor($foregroundColor = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('foregroundColor');
        if ($comparison === null && is_array($foregroundColor)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $foregroundColor, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related CalendarEvent object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\CalendarEvent|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\CalendarEvent> $calendarEvent the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByCalendarEvent(CalendarEvent|ObjectCollection $calendarEvent, ?string $comparison = null)
    {
        if ($calendarEvent instanceof CalendarEvent) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('calendar_id'), $calendarEvent->getCalendarId(), $comparison);
        } elseif ($calendarEvent instanceof ObjectCollection) {
            $this
                ->useCalendarEventQuery()
                ->filterByPrimaryKeys($calendarEvent->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCalendarEvent() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\CalendarEvent or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the CalendarEvent relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinCalendarEvent(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CalendarEvent');

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
            $this->addJoinObject($join, 'CalendarEvent');
        }

        return $this;
    }

    /**
     * Use the CalendarEvent relation CalendarEvent object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> A secondary query class using the current class as primary query
     */
    public function useCalendarEventQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> $query */
        $query = $this->joinCalendarEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'CalendarEvent', '\ChurchCRM\model\ChurchCRM\CalendarEventQuery');

        return $query;
    }

    /**
     * Use the CalendarEvent relation CalendarEvent object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\CalendarEventQuery<mixed>):\ChurchCRM\model\ChurchCRM\CalendarEventQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withCalendarEventQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useCalendarEventQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to CalendarEvent table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> The inner query object of the EXISTS statement
     */
    public function useCalendarEventExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> $q */
        $q = $this->useExistsQuery('CalendarEvent', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to CalendarEvent table for a NOT EXISTS query.
     *
     * @see useCalendarEventExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useCalendarEventNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> $q*/
        $q = $this->useExistsQuery('CalendarEvent', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to CalendarEvent table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> The inner query object of the IN statement
     */
    public function useInCalendarEventQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> $q */
        $q = $this->useInQuery('CalendarEvent', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to CalendarEvent table for a NOT IN query.
     *
     * @see useCalendarEventInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInCalendarEventQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\CalendarEventQuery<static> $q */
        $q = $this->useInQuery('CalendarEvent', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Event object
     * using the calendar_events table as cross reference
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this
     */
    public function filterByEvent(Event $event, ?string $comparison = null)
    {
        $this
            ->useCalendarEventQuery()
            ->filterByEvent($event, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Calendar|null $calendar Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildCalendar $calendar = null)
    {
        if ($calendar) {
            $resolvedColumn = $this->resolveLocalColumnByName('calendar_id');
            $this->addUsingOperator($resolvedColumn, $calendar->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the calendars table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CalendarTableMap::clearInstancePool();
            CalendarTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CalendarTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CalendarTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CalendarTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            CalendarTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
