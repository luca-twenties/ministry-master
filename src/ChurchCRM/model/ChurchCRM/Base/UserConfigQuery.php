<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\UserConfigTableMap;
use ChurchCRM\model\ChurchCRM\UserConfig as ChildUserConfig;
use ChurchCRM\model\ChurchCRM\UserConfigQuery as ChildUserConfigQuery;
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
 * Base class that represents a query for the `userconfig_ucfg` table.
 *
 * @method static orderByPeronId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_per_id column
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_id column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_name column
 * @method static orderByValue($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_value column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_type column
 * @method static orderByTooltip($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_tooltip column
 * @method static orderByPermission($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_permission column
 * @method static orderByCat($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the ucfg_cat column
 *
 * @method static groupByPeronId() Group by the ucfg_per_id column
 * @method static groupById() Group by the ucfg_id column
 * @method static groupByName() Group by the ucfg_name column
 * @method static groupByValue() Group by the ucfg_value column
 * @method static groupByType() Group by the ucfg_type column
 * @method static groupByTooltip() Group by the ucfg_tooltip column
 * @method static groupByPermission() Group by the ucfg_permission column
 * @method static groupByCat() Group by the ucfg_cat column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method static rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method static innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method static joinWithUser($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method static leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method static rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method static innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\UserConfig matching the query
 * @method \ChurchCRM\model\ChurchCRM\UserConfig findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\UserConfig matching the query, or a new \ChurchCRM\model\ChurchCRM\UserConfig object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByPeronId(int $ucfg_per_id) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_per_id column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneById(int $ucfg_id) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_id column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByName(string $ucfg_name) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_name column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByValue(string $ucfg_value) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_value column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByType(string $ucfg_type) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_type column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByTooltip(string $ucfg_tooltip) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_tooltip column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByPermission(string $ucfg_permission) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_permission column
 * @method \ChurchCRM\model\ChurchCRM\UserConfig|null findOneByCat(string $ucfg_cat) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_cat column
 *
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\UserConfig by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\UserConfig matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByPeronId(int $ucfg_per_id) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_per_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneById(int $ucfg_id) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByName(string $ucfg_name) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByValue(string $ucfg_value) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByType(string $ucfg_type) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByTooltip(string $ucfg_tooltip) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_tooltip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByPermission(string $ucfg_permission) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_permission column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserConfig requireOneByCat(string $ucfg_cat) Return the first \ChurchCRM\model\ChurchCRM\UserConfig filtered by the ucfg_cat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\UserConfigCollection|array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\UserConfig objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\UserConfigCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\UserConfig objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByPeronId(int|array<int> $ucfg_per_id) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_per_id column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findById(int|array<int> $ucfg_id) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_id column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByName(string|array<string> $ucfg_name) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_name column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByValue(string|array<string> $ucfg_value) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_value column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByType(string|array<string> $ucfg_type) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_type column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByTooltip(string|array<string> $ucfg_tooltip) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_tooltip column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByPermission(string|array<string> $ucfg_permission) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_permission column
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserConfig> findByCat(string|array<string> $ucfg_cat) Return \ChurchCRM\model\ChurchCRM\UserConfig objects filtered by the ucfg_cat column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\UserConfig>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class UserConfigQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of UserConfigQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\UserConfig',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserConfigQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\UserConfigQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildUserConfigQuery) {
            return $criteria;
        }
        $query = new ChildUserConfigQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\UserConfig|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserConfigTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
        $obj = UserConfigTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\UserConfig|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildUserConfig
    {
        $sql = 'SELECT ucfg_per_id, ucfg_id, ucfg_name, ucfg_value, ucfg_type, ucfg_tooltip, ucfg_permission, ucfg_cat FROM userconfig_ucfg WHERE ucfg_per_id = :p0 AND ucfg_id = :p1';
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
            $obj = new ChildUserConfig();
            $obj->hydrate($row);
            $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
            UserConfigTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\UserConfig|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\UserConfig>|mixed|array the list of results, formatted by the current formatter
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
        $tableMap = UserConfigTableMap::getTableMap();
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_per_id');
        $this->addUsingOperator($resolvedColumn, $key[0], Criteria::EQUAL);
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_id');
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

        $resolvedColumn0 = $this->resolveLocalColumnByName('ucfg_per_id');
        $resolvedColumn1 = $this->resolveLocalColumnByName('ucfg_id');

        foreach ($keys as $key) {
            $filter0 = $this->buildFilter($resolvedColumn0, $key[0], Criteria::EQUAL);
            $this->addOr($filter0);

            $filter1 = $this->buildFilter($resolvedColumn1, $key[1], Criteria::EQUAL);
            $filter0->addAnd($filter1);
        }

        return $this;
    }

    /**
     * Filter the query on the ucfg_per_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPeronId(1234); // WHERE ucfg_per_id = 1234
     * $query->filterByPeronId(array(12, 34)); // WHERE ucfg_per_id IN (12, 34)
     * $query->filterByPeronId(array('min' => 12)); // WHERE ucfg_per_id > 12
     * </code>
     *
     * @see static::filterByUser()
     *
     * @param mixed $peronId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPeronId($peronId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_per_id');
        if (is_array($peronId)) {
            $useMinMax = false;
            if (isset($peronId['min'])) {
                $this->addUsingOperator($resolvedColumn, $peronId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($peronId['max'])) {
                $this->addUsingOperator($resolvedColumn, $peronId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $peronId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ucfg_id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE ucfg_id = 1234
     * $query->filterById(array(12, 34)); // WHERE ucfg_id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE ucfg_id > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_id');
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
     * Filter the query on the ucfg_name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE ucfg_name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE ucfg_name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE ucfg_name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ucfg_value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue'); // WHERE ucfg_value = 'fooValue'
     * $query->filterByValue('%fooValue%', Criteria::LIKE); // WHERE ucfg_value LIKE '%fooValue%'
     * $query->filterByValue(['foo', 'bar']); // WHERE ucfg_value IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $value The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByValue($value = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_value');
        if ($comparison === null && is_array($value)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $value, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ucfg_type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue'); // WHERE ucfg_type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE ucfg_type LIKE '%fooValue%'
     * $query->filterByType(['foo', 'bar']); // WHERE ucfg_type IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $type The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByType($type = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_type');
        if ($comparison === null && is_array($type)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $type, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ucfg_tooltip column
     *
     * Example usage:
     * <code>
     * $query->filterByTooltip('fooValue'); // WHERE ucfg_tooltip = 'fooValue'
     * $query->filterByTooltip('%fooValue%', Criteria::LIKE); // WHERE ucfg_tooltip LIKE '%fooValue%'
     * $query->filterByTooltip(['foo', 'bar']); // WHERE ucfg_tooltip IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $tooltip The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTooltip($tooltip = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_tooltip');
        if ($comparison === null && is_array($tooltip)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $tooltip, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ucfg_permission column
     *
     * Example usage:
     * <code>
     * $query->filterByPermission('fooValue'); // WHERE ucfg_permission = 'fooValue'
     * $query->filterByPermission('%fooValue%', Criteria::LIKE); // WHERE ucfg_permission LIKE '%fooValue%'
     * $query->filterByPermission(['foo', 'bar']); // WHERE ucfg_permission IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $permission The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPermission($permission = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_permission');
        if ($comparison === null && is_array($permission)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $permission, $comparison);

        return $this;
    }

    /**
     * Filter the query on the ucfg_cat column
     *
     * Example usage:
     * <code>
     * $query->filterByCat('fooValue'); // WHERE ucfg_cat = 'fooValue'
     * $query->filterByCat('%fooValue%', Criteria::LIKE); // WHERE ucfg_cat LIKE '%fooValue%'
     * $query->filterByCat(['foo', 'bar']); // WHERE ucfg_cat IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $cat The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByCat($cat = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('ucfg_cat');
        if ($comparison === null && is_array($cat)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $cat, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related User object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\User|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\User> $user The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByUser($user, ?string $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('ucfg_per_id'), $user->getPersonId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('ucfg_per_id'), $user->toKeyValue('PrimaryKey', 'PersonId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinUser(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> A secondary query class using the current class as primary query
     */
    public function useUserQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $query */
        $query = $this->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'User', '\ChurchCRM\model\ChurchCRM\UserQuery');

        return $query;
    }

    /**
     * Use the User relation User object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\UserQuery<mixed>):\ChurchCRM\model\ChurchCRM\UserQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useUserQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to User table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the EXISTS statement
     */
    public function useUserExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q */
        $q = $this->useExistsQuery('User', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to User table for a NOT EXISTS query.
     *
     * @see useUserExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useUserNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q*/
        $q = $this->useExistsQuery('User', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to User table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the IN statement
     */
    public function useInUserQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q */
        $q = $this->useInQuery('User', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to User table for a NOT IN query.
     *
     * @see useUserInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\UserQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInUserQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\UserQuery<static> $q */
        $q = $this->useInQuery('User', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\UserConfig|null $userConfig Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildUserConfig $userConfig = null)
    {
        if ($userConfig) {
            $pkFilter = $this->buildFilter($this->resolveLocalColumnByName('ucfg_per_id'), $userConfig->getPeronId(), Criteria::NOT_EQUAL);
            $pkFilter->addOr($this->buildFilter($this->resolveLocalColumnByName('ucfg_id'), $userConfig->getId(), Criteria::NOT_EQUAL));
            $this->addAnd($pkFilter);
        }

        return $this;
    }

    /**
     * Deletes all rows from the userconfig_ucfg table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserConfigTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserConfigTableMap::clearInstancePool();
            UserConfigTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserConfigTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserConfigTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserConfigTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            UserConfigTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
