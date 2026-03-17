<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\KioskDevice as ChildKioskDevice;
use ChurchCRM\model\ChurchCRM\KioskDeviceQuery as ChildKioskDeviceQuery;
use ChurchCRM\model\ChurchCRM\Map\KioskDeviceTableMap;
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
 * Base class that represents a query for the `kioskdevice_kdev` table.
 *
 * This contains a list of all (un)registered kiosk devices
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_ID column
 * @method static orderByGUIDHash($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_GUIDHash column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_Name column
 * @method static orderByDeviceType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_deviceType column
 * @method static orderByLastHeartbeat($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_lastHeartbeat column
 * @method static orderByAccepted($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_Accepted column
 * @method static orderByPendingCommands($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the kdev_PendingCommands column
 *
 * @method static groupById() Group by the kdev_ID column
 * @method static groupByGUIDHash() Group by the kdev_GUIDHash column
 * @method static groupByName() Group by the kdev_Name column
 * @method static groupByDeviceType() Group by the kdev_deviceType column
 * @method static groupByLastHeartbeat() Group by the kdev_lastHeartbeat column
 * @method static groupByAccepted() Group by the kdev_Accepted column
 * @method static groupByPendingCommands() Group by the kdev_PendingCommands column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
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
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice matching the query
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice matching the query, or a new \ChurchCRM\model\ChurchCRM\KioskDevice object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneById(int $kdev_ID) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_ID column
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneByGUIDHash(string $kdev_GUIDHash) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_GUIDHash column
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneByName(string $kdev_Name) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_Name column
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneByDeviceType(string $kdev_deviceType) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_deviceType column
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneByLastHeartbeat(string $kdev_lastHeartbeat) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_lastHeartbeat column
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneByAccepted(bool $kdev_Accepted) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_Accepted column
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice|null findOneByPendingCommands(string $kdev_PendingCommands) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_PendingCommands column
 *
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\KioskDevice by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneById(int $kdev_ID) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneByGUIDHash(string $kdev_GUIDHash) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_GUIDHash column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneByName(string $kdev_Name) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneByDeviceType(string $kdev_deviceType) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_deviceType column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneByLastHeartbeat(string $kdev_lastHeartbeat) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_lastHeartbeat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneByAccepted(bool $kdev_Accepted) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_Accepted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\KioskDevice requireOneByPendingCommands(string $kdev_PendingCommands) Return the first \ChurchCRM\model\ChurchCRM\KioskDevice filtered by the kdev_PendingCommands column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\KioskDeviceCollection|array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\KioskDeviceCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\KioskDevice objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findById(int|array<int> $kdev_ID) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findByGUIDHash(string|array<string> $kdev_GUIDHash) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_GUIDHash column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findByName(string|array<string> $kdev_Name) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findByDeviceType(string|array<string> $kdev_deviceType) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_deviceType column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findByLastHeartbeat(string|array<string> $kdev_lastHeartbeat) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_lastHeartbeat column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findByAccepted(bool|array<bool> $kdev_Accepted) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_Accepted column
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\KioskDevice> findByPendingCommands(string|array<string> $kdev_PendingCommands) Return \ChurchCRM\model\ChurchCRM\KioskDevice objects filtered by the kdev_PendingCommands column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\KioskDevice>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class KioskDeviceQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of KioskDeviceQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\KioskDevice',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildKioskDeviceQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\KioskDeviceQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildKioskDeviceQuery) {
            return $criteria;
        }
        $query = new ChildKioskDeviceQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\KioskDevice|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = KioskDeviceTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\KioskDevice|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildKioskDevice
    {
        $sql = 'SELECT kdev_ID, kdev_GUIDHash, kdev_Name, kdev_deviceType, kdev_lastHeartbeat, kdev_Accepted, kdev_PendingCommands FROM kioskdevice_kdev WHERE kdev_ID = :p0';
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
            $obj = new ChildKioskDevice();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            KioskDeviceTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\KioskDevice|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\KioskDevice>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the kdev_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE kdev_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE kdev_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE kdev_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_ID');
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
     * Filter the query on the kdev_GUIDHash column
     *
     * Example usage:
     * <code>
     * $query->filterByGUIDHash('fooValue'); // WHERE kdev_GUIDHash = 'fooValue'
     * $query->filterByGUIDHash('%fooValue%', Criteria::LIKE); // WHERE kdev_GUIDHash LIKE '%fooValue%'
     * $query->filterByGUIDHash(['foo', 'bar']); // WHERE kdev_GUIDHash IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $gUIDHash The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByGUIDHash($gUIDHash = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_GUIDHash');
        if ($comparison === null && is_array($gUIDHash)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $gUIDHash, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kdev_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE kdev_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE kdev_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE kdev_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kdev_deviceType column
     *
     * Example usage:
     * <code>
     * $query->filterByDeviceType('fooValue'); // WHERE kdev_deviceType = 'fooValue'
     * $query->filterByDeviceType('%fooValue%', Criteria::LIKE); // WHERE kdev_deviceType LIKE '%fooValue%'
     * $query->filterByDeviceType(['foo', 'bar']); // WHERE kdev_deviceType IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $deviceType The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDeviceType($deviceType = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_deviceType');
        if ($comparison === null && is_array($deviceType)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $deviceType, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kdev_lastHeartbeat column
     *
     * Example usage:
     * <code>
     * $query->filterByLastHeartbeat('fooValue'); // WHERE kdev_lastHeartbeat = 'fooValue'
     * $query->filterByLastHeartbeat('%fooValue%', Criteria::LIKE); // WHERE kdev_lastHeartbeat LIKE '%fooValue%'
     * $query->filterByLastHeartbeat(['foo', 'bar']); // WHERE kdev_lastHeartbeat IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $lastHeartbeat The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByLastHeartbeat($lastHeartbeat = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_lastHeartbeat');
        if ($comparison === null && is_array($lastHeartbeat)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $lastHeartbeat, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kdev_Accepted column
     *
     * Example usage:
     * <code>
     * $query->filterByAccepted(true); // WHERE kdev_Accepted = true
     * $query->filterByAccepted('yes'); // WHERE kdev_Accepted = true
     * </code>
     *
     * @param string|bool|null $accepted The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAccepted($accepted = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_Accepted');
        if (is_string($accepted)) {
            $accepted = in_array(strtolower($accepted), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $accepted, $comparison);

        return $this;
    }

    /**
     * Filter the query on the kdev_PendingCommands column
     *
     * Example usage:
     * <code>
     * $query->filterByPendingCommands('fooValue'); // WHERE kdev_PendingCommands = 'fooValue'
     * $query->filterByPendingCommands('%fooValue%', Criteria::LIKE); // WHERE kdev_PendingCommands LIKE '%fooValue%'
     * $query->filterByPendingCommands(['foo', 'bar']); // WHERE kdev_PendingCommands IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $pendingCommands The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPendingCommands($pendingCommands = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('kdev_PendingCommands');
        if ($comparison === null && is_array($pendingCommands)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $pendingCommands, $comparison);

        return $this;
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
                ->addUsingOperator($this->resolveLocalColumnByName('kdev_ID'), $kioskAssignment->getKioskId(), $comparison);
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
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\KioskDevice|null $kioskDevice Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildKioskDevice $kioskDevice = null)
    {
        if ($kioskDevice) {
            $resolvedColumn = $this->resolveLocalColumnByName('kdev_ID');
            $this->addUsingOperator($resolvedColumn, $kioskDevice->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the kioskdevice_kdev table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            KioskDeviceTableMap::clearInstancePool();
            KioskDeviceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(KioskDeviceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            KioskDeviceTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            KioskDeviceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
