<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\FundRaiser as ChildFundRaiser;
use ChurchCRM\model\ChurchCRM\FundRaiserQuery as ChildFundRaiserQuery;
use ChurchCRM\model\ChurchCRM\Map\FundRaiserTableMap;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `fundraiser_fr` table.
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fr_ID column
 * @method static orderByDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fr_date column
 * @method static orderByTitle($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fr_title column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fr_description column
 * @method static orderByEnteredBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fr_EnteredBy column
 * @method static orderByEnteredDate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the fr_EnteredDate column
 *
 * @method static groupById() Group by the fr_ID column
 * @method static groupByDate() Group by the fr_date column
 * @method static groupByTitle() Group by the fr_title column
 * @method static groupByDescription() Group by the fr_description column
 * @method static groupByEnteredBy() Group by the fr_EnteredBy column
 * @method static groupByEnteredDate() Group by the fr_EnteredDate column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser matching the query
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser matching the query, or a new \ChurchCRM\model\ChurchCRM\FundRaiser object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOneById(int $fr_ID) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_ID column
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOneByDate(string $fr_date) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_date column
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOneByTitle(string $fr_title) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_title column
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOneByDescription(string $fr_description) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_description column
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOneByEnteredBy(int $fr_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_EnteredBy column
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser|null findOneByEnteredDate(string $fr_EnteredDate) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_EnteredDate column
 *
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\FundRaiser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOneById(int $fr_ID) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOneByDate(string $fr_date) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOneByTitle(string $fr_title) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOneByDescription(string $fr_description) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOneByEnteredBy(int $fr_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_EnteredBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\FundRaiser requireOneByEnteredDate(string $fr_EnteredDate) Return the first \ChurchCRM\model\ChurchCRM\FundRaiser filtered by the fr_EnteredDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\FundRaiserCollection|array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\FundRaiserCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\FundRaiser objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> findById(int|array<int> $fr_ID) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects filtered by the fr_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> findByDate(string|array<string> $fr_date) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects filtered by the fr_date column
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> findByTitle(string|array<string> $fr_title) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects filtered by the fr_title column
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> findByDescription(string|array<string> $fr_description) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects filtered by the fr_description column
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> findByEnteredBy(int|array<int> $fr_EnteredBy) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects filtered by the fr_EnteredBy column
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\FundRaiser> findByEnteredDate(string|array<string> $fr_EnteredDate) Return \ChurchCRM\model\ChurchCRM\FundRaiser objects filtered by the fr_EnteredDate column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\FundRaiser>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class FundRaiserQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of FundRaiserQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\FundRaiser',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFundRaiserQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\FundRaiserQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildFundRaiserQuery) {
            return $criteria;
        }
        $query = new ChildFundRaiserQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\FundRaiser|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FundRaiserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = FundRaiserTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\FundRaiser|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildFundRaiser
    {
        $sql = 'SELECT fr_ID, fr_date, fr_title, fr_description, fr_EnteredBy, fr_EnteredDate FROM fundraiser_fr WHERE fr_ID = :p0';
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
            $obj = new ChildFundRaiser();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            FundRaiserTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\FundRaiser|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\FundRaiser>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('fr_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('fr_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the fr_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE fr_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE fr_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE fr_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('fr_ID');
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
     * Filter the query on the fr_date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE fr_date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE fr_date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE fr_date > '2011-03-13'
     * </code>
     *
     * @param mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDate($date = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fr_date');
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingOperator($resolvedColumn, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingOperator($resolvedColumn, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $date, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fr_title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue'); // WHERE fr_title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE fr_title LIKE '%fooValue%'
     * $query->filterByTitle(['foo', 'bar']); // WHERE fr_title IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $title The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTitle($title = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fr_title');
        if ($comparison === null && is_array($title)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $title, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fr_description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE fr_description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE fr_description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE fr_description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fr_description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fr_EnteredBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredBy(1234); // WHERE fr_EnteredBy = 1234
     * $query->filterByEnteredBy(array(12, 34)); // WHERE fr_EnteredBy IN (12, 34)
     * $query->filterByEnteredBy(array('min' => 12)); // WHERE fr_EnteredBy > 12
     * </code>
     *
     * @param mixed $enteredBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnteredBy($enteredBy = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fr_EnteredBy');
        if (is_array($enteredBy)) {
            $useMinMax = false;
            if (isset($enteredBy['min'])) {
                $this->addUsingOperator($resolvedColumn, $enteredBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enteredBy['max'])) {
                $this->addUsingOperator($resolvedColumn, $enteredBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $enteredBy, $comparison);

        return $this;
    }

    /**
     * Filter the query on the fr_EnteredDate column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredDate('2011-03-14'); // WHERE fr_EnteredDate = '2011-03-14'
     * $query->filterByEnteredDate('now'); // WHERE fr_EnteredDate = '2011-03-14'
     * $query->filterByEnteredDate(array('max' => 'yesterday')); // WHERE fr_EnteredDate > '2011-03-13'
     * </code>
     *
     * @param mixed $enteredDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEnteredDate($enteredDate = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('fr_EnteredDate');
        if (is_array($enteredDate)) {
            $useMinMax = false;
            if (isset($enteredDate['min'])) {
                $this->addUsingOperator($resolvedColumn, $enteredDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enteredDate['max'])) {
                $this->addUsingOperator($resolvedColumn, $enteredDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $enteredDate, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\FundRaiser|null $fundRaiser Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildFundRaiser $fundRaiser = null)
    {
        if ($fundRaiser) {
            $resolvedColumn = $this->resolveLocalColumnByName('fr_ID');
            $this->addUsingOperator($resolvedColumn, $fundRaiser->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the fundraiser_fr table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FundRaiserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FundRaiserTableMap::clearInstancePool();
            FundRaiserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FundRaiserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FundRaiserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FundRaiserTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            FundRaiserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
