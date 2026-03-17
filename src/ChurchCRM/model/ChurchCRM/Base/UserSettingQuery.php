<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\UserSettingTableMap;
use ChurchCRM\model\ChurchCRM\UserSetting as ChildUserSetting;
use ChurchCRM\model\ChurchCRM\UserSettingQuery as ChildUserSettingQuery;
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
 * Base class that represents a query for the `user_settings` table.
 *
 * @method static orderByUserId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the user_id column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the setting_name column
 * @method static orderByValue($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the setting_value column
 *
 * @method static groupByUserId() Group by the user_id column
 * @method static groupByName() Group by the setting_name column
 * @method static groupByValue() Group by the setting_value column
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
 * @method \ChurchCRM\model\ChurchCRM\UserSetting|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\UserSetting matching the query
 * @method \ChurchCRM\model\ChurchCRM\UserSetting findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\UserSetting matching the query, or a new \ChurchCRM\model\ChurchCRM\UserSetting object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\UserSetting|null findOneByUserId(int $user_id) Return the first \ChurchCRM\model\ChurchCRM\UserSetting filtered by the user_id column
 * @method \ChurchCRM\model\ChurchCRM\UserSetting|null findOneByName(string $setting_name) Return the first \ChurchCRM\model\ChurchCRM\UserSetting filtered by the setting_name column
 * @method \ChurchCRM\model\ChurchCRM\UserSetting|null findOneByValue(string $setting_value) Return the first \ChurchCRM\model\ChurchCRM\UserSetting filtered by the setting_value column
 *
 * @method \ChurchCRM\model\ChurchCRM\UserSetting requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\UserSetting by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserSetting requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\UserSetting matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\UserSetting requireOneByUserId(int $user_id) Return the first \ChurchCRM\model\ChurchCRM\UserSetting filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserSetting requireOneByName(string $setting_name) Return the first \ChurchCRM\model\ChurchCRM\UserSetting filtered by the setting_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\UserSetting requireOneByValue(string $setting_value) Return the first \ChurchCRM\model\ChurchCRM\UserSetting filtered by the setting_value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection|array<\ChurchCRM\model\ChurchCRM\UserSetting>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserSetting> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\UserSetting objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\UserSetting objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\UserSetting>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserSetting> findByUserId(int|array<int> $user_id) Return \ChurchCRM\model\ChurchCRM\UserSetting objects filtered by the user_id column
 * @method array<\ChurchCRM\model\ChurchCRM\UserSetting>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserSetting> findByName(string|array<string> $setting_name) Return \ChurchCRM\model\ChurchCRM\UserSetting objects filtered by the setting_name column
 * @method array<\ChurchCRM\model\ChurchCRM\UserSetting>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\UserSetting> findByValue(string|array<string> $setting_value) Return \ChurchCRM\model\ChurchCRM\UserSetting objects filtered by the setting_value column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\UserSetting>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class UserSettingQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of UserSettingQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\UserSetting',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserSettingQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\UserSettingQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildUserSettingQuery) {
            return $criteria;
        }
        $query = new ChildUserSettingQuery();
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
     * @param array{int|null, string|null} $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\UserSetting|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserSettingTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
        $obj = UserSettingTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\UserSetting|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildUserSetting
    {
        $sql = 'SELECT user_id, setting_name, setting_value FROM user_settings WHERE user_id = :p0 AND setting_name = :p1';
        $stmt = $con->prepare($sql);
        if (is_bool($stmt)) {
            throw new PropelException('Failed to initialize statement');
        }
        $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
        $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            $obj = new ChildUserSetting();
            $obj->hydrate($row);
            $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
            UserSettingTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\UserSetting|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\UserSetting>|mixed|array the list of results, formatted by the current formatter
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
        $tableMap = UserSettingTableMap::getTableMap();
        $resolvedColumn = $this->resolveLocalColumnByName('user_id');
        $this->addUsingOperator($resolvedColumn, $key[0], Criteria::EQUAL);
        $resolvedColumn = $this->resolveLocalColumnByName('setting_name');
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

        $resolvedColumn0 = $this->resolveLocalColumnByName('user_id');
        $resolvedColumn1 = $this->resolveLocalColumnByName('setting_name');

        foreach ($keys as $key) {
            $filter0 = $this->buildFilter($resolvedColumn0, $key[0], Criteria::EQUAL);
            $this->addOr($filter0);

            $filter1 = $this->buildFilter($resolvedColumn1, $key[1], Criteria::EQUAL);
            $filter0->addAnd($filter1);
        }

        return $this;
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see static::filterByUser()
     *
     * @param mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByUserId($userId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('user_id');
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingOperator($resolvedColumn, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingOperator($resolvedColumn, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $userId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the setting_name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE setting_name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE setting_name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE setting_name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('setting_name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the setting_value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue'); // WHERE setting_value = 'fooValue'
     * $query->filterByValue('%fooValue%', Criteria::LIKE); // WHERE setting_value LIKE '%fooValue%'
     * $query->filterByValue(['foo', 'bar']); // WHERE setting_value IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $value The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByValue($value = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('setting_value');
        if ($comparison === null && is_array($value)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $value, $comparison);

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
                ->addUsingOperator($this->resolveLocalColumnByName('user_id'), $user->getPersonId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('user_id'), $user->toKeyValue('PrimaryKey', 'PersonId'), $comparison);

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
     * @param \ChurchCRM\model\ChurchCRM\UserSetting|null $userSetting Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildUserSetting $userSetting = null)
    {
        if ($userSetting) {
            $pkFilter = $this->buildFilter($this->resolveLocalColumnByName('user_id'), $userSetting->getUserId(), Criteria::NOT_EQUAL);
            $pkFilter->addOr($this->buildFilter($this->resolveLocalColumnByName('setting_name'), $userSetting->getName(), Criteria::NOT_EQUAL));
            $this->addAnd($pkFilter);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_settings table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSettingTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserSettingTableMap::clearInstancePool();
            UserSettingTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserSettingTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserSettingTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserSettingTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            UserSettingTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
