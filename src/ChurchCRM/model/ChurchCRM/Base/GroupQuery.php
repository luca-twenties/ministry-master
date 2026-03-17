<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Group as ChildGroup;
use ChurchCRM\model\ChurchCRM\GroupQuery as ChildGroupQuery;
use ChurchCRM\model\ChurchCRM\Map\GroupTableMap;
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
 * Base class that represents a query for the `group_grp` table.
 *
 * This contains the name and description for each group, as well as foreign keys to the list of group roles
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_ID column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_Type column
 * @method static orderByRoleListId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_RoleListID column
 * @method static orderByDefaultRole($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_DefaultRole column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_Name column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_Description column
 * @method static orderByHasSpecialProps($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_hasSpecialProps column
 * @method static orderByActive($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_active column
 * @method static orderByIncludeInEmailExport($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_include_email_export column
 *
 * @method static groupById() Group by the grp_ID column
 * @method static groupByType() Group by the grp_Type column
 * @method static groupByRoleListId() Group by the grp_RoleListID column
 * @method static groupByDefaultRole() Group by the grp_DefaultRole column
 * @method static groupByName() Group by the grp_Name column
 * @method static groupByDescription() Group by the grp_Description column
 * @method static groupByHasSpecialProps() Group by the grp_hasSpecialProps column
 * @method static groupByActive() Group by the grp_active column
 * @method static groupByIncludeInEmailExport() Group by the grp_include_email_export column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinListOption($relationAlias = null) Adds a LEFT JOIN clause to the query using the ListOption relation
 * @method static rightJoinListOption($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ListOption relation
 * @method static innerJoinListOption($relationAlias = null) Adds a INNER JOIN clause to the query using the ListOption relation
 *
 * @method static joinWithListOption($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the ListOption relation
 *
 * @method static leftJoinWithListOption() Adds a LEFT JOIN clause and with to the query using the ListOption relation
 * @method static rightJoinWithListOption() Adds a RIGHT JOIN clause and with to the query using the ListOption relation
 * @method static innerJoinWithListOption() Adds a INNER JOIN clause and with to the query using the ListOption relation
 *
 * @method static leftJoinPerson2group2roleP2g2r($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person2group2roleP2g2r relation
 * @method static rightJoinPerson2group2roleP2g2r($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person2group2roleP2g2r relation
 * @method static innerJoinPerson2group2roleP2g2r($relationAlias = null) Adds a INNER JOIN clause to the query using the Person2group2roleP2g2r relation
 *
 * @method static joinWithPerson2group2roleP2g2r($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person2group2roleP2g2r relation
 *
 * @method static leftJoinWithPerson2group2roleP2g2r() Adds a LEFT JOIN clause and with to the query using the Person2group2roleP2g2r relation
 * @method static rightJoinWithPerson2group2roleP2g2r() Adds a RIGHT JOIN clause and with to the query using the Person2group2roleP2g2r relation
 * @method static innerJoinWithPerson2group2roleP2g2r() Adds a INNER JOIN clause and with to the query using the Person2group2roleP2g2r relation
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
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Group matching the query
 * @method \ChurchCRM\model\ChurchCRM\Group findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Group matching the query, or a new \ChurchCRM\model\ChurchCRM\Group object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneById(int $grp_ID) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_ID column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByType(int $grp_Type) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_Type column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByRoleListId(int $grp_RoleListID) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_RoleListID column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByDefaultRole(int $grp_DefaultRole) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_DefaultRole column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByName(string $grp_Name) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_Name column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByDescription(string $grp_Description) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_Description column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByHasSpecialProps(bool $grp_hasSpecialProps) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_hasSpecialProps column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByActive(bool $grp_active) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_active column
 * @method \ChurchCRM\model\ChurchCRM\Group|null findOneByIncludeInEmailExport(bool $grp_include_email_export) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_include_email_export column
 *
 * @method \ChurchCRM\model\ChurchCRM\Group requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Group by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Group matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneById(int $grp_ID) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByType(int $grp_Type) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByRoleListId(int $grp_RoleListID) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_RoleListID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByDefaultRole(int $grp_DefaultRole) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_DefaultRole column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByName(string $grp_Name) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByDescription(string $grp_Description) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByHasSpecialProps(bool $grp_hasSpecialProps) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_hasSpecialProps column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByActive(bool $grp_active) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Group requireOneByIncludeInEmailExport(bool $grp_include_email_export) Return the first \ChurchCRM\model\ChurchCRM\Group filtered by the grp_include_email_export column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\GroupCollection|array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Group objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\GroupCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Group objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findById(int|array<int> $grp_ID) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByType(int|array<int> $grp_Type) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_Type column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByRoleListId(int|array<int> $grp_RoleListID) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_RoleListID column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByDefaultRole(int|array<int> $grp_DefaultRole) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_DefaultRole column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByName(string|array<string> $grp_Name) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByDescription(string|array<string> $grp_Description) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_Description column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByHasSpecialProps(bool|array<bool> $grp_hasSpecialProps) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_hasSpecialProps column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByActive(bool|array<bool> $grp_active) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_active column
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Group> findByIncludeInEmailExport(bool|array<bool> $grp_include_email_export) Return \ChurchCRM\model\ChurchCRM\Group objects filtered by the grp_include_email_export column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Group>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class GroupQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of GroupQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Group',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildGroupQuery) {
            return $criteria;
        }
        $query = new ChildGroupQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Group|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = GroupTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Group|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildGroup
    {
        $sql = 'SELECT grp_ID, grp_Type, grp_RoleListID, grp_DefaultRole, grp_Name, grp_Description, grp_hasSpecialProps, grp_active, grp_include_email_export FROM group_grp WHERE grp_ID = :p0';
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
            $obj = new ChildGroup();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            GroupTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Group|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Group>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('grp_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('grp_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the grp_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE grp_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE grp_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE grp_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('grp_ID');
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
     * Filter the query on the grp_Type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE grp_Type = 1234
     * $query->filterByType(array(12, 34)); // WHERE grp_Type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE grp_Type > 12
     * </code>
     *
     * @see static::filterByListOption()
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
        $resolvedColumn = $this->resolveLocalColumnByName('grp_Type');
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
     * Filter the query on the grp_RoleListID column
     *
     * Example usage:
     * <code>
     * $query->filterByRoleListId(1234); // WHERE grp_RoleListID = 1234
     * $query->filterByRoleListId(array(12, 34)); // WHERE grp_RoleListID IN (12, 34)
     * $query->filterByRoleListId(array('min' => 12)); // WHERE grp_RoleListID > 12
     * </code>
     *
     * @see static::filterByListOption()
     *
     * @param mixed $roleListId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByRoleListId($roleListId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_RoleListID');
        if (is_array($roleListId)) {
            $useMinMax = false;
            if (isset($roleListId['min'])) {
                $this->addUsingOperator($resolvedColumn, $roleListId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($roleListId['max'])) {
                $this->addUsingOperator($resolvedColumn, $roleListId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $roleListId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the grp_DefaultRole column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultRole(1234); // WHERE grp_DefaultRole = 1234
     * $query->filterByDefaultRole(array(12, 34)); // WHERE grp_DefaultRole IN (12, 34)
     * $query->filterByDefaultRole(array('min' => 12)); // WHERE grp_DefaultRole > 12
     * </code>
     *
     * @param mixed $defaultRole The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefaultRole($defaultRole = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_DefaultRole');
        if (is_array($defaultRole)) {
            $useMinMax = false;
            if (isset($defaultRole['min'])) {
                $this->addUsingOperator($resolvedColumn, $defaultRole['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($defaultRole['max'])) {
                $this->addUsingOperator($resolvedColumn, $defaultRole['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $defaultRole, $comparison);

        return $this;
    }

    /**
     * Filter the query on the grp_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE grp_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE grp_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE grp_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the grp_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE grp_Description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE grp_Description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE grp_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_Description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

        return $this;
    }

    /**
     * Filter the query on the grp_hasSpecialProps column
     *
     * Example usage:
     * <code>
     * $query->filterByHasSpecialProps(true); // WHERE grp_hasSpecialProps = true
     * $query->filterByHasSpecialProps('yes'); // WHERE grp_hasSpecialProps = true
     * </code>
     *
     * @param string|bool|null $hasSpecialProps The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByHasSpecialProps($hasSpecialProps = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_hasSpecialProps');
        if (is_string($hasSpecialProps)) {
            $hasSpecialProps = in_array(strtolower($hasSpecialProps), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $hasSpecialProps, $comparison);

        return $this;
    }

    /**
     * Filter the query on the grp_active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(true); // WHERE grp_active = true
     * $query->filterByActive('yes'); // WHERE grp_active = true
     * </code>
     *
     * @param string|bool|null $active The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByActive($active = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_active');
        if (is_string($active)) {
            $active = in_array(strtolower($active), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $active, $comparison);

        return $this;
    }

    /**
     * Filter the query on the grp_include_email_export column
     *
     * Example usage:
     * <code>
     * $query->filterByIncludeInEmailExport(true); // WHERE grp_include_email_export = true
     * $query->filterByIncludeInEmailExport('yes'); // WHERE grp_include_email_export = true
     * </code>
     *
     * @param string|bool|null $includeInEmailExport The value to use as filter.
     *      Non-boolean arguments are converted using the following rules:
     *          - 1, '1', 'true', 'on', and 'yes' are converted to boolean true
     *          - 0, '0', 'false', 'off', and 'no' are converted to boolean false
     *      Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByIncludeInEmailExport($includeInEmailExport = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_include_email_export');
        if (is_string($includeInEmailExport)) {
            $includeInEmailExport = in_array(strtolower($includeInEmailExport), ['false', 'off', '-', 'no', 'n', '0', ''], true) ? false : true;
        }
        $this->addUsingOperator($resolvedColumn, $includeInEmailExport, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related ListOption object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\ListOption|null $listOption The related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByListOption($listOption, ?string $comparison = null)
    {
        if ($listOption instanceof ListOption) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('grp_RoleListID'), $listOption->getId(), $comparison)
                ->addUsingOperator($this->resolveLocalColumnByName('grp_Type'), $listOption->getOptionId(), $comparison);
        } else {
            throw new PropelException('filterByListOption() only accepts arguments of type ListOption');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ListOption relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinListOption(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ListOption');

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
            $this->addJoinObject($join, 'ListOption');
        }

        return $this;
    }

    /**
     * Use the ListOption relation ListOption object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> A secondary query class using the current class as primary query
     */
    public function useListOptionQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> $query */
        $query = $this->joinListOption($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'ListOption', '\ChurchCRM\model\ChurchCRM\ListOptionQuery');

        return $query;
    }

    /**
     * Use the ListOption relation ListOption object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\ListOptionQuery<mixed>):\ChurchCRM\model\ChurchCRM\ListOptionQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withListOptionQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useListOptionQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to ListOption table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> The inner query object of the EXISTS statement
     */
    public function useListOptionExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> $q */
        $q = $this->useExistsQuery('ListOption', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to ListOption table for a NOT EXISTS query.
     *
     * @see useListOptionExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useListOptionNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> $q*/
        $q = $this->useExistsQuery('ListOption', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to ListOption table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> The inner query object of the IN statement
     */
    public function useInListOptionQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> $q */
        $q = $this->useInQuery('ListOption', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to ListOption table for a NOT IN query.
     *
     * @see useListOptionInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInListOptionQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\ListOptionQuery<static> $q */
        $q = $this->useInQuery('ListOption', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Person2group2roleP2g2r object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r> $person2group2roleP2g2r the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByPerson2group2roleP2g2r(Person2group2roleP2g2r|ObjectCollection $person2group2roleP2g2r, ?string $comparison = null)
    {
        if ($person2group2roleP2g2r instanceof Person2group2roleP2g2r) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('grp_ID'), $person2group2roleP2g2r->getGroupId(), $comparison);
        } elseif ($person2group2roleP2g2r instanceof ObjectCollection) {
            $this
                ->usePerson2group2roleP2g2rQuery()
                ->filterByPrimaryKeys($person2group2roleP2g2r->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPerson2group2roleP2g2r() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the Person2group2roleP2g2r relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPerson2group2roleP2g2r(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person2group2roleP2g2r');

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
            $this->addJoinObject($join, 'Person2group2roleP2g2r');
        }

        return $this;
    }

    /**
     * Use the Person2group2roleP2g2r relation Person2group2roleP2g2r object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> A secondary query class using the current class as primary query
     */
    public function usePerson2group2roleP2g2rQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $query */
        $query = $this->joinPerson2group2roleP2g2r($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Person2group2roleP2g2r', '\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery');

        return $query;
    }

    /**
     * Use the Person2group2roleP2g2r relation Person2group2roleP2g2r object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<mixed>):\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPerson2group2roleP2g2rQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePerson2group2roleP2g2rQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the EXISTS statement
     */
    public function usePerson2group2roleP2g2rExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q */
        $q = $this->useExistsQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for a NOT EXISTS query.
     *
     * @see usePerson2group2roleP2g2rExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePerson2group2roleP2g2rNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q*/
        $q = $this->useExistsQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the IN statement
     */
    public function useInPerson2group2roleP2g2rQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q */
        $q = $this->useInQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Person2group2roleP2g2r table for a NOT IN query.
     *
     * @see usePerson2group2roleP2g2rInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPerson2group2roleP2g2rQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery<static> $q */
        $q = $this->useInQuery('Person2group2roleP2g2r', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related EventType object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventType|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventType> $eventType the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByEventType(EventType|ObjectCollection $eventType, ?string $comparison = null)
    {
        if ($eventType instanceof EventType) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('grp_ID'), $eventType->getGroupId(), $comparison);
        } elseif ($eventType instanceof ObjectCollection) {
            $this
                ->useEventTypeQuery()
                ->filterByPrimaryKeys($eventType->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventType() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\EventType or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the EventType relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinEventType(?string $relationAlias = null, ?string $joinType = Criteria::LEFT_JOIN)
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
    public function useEventTypeQuery(?string $relationAlias = null, string $joinType = Criteria::LEFT_JOIN)
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
        ?string $joinType = Criteria::LEFT_JOIN
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
                ->addUsingOperator($this->resolveLocalColumnByName('grp_ID'), $eventAudience->getGroupId(), $comparison);
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
     * Filter the query by a related Event object
     * using the event_audience table as cross reference
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL and Criteria::IN for queries
     *
     * @return $this
     */
    public function filterByEvent(Event $event, ?string $comparison = null)
    {
        $this
            ->useEventAudienceQuery()
            ->filterByEvent($event, $comparison)
            ->endUse();

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Group|null $group Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildGroup $group = null)
    {
        if ($group) {
            $resolvedColumn = $this->resolveLocalColumnByName('grp_ID');
            $this->addUsingOperator($resolvedColumn, $group->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the group_grp table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupTableMap::clearInstancePool();
            GroupTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GroupTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            GroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
