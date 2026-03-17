<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\RecordPropertyTableMap;
use ChurchCRM\model\ChurchCRM\RecordProperty as ChildRecordProperty;
use ChurchCRM\model\ChurchCRM\RecordPropertyQuery as ChildRecordPropertyQuery;
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
 * Base class that represents a query for the `record2property_r2p` table.
 *
 * This table indicates which persons, families, or groups are assigned specific properties and what the values of those properties are.
 *
 * @method static orderByPropertyId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the r2p_pro_ID column
 * @method static orderByRecordId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the r2p_record_ID column
 * @method static orderByPropertyValue($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the r2p_Value column
 *
 * @method static groupByPropertyId() Group by the r2p_pro_ID column
 * @method static groupByRecordId() Group by the r2p_record_ID column
 * @method static groupByPropertyValue() Group by the r2p_Value column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinProperty($relationAlias = null) Adds a LEFT JOIN clause to the query using the Property relation
 * @method static rightJoinProperty($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Property relation
 * @method static innerJoinProperty($relationAlias = null) Adds a INNER JOIN clause to the query using the Property relation
 *
 * @method static joinWithProperty($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Property relation
 *
 * @method static leftJoinWithProperty() Adds a LEFT JOIN clause and with to the query using the Property relation
 * @method static rightJoinWithProperty() Adds a RIGHT JOIN clause and with to the query using the Property relation
 * @method static innerJoinWithProperty() Adds a INNER JOIN clause and with to the query using the Property relation
 *
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty matching the query
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty matching the query, or a new \ChurchCRM\model\ChurchCRM\RecordProperty object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty|null findOneByPropertyId(int $r2p_pro_ID) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty filtered by the r2p_pro_ID column
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty|null findOneByRecordId(int $r2p_record_ID) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty filtered by the r2p_record_ID column
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty|null findOneByPropertyValue(string $r2p_Value) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty filtered by the r2p_Value column
 *
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\RecordProperty by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty requireOneByPropertyId(int $r2p_pro_ID) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty filtered by the r2p_pro_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty requireOneByRecordId(int $r2p_record_ID) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty filtered by the r2p_record_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\RecordProperty requireOneByPropertyValue(string $r2p_Value) Return the first \ChurchCRM\model\ChurchCRM\RecordProperty filtered by the r2p_Value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection|array<\ChurchCRM\model\ChurchCRM\RecordProperty>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\RecordProperty> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\RecordProperty objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\RecordProperty objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\RecordProperty>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\RecordProperty> findByPropertyId(int|array<int> $r2p_pro_ID) Return \ChurchCRM\model\ChurchCRM\RecordProperty objects filtered by the r2p_pro_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\RecordProperty>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\RecordProperty> findByRecordId(int|array<int> $r2p_record_ID) Return \ChurchCRM\model\ChurchCRM\RecordProperty objects filtered by the r2p_record_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\RecordProperty>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\RecordProperty> findByPropertyValue(string|array<string> $r2p_Value) Return \ChurchCRM\model\ChurchCRM\RecordProperty objects filtered by the r2p_Value column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\RecordProperty>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class RecordPropertyQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of RecordPropertyQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\RecordProperty',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRecordPropertyQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildRecordPropertyQuery) {
            return $criteria;
        }
        $query = new ChildRecordPropertyQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\RecordProperty|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RecordPropertyTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
        $obj = RecordPropertyTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\RecordProperty|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildRecordProperty
    {
        $sql = 'SELECT r2p_pro_ID, r2p_record_ID, r2p_Value FROM record2property_r2p WHERE r2p_pro_ID = :p0 AND r2p_record_ID = :p1';
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
            $obj = new ChildRecordProperty();
            $obj->hydrate($row);
            $poolKey = serialize(array_map(fn ($k) => (string)$k, $key));
            RecordPropertyTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\RecordProperty|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\RecordProperty>|mixed|array the list of results, formatted by the current formatter
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
        $tableMap = RecordPropertyTableMap::getTableMap();
        $resolvedColumn = $this->resolveLocalColumnByName('r2p_pro_ID');
        $this->addUsingOperator($resolvedColumn, $key[0], Criteria::EQUAL);
        $resolvedColumn = $this->resolveLocalColumnByName('r2p_record_ID');
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

        $resolvedColumn0 = $this->resolveLocalColumnByName('r2p_pro_ID');
        $resolvedColumn1 = $this->resolveLocalColumnByName('r2p_record_ID');

        foreach ($keys as $key) {
            $filter0 = $this->buildFilter($resolvedColumn0, $key[0], Criteria::EQUAL);
            $this->addOr($filter0);

            $filter1 = $this->buildFilter($resolvedColumn1, $key[1], Criteria::EQUAL);
            $filter0->addAnd($filter1);
        }

        return $this;
    }

    /**
     * Filter the query on the r2p_pro_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByPropertyId(1234); // WHERE r2p_pro_ID = 1234
     * $query->filterByPropertyId(array(12, 34)); // WHERE r2p_pro_ID IN (12, 34)
     * $query->filterByPropertyId(array('min' => 12)); // WHERE r2p_pro_ID > 12
     * </code>
     *
     * @see static::filterByProperty()
     *
     * @param mixed $propertyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPropertyId($propertyId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('r2p_pro_ID');
        if (is_array($propertyId)) {
            $useMinMax = false;
            if (isset($propertyId['min'])) {
                $this->addUsingOperator($resolvedColumn, $propertyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($propertyId['max'])) {
                $this->addUsingOperator($resolvedColumn, $propertyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $propertyId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the r2p_record_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByRecordId(1234); // WHERE r2p_record_ID = 1234
     * $query->filterByRecordId(array(12, 34)); // WHERE r2p_record_ID IN (12, 34)
     * $query->filterByRecordId(array('min' => 12)); // WHERE r2p_record_ID > 12
     * </code>
     *
     * @param mixed $recordId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByRecordId($recordId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('r2p_record_ID');
        if (is_array($recordId)) {
            $useMinMax = false;
            if (isset($recordId['min'])) {
                $this->addUsingOperator($resolvedColumn, $recordId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($recordId['max'])) {
                $this->addUsingOperator($resolvedColumn, $recordId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $recordId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the r2p_Value column
     *
     * Example usage:
     * <code>
     * $query->filterByPropertyValue('fooValue'); // WHERE r2p_Value = 'fooValue'
     * $query->filterByPropertyValue('%fooValue%', Criteria::LIKE); // WHERE r2p_Value LIKE '%fooValue%'
     * $query->filterByPropertyValue(['foo', 'bar']); // WHERE r2p_Value IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $propertyValue The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPropertyValue($propertyValue = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('r2p_Value');
        if ($comparison === null && is_array($propertyValue)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $propertyValue, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Property object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Property|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Property> $property The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByProperty($property, ?string $comparison = null)
    {
        if ($property instanceof Property) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('r2p_pro_ID'), $property->getProId(), $comparison);
        } elseif ($property instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('r2p_pro_ID'), $property->toKeyValue('PrimaryKey', 'ProId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByProperty() only accepts arguments of type Property or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Property relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinProperty(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Property');

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
            $this->addJoinObject($join, 'Property');
        }

        return $this;
    }

    /**
     * Use the Property relation Property object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyQuery<static> A secondary query class using the current class as primary query
     */
    public function usePropertyQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyQuery<static> $query */
        $query = $this->joinProperty($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Property', '\ChurchCRM\model\ChurchCRM\PropertyQuery');

        return $query;
    }

    /**
     * Use the Property relation Property object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PropertyQuery<mixed>):\ChurchCRM\model\ChurchCRM\PropertyQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPropertyQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePropertyQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Property table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyQuery<static> The inner query object of the EXISTS statement
     */
    public function usePropertyExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyQuery<static> $q */
        $q = $this->useExistsQuery('Property', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Property table for a NOT EXISTS query.
     *
     * @see usePropertyExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePropertyNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyQuery<static> $q*/
        $q = $this->useExistsQuery('Property', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Property table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyQuery<static> The inner query object of the IN statement
     */
    public function useInPropertyQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyQuery<static> $q */
        $q = $this->useInQuery('Property', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Property table for a NOT IN query.
     *
     * @see usePropertyInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPropertyQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyQuery<static> $q */
        $q = $this->useInQuery('Property', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\RecordProperty|null $recordProperty Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildRecordProperty $recordProperty = null)
    {
        if ($recordProperty) {
            $pkFilter = $this->buildFilter($this->resolveLocalColumnByName('r2p_pro_ID'), $recordProperty->getPropertyId(), Criteria::NOT_EQUAL);
            $pkFilter->addOr($this->buildFilter($this->resolveLocalColumnByName('r2p_record_ID'), $recordProperty->getRecordId(), Criteria::NOT_EQUAL));
            $this->addAnd($pkFilter);
        }

        return $this;
    }

    /**
     * Deletes all rows from the record2property_r2p table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RecordPropertyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RecordPropertyTableMap::clearInstancePool();
            RecordPropertyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RecordPropertyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RecordPropertyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RecordPropertyTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            RecordPropertyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
