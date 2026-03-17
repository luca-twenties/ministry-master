<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\KioskAssignment as ChildKioskAssignment;
use ChurchCRM\model\ChurchCRM\KioskAssignmentQuery as ChildKioskAssignmentQuery;
use ChurchCRM\model\ChurchCRM\Map\KioskAssignmentTableMap;
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
 * Base class that represents a query for the `kioskassginment_kasm` table.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kasm_ID column
 * @method static orderByKioskId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kasm_kdevId column
 * @method static orderByAssignmentType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kasm_AssignmentType column
 * @method static orderByEventId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kasm_EventId column
 *
 * @method static groupById() Group by the kasm_ID column
 * @method static groupByKioskId() Group by the kasm_kdevId column
 * @method static groupByAssignmentType() Group by the kasm_AssignmentType column
 * @method static groupByEventId() Group by the kasm_EventId column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinKioskDevice($relationAlias = null) Adds a LEFT JOIN clause to the query using the KioskDevice relation
 * @method static rightJoinKioskDevice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the KioskDevice relation
 * @method static innerJoinKioskDevice($relationAlias = null) Adds a INNER JOIN clause to the query using the KioskDevice relation
 *
 * @method static joinWithKioskDevice($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the KioskDevice relation
 *
 * @method static leftJoinWithKioskDevice() Adds a LEFT JOIN clause and with to the query using the KioskDevice relation
 * @method static rightJoinWithKioskDevice() Adds a RIGHT JOIN clause and with to the query using the KioskDevice relation
 * @method static innerJoinWithKioskDevice() Adds a INNER JOIN clause and with to the query using the KioskDevice relation
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
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment matching the query
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment matching the query, or a new \ChurchCRM\model\ChurchCRM\KioskAssignment object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment|null findOneById(int $kasm_ID) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_ID column
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment|null findOneByKioskId(int $kasm_kdevId) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_kdevId column
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment|null findOneByAssignmentType(int $kasm_AssignmentType) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_AssignmentType column
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment|null findOneByEventId(int $kasm_EventId) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_EventId column
 *
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\KioskAssignment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment requireOneById(int $kasm_ID) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment requireOneByKioskId(int $kasm_kdevId) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_kdevId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment requireOneByAssignmentType(int $kasm_AssignmentType) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_AssignmentType column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskAssignment requireOneByEventId(int $kasm_EventId) Return the first \ChurchCRM\model\ChurchCRM\KioskAssignment filtered by the kasm_EventId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection|array<\ChurchCRM\model\ChurchCRM\KioskAssignment>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskAssignment> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\KioskAssignment objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\KioskAssignment objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\KioskAssignment>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskAssignment> findById(int|array<int> $kasm_ID) Return \ChurchCRM\model\ChurchCRM\KioskAssignment objects filtered by the kasm_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskAssignment>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskAssignment> findByKioskId(int|array<int> $kasm_kdevId) Return \ChurchCRM\model\ChurchCRM\KioskAssignment objects filtered by the kasm_kdevId column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskAssignment>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskAssignment> findByAssignmentType(int|array<int> $kasm_AssignmentType) Return \ChurchCRM\model\ChurchCRM\KioskAssignment objects filtered by the kasm_AssignmentType column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskAssignment>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskAssignment> findByEventId(int|array<int> $kasm_EventId) Return \ChurchCRM\model\ChurchCRM\KioskAssignment objects filtered by the kasm_EventId column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\KioskAssignment>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class KioskAssignmentQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of KioskAssignmentQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\KioskAssignment',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildKioskAssignmentQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignmentQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildKioskAssignmentQuery) {
            return $criteria;
        }
        $query = new ChildKioskAssignmentQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\KioskAssignment|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(KioskAssignmentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = KioskAssignmentTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\KioskAssignment|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildKioskAssignment
    {
        $sql = 'SELECT kasm_ID, kasm_kdevId, kasm_AssignmentType, kasm_EventId FROM kioskassginment_kasm WHERE kasm_ID = :p0';
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
            $obj = new ChildKioskAssignment();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            KioskAssignmentTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\KioskAssignment|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\KioskAssignment>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('kasm_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('kasm_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the kasm_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE kasm_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE kasm_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE kasm_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('kasm_ID');
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
     * Filter the query on the kasm_kdevId column
     *
     * Example usage:
     * <code>
     * $query->filterByKioskId(1234); // WHERE kasm_kdevId = 1234
     * $query->filterByKioskId(array(12, 34)); // WHERE kasm_kdevId IN (12, 34)
     * $query->filterByKioskId(array('min' => 12)); // WHERE kasm_kdevId > 12
     * </code>
     *
     * @see static::filterByKioskDevice()
     *
     * @param mixed $kioskId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByKioskId($kioskId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kasm_kdevId');
        if (is_array($kioskId)) {
            $useMinMax = false;
            if (isset($kioskId['min'])) {
                $this->addUsingOperator($resolvedColumn, $kioskId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($kioskId['max'])) {
                $this->addUsingOperator($resolvedColumn, $kioskId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $kioskId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kasm_AssignmentType column
     *
     * Example usage:
     * <code>
     * $query->filterByAssignmentType(1234); // WHERE kasm_AssignmentType = 1234
     * $query->filterByAssignmentType(array(12, 34)); // WHERE kasm_AssignmentType IN (12, 34)
     * $query->filterByAssignmentType(array('min' => 12)); // WHERE kasm_AssignmentType > 12
     * </code>
     *
     * @param mixed $assignmentType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAssignmentType($assignmentType = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kasm_AssignmentType');
        if (is_array($assignmentType)) {
            $useMinMax = false;
            if (isset($assignmentType['min'])) {
                $this->addUsingOperator($resolvedColumn, $assignmentType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assignmentType['max'])) {
                $this->addUsingOperator($resolvedColumn, $assignmentType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $assignmentType, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kasm_EventId column
     *
     * Example usage:
     * <code>
     * $query->filterByEventId(1234); // WHERE kasm_EventId = 1234
     * $query->filterByEventId(array(12, 34)); // WHERE kasm_EventId IN (12, 34)
     * $query->filterByEventId(array('min' => 12)); // WHERE kasm_EventId > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('kasm_EventId');
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
     * Filter the query by a related KioskDevice object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\KioskDevice|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\KioskDevice> $kioskDevice The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByKioskDevice($kioskDevice, ?string $comparison = null)
    {
        if ($kioskDevice instanceof KioskDevice) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('kasm_kdevId'), $kioskDevice->getId(), $comparison);
        } elseif ($kioskDevice instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('kasm_kdevId'), $kioskDevice->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByKioskDevice() only accepts arguments of type KioskDevice or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the KioskDevice relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinKioskDevice(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('KioskDevice');

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
            $this->addJoinObject($join, 'KioskDevice');
        }

        return $this;
    }

    /**
     * Use the KioskDevice relation KioskDevice object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> A secondary query class using the current class as primary query
     */
    public function useKioskDeviceQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> $query */
        $query = $this->joinKioskDevice($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'KioskDevice', '\ChurchCRM\model\ChurchCRM\KioskDeviceQuery');

        return $query;
    }

    /**
     * Use the KioskDevice relation KioskDevice object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\KioskDeviceQuery<mixed>):\ChurchCRM\model\ChurchCRM\KioskDeviceQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withKioskDeviceQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::LEFT_JOIN
    ) {
        $relatedQuery = $this->useKioskDeviceQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to KioskDevice table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> The inner query object of the EXISTS statement
     */
    public function useKioskDeviceExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> $q */
        $q = $this->useExistsQuery('KioskDevice', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to KioskDevice table for a NOT EXISTS query.
     *
     * @see useKioskDeviceExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useKioskDeviceNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> $q*/
        $q = $this->useExistsQuery('KioskDevice', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to KioskDevice table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> The inner query object of the IN statement
     */
    public function useInKioskDeviceQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> $q */
        $q = $this->useInQuery('KioskDevice', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to KioskDevice table for a NOT IN query.
     *
     * @see useKioskDeviceInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInKioskDeviceQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<static> $q */
        $q = $this->useInQuery('KioskDevice', $modelAlias, $queryClass, Criteria::NOT_IN);

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
                ->addUsingOperator($this->resolveLocalColumnByName('kasm_EventId'), $event->getId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('kasm_EventId'), $event->toKeyValue('PrimaryKey', 'Id'), $comparison);

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
    public function joinEvent(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
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
    public function useEventQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
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
        ?string $joinType = Criteria::LEFT_JOIN
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
     * @param \ChurchCRM\model\ChurchCRM\KioskAssignment|null $kioskAssignment Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildKioskAssignment $kioskAssignment = null)
    {
        if ($kioskAssignment) {
            $resolvedColumn = $this->resolveLocalColumnByName('kasm_ID');
            $this->addUsingOperator($resolvedColumn, $kioskAssignment->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kioskassginment_kasm table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(KioskAssignmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            KioskAssignmentTableMap::clearInstancePool();
            KioskAssignmentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(KioskAssignmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(KioskAssignmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            KioskAssignmentTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            KioskAssignmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
