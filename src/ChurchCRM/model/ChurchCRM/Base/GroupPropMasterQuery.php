<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\GroupPropMaster as ChildGroupPropMaster;
use ChurchCRM\model\ChurchCRM\GroupPropMasterQuery as ChildGroupPropMasterQuery;
use ChurchCRM\model\ChurchCRM\Map\GroupPropMasterTableMap;
use Exception;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\TypedModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Propel;

/**
 * Base class that represents a query for the `groupprop_master` table.
 *
 * This contains definitions for the group-specific fields
 *
 * @method static orderByGrpId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the grp_ID column
 * @method static orderByPropId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prop_ID column
 * @method static orderByField($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prop_Field column
 * @method static orderByName($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prop_Name column
 * @method static orderByDescription($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prop_Description column
 * @method static orderByTypeId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the type_ID column
 * @method static orderBySpecial($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prop_Special column
 * @method static orderByPersonDisplay($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the prop_PersonDisplay column
 *
 * @method static groupByGrpId() Group by the grp_ID column
 * @method static groupByPropId() Group by the prop_ID column
 * @method static groupByField() Group by the prop_Field column
 * @method static groupByName() Group by the prop_Name column
 * @method static groupByDescription() Group by the prop_Description column
 * @method static groupByTypeId() Group by the type_ID column
 * @method static groupBySpecial() Group by the prop_Special column
 * @method static groupByPersonDisplay() Group by the prop_PersonDisplay column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster matching the query
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster matching the query, or a new \ChurchCRM\model\ChurchCRM\GroupPropMaster object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByGrpId(int $grp_ID) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the grp_ID column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByPropId(int $prop_ID) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_ID column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByField(string $prop_Field) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Field column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByName(string $prop_Name) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Name column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByDescription(string $prop_Description) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Description column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByTypeId(int $type_ID) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the type_ID column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneBySpecial(int $prop_Special) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Special column
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster|null findOneByPersonDisplay(string $prop_PersonDisplay) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_PersonDisplay column
 *
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\GroupPropMaster by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByGrpId(int $grp_ID) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the grp_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByPropId(int $prop_ID) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByField(string $prop_Field) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Field column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByName(string $prop_Name) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByDescription(string $prop_Description) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByTypeId(int $type_ID) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the type_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneBySpecial(int $prop_Special) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_Special column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\GroupPropMaster requireOneByPersonDisplay(string $prop_PersonDisplay) Return the first \ChurchCRM\model\ChurchCRM\GroupPropMaster filtered by the prop_PersonDisplay column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\GroupPropMasterCollection|array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\GroupPropMasterCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\GroupPropMaster objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByGrpId(int|array<int> $grp_ID) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the grp_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByPropId(int|array<int> $prop_ID) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the prop_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByField(string|array<string> $prop_Field) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the prop_Field column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByName(string|array<string> $prop_Name) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the prop_Name column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByDescription(string|array<string> $prop_Description) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the prop_Description column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByTypeId(int|array<int> $type_ID) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the type_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findBySpecial(int|array<int> $prop_Special) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the prop_Special column
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\GroupPropMaster> findByPersonDisplay(string|array<string> $prop_PersonDisplay) Return \ChurchCRM\model\ChurchCRM\GroupPropMaster objects filtered by the prop_PersonDisplay column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\GroupPropMaster>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class GroupPropMasterQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of GroupPropMasterQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\GroupPropMaster',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupPropMasterQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\GroupPropMasterQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildGroupPropMasterQuery) {
            return $criteria;
        }
        $query = new ChildGroupPropMasterQuery();
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
     *
     * </code>
     *
     * @param never $key Primary key to use for the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con an optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\GroupPropMaster|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The GroupPropMaster object has no primary key');
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
     * @throws \LogicException
     *
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\GroupPropMaster>|mixed|array the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
    {
        throw new LogicException('The GroupPropMaster object has no primary key');
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
        throw new LogicException('The GroupPropMaster object has no primary key');
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
        throw new LogicException('The GroupPropMaster object has no primary key');
    }

    /**
     * Filter the query on the grp_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByGrpId(1234); // WHERE grp_ID = 1234
     * $query->filterByGrpId(array(12, 34)); // WHERE grp_ID IN (12, 34)
     * $query->filterByGrpId(array('min' => 12)); // WHERE grp_ID > 12
     * </code>
     *
     * @param mixed $grpId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByGrpId($grpId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('grp_ID');
        if (is_array($grpId)) {
            $useMinMax = false;
            if (isset($grpId['min'])) {
                $this->addUsingOperator($resolvedColumn, $grpId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($grpId['max'])) {
                $this->addUsingOperator($resolvedColumn, $grpId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $grpId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prop_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByPropId(1234); // WHERE prop_ID = 1234
     * $query->filterByPropId(array(12, 34)); // WHERE prop_ID IN (12, 34)
     * $query->filterByPropId(array('min' => 12)); // WHERE prop_ID > 12
     * </code>
     *
     * @param mixed $propId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPropId($propId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prop_ID');
        if (is_array($propId)) {
            $useMinMax = false;
            if (isset($propId['min'])) {
                $this->addUsingOperator($resolvedColumn, $propId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($propId['max'])) {
                $this->addUsingOperator($resolvedColumn, $propId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $propId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prop_Field column
     *
     * Example usage:
     * <code>
     * $query->filterByField('fooValue'); // WHERE prop_Field = 'fooValue'
     * $query->filterByField('%fooValue%', Criteria::LIKE); // WHERE prop_Field LIKE '%fooValue%'
     * $query->filterByField(['foo', 'bar']); // WHERE prop_Field IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $field The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByField($field = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prop_Field');
        if ($comparison === null && is_array($field)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $field, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prop_Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue'); // WHERE prop_Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE prop_Name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE prop_Name IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prop_Name');
        if ($comparison === null && is_array($name)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $name, $comparison);

        return $this;
    }

    /**
     * Filter the query on the prop_Description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue'); // WHERE prop_Description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE prop_Description LIKE '%fooValue%'
     * $query->filterByDescription(['foo', 'bar']); // WHERE prop_Description IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $description The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDescription($description = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prop_Description');
        if ($comparison === null && is_array($description)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $description, $comparison);

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
     * Filter the query on the prop_Special column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecial(1234); // WHERE prop_Special = 1234
     * $query->filterBySpecial(array(12, 34)); // WHERE prop_Special IN (12, 34)
     * $query->filterBySpecial(array('min' => 12)); // WHERE prop_Special > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('prop_Special');
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
     * Filter the query on the prop_PersonDisplay column
     *
     * Example usage:
     * <code>
     * $query->filterByPersonDisplay('fooValue'); // WHERE prop_PersonDisplay = 'fooValue'
     * $query->filterByPersonDisplay('%fooValue%', Criteria::LIKE); // WHERE prop_PersonDisplay LIKE '%fooValue%'
     * $query->filterByPersonDisplay(['foo', 'bar']); // WHERE prop_PersonDisplay IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $personDisplay The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPersonDisplay($personDisplay = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('prop_PersonDisplay');
        if ($comparison === null && is_array($personDisplay)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $personDisplay, $comparison);

        return $this;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\GroupPropMaster|null $groupPropMaster Object to remove from the list of results
     *
     * @throws \LogicException
     *
     * @return $this
     */
    public function prune(?ChildGroupPropMaster $groupPropMaster = null)
    {
        if ($groupPropMaster) {
            throw new LogicException('GroupPropMaster object has no primary key');

        }

        return $this;
    }

    /**
     * Deletes all rows from the groupprop_master table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupPropMasterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupPropMasterTableMap::clearInstancePool();
            GroupPropMasterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupPropMasterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupPropMasterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GroupPropMasterTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            GroupPropMasterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
