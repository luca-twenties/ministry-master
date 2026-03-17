<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Event as ChildEvent;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\Map\EventTableMap;
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
 * Base class that represents a query for the `events_event` table.
 *
 * This contains events
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_id column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_type column
 * @method static orderByTitle($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_title column
 * @method static orderByDesc($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_desc column
 * @method static orderByText($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_text column
 * @method static orderByStart($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_start column
 * @method static orderByEnd($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_end column
 * @method static orderByInActive($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the inactive column
 * @method static orderByLocationId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_id column
 * @method static orderByPrimaryContactPersonId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the primary_contact_person_id column
 * @method static orderBySecondaryContactPersonId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the secondary_contact_person_id column
 * @method static orderByURL($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the event_url column
 *
 * @method static groupById() Group by the event_id column
 * @method static groupByType() Group by the event_type column
 * @method static groupByTitle() Group by the event_title column
 * @method static groupByDesc() Group by the event_desc column
 * @method static groupByText() Group by the event_text column
 * @method static groupByStart() Group by the event_start column
 * @method static groupByEnd() Group by the event_end column
 * @method static groupByInActive() Group by the inactive column
 * @method static groupByLocationId() Group by the location_id column
 * @method static groupByPrimaryContactPersonId() Group by the primary_contact_person_id column
 * @method static groupBySecondaryContactPersonId() Group by the secondary_contact_person_id column
 * @method static groupByURL() Group by the event_url column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
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
 * @method static leftJoinPersonRelatedByType($relationAlias = null) Adds a LEFT JOIN clause to the query using the PersonRelatedByType relation
 * @method static rightJoinPersonRelatedByType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PersonRelatedByType relation
 * @method static innerJoinPersonRelatedByType($relationAlias = null) Adds a INNER JOIN clause to the query using the PersonRelatedByType relation
 *
 * @method static joinWithPersonRelatedByType($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the PersonRelatedByType relation
 *
 * @method static leftJoinWithPersonRelatedByType() Adds a LEFT JOIN clause and with to the query using the PersonRelatedByType relation
 * @method static rightJoinWithPersonRelatedByType() Adds a RIGHT JOIN clause and with to the query using the PersonRelatedByType relation
 * @method static innerJoinWithPersonRelatedByType() Adds a INNER JOIN clause and with to the query using the PersonRelatedByType relation
 *
 * @method static leftJoinPersonRelatedBySecondaryContactPersonId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PersonRelatedBySecondaryContactPersonId relation
 * @method static rightJoinPersonRelatedBySecondaryContactPersonId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PersonRelatedBySecondaryContactPersonId relation
 * @method static innerJoinPersonRelatedBySecondaryContactPersonId($relationAlias = null) Adds a INNER JOIN clause to the query using the PersonRelatedBySecondaryContactPersonId relation
 *
 * @method static joinWithPersonRelatedBySecondaryContactPersonId($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the PersonRelatedBySecondaryContactPersonId relation
 *
 * @method static leftJoinWithPersonRelatedBySecondaryContactPersonId() Adds a LEFT JOIN clause and with to the query using the PersonRelatedBySecondaryContactPersonId relation
 * @method static rightJoinWithPersonRelatedBySecondaryContactPersonId() Adds a RIGHT JOIN clause and with to the query using the PersonRelatedBySecondaryContactPersonId relation
 * @method static innerJoinWithPersonRelatedBySecondaryContactPersonId() Adds a INNER JOIN clause and with to the query using the PersonRelatedBySecondaryContactPersonId relation
 *
 * @method static leftJoinLocation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Location relation
 * @method static rightJoinLocation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Location relation
 * @method static innerJoinLocation($relationAlias = null) Adds a INNER JOIN clause to the query using the Location relation
 *
 * @method static joinWithLocation($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Location relation
 *
 * @method static leftJoinWithLocation() Adds a LEFT JOIN clause and with to the query using the Location relation
 * @method static rightJoinWithLocation() Adds a RIGHT JOIN clause and with to the query using the Location relation
 * @method static innerJoinWithLocation() Adds a INNER JOIN clause and with to the query using the Location relation
 *
 * @method static leftJoinEventAttend($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventAttend relation
 * @method static rightJoinEventAttend($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventAttend relation
 * @method static innerJoinEventAttend($relationAlias = null) Adds a INNER JOIN clause to the query using the EventAttend relation
 *
 * @method static joinWithEventAttend($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the EventAttend relation
 *
 * @method static leftJoinWithEventAttend() Adds a LEFT JOIN clause and with to the query using the EventAttend relation
 * @method static rightJoinWithEventAttend() Adds a RIGHT JOIN clause and with to the query using the EventAttend relation
 * @method static innerJoinWithEventAttend() Adds a INNER JOIN clause and with to the query using the EventAttend relation
 *
 * @method static leftJoinKioskAssignment($relationAlias = null) Adds a LEFT JOIN clause to the query using the KioskAssignment relation
 * @method static rightJoinKioskAssignment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the KioskAssignment relation
 * @method static innerJoinKioskAssignment($relationAlias = null) Adds a INNER JOIN clause to the query using the KioskAssignment relation
 *
 * @method static joinWithKioskAssignment($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the KioskAssignment relation
 *
 * @method static leftJoinWithKioskAssignment() Adds a LEFT JOIN clause and with to the query using the KioskAssignment relation
 * @method static rightJoinWithKioskAssignment() Adds a RIGHT JOIN clause and with to the query using the KioskAssignment relation
 * @method static innerJoinWithKioskAssignment() Adds a INNER JOIN clause and with to the query using the KioskAssignment relation
 *
 * @method static leftJoinEventAudience($relationAlias = null) Adds a LEFT JOIN clause to the query using the EventAudience relation
 * @method static rightJoinEventAudience($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EventAudience relation
 * @method static innerJoinEventAudience($relationAlias = null) Adds a INNER JOIN clause to the query using the EventAudience relation
 *
 * @method static joinWithEventAudience($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the EventAudience relation
 *
 * @method static leftJoinWithEventAudience() Adds a LEFT JOIN clause and with to the query using the EventAudience relation
 * @method static rightJoinWithEventAudience() Adds a RIGHT JOIN clause and with to the query using the EventAudience relation
 * @method static innerJoinWithEventAudience() Adds a INNER JOIN clause and with to the query using the EventAudience relation
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
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Event matching the query
 * @method \ChurchCRM\model\ChurchCRM\Event findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Event matching the query, or a new \ChurchCRM\model\ChurchCRM\Event object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneById(int $event_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_id column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByType(int $event_type) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_type column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByTitle(string $event_title) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_title column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByDesc(string $event_desc) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_desc column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByText(string $event_text) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_text column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByStart(string $event_start) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_start column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByEnd(string $event_end) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_end column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByInActive(int $inactive) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the inactive column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByLocationId(int $location_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the location_id column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByPrimaryContactPersonId(int $primary_contact_person_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the primary_contact_person_id column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneBySecondaryContactPersonId(int $secondary_contact_person_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the secondary_contact_person_id column
 * @method \ChurchCRM\model\ChurchCRM\Event|null findOneByURL(string $event_url) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_url column
 *
 * @method \ChurchCRM\model\ChurchCRM\Event requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Event by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Event matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneById(int $event_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByType(int $event_type) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByTitle(string $event_title) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByDesc(string $event_desc) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_desc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByText(string $event_text) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByStart(string $event_start) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByEnd(string $event_end) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_end column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByInActive(int $inactive) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the inactive column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByLocationId(int $location_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the location_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByPrimaryContactPersonId(int $primary_contact_person_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the primary_contact_person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneBySecondaryContactPersonId(int $secondary_contact_person_id) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the secondary_contact_person_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Event requireOneByURL(string $event_url) Return the first \ChurchCRM\model\ChurchCRM\Event filtered by the event_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection|array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Event objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Event objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findById(int|array<int> $event_id) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByType(int|array<int> $event_type) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_type column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByTitle(string|array<string> $event_title) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_title column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByDesc(string|array<string> $event_desc) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_desc column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByText(string|array<string> $event_text) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_text column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByStart(string|array<string> $event_start) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_start column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByEnd(string|array<string> $event_end) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_end column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByInActive(int|array<int> $inactive) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the inactive column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByLocationId(int|array<int> $location_id) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the location_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByPrimaryContactPersonId(int|array<int> $primary_contact_person_id) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the primary_contact_person_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findBySecondaryContactPersonId(int|array<int> $secondary_contact_person_id) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the secondary_contact_person_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Event> findByURL(string|array<string> $event_url) Return \ChurchCRM\model\ChurchCRM\Event objects filtered by the event_url column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Event>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class EventQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of EventQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Event',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\EventQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildEventQuery) {
            return $criteria;
        }
        $query = new ChildEventQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Event|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = EventTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Event|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildEvent
    {
        $sql = 'SELECT event_id, event_type, event_title, event_desc, event_text, event_start, event_end, inactive, location_id, primary_contact_person_id, secondary_contact_person_id, event_url FROM events_event WHERE event_id = :p0';
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
            $obj = new ChildEvent();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            EventTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Event|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Event>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('event_id');
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
        $resolvedColumn = $this->resolveLocalColumnByName('event_id');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the event_id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE event_id = 1234
     * $query->filterById(array(12, 34)); // WHERE event_id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE event_id > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('event_id');
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
     * Filter the query on the event_type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE event_type = 1234
     * $query->filterByType(array(12, 34)); // WHERE event_type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE event_type > 12
     * </code>
     *
     * @see static::filterByEventType()
     * @see static::filterByPersonRelatedByType()
     *
     * @param mixed $type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByType($type = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_type');
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingOperator($resolvedColumn, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingOperator($resolvedColumn, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $type, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue'); // WHERE event_title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE event_title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE event_title IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_title');
        if ($comparison === null && is_array($title)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_desc column
     *
     * Example usage:
     * <code>
     * $query->filterByDesc('fooValue'); // WHERE event_desc = 'fooValue'
     * $query->filterByDesc('%fooValue%', Criteria::LIKE); // WHERE event_desc LIKE '%fooValue%'
     * $query->filterByDesc(['foo', 'bar']); // WHERE event_desc IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $desc The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDesc($desc = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_desc');
        if ($comparison === null && is_array($desc)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $desc, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue'); // WHERE event_text = 'fooValue'
     * $query->filterByText('%fooValue%', Criteria::LIKE); // WHERE event_text LIKE '%fooValue%'
     * $query->filterByText(['foo', 'bar']); // WHERE event_text IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $text The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByText($text = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_text');
        if ($comparison === null && is_array($text)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $text, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_start column
     *
     * Example usage:
     * <code>
     * $query->filterByStart('2011-03-14'); // WHERE event_start = '2011-03-14'
     * $query->filterByStart('now'); // WHERE event_start = '2011-03-14'
     * $query->filterByStart(array('max' => 'yesterday')); // WHERE event_start > '2011-03-13'
     * </code>
     *
     * @param mixed $start The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByStart($start = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_start');
        if (is_array($start)) {
            $useMinMax = false;
            if (isset($start['min'])) {
                $this->addUsingOperator($resolvedColumn, $start['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($start['max'])) {
                $this->addUsingOperator($resolvedColumn, $start['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $start, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_end column
     *
     * Example usage:
     * <code>
     * $query->filterByEnd('2011-03-14'); // WHERE event_end = '2011-03-14'
     * $query->filterByEnd('now'); // WHERE event_end = '2011-03-14'
     * $query->filterByEnd(array('max' => 'yesterday')); // WHERE event_end > '2011-03-13'
     * </code>
     *
     * @param mixed $end The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnd($end = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_end');
        if (is_array($end)) {
            $useMinMax = false;
            if (isset($end['min'])) {
                $this->addUsingOperator($resolvedColumn, $end['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($end['max'])) {
                $this->addUsingOperator($resolvedColumn, $end['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $end, $comparison);

        return $this;
    }

    /**
     * Filter the query on the inactive column
     *
     * Example usage:
     * <code>
     * $query->filterByInActive(1234); // WHERE inactive = 1234
     * $query->filterByInActive(array(12, 34)); // WHERE inactive IN (12, 34)
     * $query->filterByInActive(array('min' => 12)); // WHERE inactive > 12
     * </code>
     *
     * @param mixed $inActive The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByInActive($inActive = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('inactive');
        if (is_array($inActive)) {
            $useMinMax = false;
            if (isset($inActive['min'])) {
                $this->addUsingOperator($resolvedColumn, $inActive['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inActive['max'])) {
                $this->addUsingOperator($resolvedColumn, $inActive['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $inActive, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationId(1234); // WHERE location_id = 1234
     * $query->filterByLocationId(array(12, 34)); // WHERE location_id IN (12, 34)
     * $query->filterByLocationId(array('min' => 12)); // WHERE location_id > 12
     * </code>
     *
     * @see static::filterByLocation()
     *
     * @param mixed $locationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationId($locationId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_id');
        if (is_array($locationId)) {
            $useMinMax = false;
            if (isset($locationId['min'])) {
                $this->addUsingOperator($resolvedColumn, $locationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationId['max'])) {
                $this->addUsingOperator($resolvedColumn, $locationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $locationId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the primary_contact_person_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPrimaryContactPersonId(1234); // WHERE primary_contact_person_id = 1234
     * $query->filterByPrimaryContactPersonId(array(12, 34)); // WHERE primary_contact_person_id IN (12, 34)
     * $query->filterByPrimaryContactPersonId(array('min' => 12)); // WHERE primary_contact_person_id > 12
     * </code>
     *
     * @param mixed $primaryContactPersonId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPrimaryContactPersonId($primaryContactPersonId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('primary_contact_person_id');
        if (is_array($primaryContactPersonId)) {
            $useMinMax = false;
            if (isset($primaryContactPersonId['min'])) {
                $this->addUsingOperator($resolvedColumn, $primaryContactPersonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($primaryContactPersonId['max'])) {
                $this->addUsingOperator($resolvedColumn, $primaryContactPersonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $primaryContactPersonId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the secondary_contact_person_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySecondaryContactPersonId(1234); // WHERE secondary_contact_person_id = 1234
     * $query->filterBySecondaryContactPersonId(array(12, 34)); // WHERE secondary_contact_person_id IN (12, 34)
     * $query->filterBySecondaryContactPersonId(array('min' => 12)); // WHERE secondary_contact_person_id > 12
     * </code>
     *
     * @see static::filterByPersonRelatedBySecondaryContactPersonId()
     *
     * @param mixed $secondaryContactPersonId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySecondaryContactPersonId($secondaryContactPersonId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('secondary_contact_person_id');
        if (is_array($secondaryContactPersonId)) {
            $useMinMax = false;
            if (isset($secondaryContactPersonId['min'])) {
                $this->addUsingOperator($resolvedColumn, $secondaryContactPersonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($secondaryContactPersonId['max'])) {
                $this->addUsingOperator($resolvedColumn, $secondaryContactPersonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $secondaryContactPersonId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the event_url column
     *
     * Example usage:
     * <code>
     * $query->filterByURL('fooValue'); // WHERE event_url = 'fooValue'
     * $query->filterByURL('%fooValue%', Criteria::LIKE); // WHERE event_url LIKE '%fooValue%'
     * $query->filterByURL(['foo', 'bar']); // WHERE event_url IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $uRL The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByURL($uRL = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('event_url');
        if ($comparison === null && is_array($uRL)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $uRL, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related EventType object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventType|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventType> $eventType The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByEventType($eventType, ?string $comparison = null)
    {
        if ($eventType instanceof EventType) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_type'), $eventType->getId(), $comparison);
        } elseif ($eventType instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_type'), $eventType->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByEventType() only accepts arguments of type EventType or Collection');
        }
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
     * Use the EventType relation EventType object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> A secondary query class using the current class as primary query
     */
    public function useEventTypeQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> $query */
        $query = $this->joinEventType($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'EventType', '\ChurchCRM\model\ChurchCRM\EventTypeQuery');

        return $query;
    }

    /**
     * Use the EventType relation EventType object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventTypeQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventTypeQuery<mixed> $callable A function working on the related query
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
     * Use the relation to EventType table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> The inner query object of the EXISTS statement
     */
    public function useEventTypeExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> $q */
        $q = $this->useExistsQuery('EventType', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to EventType table for a NOT EXISTS query.
     *
     * @see useEventTypeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useEventTypeNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> $q*/
        $q = $this->useExistsQuery('EventType', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to EventType table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> The inner query object of the IN statement
     */
    public function useInEventTypeQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> $q */
        $q = $this->useInQuery('EventType', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to EventType table for a NOT IN query.
     *
     * @see useEventTypeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInEventTypeQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventTypeQuery<static> $q */
        $q = $this->useInQuery('EventType', $modelAlias, $queryClass, Criteria::NOT_IN);

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
    public function filterByPersonRelatedByType($person, ?string $comparison = null)
    {
        if ($person instanceof Person) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_type'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_type'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPersonRelatedByType() only accepts arguments of type Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PersonRelatedByType relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPersonRelatedByType(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PersonRelatedByType');

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
            $this->addJoinObject($join, 'PersonRelatedByType');
        }

        return $this;
    }

    /**
     * Use the PersonRelatedByType relation Person object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> A secondary query class using the current class as primary query
     */
    public function usePersonRelatedByTypeQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $query */
        $query = $this->joinPersonRelatedByType($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'PersonRelatedByType', '\ChurchCRM\model\ChurchCRM\PersonQuery');

        return $query;
    }

    /**
     * Use the PersonRelatedByType relation Person object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PersonQuery<mixed>):\ChurchCRM\model\ChurchCRM\PersonQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPersonRelatedByTypeQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePersonRelatedByTypeQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the PersonRelatedByType relation to the Person table for an EXISTS query.
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
    public function usePersonRelatedByTypeExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useExistsQuery('PersonRelatedByType', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the PersonRelatedByType relation to the Person table for a NOT EXISTS query.
     *
     * @see usePersonRelatedByTypeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePersonRelatedByTypeNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q*/
        $q = $this->useExistsQuery('PersonRelatedByType', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the PersonRelatedByType relation to the Person table for an IN query.
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
    public function useInPersonRelatedByTypeQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('PersonRelatedByType', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the PersonRelatedByType relation to the Person table for a NOT IN query.
     *
     * @see usePersonRelatedByTypeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPersonRelatedByTypeQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('PersonRelatedByType', $modelAlias, $queryClass, Criteria::NOT_IN);

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
    public function filterByPersonRelatedBySecondaryContactPersonId($person, ?string $comparison = null)
    {
        if ($person instanceof Person) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('secondary_contact_person_id'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('secondary_contact_person_id'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPersonRelatedBySecondaryContactPersonId() only accepts arguments of type Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PersonRelatedBySecondaryContactPersonId relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPersonRelatedBySecondaryContactPersonId(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PersonRelatedBySecondaryContactPersonId');

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
            $this->addJoinObject($join, 'PersonRelatedBySecondaryContactPersonId');
        }

        return $this;
    }

    /**
     * Use the PersonRelatedBySecondaryContactPersonId relation Person object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> A secondary query class using the current class as primary query
     */
    public function usePersonRelatedBySecondaryContactPersonIdQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $query */
        $query = $this->joinPersonRelatedBySecondaryContactPersonId($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'PersonRelatedBySecondaryContactPersonId', '\ChurchCRM\model\ChurchCRM\PersonQuery');

        return $query;
    }

    /**
     * Use the PersonRelatedBySecondaryContactPersonId relation Person object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PersonQuery<mixed>):\ChurchCRM\model\ChurchCRM\PersonQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPersonRelatedBySecondaryContactPersonIdQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePersonRelatedBySecondaryContactPersonIdQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the PersonRelatedBySecondaryContactPersonId relation to the Person table for an EXISTS query.
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
    public function usePersonRelatedBySecondaryContactPersonIdExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useExistsQuery('PersonRelatedBySecondaryContactPersonId', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the PersonRelatedBySecondaryContactPersonId relation to the Person table for a NOT EXISTS query.
     *
     * @see usePersonRelatedBySecondaryContactPersonIdExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePersonRelatedBySecondaryContactPersonIdNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q*/
        $q = $this->useExistsQuery('PersonRelatedBySecondaryContactPersonId', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the PersonRelatedBySecondaryContactPersonId relation to the Person table for an IN query.
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
    public function useInPersonRelatedBySecondaryContactPersonIdQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('PersonRelatedBySecondaryContactPersonId', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the PersonRelatedBySecondaryContactPersonId relation to the Person table for a NOT IN query.
     *
     * @see usePersonRelatedBySecondaryContactPersonIdInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPersonRelatedBySecondaryContactPersonIdQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('PersonRelatedBySecondaryContactPersonId', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Location object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Location|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Location> $location The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByLocation($location, ?string $comparison = null)
    {
        if ($location instanceof Location) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('location_id'), $location->getLocationId(), $comparison);
        } elseif ($location instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('location_id'), $location->toKeyValue('PrimaryKey', 'LocationId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByLocation() only accepts arguments of type Location or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Location relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinLocation(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Location');

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
            $this->addJoinObject($join, 'Location');
        }

        return $this;
    }

    /**
     * Use the Location relation Location object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\LocationQuery<static> A secondary query class using the current class as primary query
     */
    public function useLocationQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\LocationQuery<static> $query */
        $query = $this->joinLocation($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Location', '\ChurchCRM\model\ChurchCRM\LocationQuery');

        return $query;
    }

    /**
     * Use the Location relation Location object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\LocationQuery<mixed>):\ChurchCRM\model\ChurchCRM\LocationQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withLocationQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useLocationQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Location table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\LocationQuery<static> The inner query object of the EXISTS statement
     */
    public function useLocationExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\LocationQuery<static> $q */
        $q = $this->useExistsQuery('Location', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Location table for a NOT EXISTS query.
     *
     * @see useLocationExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\LocationQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useLocationNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\LocationQuery<static> $q*/
        $q = $this->useExistsQuery('Location', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Location table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\LocationQuery<static> The inner query object of the IN statement
     */
    public function useInLocationQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\LocationQuery<static> $q */
        $q = $this->useInQuery('Location', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Location table for a NOT IN query.
     *
     * @see useLocationInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\LocationQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInLocationQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\LocationQuery<static> $q */
        $q = $this->useInQuery('Location', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related EventAttend object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAttend|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAttend> $eventAttend the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByEventAttend(EventAttend|ObjectCollection $eventAttend, ?string $comparison = null)
    {
        if ($eventAttend instanceof EventAttend) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_id'), $eventAttend->getEventId(), $comparison);
        } elseif ($eventAttend instanceof ObjectCollection) {
            $this
                ->useEventAttendQuery()
                ->filterByPrimaryKeys($eventAttend->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventAttend() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\EventAttend or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the EventAttend relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinEventAttend(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventAttend');

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
            $this->addJoinObject($join, 'EventAttend');
        }

        return $this;
    }

    /**
     * Use the EventAttend relation EventAttend object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> A secondary query class using the current class as primary query
     */
    public function useEventAttendQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $query */
        $query = $this->joinEventAttend($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'EventAttend', '\ChurchCRM\model\ChurchCRM\EventAttendQuery');

        return $query;
    }

    /**
     * Use the EventAttend relation EventAttend object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventAttendQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventAttendQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEventAttendQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useEventAttendQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to EventAttend table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the EXISTS statement
     */
    public function useEventAttendExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q */
        $q = $this->useExistsQuery('EventAttend', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to EventAttend table for a NOT EXISTS query.
     *
     * @see useEventAttendExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useEventAttendNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q*/
        $q = $this->useExistsQuery('EventAttend', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to EventAttend table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the IN statement
     */
    public function useInEventAttendQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q */
        $q = $this->useInQuery('EventAttend', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to EventAttend table for a NOT IN query.
     *
     * @see useEventAttendInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInEventAttendQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAttendQuery<static> $q */
        $q = $this->useInQuery('EventAttend', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related KioskAssignment object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\KioskAssignment|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\KioskAssignment> $kioskAssignment the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByKioskAssignment(KioskAssignment|ObjectCollection $kioskAssignment, ?string $comparison = null)
    {
        if ($kioskAssignment instanceof KioskAssignment) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_id'), $kioskAssignment->getEventId(), $comparison);
        } elseif ($kioskAssignment instanceof ObjectCollection) {
            $this
                ->useKioskAssignmentQuery()
                ->filterByPrimaryKeys($kioskAssignment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByKioskAssignment() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\KioskAssignment or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the KioskAssignment relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinKioskAssignment(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('KioskAssignment');

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
            $this->addJoinObject($join, 'KioskAssignment');
        }

        return $this;
    }

    /**
     * Use the KioskAssignment relation KioskAssignment object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> A secondary query class using the current class as primary query
     */
    public function useKioskAssignmentQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> $query */
        $query = $this->joinKioskAssignment($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'KioskAssignment', '\ChurchCRM\model\ChurchCRM\KioskAssignmentQuery');

        return $query;
    }

    /**
     * Use the KioskAssignment relation KioskAssignment object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<mixed>):\ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withKioskAssignmentQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useKioskAssignmentQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to KioskAssignment table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> The inner query object of the EXISTS statement
     */
    public function useKioskAssignmentExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> $q */
        $q = $this->useExistsQuery('KioskAssignment', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to KioskAssignment table for a NOT EXISTS query.
     *
     * @see useKioskAssignmentExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useKioskAssignmentNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> $q*/
        $q = $this->useExistsQuery('KioskAssignment', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to KioskAssignment table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> The inner query object of the IN statement
     */
    public function useInKioskAssignmentQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> $q */
        $q = $this->useInQuery('KioskAssignment', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to KioskAssignment table for a NOT IN query.
     *
     * @see useKioskAssignmentInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInKioskAssignmentQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<static> $q */
        $q = $this->useInQuery('KioskAssignment', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related EventAudience object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAudience|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAudience> $eventAudience the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByEventAudience(EventAudience|ObjectCollection $eventAudience, ?string $comparison = null)
    {
        if ($eventAudience instanceof EventAudience) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('event_id'), $eventAudience->getEventId(), $comparison);
        } elseif ($eventAudience instanceof ObjectCollection) {
            $this
                ->useEventAudienceQuery()
                ->filterByPrimaryKeys($eventAudience->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventAudience() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\EventAudience or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the EventAudience relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinEventAudience(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EventAudience');

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
            $this->addJoinObject($join, 'EventAudience');
        }

        return $this;
    }

    /**
     * Use the EventAudience relation EventAudience object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> A secondary query class using the current class as primary query
     */
    public function useEventAudienceQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> $query */
        $query = $this->joinEventAudience($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'EventAudience', '\ChurchCRM\model\ChurchCRM\EventAudienceQuery');

        return $query;
    }

    /**
     * Use the EventAudience relation EventAudience object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\EventAudienceQuery<mixed>):\ChurchCRM\model\ChurchCRM\EventAudienceQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withEventAudienceQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useEventAudienceQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to EventAudience table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> The inner query object of the EXISTS statement
     */
    public function useEventAudienceExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> $q */
        $q = $this->useExistsQuery('EventAudience', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to EventAudience table for a NOT EXISTS query.
     *
     * @see useEventAudienceExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useEventAudienceNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> $q*/
        $q = $this->useExistsQuery('EventAudience', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to EventAudience table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> The inner query object of the IN statement
     */
    public function useInEventAudienceQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> $q */
        $q = $this->useInQuery('EventAudience', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to EventAudience table for a NOT IN query.
     *
     * @see useEventAudienceInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInEventAudienceQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\EventAudienceQuery<static> $q */
        $q = $this->useInQuery('EventAudience', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
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
                ->addUsingOperator($this->resolveLocalColumnByName('event_id'), $calendarEvent->getEventId(), $comparison);
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
     * Filter the query by a related Group object
     * using the event_audience table as cross reference
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Group $group the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this
     */
    public function filterByGroup(Group $group, ?string $comparison = null)
    {
        $this
            ->useEventAudienceQuery()
            ->filterByGroup($group, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Filter the query by a related Calendar object
     * using the calendar_events table as cross reference
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Calendar $calendar the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this
     */
    public function filterByCalendar(Calendar $calendar, ?string $comparison = null)
    {
        $this
            ->useCalendarEventQuery()
            ->filterByCalendar($calendar, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Event|null $event Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildEvent $event = null)
    {
        if ($event) {
            $resolvedColumn = $this->resolveLocalColumnByName('event_id');
            $this->addUsingOperator($resolvedColumn, $event->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the events_event table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventTableMap::clearInstancePool();
            EventTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            EventTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
