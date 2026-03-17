<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\PropertyTypeTableMap;
use ChurchCRM\model\ChurchCRM\PropertyType as ChildPropertyType;
use ChurchCRM\model\ChurchCRM\PropertyTypeQuery as ChildPropertyTypeQuery;
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
 * Base class that represents a query for the `propertytype_prt` table.
 *
 * This contains all the defined property types
 *
 * @method static orderByPrtId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prt_ID column
 * @method static orderByPrtClass($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prt_Class column
 * @method static orderByPrtName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prt_Name column
 * @method static orderByPrtDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prt_Description column
 *
 * @method static groupByPrtId() Group by the prt_ID column
 * @method static groupByPrtClass() Group by the prt_Class column
 * @method static groupByPrtName() Group by the prt_Name column
 * @method static groupByPrtDescription() Group by the prt_Description column
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
 * @method \ChurchCRM\model\ChurchCRM\PropertyType|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PropertyType matching the query
 * @method \ChurchCRM\model\ChurchCRM\PropertyType findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PropertyType matching the query, or a new \ChurchCRM\model\ChurchCRM\PropertyType object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\PropertyType|null findOneByPrtId(int $prt_ID) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_ID column
 * @method \ChurchCRM\model\ChurchCRM\PropertyType|null findOneByPrtClass(string $prt_Class) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_Class column
 * @method \ChurchCRM\model\ChurchCRM\PropertyType|null findOneByPrtName(string $prt_Name) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_Name column
 * @method \ChurchCRM\model\ChurchCRM\PropertyType|null findOneByPrtDescription(string $prt_Description) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_Description column
 *
 * @method \ChurchCRM\model\ChurchCRM\PropertyType requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\PropertyType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PropertyType requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PropertyType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\PropertyType requireOneByPrtId(int $prt_ID) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PropertyType requireOneByPrtClass(string $prt_Class) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_Class column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PropertyType requireOneByPrtName(string $prt_Name) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PropertyType requireOneByPrtDescription(string $prt_Description) Return the first \ChurchCRM\model\ChurchCRM\PropertyType filtered by the prt_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyTypeCollection|array<\ChurchCRM\model\ChurchCRM\PropertyType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PropertyType> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\PropertyType objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyTypeCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\PropertyType objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\PropertyType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PropertyType> findByPrtId(int|array<int> $prt_ID) Return \ChurchCRM\model\ChurchCRM\PropertyType objects filtered by the prt_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\PropertyType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PropertyType> findByPrtClass(string|array<string> $prt_Class) Return \ChurchCRM\model\ChurchCRM\PropertyType objects filtered by the prt_Class column
 * @method array<\ChurchCRM\model\ChurchCRM\PropertyType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PropertyType> findByPrtName(string|array<string> $prt_Name) Return \ChurchCRM\model\ChurchCRM\PropertyType objects filtered by the prt_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\PropertyType>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PropertyType> findByPrtDescription(string|array<string> $prt_Description) Return \ChurchCRM\model\ChurchCRM\PropertyType objects filtered by the prt_Description column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\PropertyType>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class PropertyTypeQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of PropertyTypeQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\PropertyType',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPropertyTypeQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPropertyTypeQuery) {
            return $criteria;
        }
        $query = new ChildPropertyTypeQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\PropertyType|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = PropertyTypeTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\PropertyType|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildPropertyType
    {
        $sql = 'SELECT prt_ID, prt_Class, prt_Name, prt_Description FROM propertytype_prt WHERE prt_ID = :p0';
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
            $obj = new ChildPropertyType();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            PropertyTypeTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\PropertyType|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\PropertyType>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('prt_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('prt_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the prt_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByPrtId(1234); // WHERE prt_ID = 1234
     * $query->filterByPrtId(array(12, 34)); // WHERE prt_ID IN (12, 34)
     * $query->filterByPrtId(array('min' => 12)); // WHERE prt_ID > 12
     * </code>
     *
     * @param mixed $prtId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPrtId($prtId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prt_ID');
        if (is_array($prtId)) {
            $useMinMax = false;
            if (isset($prtId['min'])) {
                $this->addUsingOperator($resolvedColumn, $prtId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prtId['max'])) {
                $this->addUsingOperator($resolvedColumn, $prtId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $prtId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prt_Class column
     *
     * Example usage:
     * <code>
     * $query->filterByPrtClass('fooValue'); // WHERE prt_Class = 'fooValue'
     * $query->filterByPrtClass('%fooValue%', Criteria::LIKE); // WHERE prt_Class LIKE '%fooValue%'
     * $query->filterByPrtClass(['foo', 'bar']); // WHERE prt_Class IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $prtClass The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPrtClass($prtClass = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prt_Class');
        if ($comparison === null && is_array($prtClass)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $prtClass, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prt_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByPrtName('fooValue'); // WHERE prt_Name = 'fooValue'
     * $query->filterByPrtName('%fooValue%', Criteria::LIKE); // WHERE prt_Name LIKE '%fooValue%'
     * $query->filterByPrtName(['foo', 'bar']); // WHERE prt_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $prtName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPrtName($prtName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prt_Name');
        if ($comparison === null && is_array($prtName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $prtName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prt_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByPrtDescription('fooValue'); // WHERE prt_Description = 'fooValue'
     * $query->filterByPrtDescription('%fooValue%', Criteria::LIKE); // WHERE prt_Description LIKE '%fooValue%'
     * $query->filterByPrtDescription(['foo', 'bar']); // WHERE prt_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $prtDescription The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPrtDescription($prtDescription = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prt_Description');
        if ($comparison === null && is_array($prtDescription)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $prtDescription, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Property object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Property|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Property> $property the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByProperty(Property|ObjectCollection $property, ?string $comparison = null)
    {
        if ($property instanceof Property) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('prt_ID'), $property->getProPrtId(), $comparison);
        } elseif ($property instanceof ObjectCollection) {
            $this
                ->usePropertyQuery()
                ->filterByPrimaryKeys($property->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProperty() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\Property or Collection');
        }

        return $this;
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
     * @param \ChurchCRM\model\ChurchCRM\PropertyType|null $propertyType Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildPropertyType $propertyType = null)
    {
        if ($propertyType) {
            $resolvedColumn = $this->resolveLocalColumnByName('prt_ID');
            $this->addUsingOperator($resolvedColumn, $propertyType->getPrtId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the propertytype_prt table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PropertyTypeTableMap::clearInstancePool();
            PropertyTypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PropertyTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PropertyTypeTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            PropertyTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
