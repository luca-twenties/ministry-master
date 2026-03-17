<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\NoteTableMap;
use ChurchCRM\model\ChurchCRM\Note as ChildNote;
use ChurchCRM\model\ChurchCRM\NoteQuery as ChildNoteQuery;
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
 * Base class that represents a query for the `note_nte` table.
 *
 * Contains all person and family notes, including the date, time, and person who entered the note
 *
 * @method static orderById($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_ID column
 * @method static orderByPerId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_per_ID column
 * @method static orderByFamId($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_fam_ID column
 * @method static orderByPrivate($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_Private column
 * @method static orderByText($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_Text column
 * @method static orderByDateEntered($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_DateEntered column
 * @method static orderByDateLastEdited($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_DateLastEdited column
 * @method static orderByEnteredBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_EnteredBy column
 * @method static orderByEditedBy($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_EditedBy column
 * @method static orderByType($order = \Propel\Runtime\ActiveQuery\Criteria::ASC) Order by the nte_Type column
 *
 * @method static groupById() Group by the nte_ID column
 * @method static groupByPerId() Group by the nte_per_ID column
 * @method static groupByFamId() Group by the nte_fam_ID column
 * @method static groupByPrivate() Group by the nte_Private column
 * @method static groupByText() Group by the nte_Text column
 * @method static groupByDateEntered() Group by the nte_DateEntered column
 * @method static groupByDateLastEdited() Group by the nte_DateLastEdited column
 * @method static groupByEnteredBy() Group by the nte_EnteredBy column
 * @method static groupByEditedBy() Group by the nte_EditedBy column
 * @method static groupByType() Group by the nte_Type column
 *
 * @method static leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method static rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method static innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method static leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method static rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method static innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method static leftJoinPerson($relationAlias = null) Adds a LEFT JOIN clause to the query using the Person relation
 * @method static rightJoinPerson($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Person relation
 * @method static innerJoinPerson($relationAlias = null) Adds a INNER JOIN clause to the query using the Person relation
 *
 * @method static joinWithPerson($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Person relation
 *
 * @method static leftJoinWithPerson() Adds a LEFT JOIN clause and with to the query using the Person relation
 * @method static rightJoinWithPerson() Adds a RIGHT JOIN clause and with to the query using the Person relation
 * @method static innerJoinWithPerson() Adds a INNER JOIN clause and with to the query using the Person relation
 *
 * @method static leftJoinFamily($relationAlias = null) Adds a LEFT JOIN clause to the query using the Family relation
 * @method static rightJoinFamily($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Family relation
 * @method static innerJoinFamily($relationAlias = null) Adds a INNER JOIN clause to the query using the Family relation
 *
 * @method static joinWithFamily($joinType = \Propel\Runtime\ActiveQuery\Criteria::INNER_JOIN) Adds a join clause and with to the query using the Family relation
 *
 * @method static leftJoinWithFamily() Adds a LEFT JOIN clause and with to the query using the Family relation
 * @method static rightJoinWithFamily() Adds a RIGHT JOIN clause and with to the query using the Family relation
 * @method static innerJoinWithFamily() Adds a INNER JOIN clause and with to the query using the Family relation
 *
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Note matching the query
 * @method \ChurchCRM\model\ChurchCRM\Note findOneOrCreate(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Note matching the query, or a new \ChurchCRM\model\ChurchCRM\Note object populated from the query conditions when no match is found
 *
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneById(int $nte_ID) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_ID column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByPerId(int $nte_per_ID) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_per_ID column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByFamId(int $nte_fam_ID) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_fam_ID column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByPrivate(int $nte_Private) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_Private column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByText(string $nte_Text) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_Text column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByDateEntered(string $nte_DateEntered) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_DateEntered column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByDateLastEdited(string $nte_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_DateLastEdited column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByEnteredBy(int $nte_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_EnteredBy column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByEditedBy(int $nte_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_EditedBy column
 * @method \ChurchCRM\model\ChurchCRM\Note|null findOneByType(string $nte_Type) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_Type column
 *
 * @method \ChurchCRM\model\ChurchCRM\Note requirePk($key, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the \ChurchCRM\model\ChurchCRM\Note by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOne(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return the first \ChurchCRM\model\ChurchCRM\Note matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneById(int $nte_ID) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByPerId(int $nte_per_ID) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_per_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByFamId(int $nte_fam_ID) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_fam_ID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByPrivate(int $nte_Private) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_Private column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByText(string $nte_Text) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_Text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByDateEntered(string $nte_DateEntered) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_DateEntered column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByDateLastEdited(string $nte_DateLastEdited) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_DateLastEdited column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByEnteredBy(int $nte_EnteredBy) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_EnteredBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByEditedBy(int $nte_EditedBy) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_EditedBy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method \ChurchCRM\model\ChurchCRM\Note requireOneByType(string $nte_Type) Return the first \ChurchCRM\model\ChurchCRM\Note filtered by the nte_Type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection|array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> find(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Return \ChurchCRM\model\ChurchCRM\Note objects based on current ModelCriteria
 * @method \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection findObjects(\Propel\Runtime\Connection\ConnectionInterface|null $con = null) Get \ChurchCRM\model\ChurchCRM\Note objects in ObjectCollection
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findById(int|array<int> $nte_ID) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByPerId(int|array<int> $nte_per_ID) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_per_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByFamId(int|array<int> $nte_fam_ID) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_fam_ID column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByPrivate(int|array<int> $nte_Private) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_Private column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByText(string|array<string> $nte_Text) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_Text column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByDateEntered(string|array<string> $nte_DateEntered) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_DateEntered column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByDateLastEdited(string|array<string> $nte_DateLastEdited) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_DateLastEdited column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByEnteredBy(int|array<int> $nte_EnteredBy) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_EnteredBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByEditedBy(int|array<int> $nte_EditedBy) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_EditedBy column
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Note> findByType(string|array<string> $nte_Type) Return \ChurchCRM\model\ChurchCRM\Note objects filtered by the nte_Type column
 *
 * @method array<\ChurchCRM\model\ChurchCRM\Note>|\Propel\Runtime\Util\PropelModelPager<mixed> paginate($page = 1, $maxPerPage = 10, \Propel\Runtime\Connection\ConnectionInterface|null $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 * @template ParentQuery of \Propel\Runtime\ActiveQuery\ModelCriteria|null = null
 * @extends \Propel\Runtime\ActiveQuery\TypedModelCriteria<ParentQuery>
 */
abstract class NoteQuery extends TypedModelCriteria
{
    /**
     * @var string
     */
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of NoteQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string|null $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct(
        string $dbName = 'default',
        string $modelName = '\\ChurchCRM\\model\\ChurchCRM\\Note',
        ?string $modelAlias = null
    ) {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNoteQuery object. XS
     *
     * @param string|null $modelAlias The alias of a model in the query
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional Criteria to build the query from
     *
     * @return \ChurchCRM\model\ChurchCRM\NoteQuery<null>
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildNoteQuery) {
            return $criteria;
        }
        $query = new ChildNoteQuery();
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Note|mixed|array the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NoteTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (!$this->isEmpty()) {
            return $this->findPkComplex($key, $con);
        }

        $poolKey = (string)$key;
        $obj = NoteTableMap::getInstanceFromPool($poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Note|null A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con): ?ChildNote
    {
        $sql = 'SELECT nte_ID, nte_per_ID, nte_fam_ID, nte_Private, nte_Text, nte_DateEntered, nte_DateLastEdited, nte_EnteredBy, nte_EditedBy, nte_Type FROM note_nte WHERE nte_ID = :p0';
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
            $obj = new ChildNote();
            $obj->hydrate($row);
            $poolKey = (string)$key;
            NoteTableMap::addInstanceToPool($obj, $poolKey);
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Note|mixed|array|null the result, formatted by the current formatter
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
     * @return \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Note>|mixed|array the list of results, formatted by the current formatter
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
        $resolvedColumn = $this->resolveLocalColumnByName('nte_ID');
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
        $resolvedColumn = $this->resolveLocalColumnByName('nte_ID');
        $this->addUsingOperator($resolvedColumn, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the nte_ID column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE nte_ID = 1234
     * $query->filterById(array(12, 34)); // WHERE nte_ID IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE nte_ID > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('nte_ID');
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
     * Filter the query on the nte_per_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByPerId(1234); // WHERE nte_per_ID = 1234
     * $query->filterByPerId(array(12, 34)); // WHERE nte_per_ID IN (12, 34)
     * $query->filterByPerId(array('min' => 12)); // WHERE nte_per_ID > 12
     * </code>
     *
     * @see static::filterByPerson()
     *
     * @param mixed $perId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPerId($perId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_per_ID');
        if (is_array($perId)) {
            $useMinMax = false;
            if (isset($perId['min'])) {
                $this->addUsingOperator($resolvedColumn, $perId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perId['max'])) {
                $this->addUsingOperator($resolvedColumn, $perId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $perId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_fam_ID column
     *
     * Example usage:
     * <code>
     * $query->filterByFamId(1234); // WHERE nte_fam_ID = 1234
     * $query->filterByFamId(array(12, 34)); // WHERE nte_fam_ID IN (12, 34)
     * $query->filterByFamId(array('min' => 12)); // WHERE nte_fam_ID > 12
     * </code>
     *
     * @see static::filterByFamily()
     *
     * @param mixed $famId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByFamId($famId = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_fam_ID');
        if (is_array($famId)) {
            $useMinMax = false;
            if (isset($famId['min'])) {
                $this->addUsingOperator($resolvedColumn, $famId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($famId['max'])) {
                $this->addUsingOperator($resolvedColumn, $famId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $famId, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_Private column
     *
     * Example usage:
     * <code>
     * $query->filterByPrivate(1234); // WHERE nte_Private = 1234
     * $query->filterByPrivate(array(12, 34)); // WHERE nte_Private IN (12, 34)
     * $query->filterByPrivate(array('min' => 12)); // WHERE nte_Private > 12
     * </code>
     *
     * @param mixed $private The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByPrivate($private = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_Private');
        if (is_array($private)) {
            $useMinMax = false;
            if (isset($private['min'])) {
                $this->addUsingOperator($resolvedColumn, $private['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($private['max'])) {
                $this->addUsingOperator($resolvedColumn, $private['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $private, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_Text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue'); // WHERE nte_Text = 'fooValue'
     * $query->filterByText('%fooValue%', Criteria::LIKE); // WHERE nte_Text LIKE '%fooValue%'
     * $query->filterByText(['foo', 'bar']); // WHERE nte_Text IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $text The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByText($text = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_Text');
        if ($comparison === null && is_array($text)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $text, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_DateEntered column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEntered('2011-03-14'); // WHERE nte_DateEntered = '2011-03-14'
     * $query->filterByDateEntered('now'); // WHERE nte_DateEntered = '2011-03-14'
     * $query->filterByDateEntered(array('max' => 'yesterday')); // WHERE nte_DateEntered > '2011-03-13'
     * </code>
     *
     * @param mixed $dateEntered The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDateEntered($dateEntered = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_DateEntered');
        if (is_array($dateEntered)) {
            $useMinMax = false;
            if (isset($dateEntered['min'])) {
                $this->addUsingOperator($resolvedColumn, $dateEntered['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateEntered['max'])) {
                $this->addUsingOperator($resolvedColumn, $dateEntered['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $dateEntered, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_DateLastEdited column
     *
     * Example usage:
     * <code>
     * $query->filterByDateLastEdited('2011-03-14'); // WHERE nte_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited('now'); // WHERE nte_DateLastEdited = '2011-03-14'
     * $query->filterByDateLastEdited(array('max' => 'yesterday')); // WHERE nte_DateLastEdited > '2011-03-13'
     * </code>
     *
     * @param mixed $dateLastEdited The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByDateLastEdited($dateLastEdited = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_DateLastEdited');
        if (is_array($dateLastEdited)) {
            $useMinMax = false;
            if (isset($dateLastEdited['min'])) {
                $this->addUsingOperator($resolvedColumn, $dateLastEdited['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateLastEdited['max'])) {
                $this->addUsingOperator($resolvedColumn, $dateLastEdited['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $dateLastEdited, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_EnteredBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEnteredBy(1234); // WHERE nte_EnteredBy = 1234
     * $query->filterByEnteredBy(array(12, 34)); // WHERE nte_EnteredBy IN (12, 34)
     * $query->filterByEnteredBy(array('min' => 12)); // WHERE nte_EnteredBy > 12
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
        $resolvedColumn = $this->resolveLocalColumnByName('nte_EnteredBy');
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
     * Filter the query on the nte_EditedBy column
     *
     * Example usage:
     * <code>
     * $query->filterByEditedBy(1234); // WHERE nte_EditedBy = 1234
     * $query->filterByEditedBy(array(12, 34)); // WHERE nte_EditedBy IN (12, 34)
     * $query->filterByEditedBy(array('min' => 12)); // WHERE nte_EditedBy > 12
     * </code>
     *
     * @param mixed $editedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByEditedBy($editedBy = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_EditedBy');
        if (is_array($editedBy)) {
            $useMinMax = false;
            if (isset($editedBy['min'])) {
                $this->addUsingOperator($resolvedColumn, $editedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($editedBy['max'])) {
                $this->addUsingOperator($resolvedColumn, $editedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }
        }
        $this->addUsingOperator($resolvedColumn, $editedBy, $comparison);

        return $this;
    }

    /**
     * Filter the query on the nte_Type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue'); // WHERE nte_Type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE nte_Type LIKE '%fooValue%'
     * $query->filterByType(['foo', 'bar']); // WHERE nte_Type IN ('foo', 'bar')
     * </code>
     *
     * @param array<string>|string|null $type The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this
     */
    public function filterByType($type = null, ?string $comparison = null)
    {
        $resolvedColumn = $this->resolveLocalColumnByName('nte_Type');
        if ($comparison === null && is_array($type)) {
            $comparison = Criteria::IN;
        }
        $this->addUsingOperator($resolvedColumn, $type, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related Person object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person> $person The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByPerson($person, ?string $comparison = null)
    {
        if ($person instanceof Person) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('nte_per_ID'), $person->getId(), $comparison);
        } elseif ($person instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('nte_per_ID'), $person->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPerson() only accepts arguments of type Person or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Person relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinPerson(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Person');

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
            $this->addJoinObject($join, 'Person');
        }

        return $this;
    }

    /**
     * Use the Person relation Person object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> A secondary query class using the current class as primary query
     */
    public function usePersonQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $query */
        $query = $this->joinPerson($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Person', '\ChurchCRM\model\ChurchCRM\PersonQuery');

        return $query;
    }

    /**
     * Use the Person relation Person object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\PersonQuery<mixed>):\ChurchCRM\model\ChurchCRM\PersonQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPersonQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePersonQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Person table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the EXISTS statement
     */
    public function usePersonExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useExistsQuery('Person', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Person table for a NOT EXISTS query.
     *
     * @see usePersonExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function usePersonNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q*/
        $q = $this->useExistsQuery('Person', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Person table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the IN statement
     */
    public function useInPersonQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('Person', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Person table for a NOT IN query.
     *
     * @see usePersonInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\PersonQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInPersonQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\PersonQuery<static> $q */
        $q = $this->useInQuery('Person', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Filter the query by a related Family object
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Family|\Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Family> $family The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return static
     */
    public function filterByFamily($family, ?string $comparison = null)
    {
        if ($family instanceof Family) {
            return $this
                ->addUsingOperator($this->resolveLocalColumnByName('nte_fam_ID'), $family->getId(), $comparison);
        } elseif ($family instanceof ObjectCollection) {
            if ($comparison === null) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingOperator($this->resolveLocalColumnByName('nte_fam_ID'), $family->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByFamily() only accepts arguments of type Family or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Family relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function joinFamily(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Family');

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
            $this->addJoinObject($join, 'Family');
        }

        return $this;
    }

    /**
     * Use the Family relation Family object
     *
     * @see useQuery()
     *
     * @param string|null $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> A secondary query class using the current class as primary query
     */
    public function useFamilyQuery(?string $relationAlias = null, string $joinType = Criteria::INNER_JOIN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $query */
        $query = $this->joinFamily($relationAlias, $joinType)
            ->useQuery($relationAlias ?: 'Family', '\ChurchCRM\model\ChurchCRM\FamilyQuery');

        return $query;
    }

    /**
     * Use the Family relation Family object
     *
     * @param callable(\ChurchCRM\model\ChurchCRM\FamilyQuery<mixed>):\ChurchCRM\model\ChurchCRM\FamilyQuery<mixed> $callable A function working on the related query
     * @param string|null $relationAlias optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withFamilyQuery(
        callable $callable,
        ?string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useFamilyQuery(
            $relationAlias,
            $joinType,
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }

    /**
     * Use the relation to Family table for an EXISTS query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\FilterExpression\ExistsFilter::TYPE_* $typeOfExists
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfExists Either ExistsQueryCriterion::TYPE_EXISTS or ExistsQueryCriterion::TYPE_NOT_EXISTS
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the EXISTS statement
     */
    public function useFamilyExistsQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfExists = 'EXISTS')
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q */
        $q = $this->useExistsQuery('Family', $modelAlias, $queryClass, $typeOfExists);

        return $q;
    }

    /**
     * Use the relation to Family table for a NOT EXISTS query.
     *
     * @see useFamilyExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the NOT EXISTS statement
     */
    public function useFamilyNotExistsQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q*/
        $q = $this->useExistsQuery('Family', $modelAlias, $queryClass, 'NOT EXISTS');

        return $q;
    }

    /**
     * Use the relation to Family table for an IN query.
     *
     * @phpstan-param \Propel\Runtime\ActiveQuery\Criteria::*IN $typeOfIn
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string $typeOfIn Criteria::IN or Criteria::NOT_IN
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the IN statement
     */
    public function useInFamilyQuery(?string $modelAlias = null, ?string $queryClass = null, string $typeOfIn = Criteria::IN)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q */
        $q = $this->useInQuery('Family', $modelAlias, $queryClass, $typeOfIn);

        return $q;
    }

    /**
     * Use the relation to Family table for a NOT IN query.
     *
     * @see useFamilyInQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param class-string<\Propel\Runtime\ActiveQuery\ModelCriteria>|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \ChurchCRM\model\ChurchCRM\FamilyQuery<static> The inner query object of the NOT IN statement
     */
    public function useNotInFamilyQuery(?string $modelAlias = null, ?string $queryClass = null)
    {
        /** @var \ChurchCRM\model\ChurchCRM\FamilyQuery<static> $q */
        $q = $this->useInQuery('Family', $modelAlias, $queryClass, Criteria::NOT_IN);

        return $q;
    }

    /**
     * Exclude object from result
     *
     * @param \ChurchCRM\model\ChurchCRM\Note|null $note Object to remove from the list of results
     *
     * @return $this
     */
    public function prune(?ChildNote $note = null)
    {
        if ($note) {
            $resolvedColumn = $this->resolveLocalColumnByName('nte_ID');
            $this->addUsingOperator($resolvedColumn, $note->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the note_nte table.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con the connection to use
     *
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (!$con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NoteTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0;
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NoteTableMap::clearInstancePool();
            NoteTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NoteTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NoteTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NoteTableMap::removeInstanceFromPool($criteria);
            $affectedRows += ModelCriteria::delete($con);
            NoteTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }
}
