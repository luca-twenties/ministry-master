<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\PersonCustomMasterTableMap;
use ChurchCRM\model\ChurchCRM\PersonCustomMaster as ChildPersonCustomMaster;
use ChurchCRM\model\ChurchCRM\PersonCustomMasterQuery as ChildPersonCustomMasterQuery;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `person_custom_master` table.
 *
 * This contains definitions for the custom person fields
 *
 * @method static orderByOrder($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the custom_Order column
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the custom_Field column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the custom_Name column
 * @method static orderBySpecial($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the custom_Special column
 * @method static orderByFieldSecurity($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the custom_FieldSec column
 * @method static orderByTypeId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_ID column
 *
 * @method static groupByOrder() Group by the custom_Order column
 * @method static groupById() Group by the custom_Field column
 * @method static groupByName() Group by the custom_Name column
 * @method static groupBySpecial() Group by the custom_Special column
 * @method static groupByFieldSecurity() Group by the custom_FieldSec column
 * @method static groupByTypeId() Group by the type_ID column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster matching the query
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster matching the query, or a new \ChurchCRM\model\ChurchCRM\PersonCustomMaster object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOneByOrder(int $custom_Order) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Order column
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOneById(string $custom_Field) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Field column
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOneByName(string $custom_Name) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Name column
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOneBySpecial(int $custom_Special) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Special column
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOneByFieldSecurity(int $custom_FieldSec) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_FieldSec column
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null findOneByTypeId(int $type_ID) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the type_ID column
 *
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\PersonCustomMaster by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOneByOrder(int $custom_Order) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Order column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOneById(string $custom_Field) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Field column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOneByName(string $custom_Name) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOneBySpecial(int $custom_Special) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_Special column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOneByFieldSecurity(int $custom_FieldSec) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the custom_FieldSec column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\PersonCustomMaster requireOneByTypeId(int $type_ID) Return the first \ChurchCRM\model\ChurchCRM\PersonCustomMaster filtered by the type_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCustomMasterCollection|array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCustomMasterCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> findByOrder(int|array<int> $custom_Order) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects filtered by the custom_Order column
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> findById(string|array<string> $custom_Field) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects filtered by the custom_Field column
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> findByName(string|array<string> $custom_Name) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects filtered by the custom_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> findBySpecial(int|array<int> $custom_Special) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects filtered by the custom_Special column
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> findByFieldSecurity(int|array<int> $custom_FieldSec) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects filtered by the custom_FieldSec column
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\PersonCustomMaster> findByTypeId(int|array<int> $type_ID) Return \ChurchCRM\model\ChurchCRM\PersonCustomMaster objects filtered by the type_ID column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\PersonCustomMaster>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class PersonCustomMasterQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of PersonCustomMasterQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\PersonCustomMaster',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPersonCustomMasterQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomMasterQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildPersonCustomMasterQuery) {
            return $criteria;
        }
        $query = new ChildPersonCustomMasterQuery();
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
     * @param string $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\PersonCustomMaster|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PersonCustomMasterTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = PersonCustomMasterTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildPersonCustomMaster
    {
        $sql = 'SELECT custom_Order, custom_Field, custom_Name, custom_Special, custom_FieldSec, type_ID FROM person_custom_master WHERE custom_Field = :p0';
        $stmt = $con->prepare($sql);
        if (is_bool($stmt)) {
            throw new PropelException('Failed to initialize statement');
        }
        $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
        try {
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;

        $row = $stmt->fetch(PDO::FETCH_NUM);
        if ($row) {
            $obj = new ChildPersonCustomMaster();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            PersonCustomMasterTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\PersonCustomMaster|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\PersonCustomMaster>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('custom_Field');
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
        $resolvedColumn = $this->resolveLocalColumnByName('custom_Field');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the custom_Order column
     *
     * Example usage:
     * <code>
     * $query->filterByOrder(1234); // WHERE custom_Order = 1234
     * $query->filterByOrder(array(12, 34)); // WHERE custom_Order IN (12, 34)
     * $query->filterByOrder(array('min' => 12)); // WHERE custom_Order > 12
     * </code>
     *
     * @param mixed $order The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByOrder($order = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('custom_Order');
        if (is_array($order)) {
            $useMinMax = false;
            if (isset($order['min'])) {
                $this->addUsingOperator($resolvedColumn, $order['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($order['max'])) {
                $this->addUsingOperator($resolvedColumn, $order['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $order, $comparison);

        return $this;
    }

    /**
     * Filter the query on the custom_Field column
     *
     * Example usage:
     * <code>
     * $query->filterById('fooValue'); // WHERE custom_Field = 'fooValue'
     * $query->filterById('%fooValue%', Criteria::LIKE); // WHERE custom_Field LIKE '%fooValue%'
     * $query->filterById(['foo', 'bar']); // WHERE custom_Field IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $id The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('custom_Field');
        if ($comparison === null && is_array($id)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the custom_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE custom_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE custom_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE custom_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('custom_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the custom_Special column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecial(1234); // WHERE custom_Special = 1234
     * $query->filterBySpecial(array(12, 34)); // WHERE custom_Special IN (12, 34)
     * $query->filterBySpecial(array('min' => 12)); // WHERE custom_Special > 12
     * </code>
     *
     * @param mixed $special The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterBySpecial($special = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('custom_Special');
        if (is_array($special)) {
            $useMinMax = false;
            if (isset($special['min'])) {
                $this->addUsingOperator($resolvedColumn, $special['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($special['max'])) {
                $this->addUsingOperator($resolvedColumn, $special['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $special, $comparison);

        return $this;
    }

    /**
     * Filter the query on the custom_FieldSec column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldSecurity(1234); // WHERE custom_FieldSec = 1234
     * $query->filterByFieldSecurity(array(12, 34)); // WHERE custom_FieldSec IN (12, 34)
     * $query->filterByFieldSecurity(array('min' => 12)); // WHERE custom_FieldSec > 12
     * </code>
     *
     * @param mixed $fieldSecurity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFieldSecurity($fieldSecurity = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('custom_FieldSec');
        if (is_array($fieldSecurity)) {
            $useMinMax = false;
            if (isset($fieldSecurity['min'])) {
                $this->addUsingOperator($resolvedColumn, $fieldSecurity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldSecurity['max'])) {
                $this->addUsingOperator($resolvedColumn, $fieldSecurity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $fieldSecurity, $comparison);

        return $this;
    }

    /**
     * Filter the query on the type_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE type_ID = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE type_ID IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE type_ID > 12
     * </code>
     *
     * @param mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByTypeId($typeId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('type_ID');
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingOperator($resolvedColumn, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingOperator($resolvedColumn, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $typeId, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\PersonCustomMaster|null $personCustomMaster Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildPersonCustomMaster $personCustomMaster = null)
    {
        if ($personCustomMaster) {
            $resolvedColumn = $this->resolveLocalColumnByName('custom_Field');
            $this->addUsingOperator($resolvedColumn, $personCustomMaster->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the person_custom_master table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PersonCustomMasterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PersonCustomMasterTableMap::clearInstancePool();
            PersonCustomMasterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonCustomMasterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PersonCustomMasterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PersonCustomMasterTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            PersonCustomMasterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
