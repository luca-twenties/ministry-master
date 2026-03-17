<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\EventCountName as ChildEventCountName;
use ChurchCRM\model\ChurchCRM\EventCountNameQuery as ChildEventCountNameQuery;
use ChurchCRM\model\ChurchCRM\Map\EventCountNameTableMap;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `eventcountnames_evctnm` table.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evctnm_countid column
 * @method static orderByTypeId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evctnm_eventtypeid column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the evctnm_countname column
 *
 * @method static groupById() Group by the evctnm_countid column
 * @method static groupByTypeId() Group by the evctnm_eventtypeid column
 * @method static groupByName() Group by the evctnm_countname column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCountName|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventCountName matching the query
 * @method \ChurchCRM\model\ChurchCRM\EventCountName findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventCountName matching the query, or a new \ChurchCRM\model\ChurchCRM\EventCountName object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCountName|null findOneById(int $evctnm_countid) Return the first \ChurchCRM\model\ChurchCRM\EventCountName filtered by the evctnm_countid column
 * @method \ChurchCRM\model\ChurchCRM\EventCountName|null findOneByTypeId(int $evctnm_eventtypeid) Return the first \ChurchCRM\model\ChurchCRM\EventCountName filtered by the evctnm_eventtypeid column
 * @method \ChurchCRM\model\ChurchCRM\EventCountName|null findOneByName(string $evctnm_countname) Return the first \ChurchCRM\model\ChurchCRM\EventCountName filtered by the evctnm_countname column
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCountName requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\EventCountName by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCountName requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\EventCountName matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\EventCountName requireOneById(int $evctnm_countid) Return the first \ChurchCRM\model\ChurchCRM\EventCountName filtered by the evctnm_countid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCountName requireOneByTypeId(int $evctnm_eventtypeid) Return the first \ChurchCRM\model\ChurchCRM\EventCountName filtered by the evctnm_eventtypeid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\EventCountName requireOneByName(string $evctnm_countname) Return the first \ChurchCRM\model\ChurchCRM\EventCountName filtered by the evctnm_countname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventCountNameCollection|array<\ChurchCRM\model\ChurchCRM\EventCountName>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCountName> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\EventCountName objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\EventCountNameCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\EventCountName objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventCountName>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCountName> findById(int|array<int> $evctnm_countid) Return \ChurchCRM\model\ChurchCRM\EventCountName objects filtered by the evctnm_countid column
 * @method array<\ChurchCRM\model\ChurchCRM\EventCountName>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCountName> findByTypeId(int|array<int> $evctnm_eventtypeid) Return \ChurchCRM\model\ChurchCRM\EventCountName objects filtered by the evctnm_eventtypeid column
 * @method array<\ChurchCRM\model\ChurchCRM\EventCountName>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\EventCountName> findByName(string|array<string> $evctnm_countname) Return \ChurchCRM\model\ChurchCRM\EventCountName objects filtered by the evctnm_countname column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\EventCountName>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class EventCountNameQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of EventCountNameQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\EventCountName',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventCountNameQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\EventCountNameQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildEventCountNameQuery) {
            return $criteria;
        }
        $query = new ChildEventCountNameQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventCountName|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventCountNameTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = EventCountNameTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\EventCountName|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildEventCountName
    {
        $sql = 'SELECT evctnm_countid, evctnm_eventtypeid, evctnm_countname FROM eventcountnames_evctnm WHERE evctnm_countid = :p0';
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
            $obj = new ChildEventCountName();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            EventCountNameTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\EventCountName|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventCountName>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('evctnm_countid');
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
        $resolvedColumn = $this->resolveLocalColumnByName('evctnm_countid');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the evctnm_countid column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE evctnm_countid = 1234
     * $query->filterById(array(12, 34)); // WHERE evctnm_countid IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE evctnm_countid > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('evctnm_countid');
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
     * Filter the query on the evctnm_eventtypeid column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE evctnm_eventtypeid = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE evctnm_eventtypeid IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE evctnm_eventtypeid > 12
     * </code>
     *
     * @param mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTypeId($typeId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evctnm_eventtypeid');
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingOperator($resolvedColumn, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingOperator($resolvedColumn, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $typeId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the evctnm_countname column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE evctnm_countname = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE evctnm_countname LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE evctnm_countname IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('evctnm_countname');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\EventCountName|null $eventCountName Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildEventCountName $eventCountName = null)
    {
        if ($eventCountName) {
            $resolvedColumn = $this->resolveLocalColumnByName('evctnm_countid');
            $this->addUsingOperator($resolvedColumn, $eventCountName->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the eventcountnames_evctnm table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventCountNameTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventCountNameTableMap::clearInstancePool();
            EventCountNameTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventCountNameTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventCountNameTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventCountNameTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            EventCountNameTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
