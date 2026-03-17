<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\EventCounts as ChildEventCounts;
use ChurchCRM\model\ChurchCRM\EventCountsQuery as ChildEventCountsQuery;
use ChurchCRM\model\ChurchCRM\Map\EventCountsTableMap;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `eventcounts_evtcnt` table.
 *
 * @method static orderByEvtcntEventid($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evtcnt_eventid column
 * @method static orderByEvtcntCountid($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evtcnt_countid column
 * @method static orderByEvtcntCountname($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evtcnt_countname column
 * @method static orderByEvtcntCountcount($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evtcnt_countcount column
 * @method static orderByEvtcntNotes($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evtcnt_notes column
 *
 * @method static groupByEvtcntEventid() Group by the evtcnt_eventid column
 * @method static groupByEvtcntCountid() Group by the evtcnt_countid column
 * @method static groupByEvtcntCountname() Group by the evtcnt_countname column
 * @method static groupByEvtcntCountcount() Group by the evtcnt_countcount column
 * @method static groupByEvtcntNotes() Group by the evtcnt_notes column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCounts|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventCounts matching the query
 * @method \ChurchCRM\model\ChurchCRM\EventCounts findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventCounts matching the query, or a new \ChurchCRM\model\ChurchCRM\EventCounts object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCounts|null findOneByEvtcntEventid(int $evtcnt_eventid) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_eventid column
 * @method \ChurchCRM\model\ChurchCRM\EventCounts|null findOneByEvtcntCountid(int $evtcnt_countid) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_countid column
 * @method \ChurchCRM\model\ChurchCRM\EventCounts|null findOneByEvtcntCountname(string $evtcnt_countname) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_countname column
 * @method \ChurchCRM\model\ChurchCRM\EventCounts|null findOneByEvtcntCountcount(int $evtcnt_countcount) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_countcount column
 * @method \ChurchCRM\model\ChurchCRM\EventCounts|null findOneByEvtcntNotes(string $evtcnt_notes) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_notes column
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\EventCounts by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventCounts matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requireOneByEvtcntEventid(int $evtcnt_eventid) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_eventid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requireOneByEvtcntCountid(int $evtcnt_countid) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_countid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requireOneByEvtcntCountname(string $evtcnt_countname) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_countname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requireOneByEvtcntCountcount(int $evtcnt_countcount) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_countcount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCounts requireOneByEvtcntNotes(string $evtcnt_notes) Return the first \ChurchCRM\model\ChurchCRM\EventCounts filtered by the evtcnt_notes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventCountsCollection|array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCounts> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\EventCounts objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventCountsCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\EventCounts objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCounts> findByEvtcntEventid(int|array<int> $evtcnt_eventid) Return \ChurchCRM\model\ChurchCRM\EventCounts objects filtered by the evtcnt_eventid column
 * @method array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCounts> findByEvtcntCountid(int|array<int> $evtcnt_countid) Return \ChurchCRM\model\ChurchCRM\EventCounts objects filtered by the evtcnt_countid column
 * @method array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCounts> findByEvtcntCountname(string|array<string> $evtcnt_countname) Return \ChurchCRM\model\ChurchCRM\EventCounts objects filtered by the evtcnt_countname column
 * @method array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCounts> findByEvtcntCountcount(int|array<int> $evtcnt_countcount) Return \ChurchCRM\model\ChurchCRM\EventCounts objects filtered by the evtcnt_countcount column
 * @method array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCounts> findByEvtcntNotes(string|array<string> $evtcnt_notes) Return \ChurchCRM\model\ChurchCRM\EventCounts objects filtered by the evtcnt_notes column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventCounts>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class EventCountsQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of EventCountsQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\EventCounts',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventCountsQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\EventCountsQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildEventCountsQuery) {
            return $criteria;
        }
        $query = new ChildEventCountsQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventCounts|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventCountsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
        $obj = EventCountsTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\EventCounts|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildEventCounts
    {
        $sql = 'SELECT evtcnt_eventid, evtcnt_countid, evtcnt_countname, evtcnt_countcount, evtcnt_notes FROM eventcounts_evtcnt WHERE evtcnt_eventid = :p0 AND evtcnt_countid = :p1';
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
            $obj = new ChildEventCounts();
            $obj->hydrate($row);
            $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
            EventCountsTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventCounts|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventCounts>|mixed|array the list of results, formatted by the current formatter
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
        $tableMap = EventCountsTableMap::getTableMap();
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_eventid');
        $this->addUsingOperator($resolvedColumn, $key[0], Criteria::EQUAL);
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_countid');
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

        $resolvedColumn0 = $this->resolveLocalColumnByName('evtcnt_eventid');
        $resolvedColumn1 = $this->resolveLocalColumnByName('evtcnt_countid');

        foreach ($keys as $key) {
            $filter0 = $this->buildFilter($resolvedColumn0, $key[0], Criteria::EQUAL);
            $this->addOr($filter0);

            $filter1 = $this->buildFilter($resolvedColumn1, $key[1], Criteria::EQUAL);
            $filter0->addAnd($filter1);
        }

        return $this;
    }

    /**
     * Filter the query on the evtcnt_eventid column
     *
     * Example usage:
     * <code>
     * $query->filterByEvtcntEventid(1234); // WHERE evtcnt_eventid = 1234
     * $query->filterByEvtcntEventid(array(12, 34)); // WHERE evtcnt_eventid IN (12, 34)
     * $query->filterByEvtcntEventid(array('min' => 12)); // WHERE evtcnt_eventid > 12
     * </code>
     *
     * @param mixed $evtcntEventid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEvtcntEventid($evtcntEventid = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_eventid');
        if (is_array($evtcntEventid)) {
            $useMinMax = false;
            if (isset($evtcntEventid['min'])) {
                $this->addUsingOperator($resolvedColumn, $evtcntEventid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($evtcntEventid['max'])) {
                $this->addUsingOperator($resolvedColumn, $evtcntEventid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $evtcntEventid, $comparison);

        return $this;
    }

    /**
     * Filter the query on the evtcnt_countid column
     *
     * Example usage:
     * <code>
     * $query->filterByEvtcntCountid(1234); // WHERE evtcnt_countid = 1234
     * $query->filterByEvtcntCountid(array(12, 34)); // WHERE evtcnt_countid IN (12, 34)
     * $query->filterByEvtcntCountid(array('min' => 12)); // WHERE evtcnt_countid > 12
     * </code>
     *
     * @param mixed $evtcntCountid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEvtcntCountid($evtcntCountid = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_countid');
        if (is_array($evtcntCountid)) {
            $useMinMax = false;
            if (isset($evtcntCountid['min'])) {
                $this->addUsingOperator($resolvedColumn, $evtcntCountid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($evtcntCountid['max'])) {
                $this->addUsingOperator($resolvedColumn, $evtcntCountid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $evtcntCountid, $comparison);

        return $this;
    }

    /**
     * Filter the query on the evtcnt_countname column
     *
     * Example usage:
     * <code>
     * $query->filterByEvtcntCountname('fooValue'); // WHERE evtcnt_countname = 'fooValue'
     * $query->filterByEvtcntCountname('%fooValue%', Criteria::LIKE); // WHERE evtcnt_countname LIKE '%fooValue%'
     * $query->filterByEvtcntCountname(['foo', 'bar']); // WHERE evtcnt_countname IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $evtcntCountname The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEvtcntCountname($evtcntCountname = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_countname');
        if ($comparison === null && is_array($evtcntCountname)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $evtcntCountname, $comparison);

        return $this;
    }

    /**
     * Filter the query on the evtcnt_countcount column
     *
     * Example usage:
     * <code>
     * $query->filterByEvtcntCountcount(1234); // WHERE evtcnt_countcount = 1234
     * $query->filterByEvtcntCountcount(array(12, 34)); // WHERE evtcnt_countcount IN (12, 34)
     * $query->filterByEvtcntCountcount(array('min' => 12)); // WHERE evtcnt_countcount > 12
     * </code>
     *
     * @param mixed $evtcntCountcount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEvtcntCountcount($evtcntCountcount = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_countcount');
        if (is_array($evtcntCountcount)) {
            $useMinMax = false;
            if (isset($evtcntCountcount['min'])) {
                $this->addUsingOperator($resolvedColumn, $evtcntCountcount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($evtcntCountcount['max'])) {
                $this->addUsingOperator($resolvedColumn, $evtcntCountcount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $evtcntCountcount, $comparison);

        return $this;
    }

    /**
     * Filter the query on the evtcnt_notes column
     *
     * Example usage:
     * <code>
     * $query->filterByEvtcntNotes('fooValue'); // WHERE evtcnt_notes = 'fooValue'
     * $query->filterByEvtcntNotes('%fooValue%', Criteria::LIKE); // WHERE evtcnt_notes LIKE '%fooValue%'
     * $query->filterByEvtcntNotes(['foo', 'bar']); // WHERE evtcnt_notes IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $evtcntNotes The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEvtcntNotes($evtcntNotes = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evtcnt_notes');
        if ($comparison === null && is_array($evtcntNotes)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $evtcntNotes, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\EventCounts|null $eventCounts Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildEventCounts $eventCounts = null)
    {
        if ($eventCounts) {
            $pkFilter = $this->buildFilter($this->resolveLocalColumnByName('evtcnt_eventid'), $eventCounts->getEvtcntEventid(), Criteria::NOT_EQUAL);
            $pkFilter->addOr($this->buildFilter($this->resolveLocalColumnByName('evtcnt_countid'), $eventCounts->getEvtcntCountid(), Criteria::NOT_EQUAL));
            $this->addAnd($pkFilter);
        }

        return $this;
    }

    /**
     * Deletes all rows from the eventcounts_evtcnt table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventCountsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventCountsTableMap::clearInstancePool();
            EventCountsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventCountsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventCountsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventCountsTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            EventCountsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
