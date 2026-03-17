<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\VolunteerOpportunityTableMap;
use ChurchCRM\model\ChurchCRM\VolunteerOpportunity as ChildVolunteerOpportunity;
use ChurchCRM\model\ChurchCRM\VolunteerOpportunityQuery as ChildVolunteerOpportunityQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `volunteeropportunity_vol` table.
 *
 * This contains the names and descriptions of volunteer opportunities
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the vol_ID column
 * @method static orderByOrder($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the vol_Order column
 * @method static orderByActive($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the vol_Active column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the vol_Name column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the vol_Description column
 *
 * @method static groupById() Group by the vol_ID column
 * @method static groupByOrder() Group by the vol_Order column
 * @method static groupByActive() Group by the vol_Active column
 * @method static groupByName() Group by the vol_Name column
 * @method static groupByDescription() Group by the vol_Description column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity matching the query
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity matching the query, or a new \ChurchCRM\model\ChurchCRM\VolunteerOpportunity object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null findOneById(int $vol_ID) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_ID column
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null findOneByOrder(int $vol_Order) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Order column
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null findOneByActive(string $vol_Active) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Active column
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null findOneByName(string $vol_Name) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Name column
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null findOneByDescription(string $vol_Description) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Description column
 *
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\VolunteerOpportunity by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requireOneById(int $vol_ID) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requireOneByOrder(int $vol_Order) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requireOneByActive(string $vol_Active) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requireOneByName(string $vol_Name) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\VolunteerOpportunity requireOneByDescription(string $vol_Description) Return the first \ChurchCRM\model\ChurchCRM\VolunteerOpportunity filtered by the vol_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\VolunteerOpportunityCollection|array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\VolunteerOpportunityCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity> findById(int|array<int> $vol_ID) Return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects filtered by the vol_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity> findByOrder(int|array<int> $vol_Order) Return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects filtered by the vol_Order column
 * @method array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity> findByActive(string|array<string> $vol_Active) Return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects filtered by the vol_Active column
 * @method array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity> findByName(string|array<string> $vol_Name) Return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects filtered by the vol_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity> findByDescription(string|array<string> $vol_Description) Return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity objects filtered by the vol_Description column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\VolunteerOpportunity>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class VolunteerOpportunityQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of VolunteerOpportunityQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\VolunteerOpportunity',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildVolunteerOpportunityQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\VolunteerOpportunityQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildVolunteerOpportunityQuery) {
            return $criteria;
        }
        $query = new ChildVolunteerOpportunityQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\VolunteerOpportunity|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(VolunteerOpportunityTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = VolunteerOpportunityTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildVolunteerOpportunity
    {
        $sql = 'SELECT vol_ID, vol_Order, vol_Active, vol_Name, vol_Description FROM volunteeropportunity_vol WHERE vol_ID = :p0';
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
            $obj = new ChildVolunteerOpportunity();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            VolunteerOpportunityTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\VolunteerOpportunity|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\VolunteerOpportunity>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('vol_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('vol_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the vol_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE vol_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE vol_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE vol_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('vol_ID');
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
     * Filter the query on the vol_Order column
     *
     * Example usage:
     * <code>
     * $query->filterByOrder(1234); // WHERE vol_Order = 1234
     * $query->filterByOrder(array(12, 34)); // WHERE vol_Order IN (12, 34)
     * $query->filterByOrder(array('min' => 12)); // WHERE vol_Order > 12
     * </code>
     *
     * @param mixed $order The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOrder($order = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('vol_Order');
        if (is_array($order)) {
            $useMinMax = false;
            if (isset($order['min'])) {
                $this->addUsingOperator($resolvedColumn, $order['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($order['max'])) {
                $this->addUsingOperator($resolvedColumn, $order['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $order, $comparison);

        return $this;
    }

    /**
     * Filter the query on the vol_Active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive('fooValue'); // WHERE vol_Active = 'fooValue'
     * $query->filterByActive('%fooValue%', Criteria::LIKE); // WHERE vol_Active LIKE '%fooValue%'
     * $query->filterByActive(['foo', 'bar']); // WHERE vol_Active IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $active The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByActive($active = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('vol_Active');
        if ($comparison === null && is_array($active)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $active, $comparison);

        return $this;
    }

    /**
     * Filter the query on the vol_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE vol_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE vol_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE vol_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('vol_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the vol_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE vol_Description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE vol_Description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE vol_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('vol_Description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\VolunteerOpportunity|null $volunteerOpportunity Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildVolunteerOpportunity $volunteerOpportunity = null)
    {
        if ($volunteerOpportunity) {
            $resolvedColumn = $this->resolveLocalColumnByName('vol_ID');
            $this->addUsingOperator($resolvedColumn, $volunteerOpportunity->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the volunteeropportunity_vol table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(VolunteerOpportunityTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            VolunteerOpportunityTableMap::clearInstancePool();
            VolunteerOpportunityTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(VolunteerOpportunityTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(VolunteerOpportunityTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            VolunteerOpportunityTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            VolunteerOpportunityTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
