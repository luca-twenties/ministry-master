<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\DonatedItem as ChildDonatedItem;
use ChurchCRM\model\ChurchCRM\DonatedItemQuery as ChildDonatedItemQuery;
use ChurchCRM\model\ChurchCRM\Map\DonatedItemTableMap;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `donateditem_di` table.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_ID column
 * @method static orderByItem($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_item column
 * @method static orderByFrId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_FR_ID column
 * @method static orderByDonorId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_donor_ID column
 * @method static orderByBuyerId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_buyer_ID column
 * @method static orderByMultibuy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_multibuy column
 * @method static orderByTitle($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_title column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_description column
 * @method static orderBySellprice($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_sellprice column
 * @method static orderByEstprice($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_estprice column
 * @method static orderByMinimum($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_minimum column
 * @method static orderByMaterialValue($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_materialvalue column
 * @method static orderByEnteredby($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_EnteredBy column
 * @method static orderByEntereddate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_EnteredDate column
 * @method static orderByPicture($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the di_picture column
 *
 * @method static groupById() Group by the di_ID column
 * @method static groupByItem() Group by the di_item column
 * @method static groupByFrId() Group by the di_FR_ID column
 * @method static groupByDonorId() Group by the di_donor_ID column
 * @method static groupByBuyerId() Group by the di_buyer_ID column
 * @method static groupByMultibuy() Group by the di_multibuy column
 * @method static groupByTitle() Group by the di_title column
 * @method static groupByDescription() Group by the di_description column
 * @method static groupBySellprice() Group by the di_sellprice column
 * @method static groupByEstprice() Group by the di_estprice column
 * @method static groupByMinimum() Group by the di_minimum column
 * @method static groupByMaterialValue() Group by the di_materialvalue column
 * @method static groupByEnteredby() Group by the di_EnteredBy column
 * @method static groupByEntereddate() Group by the di_EnteredDate column
 * @method static groupByPicture() Group by the di_picture column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem matching the query
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem matching the query, or a new \ChurchCRM\model\ChurchCRM\DonatedItem object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneById(int $di_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_ID column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByItem(string $di_item) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_item column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByFrId(int $di_FR_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_FR_ID column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByDonorId(int $di_donor_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_donor_ID column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByBuyerId(int $di_buyer_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_buyer_ID column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByMultibuy(int $di_multibuy) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_multibuy column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByTitle(string $di_title) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_title column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByDescription(string $di_description) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_description column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneBySellprice(string $di_sellprice) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_sellprice column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByEstprice(string $di_estprice) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_estprice column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByMinimum(string $di_minimum) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_minimum column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByMaterialValue(string $di_materialvalue) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_materialvalue column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByEnteredby(int $di_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_EnteredBy column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByEntereddate(string $di_EnteredDate) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_EnteredDate column
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem|null findOneByPicture(string $di_picture) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_picture column
 *
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\DonatedItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneById(int $di_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByItem(string $di_item) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_item column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByFrId(int $di_FR_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_FR_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByDonorId(int $di_donor_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_donor_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByBuyerId(int $di_buyer_ID) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_buyer_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByMultibuy(int $di_multibuy) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_multibuy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByTitle(string $di_title) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByDescription(string $di_description) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneBySellprice(string $di_sellprice) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_sellprice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByEstprice(string $di_estprice) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_estprice column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByMinimum(string $di_minimum) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_minimum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByMaterialValue(string $di_materialvalue) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_materialvalue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByEnteredby(int $di_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_EnteredBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByEntereddate(string $di_EnteredDate) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_EnteredDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\DonatedItem requireOneByPicture(string $di_picture) Return the first \ChurchCRM\model\ChurchCRM\DonatedItem filtered by the di_picture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\DonatedItemCollection|array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\DonatedItemCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\DonatedItem objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findById(int|array<int> $di_ID) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByItem(string|array<string> $di_item) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_item column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByFrId(int|array<int> $di_FR_ID) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_FR_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByDonorId(int|array<int> $di_donor_ID) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_donor_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByBuyerId(int|array<int> $di_buyer_ID) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_buyer_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByMultibuy(int|array<int> $di_multibuy) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_multibuy column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByTitle(string|array<string> $di_title) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_title column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByDescription(string|array<string> $di_description) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_description column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findBySellprice(string|array<string> $di_sellprice) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_sellprice column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByEstprice(string|array<string> $di_estprice) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_estprice column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByMinimum(string|array<string> $di_minimum) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_minimum column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByMaterialValue(string|array<string> $di_materialvalue) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_materialvalue column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByEnteredby(int|array<int> $di_EnteredBy) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_EnteredBy column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByEntereddate(string|array<string> $di_EnteredDate) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_EnteredDate column
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\DonatedItem> findByPicture(string|array<string> $di_picture) Return \ChurchCRM\model\ChurchCRM\DonatedItem objects filtered by the di_picture column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\DonatedItem>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class DonatedItemQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of DonatedItemQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\DonatedItem',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDonatedItemQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\DonatedItemQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildDonatedItemQuery) {
            return $criteria;
        }
        $query = new ChildDonatedItemQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\DonatedItem|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DonatedItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = DonatedItemTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\DonatedItem|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildDonatedItem
    {
        $sql = 'SELECT di_ID, di_item, di_FR_ID, di_donor_ID, di_buyer_ID, di_multibuy, di_title, di_description, di_sellprice, di_estprice, di_minimum, di_materialvalue, di_EnteredBy, di_EnteredDate, di_picture FROM donateditem_di WHERE di_ID = :p0';
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
            $obj = new ChildDonatedItem();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            DonatedItemTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\DonatedItem|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\DonatedItem>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('di_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('di_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the di_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE di_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE di_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE di_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('di_ID');
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
     * Filter the query on the di_item column
     *
     * Example usage:
     * <code>
     * $query->filterByItem('fooValue'); // WHERE di_item = 'fooValue'
     * $query->filterByItem('%fooValue%', Criteria::LIKE); // WHERE di_item LIKE '%fooValue%'
     * $query->filterByItem(['foo', 'bar']); // WHERE di_item IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $item The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByItem($item = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_item');
        if ($comparison === null && is_array($item)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $item, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_FR_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByFrId(1234); // WHERE di_FR_ID = 1234
     * $query->filterByFrId(array(12, 34)); // WHERE di_FR_ID IN (12, 34)
     * $query->filterByFrId(array('min' => 12)); // WHERE di_FR_ID > 12
     * </code>
     *
     * @param mixed $frId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFrId($frId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_FR_ID');
        if (is_array($frId)) {
            $useMinMax = false;
            if (isset($frId['min'])) {
                $this->addUsingOperator($resolvedColumn, $frId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($frId['max'])) {
                $this->addUsingOperator($resolvedColumn, $frId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $frId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_donor_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByDonorId(1234); // WHERE di_donor_ID = 1234
     * $query->filterByDonorId(array(12, 34)); // WHERE di_donor_ID IN (12, 34)
     * $query->filterByDonorId(array('min' => 12)); // WHERE di_donor_ID > 12
     * </code>
     *
     * @param mixed $donorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDonorId($donorId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_donor_ID');
        if (is_array($donorId)) {
            $useMinMax = false;
            if (isset($donorId['min'])) {
                $this->addUsingOperator($resolvedColumn, $donorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($donorId['max'])) {
                $this->addUsingOperator($resolvedColumn, $donorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $donorId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_buyer_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByBuyerId(1234); // WHERE di_buyer_ID = 1234
     * $query->filterByBuyerId(array(12, 34)); // WHERE di_buyer_ID IN (12, 34)
     * $query->filterByBuyerId(array('min' => 12)); // WHERE di_buyer_ID > 12
     * </code>
     *
     * @param mixed $buyerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByBuyerId($buyerId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_buyer_ID');
        if (is_array($buyerId)) {
            $useMinMax = false;
            if (isset($buyerId['min'])) {
                $this->addUsingOperator($resolvedColumn, $buyerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($buyerId['max'])) {
                $this->addUsingOperator($resolvedColumn, $buyerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $buyerId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_multibuy column
     *
     * Example usage:
     * <code>
     * $query->filterByMultibuy(1234); // WHERE di_multibuy = 1234
     * $query->filterByMultibuy(array(12, 34)); // WHERE di_multibuy IN (12, 34)
     * $query->filterByMultibuy(array('min' => 12)); // WHERE di_multibuy > 12
     * </code>
     *
     * @param mixed $multibuy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMultibuy($multibuy = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_multibuy');
        if (is_array($multibuy)) {
            $useMinMax = false;
            if (isset($multibuy['min'])) {
                $this->addUsingOperator($resolvedColumn, $multibuy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($multibuy['max'])) {
                $this->addUsingOperator($resolvedColumn, $multibuy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $multibuy, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue'); // WHERE di_title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE di_title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE di_title IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_title');
        if ($comparison === null && is_array($title)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE di_description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE di_description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE di_description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_sellprice column
     *
     * Example usage:
     * <code>
     * $query->filterBySellprice(1234); // WHERE di_sellprice = 1234
     * $query->filterBySellprice(array(12, 34)); // WHERE di_sellprice IN (12, 34)
     * $query->filterBySellprice(array('min' => 12)); // WHERE di_sellprice > 12
     * </code>
     *
     * @param mixed $sellprice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySellprice($sellprice = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_sellprice');
        if (is_array($sellprice)) {
            $useMinMax = false;
            if (isset($sellprice['min'])) {
                $this->addUsingOperator($resolvedColumn, $sellprice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sellprice['max'])) {
                $this->addUsingOperator($resolvedColumn, $sellprice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $sellprice, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_estprice column
     *
     * Example usage:
     * <code>
     * $query->filterByEstprice(1234); // WHERE di_estprice = 1234
     * $query->filterByEstprice(array(12, 34)); // WHERE di_estprice IN (12, 34)
     * $query->filterByEstprice(array('min' => 12)); // WHERE di_estprice > 12
     * </code>
     *
     * @param mixed $estprice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEstprice($estprice = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_estprice');
        if (is_array($estprice)) {
            $useMinMax = false;
            if (isset($estprice['min'])) {
                $this->addUsingOperator($resolvedColumn, $estprice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($estprice['max'])) {
                $this->addUsingOperator($resolvedColumn, $estprice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $estprice, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_minimum column
     *
     * Example usage:
     * <code>
     * $query->filterByMinimum(1234); // WHERE di_minimum = 1234
     * $query->filterByMinimum(array(12, 34)); // WHERE di_minimum IN (12, 34)
     * $query->filterByMinimum(array('min' => 12)); // WHERE di_minimum > 12
     * </code>
     *
     * @param mixed $minimum The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMinimum($minimum = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_minimum');
        if (is_array($minimum)) {
            $useMinMax = false;
            if (isset($minimum['min'])) {
                $this->addUsingOperator($resolvedColumn, $minimum['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minimum['max'])) {
                $this->addUsingOperator($resolvedColumn, $minimum['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $minimum, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_materialvalue column
     *
     * Example usage:
     * <code>
     * $query->filterByMaterialValue(1234); // WHERE di_materialvalue = 1234
     * $query->filterByMaterialValue(array(12, 34)); // WHERE di_materialvalue IN (12, 34)
     * $query->filterByMaterialValue(array('min' => 12)); // WHERE di_materialvalue > 12
     * </code>
     *
     * @param mixed $materialValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByMaterialValue($materialValue = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_materialvalue');
        if (is_array($materialValue)) {
            $useMinMax = false;
            if (isset($materialValue['min'])) {
                $this->addUsingOperator($resolvedColumn, $materialValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($materialValue['max'])) {
                $this->addUsingOperator($resolvedColumn, $materialValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $materialValue, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_EnteredBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredby(1234); // WHERE di_EnteredBy = 1234
     * $query->filterByEnteredby(array(12, 34)); // WHERE di_EnteredBy IN (12, 34)
     * $query->filterByEnteredby(array('min' => 12)); // WHERE di_EnteredBy > 12
     * </code>
     *
     * @param mixed $enteredby The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnteredby($enteredby = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_EnteredBy');
        if (is_array($enteredby)) {
            $useMinMax = false;
            if (isset($enteredby['min'])) {
                $this->addUsingOperator($resolvedColumn, $enteredby['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enteredby['max'])) {
                $this->addUsingOperator($resolvedColumn, $enteredby['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $enteredby, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_EnteredDate column
     *
     * Example usage:
     * <code>
     * $query->filterByEntereddate('2011-03-14'); // WHERE di_EnteredDate = '2011-03-14'
     * $query->filterByEntereddate('now'); // WHERE di_EnteredDate = '2011-03-14'
     * $query->filterByEntereddate(array('max' => 'yesterday')); // WHERE di_EnteredDate > '2011-03-13'
     * </code>
     *
     * @param mixed $entereddate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEntereddate($entereddate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_EnteredDate');
        if (is_array($entereddate)) {
            $useMinMax = false;
            if (isset($entereddate['min'])) {
                $this->addUsingOperator($resolvedColumn, $entereddate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($entereddate['max'])) {
                $this->addUsingOperator($resolvedColumn, $entereddate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $entereddate, $comparison);

        return $this;
    }

    /**
     * Filter the query on the di_picture column
     *
     * Example usage:
     * <code>
     * $query->filterByPicture('fooValue'); // WHERE di_picture = 'fooValue'
     * $query->filterByPicture('%fooValue%', Criteria::LIKE); // WHERE di_picture LIKE '%fooValue%'
     * $query->filterByPicture(['foo', 'bar']); // WHERE di_picture IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $picture The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPicture($picture = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('di_picture');
        if ($comparison === null && is_array($picture)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $picture, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\DonatedItem|null $donatedItem Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildDonatedItem $donatedItem = null)
    {
        if ($donatedItem) {
            $resolvedColumn = $this->resolveLocalColumnByName('di_ID');
            $this->addUsingOperator($resolvedColumn, $donatedItem->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the donateditem_di table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DonatedItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DonatedItemTableMap::clearInstancePool();
            DonatedItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DonatedItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DonatedItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DonatedItemTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            DonatedItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
