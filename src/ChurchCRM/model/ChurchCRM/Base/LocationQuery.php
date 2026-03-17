<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Location as ChildLocation;
use ChurchCRM\model\ChurchCRM\LocationQuery as ChildLocationQuery;
use ChurchCRM\model\ChurchCRM\Map\LocationTableMap;
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
 * Base class that represents a query for the `locations` table.
 *
 * This is a table for storing all physical locations (Church Offices, Events, etc)
 *
 * @method static orderByLocationId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_id column
 * @method static orderByLocationType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_typeID column
 * @method static orderByLocationName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_name column
 * @method static orderByLocationAddress($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_address column
 * @method static orderByLocationCity($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_city column
 * @method static orderByLocationState($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_state column
 * @method static orderByLocationZip($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_zip column
 * @method static orderByLocationCountry($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_country column
 * @method static orderByLocationPhone($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_phone column
 * @method static orderByLocationEmail($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_email column
 * @method static orderByLocationTimzezone($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the location_timzezone column
 *
 * @method static groupByLocationId() Group by the location_id column
 * @method static groupByLocationType() Group by the location_typeID column
 * @method static groupByLocationName() Group by the location_name column
 * @method static groupByLocationAddress() Group by the location_address column
 * @method static groupByLocationCity() Group by the location_city column
 * @method static groupByLocationState() Group by the location_state column
 * @method static groupByLocationZip() Group by the location_zip column
 * @method static groupByLocationCountry() Group by the location_country column
 * @method static groupByLocationPhone() Group by the location_phone column
 * @method static groupByLocationEmail() Group by the location_email column
 * @method static groupByLocationTimzezone() Group by the location_timzezone column
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
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Location matching the query
 * @method \ChurchCRM\model\ChurchCRM\Location findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Location matching the query, or a new \ChurchCRM\model\ChurchCRM\Location object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationId(int $location_id) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_id column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationType(int $location_typeID) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_typeID column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationName(string $location_name) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_name column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationAddress(string $location_address) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_address column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationCity(string $location_city) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_city column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationState(string $location_state) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_state column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationZip(string $location_zip) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_zip column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationCountry(string $location_country) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_country column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationPhone(string $location_phone) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_phone column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationEmail(string $location_email) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_email column
 * @method \ChurchCRM\model\ChurchCRM\Location|null findOneByLocationTimzezone(string $location_timzezone) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_timzezone column
 *
 * @method \ChurchCRM\model\ChurchCRM\Location requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Location by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Location matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationId(int $location_id) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationType(int $location_typeID) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_typeID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationName(string $location_name) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationAddress(string $location_address) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationCity(string $location_city) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationState(string $location_state) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationZip(string $location_zip) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationCountry(string $location_country) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationPhone(string $location_phone) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationEmail(string $location_email) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Location requireOneByLocationTimzezone(string $location_timzezone) Return the first \ChurchCRM\model\ChurchCRM\Location filtered by the location_timzezone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\LocationCollection|array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Location objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\LocationCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Location objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationId(int|array<int> $location_id) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_id column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationType(int|array<int> $location_typeID) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_typeID column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationName(string|array<string> $location_name) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_name column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationAddress(string|array<string> $location_address) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_address column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationCity(string|array<string> $location_city) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_city column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationState(string|array<string> $location_state) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_state column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationZip(string|array<string> $location_zip) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_zip column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationCountry(string|array<string> $location_country) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_country column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationPhone(string|array<string> $location_phone) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_phone column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationEmail(string|array<string> $location_email) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_email column
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Location> findByLocationTimzezone(string|array<string> $location_timzezone) Return \ChurchCRM\model\ChurchCRM\Location objects filtered by the location_timzezone column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Location>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class LocationQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of LocationQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Location',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLocationQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\LocationQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildLocationQuery) {
            return $criteria;
        }
        $query = new ChildLocationQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Location|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LocationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = LocationTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Location|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildLocation
    {
        $sql = 'SELECT location_id, location_typeID, location_name, location_address, location_city, location_state, location_zip, location_country, location_phone, location_email, location_timzezone FROM locations WHERE location_id = :p0';
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
            $obj = new ChildLocation();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            LocationTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Location|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Location>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('location_id');
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
        $resolvedColumn = $this->resolveLocalColumnByName('location_id');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

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
     * Filter the query on the location_typeID column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationType(1234); // WHERE location_typeID = 1234
     * $query->filterByLocationType(array(12, 34)); // WHERE location_typeID IN (12, 34)
     * $query->filterByLocationType(array('min' => 12)); // WHERE location_typeID > 12
     * </code>
     *
     * @param mixed $locationType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationType($locationType = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_typeID');
        if (is_array($locationType)) {
            $useMinMax = false;
            if (isset($locationType['min'])) {
                $this->addUsingOperator($resolvedColumn, $locationType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationType['max'])) {
                $this->addUsingOperator($resolvedColumn, $locationType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $locationType, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationName('fooValue'); // WHERE location_name = 'fooValue'
     * $query->filterByLocationName('%fooValue%', Criteria::LIKE); // WHERE location_name LIKE '%fooValue%'
     * $query->filterByLocationName(['foo', 'bar']); // WHERE location_name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationName($locationName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_name');
        if ($comparison === null && is_array($locationName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_address column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationAddress('fooValue'); // WHERE location_address = 'fooValue'
     * $query->filterByLocationAddress('%fooValue%', Criteria::LIKE); // WHERE location_address LIKE '%fooValue%'
     * $query->filterByLocationAddress(['foo', 'bar']); // WHERE location_address IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationAddress The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationAddress($locationAddress = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_address');
        if ($comparison === null && is_array($locationAddress)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationAddress, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_city column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationCity('fooValue'); // WHERE location_city = 'fooValue'
     * $query->filterByLocationCity('%fooValue%', Criteria::LIKE); // WHERE location_city LIKE '%fooValue%'
     * $query->filterByLocationCity(['foo', 'bar']); // WHERE location_city IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationCity The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationCity($locationCity = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_city');
        if ($comparison === null && is_array($locationCity)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationCity, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_state column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationState('fooValue'); // WHERE location_state = 'fooValue'
     * $query->filterByLocationState('%fooValue%', Criteria::LIKE); // WHERE location_state LIKE '%fooValue%'
     * $query->filterByLocationState(['foo', 'bar']); // WHERE location_state IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationState The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationState($locationState = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_state');
        if ($comparison === null && is_array($locationState)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationState, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_zip column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationZip('fooValue'); // WHERE location_zip = 'fooValue'
     * $query->filterByLocationZip('%fooValue%', Criteria::LIKE); // WHERE location_zip LIKE '%fooValue%'
     * $query->filterByLocationZip(['foo', 'bar']); // WHERE location_zip IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationZip The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationZip($locationZip = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_zip');
        if ($comparison === null && is_array($locationZip)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationZip, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_country column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationCountry('fooValue'); // WHERE location_country = 'fooValue'
     * $query->filterByLocationCountry('%fooValue%', Criteria::LIKE); // WHERE location_country LIKE '%fooValue%'
     * $query->filterByLocationCountry(['foo', 'bar']); // WHERE location_country IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationCountry The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationCountry($locationCountry = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_country');
        if ($comparison === null && is_array($locationCountry)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationCountry, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationPhone('fooValue'); // WHERE location_phone = 'fooValue'
     * $query->filterByLocationPhone('%fooValue%', Criteria::LIKE); // WHERE location_phone LIKE '%fooValue%'
     * $query->filterByLocationPhone(['foo', 'bar']); // WHERE location_phone IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationPhone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationPhone($locationPhone = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_phone');
        if ($comparison === null && is_array($locationPhone)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationPhone, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_email column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationEmail('fooValue'); // WHERE location_email = 'fooValue'
     * $query->filterByLocationEmail('%fooValue%', Criteria::LIKE); // WHERE location_email LIKE '%fooValue%'
     * $query->filterByLocationEmail(['foo', 'bar']); // WHERE location_email IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationEmail The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationEmail($locationEmail = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_email');
        if ($comparison === null && is_array($locationEmail)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationEmail, $comparison);

        return $this;
    }

    /**
     * Filter the query on the location_timzezone column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationTimzezone('fooValue'); // WHERE location_timzezone = 'fooValue'
     * $query->filterByLocationTimzezone('%fooValue%', Criteria::LIKE); // WHERE location_timzezone LIKE '%fooValue%'
     * $query->filterByLocationTimzezone(['foo', 'bar']); // WHERE location_timzezone IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $locationTimzezone The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLocationTimzezone($locationTimzezone = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('location_timzezone');
        if ($comparison === null && is_array($locationTimzezone)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $locationTimzezone, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Event object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event> $event the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByEvent(Event|ObjectCollection $event, ?string $comparison = null)
    {
        if ($event instanceof Event) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('location_id'), $event->getLocationId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            $this
                ->useEventQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEvent() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Event or Collection');
        }

        return $this;
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
     * @param \ChurchCRM\model\ChurchCRM\Location|null $location Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildLocation $location = null)
    {
        if ($location) {
            $resolvedColumn = $this->resolveLocalColumnByName('location_id');
            $this->addUsingOperator($resolvedColumn, $location->getLocationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the locations table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LocationTableMap::clearInstancePool();
            LocationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LocationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LocationTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            LocationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
