<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\QueryParametersTableMap;
use ChurchCRM\model\ChurchCRM\QueryParameters as ChildQueryParameters;
use ChurchCRM\model\ChurchCRM\QueryParametersQuery as ChildQueryParametersQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `queryparameters_qrp` table.
 *
 * defines the parameters for each query
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_ID column
 * @method static orderByQryId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_qry_ID column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Type column
 * @method static orderByOptionSQL($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_OptionSQL column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Name column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Description column
 * @method static orderByAlias($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Alias column
 * @method static orderByDefault($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Default column
 * @method static orderByRequired($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Required column
 * @method static orderByInputBoxSize($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_InputBoxSize column
 * @method static orderByValidation($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_Validation column
 * @method static orderByNumericMax($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_NumericMax column
 * @method static orderByNumericMin($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_NumericMin column
 * @method static orderByAlphaMinLength($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_AlphaMinLength column
 * @method static orderByAlphaMaxLength($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the qrp_AlphaMaxLength column
 *
 * @method static groupById() Group by the qrp_ID column
 * @method static groupByQryId() Group by the qrp_qry_ID column
 * @method static groupByType() Group by the qrp_Type column
 * @method static groupByOptionSQL() Group by the qrp_OptionSQL column
 * @method static groupByName() Group by the qrp_Name column
 * @method static groupByDescription() Group by the qrp_Description column
 * @method static groupByAlias() Group by the qrp_Alias column
 * @method static groupByDefault() Group by the qrp_Default column
 * @method static groupByRequired() Group by the qrp_Required column
 * @method static groupByInputBoxSize() Group by the qrp_InputBoxSize column
 * @method static groupByValidation() Group by the qrp_Validation column
 * @method static groupByNumericMax() Group by the qrp_NumericMax column
 * @method static groupByNumericMin() Group by the qrp_NumericMin column
 * @method static groupByAlphaMinLength() Group by the qrp_AlphaMinLength column
 * @method static groupByAlphaMaxLength() Group by the qrp_AlphaMaxLength column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters matching the query
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters matching the query, or a new \ChurchCRM\model\ChurchCRM\QueryParameters object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneById(int $qrp_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_ID column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByQryId(int $qrp_qry_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_qry_ID column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByType(int $qrp_Type) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Type column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByOptionSQL(string $qrp_OptionSQL) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_OptionSQL column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByName(string $qrp_Name) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Name column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByDescription(string $qrp_Description) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Description column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByAlias(string $qrp_Alias) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Alias column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByDefault(string $qrp_Default) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Default column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByRequired(int $qrp_Required) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Required column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByInputBoxSize(int $qrp_InputBoxSize) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_InputBoxSize column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByValidation(string $qrp_Validation) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Validation column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByNumericMax(int $qrp_NumericMax) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_NumericMax column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByNumericMin(int $qrp_NumericMin) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_NumericMin column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByAlphaMinLength(int $qrp_AlphaMinLength) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_AlphaMinLength column
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters|null findOneByAlphaMaxLength(int $qrp_AlphaMaxLength) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_AlphaMaxLength column
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\QueryParameters by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneById(int $qrp_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByQryId(int $qrp_qry_ID) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_qry_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByType(int $qrp_Type) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByOptionSQL(string $qrp_OptionSQL) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_OptionSQL column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByName(string $qrp_Name) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByDescription(string $qrp_Description) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByAlias(string $qrp_Alias) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Alias column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByDefault(string $qrp_Default) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Default column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByRequired(int $qrp_Required) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Required column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByInputBoxSize(int $qrp_InputBoxSize) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_InputBoxSize column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByValidation(string $qrp_Validation) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_Validation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByNumericMax(int $qrp_NumericMax) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_NumericMax column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByNumericMin(int $qrp_NumericMin) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_NumericMin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByAlphaMinLength(int $qrp_AlphaMinLength) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_AlphaMinLength column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\QueryParameters requireOneByAlphaMaxLength(int $qrp_AlphaMaxLength) Return the first \ChurchCRM\model\ChurchCRM\QueryParameters filtered by the qrp_AlphaMaxLength column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\QueryParametersCollection|array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\QueryParametersCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\QueryParameters objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findById(int|array<int> $qrp_ID) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByQryId(int|array<int> $qrp_qry_ID) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_qry_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByType(int|array<int> $qrp_Type) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Type column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByOptionSQL(string|array<string> $qrp_OptionSQL) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_OptionSQL column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByName(string|array<string> $qrp_Name) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByDescription(string|array<string> $qrp_Description) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Description column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByAlias(string|array<string> $qrp_Alias) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Alias column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByDefault(string|array<string> $qrp_Default) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Default column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByRequired(int|array<int> $qrp_Required) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Required column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByInputBoxSize(int|array<int> $qrp_InputBoxSize) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_InputBoxSize column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByValidation(string|array<string> $qrp_Validation) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_Validation column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByNumericMax(int|array<int> $qrp_NumericMax) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_NumericMax column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByNumericMin(int|array<int> $qrp_NumericMin) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_NumericMin column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByAlphaMinLength(int|array<int> $qrp_AlphaMinLength) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_AlphaMinLength column
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\QueryParameters> findByAlphaMaxLength(int|array<int> $qrp_AlphaMaxLength) Return \ChurchCRM\model\ChurchCRM\QueryParameters objects filtered by the qrp_AlphaMaxLength column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\QueryParameters>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class QueryParametersQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of QueryParametersQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\QueryParameters',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildQueryParametersQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\QueryParametersQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildQueryParametersQuery) {
            return $criteria;
        }
        $query = new ChildQueryParametersQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\QueryParameters|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = QueryParametersTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\QueryParameters|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildQueryParameters
    {
        $sql = 'SELECT qrp_ID, qrp_qry_ID, qrp_Type, qrp_OptionSQL, qrp_Name, qrp_Description, qrp_Alias, qrp_Default, qrp_Required, qrp_InputBoxSize, qrp_Validation, qrp_NumericMax, qrp_NumericMin, qrp_AlphaMinLength, qrp_AlphaMaxLength FROM queryparameters_qrp WHERE qrp_ID = :p0';
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
            $obj = new ChildQueryParameters();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            QueryParametersTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\QueryParameters|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\QueryParameters>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the qrp_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE qrp_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE qrp_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE qrp_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_ID');
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
     * Filter the query on the qrp_qry_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByQryId(1234); // WHERE qrp_qry_ID = 1234
     * $query->filterByQryId(array(12, 34)); // WHERE qrp_qry_ID IN (12, 34)
     * $query->filterByQryId(array('min' => 12)); // WHERE qrp_qry_ID > 12
     * </code>
     *
     * @param mixed $qryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByQryId($qryId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_qry_ID');
        if (is_array($qryId)) {
            $useMinMax = false;
            if (isset($qryId['min'])) {
                $this->addUsingOperator($resolvedColumn, $qryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qryId['max'])) {
                $this->addUsingOperator($resolvedColumn, $qryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $qryId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE qrp_Type = 1234
     * $query->filterByType(array(12, 34)); // WHERE qrp_Type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE qrp_Type > 12
     * </code>
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
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Type');
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
     * Filter the query on the qrp_OptionSQL column
     *
     * Example usage:
     * <code>
     * $query->filterByOptionSQL('fooValue'); // WHERE qrp_OptionSQL = 'fooValue'
     * $query->filterByOptionSQL('%fooValue%', Criteria::LIKE); // WHERE qrp_OptionSQL LIKE '%fooValue%'
     * $query->filterByOptionSQL(['foo', 'bar']); // WHERE qrp_OptionSQL IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $optionSQL The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOptionSQL($optionSQL = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_OptionSQL');
        if ($comparison === null && is_array($optionSQL)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $optionSQL, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE qrp_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE qrp_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE qrp_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE qrp_Description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE qrp_Description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE qrp_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Alias column
     *
     * Example usage:
     * <code>
     * $query->filterByAlias('fooValue'); // WHERE qrp_Alias = 'fooValue'
     * $query->filterByAlias('%fooValue%', Criteria::LIKE); // WHERE qrp_Alias LIKE '%fooValue%'
     * $query->filterByAlias(['foo', 'bar']); // WHERE qrp_Alias IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $alias The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAlias($alias = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Alias');
        if ($comparison === null && is_array($alias)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $alias, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Default column
     *
     * Example usage:
     * <code>
     * $query->filterByDefault('fooValue'); // WHERE qrp_Default = 'fooValue'
     * $query->filterByDefault('%fooValue%', Criteria::LIKE); // WHERE qrp_Default LIKE '%fooValue%'
     * $query->filterByDefault(['foo', 'bar']); // WHERE qrp_Default IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $default The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDefault($default = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Default');
        if ($comparison === null && is_array($default)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $default, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Required column
     *
     * Example usage:
     * <code>
     * $query->filterByRequired(1234); // WHERE qrp_Required = 1234
     * $query->filterByRequired(array(12, 34)); // WHERE qrp_Required IN (12, 34)
     * $query->filterByRequired(array('min' => 12)); // WHERE qrp_Required > 12
     * </code>
     *
     * @param mixed $required The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByRequired($required = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Required');
        if (is_array($required)) {
            $useMinMax = false;
            if (isset($required['min'])) {
                $this->addUsingOperator($resolvedColumn, $required['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($required['max'])) {
                $this->addUsingOperator($resolvedColumn, $required['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $required, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_InputBoxSize column
     *
     * Example usage:
     * <code>
     * $query->filterByInputBoxSize(1234); // WHERE qrp_InputBoxSize = 1234
     * $query->filterByInputBoxSize(array(12, 34)); // WHERE qrp_InputBoxSize IN (12, 34)
     * $query->filterByInputBoxSize(array('min' => 12)); // WHERE qrp_InputBoxSize > 12
     * </code>
     *
     * @param mixed $inputBoxSize The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByInputBoxSize($inputBoxSize = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_InputBoxSize');
        if (is_array($inputBoxSize)) {
            $useMinMax = false;
            if (isset($inputBoxSize['min'])) {
                $this->addUsingOperator($resolvedColumn, $inputBoxSize['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($inputBoxSize['max'])) {
                $this->addUsingOperator($resolvedColumn, $inputBoxSize['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $inputBoxSize, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_Validation column
     *
     * Example usage:
     * <code>
     * $query->filterByValidation('fooValue'); // WHERE qrp_Validation = 'fooValue'
     * $query->filterByValidation('%fooValue%', Criteria::LIKE); // WHERE qrp_Validation LIKE '%fooValue%'
     * $query->filterByValidation(['foo', 'bar']); // WHERE qrp_Validation IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $validation The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByValidation($validation = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_Validation');
        if ($comparison === null && is_array($validation)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $validation, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_NumericMax column
     *
     * Example usage:
     * <code>
     * $query->filterByNumericMax(1234); // WHERE qrp_NumericMax = 1234
     * $query->filterByNumericMax(array(12, 34)); // WHERE qrp_NumericMax IN (12, 34)
     * $query->filterByNumericMax(array('min' => 12)); // WHERE qrp_NumericMax > 12
     * </code>
     *
     * @param mixed $numericMax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByNumericMax($numericMax = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_NumericMax');
        if (is_array($numericMax)) {
            $useMinMax = false;
            if (isset($numericMax['min'])) {
                $this->addUsingOperator($resolvedColumn, $numericMax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numericMax['max'])) {
                $this->addUsingOperator($resolvedColumn, $numericMax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $numericMax, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_NumericMin column
     *
     * Example usage:
     * <code>
     * $query->filterByNumericMin(1234); // WHERE qrp_NumericMin = 1234
     * $query->filterByNumericMin(array(12, 34)); // WHERE qrp_NumericMin IN (12, 34)
     * $query->filterByNumericMin(array('min' => 12)); // WHERE qrp_NumericMin > 12
     * </code>
     *
     * @param mixed $numericMin The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByNumericMin($numericMin = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_NumericMin');
        if (is_array($numericMin)) {
            $useMinMax = false;
            if (isset($numericMin['min'])) {
                $this->addUsingOperator($resolvedColumn, $numericMin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numericMin['max'])) {
                $this->addUsingOperator($resolvedColumn, $numericMin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $numericMin, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_AlphaMinLength column
     *
     * Example usage:
     * <code>
     * $query->filterByAlphaMinLength(1234); // WHERE qrp_AlphaMinLength = 1234
     * $query->filterByAlphaMinLength(array(12, 34)); // WHERE qrp_AlphaMinLength IN (12, 34)
     * $query->filterByAlphaMinLength(array('min' => 12)); // WHERE qrp_AlphaMinLength > 12
     * </code>
     *
     * @param mixed $alphaMinLength The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAlphaMinLength($alphaMinLength = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_AlphaMinLength');
        if (is_array($alphaMinLength)) {
            $useMinMax = false;
            if (isset($alphaMinLength['min'])) {
                $this->addUsingOperator($resolvedColumn, $alphaMinLength['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alphaMinLength['max'])) {
                $this->addUsingOperator($resolvedColumn, $alphaMinLength['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $alphaMinLength, $comparison);

        return $this;
    }

    /**
     * Filter the query on the qrp_AlphaMaxLength column
     *
     * Example usage:
     * <code>
     * $query->filterByAlphaMaxLength(1234); // WHERE qrp_AlphaMaxLength = 1234
     * $query->filterByAlphaMaxLength(array(12, 34)); // WHERE qrp_AlphaMaxLength IN (12, 34)
     * $query->filterByAlphaMaxLength(array('min' => 12)); // WHERE qrp_AlphaMaxLength > 12
     * </code>
     *
     * @param mixed $alphaMaxLength The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByAlphaMaxLength($alphaMaxLength = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('qrp_AlphaMaxLength');
        if (is_array($alphaMaxLength)) {
            $useMinMax = false;
            if (isset($alphaMaxLength['min'])) {
                $this->addUsingOperator($resolvedColumn, $alphaMaxLength['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alphaMaxLength['max'])) {
                $this->addUsingOperator($resolvedColumn, $alphaMaxLength['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $alphaMaxLength, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\QueryParameters|null $queryParameters Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildQueryParameters $queryParameters = null)
    {
        if ($queryParameters) {
            $resolvedColumn = $this->resolveLocalColumnByName('qrp_ID');
            $this->addUsingOperator($resolvedColumn, $queryParameters->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the queryparameters_qrp table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            QueryParametersTableMap::clearInstancePool();
            QueryParametersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(QueryParametersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            QueryParametersTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            QueryParametersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
