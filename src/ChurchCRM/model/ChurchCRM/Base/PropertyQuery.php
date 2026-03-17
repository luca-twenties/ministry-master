<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\PropertyTableMap;
use ChurchCRM\model\ChurchCRM\Property as ChildProperty;
use ChurchCRM\model\ChurchCRM\PropertyQuery as ChildPropertyQuery;
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
 * Base class that represents a query for the `property_pro` table.
 *
 * @method static orderByProId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the pro_ID column
 * @method static orderByProClass($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the pro_Class column
 * @method static orderByProPrtId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the pro_prt_ID column
 * @method static orderByProName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the pro_Name column
 * @method static orderByProDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the pro_Description column
 * @method static orderByProPrompt($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the pro_Prompt column
 *
 * @method static groupByProId() Group by the pro_ID column
 * @method static groupByProClass() Group by the pro_Class column
 * @method static groupByProPrtId() Group by the pro_prt_ID column
 * @method static groupByProName() Group by the pro_Name column
 * @method static groupByProDescription() Group by the pro_Description column
 * @method static groupByProPrompt() Group by the pro_Prompt column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinPropertyType($relationAlias = null) Adds a LEFT JOIN clause to the query using the PropertyType relation
 * @method static rightJoinPropertyType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PropertyType relation
 * @method static innerJoinPropertyType($relationAlias = null) Adds a INNER JOIN clause to the query using the PropertyType relation
 *
 * @method static joinWithPropertyType($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the PropertyType relation
 *
 * @method static leftJoinWithPropertyType() Adds a LEFT JOIN clause and with to the query using the PropertyType relation
 * @method static rightJoinWithPropertyType() Adds a RIGHT JOIN clause and with to the query using the PropertyType relation
 * @method static innerJoinWithPropertyType() Adds a INNER JOIN clause and with to the query using the PropertyType relation
 *
 * @method static leftJoinRecordProperty($relationAlias = null) Adds a LEFT JOIN clause to the query using the RecordProperty relation
 * @method static rightJoinRecordProperty($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RecordProperty relation
 * @method static innerJoinRecordProperty($relationAlias = null) Adds a INNER JOIN clause to the query using the RecordProperty relation
 *
 * @method static joinWithRecordProperty($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the RecordProperty relation
 *
 * @method static leftJoinWithRecordProperty() Adds a LEFT JOIN clause and with to the query using the RecordProperty relation
 * @method static rightJoinWithRecordProperty() Adds a RIGHT JOIN clause and with to the query using the RecordProperty relation
 * @method static innerJoinWithRecordProperty() Adds a INNER JOIN clause and with to the query using the RecordProperty relation
 *
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Property matching the query
 * @method \ChurchCRM\model\ChurchCRM\Property findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Property matching the query, or a new \ChurchCRM\model\ChurchCRM\Property object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOneByProId(int $pro_ID) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_ID column
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOneByProClass(string $pro_Class) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Class column
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOneByProPrtId(int $pro_prt_ID) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_prt_ID column
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOneByProName(string $pro_Name) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Name column
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOneByProDescription(string $pro_Description) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Description column
 * @method \ChurchCRM\model\ChurchCRM\Property|null findOneByProPrompt(string $pro_Prompt) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Prompt column
 *
 * @method \ChurchCRM\model\ChurchCRM\Property requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Property by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Property requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Property matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Property requireOneByProId(int $pro_ID) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Property requireOneByProClass(string $pro_Class) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Class column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Property requireOneByProPrtId(int $pro_prt_ID) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_prt_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Property requireOneByProName(string $pro_Name) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Property requireOneByProDescription(string $pro_Description) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Property requireOneByProPrompt(string $pro_Prompt) Return the first \ChurchCRM\model\ChurchCRM\Property filtered by the pro_Prompt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyCollection|array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Property objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Property objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> findByProId(int|array<int> $pro_ID) Return \ChurchCRM\model\ChurchCRM\Property objects filtered by the pro_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> findByProClass(string|array<string> $pro_Class) Return \ChurchCRM\model\ChurchCRM\Property objects filtered by the pro_Class column
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> findByProPrtId(int|array<int> $pro_prt_ID) Return \ChurchCRM\model\ChurchCRM\Property objects filtered by the pro_prt_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> findByProName(string|array<string> $pro_Name) Return \ChurchCRM\model\ChurchCRM\Property objects filtered by the pro_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> findByProDescription(string|array<string> $pro_Description) Return \ChurchCRM\model\ChurchCRM\Property objects filtered by the pro_Description column
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Property> findByProPrompt(string|array<string> $pro_Prompt) Return \ChurchCRM\model\ChurchCRM\Property objects filtered by the pro_Prompt column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Property>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class PropertyQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of PropertyQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Property',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPropertyQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPropertyQuery) {
            return $criteria;
        }
        $query = new ChildPropertyQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Property|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PropertyTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = PropertyTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Property|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildProperty
    {
        $sql = 'SELECT pro_ID, pro_Class, pro_prt_ID, pro_Name, pro_Description, pro_Prompt FROM property_pro WHERE pro_ID = :p0';
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
            $obj = new ChildProperty();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            PropertyTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Property|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Property>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('pro_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('pro_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the pro_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByProId(1234); // WHERE pro_ID = 1234
     * $query->filterByProId(array(12, 34)); // WHERE pro_ID IN (12, 34)
     * $query->filterByProId(array('min' => 12)); // WHERE pro_ID > 12
     * </code>
     *
     * @param mixed $proId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProId($proId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('pro_ID');
        if (is_array($proId)) {
            $useMinMax = false;
            if (isset($proId['min'])) {
                $this->addUsingOperator($resolvedColumn, $proId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($proId['max'])) {
                $this->addUsingOperator($resolvedColumn, $proId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $proId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the pro_Class column
     *
     * Example usage:
     * <code>
     * $query->filterByProClass('fooValue'); // WHERE pro_Class = 'fooValue'
     * $query->filterByProClass('%fooValue%', Criteria::LIKE); // WHERE pro_Class LIKE '%fooValue%'
     * $query->filterByProClass(['foo', 'bar']); // WHERE pro_Class IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $proClass The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProClass($proClass = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('pro_Class');
        if ($comparison === null && is_array($proClass)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $proClass, $comparison);

        return $this;
    }

    /**
     * Filter the query on the pro_prt_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByProPrtId(1234); // WHERE pro_prt_ID = 1234
     * $query->filterByProPrtId(array(12, 34)); // WHERE pro_prt_ID IN (12, 34)
     * $query->filterByProPrtId(array('min' => 12)); // WHERE pro_prt_ID > 12
     * </code>
     *
     * @see static::filterByPropertyType()
     *
     * @param mixed $proPrtId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProPrtId($proPrtId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('pro_prt_ID');
        if (is_array($proPrtId)) {
            $useMinMax = false;
            if (isset($proPrtId['min'])) {
                $this->addUsingOperator($resolvedColumn, $proPrtId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($proPrtId['max'])) {
                $this->addUsingOperator($resolvedColumn, $proPrtId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $proPrtId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the pro_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByProName('fooValue'); // WHERE pro_Name = 'fooValue'
     * $query->filterByProName('%fooValue%', Criteria::LIKE); // WHERE pro_Name LIKE '%fooValue%'
     * $query->filterByProName(['foo', 'bar']); // WHERE pro_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $proName The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProName($proName = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('pro_Name');
        if ($comparison === null && is_array($proName)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $proName, $comparison);

        return $this;
    }

    /**
     * Filter the query on the pro_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByProDescription('fooValue'); // WHERE pro_Description = 'fooValue'
     * $query->filterByProDescription('%fooValue%', Criteria::LIKE); // WHERE pro_Description LIKE '%fooValue%'
     * $query->filterByProDescription(['foo', 'bar']); // WHERE pro_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $proDescription The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProDescription($proDescription = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('pro_Description');
        if ($comparison === null && is_array($proDescription)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $proDescription, $comparison);

        return $this;
    }

    /**
     * Filter the query on the pro_Prompt column
     *
     * Example usage:
     * <code>
     * $query->filterByProPrompt('fooValue'); // WHERE pro_Prompt = 'fooValue'
     * $query->filterByProPrompt('%fooValue%', Criteria::LIKE); // WHERE pro_Prompt LIKE '%fooValue%'
     * $query->filterByProPrompt(['foo', 'bar']); // WHERE pro_Prompt IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $proPrompt The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByProPrompt($proPrompt = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('pro_Prompt');
        if ($comparison === null && is_array($proPrompt)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $proPrompt, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related PropertyType object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\PropertyType|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\PropertyType> $propertyType The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByPropertyType($propertyType, ?string $comparison = null)
    {
        if ($propertyType instanceof PropertyType) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('pro_prt_ID'), $propertyType->getPrtId(), $comparison);
        } elseif ($propertyType instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('pro_prt_ID'), $propertyType->toKeyValue('PrimaryKey', 'PrtId'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPropertyType() only accepts arguments of type PropertyType or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PropertyType relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPropertyType(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PropertyType');

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
            $this->addJoinObject($join, 'PropertyType');
        }

        return $this;
    }

    /**
     * Use the PropertyType relation PropertyType object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> A secondary query class using the current class as primary query
     */
    public function usePropertyTypeQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> $query */
        $query = $this->joinPropertyType($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'PropertyType', '\ChurchCRM\model\ChurchCRM\PropertyTypeQuery');

        return $query;
    }

    /**
     * Use the PropertyType relation PropertyType object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PropertyTypeQuery<mixed>):\ChurchCRM\model\ChurchCRM\PropertyTypeQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPropertyTypeQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePropertyTypeQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to PropertyType table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> The inner query object of the EXISTS statement
     */
    public function usePropertyTypeExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> $q */
        $q = $this->useExistsQuery('PropertyType', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to PropertyType table for a NOT EXISTS query.
     *
     * @see usePropertyTypeExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePropertyTypeNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> $q*/
        $q = $this->useExistsQuery('PropertyType', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to PropertyType table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> The inner query object of the IN statement
     */
    public function useInPropertyTypeQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> $q */
        $q = $this->useInQuery('PropertyType', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to PropertyType table for a NOT IN query.
     *
     * @see usePropertyTypeInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPropertyTypeQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PropertyTypeQuery<static> $q */
        $q = $this->useInQuery('PropertyType', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related RecordProperty object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\RecordProperty|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\RecordProperty> $recordProperty the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this
     */
    public function filterByRecordProperty(RecordProperty|ObjectCollection $recordProperty, ?string $comparison = null)
    {
        if ($recordProperty instanceof RecordProperty) {
            $this
                ->addUsingOperator($this->resolveLocalColumnByName('pro_ID'), $recordProperty->getPropertyId(), $comparison);
        } elseif ($recordProperty instanceof ObjectCollection) {
            $this
                ->useRecordPropertyQuery()
                ->filterByPrimaryKeys($recordProperty->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRecordProperty() only accepts arguments of type \ChurchCRM\model\ChurchCRM\Base\RecordProperty or Collection');
        }

        return $this;
    }

    /**
     * Adds a JOIN clause to the query using the RecordProperty relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinRecordProperty(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RecordProperty');

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
            $this->addJoinObject($join, 'RecordProperty');
        }

        return $this;
    }

    /**
     * Use the RecordProperty relation RecordProperty object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> A secondary query class using the current class as primary query
     */
    public function useRecordPropertyQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> $query */
        $query = $this->joinRecordProperty($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'RecordProperty', '\ChurchCRM\model\ChurchCRM\RecordPropertyQuery');

        return $query;
    }

    /**
     * Use the RecordProperty relation RecordProperty object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\RecordPropertyQuery<mixed>):\ChurchCRM\model\ChurchCRM\RecordPropertyQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withRecordPropertyQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useRecordPropertyQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to RecordProperty table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> The inner query object of the EXISTS statement
     */
    public function useRecordPropertyExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> $q */
        $q = $this->useExistsQuery('RecordProperty', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to RecordProperty table for a NOT EXISTS query.
     *
     * @see useRecordPropertyExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useRecordPropertyNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> $q*/
        $q = $this->useExistsQuery('RecordProperty', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to RecordProperty table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> The inner query object of the IN statement
     */
    public function useInRecordPropertyQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> $q */
        $q = $this->useInQuery('RecordProperty', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to RecordProperty table for a NOT IN query.
     *
     * @see useRecordPropertyInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInRecordPropertyQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\RecordPropertyQuery<static> $q */
        $q = $this->useInQuery('RecordProperty', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Property|null $property Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildProperty $property = null)
    {
        if ($property) {
            $resolvedColumn = $this->resolveLocalColumnByName('pro_ID');
            $this->addUsingOperator($resolvedColumn, $property->getProId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the property_pro table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PropertyTableMap::clearInstancePool();
            PropertyTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PropertyTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PropertyTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            PropertyTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
