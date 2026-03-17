<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\VersionTableMap;
use ChurchCRM\model\ChurchCRM\Version as ChildVersion;
use ChurchCRM\model\ChurchCRM\VersionQuery as ChildVersionQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `version_ver` table.
 *
 * History of all version upgrades applied to this database
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ver_ID column
 * @method static orderByVersion($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ver_version column
 * @method static orderByUpdateStart($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ver_update_start column
 * @method static orderByUpdateEnd($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ver_update_end column
 *
 * @method static groupById() Group by the ver_ID column
 * @method static groupByVersion() Group by the ver_version column
 * @method static groupByUpdateStart() Group by the ver_update_start column
 * @method static groupByUpdateEnd() Group by the ver_update_end column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\Version|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Version matching the query
 * @method \ChurchCRM\model\ChurchCRM\Version findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Version matching the query, or a new \ChurchCRM\model\ChurchCRM\Version object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Version|null findOneById(int $ver_ID) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_ID column
 * @method \ChurchCRM\model\ChurchCRM\Version|null findOneByVersion(string $ver_version) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_version column
 * @method \ChurchCRM\model\ChurchCRM\Version|null findOneByUpdateStart(string $ver_update_start) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_update_start column
 * @method \ChurchCRM\model\ChurchCRM\Version|null findOneByUpdateEnd(string $ver_update_end) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_update_end column
 *
 * @method \ChurchCRM\model\ChurchCRM\Version requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Version by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Version requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Version matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Version requireOneById(int $ver_ID) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Version requireOneByVersion(string $ver_version) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Version requireOneByUpdateStart(string $ver_update_start) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_update_start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Version requireOneByUpdateEnd(string $ver_update_end) Return the first \ChurchCRM\model\ChurchCRM\Version filtered by the ver_update_end column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\VersionCollection|array<\ChurchCRM\model\ChurchCRM\Version>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Version> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Version objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\VersionCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Version objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Version>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Version> findById(int|array<int> $ver_ID) Return \ChurchCRM\model\ChurchCRM\Version objects filtered by the ver_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Version>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Version> findByVersion(string|array<string> $ver_version) Return \ChurchCRM\model\ChurchCRM\Version objects filtered by the ver_version column
 * @method array<\ChurchCRM\model\ChurchCRM\Version>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Version> findByUpdateStart(string|array<string> $ver_update_start) Return \ChurchCRM\model\ChurchCRM\Version objects filtered by the ver_update_start column
 * @method array<\ChurchCRM\model\ChurchCRM\Version>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Version> findByUpdateEnd(string|array<string> $ver_update_end) Return \ChurchCRM\model\ChurchCRM\Version objects filtered by the ver_update_end column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Version>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class VersionQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of VersionQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Version',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVersionQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\VersionQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildVersionQuery) {
            return $criteria;
        }
        $query = new ChildVersionQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Version|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = VersionTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Version|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildVersion
    {
        $sql = 'SELECT ver_ID, ver_version, ver_update_start, ver_update_end FROM version_ver WHERE ver_ID = :p0';
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
            $obj = new ChildVersion();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            VersionTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Version|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Version>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('ver_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('ver_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the ver_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ver_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE ver_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ver_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('ver_ID');
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
     * Filter the query on the ver_version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion('fooValue'); // WHERE ver_version = 'fooValue'
     * $query->filterByVersion('%fooValue%', Criteria::LIKE); // WHERE ver_version LIKE '%fooValue%'
     * $query->filterByVersion(['foo', 'bar']); // WHERE ver_version IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $version The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByVersion($version = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ver_version');
        if ($comparison === null && is_array($version)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $version, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ver_update_start column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateStart('2011-03-14'); // WHERE ver_update_start = '2011-03-14'
     * $query->filterByUpdateStart('now'); // WHERE ver_update_start = '2011-03-14'
     * $query->filterByUpdateStart(array('max' => 'yesterday')); // WHERE ver_update_start > '2011-03-13'
     * </code>
     *
     * @param mixed $updateStart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByUpdateStart($updateStart = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ver_update_start');
        if (is_array($updateStart)) {
            $useMinMax = false;
            if (isset($updateStart['min'])) {
                $this->addUsingOperator($resolvedColumn, $updateStart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateStart['max'])) {
                $this->addUsingOperator($resolvedColumn, $updateStart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $updateStart, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ver_update_end column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdateEnd('2011-03-14'); // WHERE ver_update_end = '2011-03-14'
     * $query->filterByUpdateEnd('now'); // WHERE ver_update_end = '2011-03-14'
     * $query->filterByUpdateEnd(array('max' => 'yesterday')); // WHERE ver_update_end > '2011-03-13'
     * </code>
     *
     * @param mixed $updateEnd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByUpdateEnd($updateEnd = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ver_update_end');
        if (is_array($updateEnd)) {
            $useMinMax = false;
            if (isset($updateEnd['min'])) {
                $this->addUsingOperator($resolvedColumn, $updateEnd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updateEnd['max'])) {
                $this->addUsingOperator($resolvedColumn, $updateEnd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $updateEnd, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Version|null $version Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildVersion $version = null)
    {
        if ($version) {
            $resolvedColumn = $this->resolveLocalColumnByName('ver_ID');
            $this->addUsingOperator($resolvedColumn, $version->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the version_ver table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VersionTableMap::clearInstancePool();
            VersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VersionTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            VersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
