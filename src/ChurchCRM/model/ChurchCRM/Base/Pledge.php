<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\DepositQuery as ChildDepositQuery;
use ChurchCRM\model\ChurchCRM\DonationFundQuery as ChildDonationFundQuery;
use ChurchCRM\model\ChurchCRM\FamilyQuery as ChildFamilyQuery;
use ChurchCRM\model\ChurchCRM\Map\PledgeTableMap;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
use ChurchCRM\model\ChurchCRM\PledgeQuery as ChildPledgeQuery;
use DateTimeInterface;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\ColumnResolver\ColumnExpression\LocalColumnExpression;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Propel;
use Propel\Runtime\Util\PropelDateTime;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * Base class that represents a row from the 'pledge_plg' table.
 *
 * This contains all payment/pledge information
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Pledge implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\PledgeTableMap';

    /**
     * attribute to determine if this object has previously been saved.
     */
    protected bool $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     */
    protected bool $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     *
     * @var array<string, bool>
     */
    protected array $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     *
     * @var array<string, mixed>
     */
    protected array $virtualColumns = [];

    /**
     * The value for the plg_plgid field.
     */
    protected int|null $plg_plgid = null;

    /**
     * The value for the plg_famid field.
     */
    protected int|null $plg_famid = null;

    /**
     * The value for the plg_fyid field.
     */
    protected int|null $plg_fyid = null;

    /**
     * The value for the plg_date field.
     */
    protected DateTimeInterface|null $plg_date = null;

    /**
     * The value for the plg_amount field.
     */
    protected string|null $plg_amount = null;

    /**
     * The value for the plg_schedule field.
     */
    protected string|null $plg_schedule = null;

    /**
     * The value for the plg_method field.
     */
    protected string|null $plg_method = null;

    /**
     * The value for the plg_comment field.
     */
    protected string|null $plg_comment = null;

    /**
     * The value for the plg_datelastedited field.
     *
     * Note: this column has a database default value of: '2016-01-01'
     */
    protected DateTimeInterface|null $plg_datelastedited = null;

    /**
     * The value for the plg_editedby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $plg_editedby = null;

    /**
     * The value for the plg_pledgeorpayment field.
     *
     * Note: this column has a database default value of: 'Pledge'
     */
    protected string|null $plg_pledgeorpayment = null;

    /**
     * The value for the plg_fundid field.
     */
    protected int|null $plg_fundid = null;

    /**
     * The value for the plg_depid field.
     */
    protected int|null $plg_depid = null;

    /**
     * The value for the plg_checkno field.
     */
    protected string|null $plg_checkno = null;

    /**
     * The value for the plg_problem field.
     */
    protected bool|null $plg_problem = null;

    /**
     * The value for the plg_scanstring field.
     */
    protected string|null $plg_scanstring = null;

    /**
     * The value for the plg_aut_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $plg_aut_id = null;

    /**
     * The value for the plg_aut_cleared field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $plg_aut_cleared = null;

    /**
     * The value for the plg_aut_resultid field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $plg_aut_resultid = null;

    /**
     * The value for the plg_nondeductible field.
     */
    protected string|null $plg_nondeductible = null;

    /**
     * The value for the plg_groupkey field.
     */
    protected string|null $plg_groupkey = null;

    /**
     * Deposit associated via Deposit relation (n:1).
     */
    protected Deposit|null $aDeposit = null;

    /**
     * DonationFund associated via DonationFund relation (n:1).
     */
    protected DonationFund|null $aDonationFund = null;

    /**
     * Family associated via Family relation (n:1).
     */
    protected Family|null $aFamily = null;

    /**
     * Person associated via Person relation (n:1).
     */
    protected Person|null $aPerson = null;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     *
     * @see __construct()
     *
     * @return void
     */
    public function applyDefaultValues(): void
    {
        $this->plg_datelastedited = PropelDateTime::newInstance('2016-01-01', null, '\DateTime');
        $this->plg_editedby = 0;
        $this->plg_pledgeorpayment = 'Pledge';
        $this->plg_aut_id = 0;
        $this->plg_aut_cleared = false;
        $this->plg_aut_resultid = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Pledge object.
     *
     * @see static::applyDefaultValues()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return (bool)$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     *
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     *
     * @return array<string> A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved. This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.
     *
     * Called by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     *
     * @return void
     */
    public function setNew(bool $b): void
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     *
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     *
     * @param bool $b The deleted state of this object.
     *
     * @return void
     */
    public function setDeleted(bool $b): void
    {
        $this->deleted = $b;
    }

    /**
     * Sets the modified state for the object to be false.
     *
     * @param string|null $col If supplied, only the specified column is reset.
     *
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if ($col !== null) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Pledge</code> instance. If
     * <code>obj</code> is an instance of <code>Pledge</code>, delegates to
     * <code>equals(Pledge)</code>. Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     *
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }
        if ($this->getPrimaryKey() === null || $obj->getPrimaryKey() === null) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array<mixed>
     */
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     *
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return mixed
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     *
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
    {
        Propel::log(static::class . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     *
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, [], true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     *
     * @return array<string>
     */
    public function __sleep(): array
    {
        $this->clearAllReferences();

        $cls = new ReflectionClass($this);
        $staticProperties = $cls->getProperties(ReflectionProperty::IS_STATIC);
        $properties = $cls->getProperties();
        $serializableProperties = array_diff($properties, $staticProperties);

        $propertyNames = [];
        foreach ($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [plg_plgid] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->plg_plgid;
    }

    /**
     * Get the [plg_famid] column value.
     *
     * @return int|null
     */
    public function getFamId()
    {
        return $this->plg_famid;
    }

    /**
     * Get the [plg_fyid] column value.
     *
     * @return int|null
     */
    public function getFyId()
    {
        return $this->plg_fyid;
    }

    /**
     * Get the [optionally formatted] temporal [plg_date] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getDate($format = null)
    {
        if ($format === null) {
            return $this->plg_date;
        } else {
            return $this->plg_date instanceof DateTimeInterface ? $this->plg_date->format($format) : null;
        }
    }

    /**
     * Get the [plg_amount] column value.
     *
     * @return string|null
     */
    public function getAmount()
    {
        return $this->plg_amount;
    }

    /**
     * Get the [plg_schedule] column value.
     *
     * @return string|null
     */
    public function getSchedule()
    {
        return $this->plg_schedule;
    }

    /**
     * Get the [plg_method] column value.
     *
     * @return string|null
     */
    public function getMethod()
    {
        return $this->plg_method;
    }

    /**
     * Get the [plg_comment] column value.
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->plg_comment;
    }

    /**
     * Get the [optionally formatted] temporal [plg_datelastedited] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00.
     */
    public function getDateLastEdited($format = null)
    {
        if ($format === null) {
            return $this->plg_datelastedited;
        } else {
            return $this->plg_datelastedited instanceof DateTimeInterface ? $this->plg_datelastedited->format($format) : null;
        }
    }

    /**
     * Get the [plg_editedby] column value.
     *
     * @return int|null
     */
    public function getEditedBy()
    {
        return $this->plg_editedby;
    }

    /**
     * Get the [plg_pledgeorpayment] column value.
     *
     * @return string|null
     */
    public function getPledgeOrPayment()
    {
        return $this->plg_pledgeorpayment;
    }

    /**
     * Get the [plg_fundid] column value.
     *
     * @return int|null
     */
    public function getFundId()
    {
        return $this->plg_fundid;
    }

    /**
     * Get the [plg_depid] column value.
     *
     * @return int|null
     */
    public function getDepId()
    {
        return $this->plg_depid;
    }

    /**
     * Get the [plg_checkno] column value.
     *
     * @return string|null
     */
    public function getCheckNo()
    {
        return $this->plg_checkno;
    }

    /**
     * Get the [plg_problem] column value.
     *
     * @return bool|null
     */
    public function getProblem()
    {
        return $this->plg_problem;
    }

    /**
     * Get the [plg_problem] column value.
     *
     * @return bool|null
     */
    public function isProblem()
    {
        return $this->getProblem();
    }

    /**
     * Get the [plg_scanstring] column value.
     *
     * @return string|null
     */
    public function getScanString()
    {
        return $this->plg_scanstring;
    }

    /**
     * Get the [plg_aut_id] column value.
     *
     * @return int|null
     */
    public function getAutId()
    {
        return $this->plg_aut_id;
    }

    /**
     * Get the [plg_aut_cleared] column value.
     *
     * @return bool|null
     */
    public function getAutCleared()
    {
        return $this->plg_aut_cleared;
    }

    /**
     * Get the [plg_aut_cleared] column value.
     *
     * @return bool|null
     */
    public function isAutCleared()
    {
        return $this->getAutCleared();
    }

    /**
     * Get the [plg_aut_resultid] column value.
     *
     * @return int|null
     */
    public function getAutResultId()
    {
        return $this->plg_aut_resultid;
    }

    /**
     * Get the [plg_nondeductible] column value.
     *
     * @return string|null
     */
    public function getNondeductible()
    {
        return $this->plg_nondeductible;
    }

    /**
     * Get the [plg_groupkey] column value.
     *
     * @return string|null
     */
    public function getGroupKey()
    {
        return $this->plg_groupkey;
    }

    /**
     * Set the value of [plg_plgid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_plgid !== $v) {
            $this->plg_plgid = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_PLGID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_famid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFamId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_famid !== $v) {
            $this->plg_famid = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_FAMID] = true;
        }

        if ($this->aFamily !== null && $this->aFamily->getId() !== $v) {
            $this->aFamily = null;
        }

        return $this;
    }

    /**
     * Set the value of [plg_fyid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFyId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_fyid !== $v) {
            $this->plg_fyid = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_FYID] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [plg_date] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->plg_date !== null || $dt !== null) {
            if ($this->plg_date === null || $dt === null || $dt->format('Y-m-d') !== $this->plg_date->format('Y-m-d')) {
                $this->plg_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PledgeTableMap::COL_PLG_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [plg_amount] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setAmount($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_amount !== $v) {
            $this->plg_amount = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_AMOUNT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_schedule] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setSchedule($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_schedule !== $v) {
            $this->plg_schedule = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_SCHEDULE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_method] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setMethod($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_method !== $v) {
            $this->plg_method = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_METHOD] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_comment] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setComment($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_comment !== $v) {
            $this->plg_comment = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_COMMENT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [plg_datelastedited] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateLastEdited($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->plg_datelastedited !== null || $dt !== null) {
            if (
                $dt !== $this->plg_datelastedited // normalized values don't match
                || $dt->format('Y-m-d') === '2016-01-01' // or the entered value matches the default
            ) {
                $this->plg_datelastedited = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PledgeTableMap::COL_PLG_DATELASTEDITED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [plg_editedby] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setEditedBy($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_editedby !== $v) {
            $this->plg_editedby = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_EDITEDBY] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    }

    /**
     * Set the value of [plg_pledgeorpayment] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPledgeOrPayment($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_pledgeorpayment !== $v) {
            $this->plg_pledgeorpayment = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_PLEDGEORPAYMENT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_fundid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFundId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_fundid !== $v) {
            $this->plg_fundid = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_FUNDID] = true;
        }

        if ($this->aDonationFund !== null && $this->aDonationFund->getId() !== $v) {
            $this->aDonationFund = null;
        }

        return $this;
    }

    /**
     * Set the value of [plg_depid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setDepId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_depid !== $v) {
            $this->plg_depid = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_DEPID] = true;
        }

        if ($this->aDeposit !== null && $this->aDeposit->getId() !== $v) {
            $this->aDeposit = null;
        }

        return $this;
    }

    /**
     * Set the value of [plg_checkno] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setCheckNo($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_checkno !== $v) {
            $this->plg_checkno = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_CHECKNO] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [plg_problem] column.
     *
     * Non-boolean arguments are converted using the following rules:
     * - 1, '1', 'true', 'on', 'yes' are converted to boolean true
     * - 0, '0', 'false', 'off', 'no' are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param string|int|bool|null $v The new value
     *
     * @return $this
     */
    public function setProblem($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->plg_problem !== $v) {
            $this->plg_problem = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_PROBLEM] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_scanstring] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setScanString($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_scanstring !== $v) {
            $this->plg_scanstring = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_SCANSTRING] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_aut_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setAutId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_aut_id !== $v) {
            $this->plg_aut_id = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_AUT_ID] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [plg_aut_cleared] column.
     *
     * Non-boolean arguments are converted using the following rules:
     * - 1, '1', 'true', 'on', 'yes' are converted to boolean true
     * - 0, '0', 'false', 'off', 'no' are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param string|int|bool|null $v The new value
     *
     * @return $this
     */
    public function setAutCleared($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->plg_aut_cleared !== $v) {
            $this->plg_aut_cleared = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_AUT_CLEARED] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_aut_resultid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setAutResultId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->plg_aut_resultid !== $v) {
            $this->plg_aut_resultid = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_AUT_RESULTID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_nondeductible] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setNondeductible($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_nondeductible !== $v) {
            $this->plg_nondeductible = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_NONDEDUCTIBLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [plg_groupkey] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setGroupKey($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->plg_groupkey !== $v) {
            $this->plg_groupkey = $v;
            $this->modifiedColumns[PledgeTableMap::COL_PLG_GROUPKEY] = true;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        if ($this->plg_datelastedited && $this->plg_datelastedited->format('Y-m-d') !== '2016-01-01') {
            return false;
        }

        if ($this->plg_editedby !== 0) {
            return false;
        }

        if ($this->plg_pledgeorpayment !== 'Pledge') {
            return false;
        }

        if ($this->plg_aut_id !== 0) {
            return false;
        }

        if ($this->plg_aut_cleared !== false) {
            return false;
        }

        if ($this->plg_aut_resultid !== 0) {
            return false;
        }

        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows. This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     *
     * @return int next starting column
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {
            $useNumericIndex = $indexType === TableMap::TYPE_NUM;

            $rowIndex = $useNumericIndex ? $startcol + 0 : PledgeTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_plgid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : PledgeTableMap::translateFieldName('FamId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_famid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : PledgeTableMap::translateFieldName('FyId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_fyid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : PledgeTableMap::translateFieldName('Date', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->plg_date = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : PledgeTableMap::translateFieldName('Amount', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_amount = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : PledgeTableMap::translateFieldName('Schedule', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_schedule = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : PledgeTableMap::translateFieldName('Method', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_method = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : PledgeTableMap::translateFieldName('Comment', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_comment = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : PledgeTableMap::translateFieldName('DateLastEdited', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->plg_datelastedited = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : PledgeTableMap::translateFieldName('EditedBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_editedby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : PledgeTableMap::translateFieldName('PledgeOrPayment', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_pledgeorpayment = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : PledgeTableMap::translateFieldName('FundId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_fundid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 12 : PledgeTableMap::translateFieldName('DepId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_depid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 13 : PledgeTableMap::translateFieldName('CheckNo', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_checkno = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 14 : PledgeTableMap::translateFieldName('Problem', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_problem = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 15 : PledgeTableMap::translateFieldName('ScanString', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_scanstring = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 16 : PledgeTableMap::translateFieldName('AutId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_aut_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 17 : PledgeTableMap::translateFieldName('AutCleared', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_aut_cleared = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 18 : PledgeTableMap::translateFieldName('AutResultId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_aut_resultid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 19 : PledgeTableMap::translateFieldName('Nondeductible', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_nondeductible = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 20 : PledgeTableMap::translateFieldName('GroupKey', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->plg_groupkey = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 21;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Pledge object', 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database. It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @return void
     */
    public function ensureConsistency(): void
    {
        if ($this->aFamily !== null && $this->plg_famid !== $this->aFamily->getId()) {
            $this->aFamily = null;
        }
        if ($this->aPerson !== null && $this->plg_editedby !== $this->aPerson->getId()) {
            $this->aPerson = null;
        }
        if ($this->aDonationFund !== null && $this->plg_fundid !== $this->aDonationFund->getId()) {
            $this->aDonationFund = null;
        }
        if ($this->aDeposit !== null && $this->plg_depid !== $this->aDeposit->getId()) {
            $this->aDeposit = null;
        }
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con (optional) The ConnectionInterface connection to use.
     *
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     *
     * @return void
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException('Cannot reload a deleted object.');
        }

        if ($this->isNew()) {
            throw new PropelException('Cannot reload an unsaved object.');
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PledgeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPledgeQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aDeposit = null;
            $this->aDonationFund = null;
            $this->aFamily = null;
            $this->aPerson = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Pledge::setDeleted()
     * @see Pledge::isDeleted()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException('This object has already been deleted.');
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PledgeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPledgeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method. This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     */
    public function save(?ConnectionInterface $con = null): int
    {
        if ($this->isDeleted()) {
            throw new PropelException('You cannot save an object that has been deleted.');
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PledgeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PledgeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @see static::save()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface $con
     *
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     */
    protected function doSave(ConnectionInterface $con): int
    {
        if ($this->alreadyInSave) {
            return 0;
        }

        $affectedRows = 0; // initialize var to track total num of affected rows
        $this->alreadyInSave = true;

        // We call the save method on the following object(s) if they
        // were passed to this object by their corresponding set
        // method. This object relates to these object(s) by a
        // foreign key reference.

        if ($this->aDeposit !== null) {
            if ($this->aDeposit->isModified() || $this->aDeposit->isNew()) {
                $affectedRows += $this->aDeposit->save($con);
            }
            $this->setDeposit($this->aDeposit);
        }

        if ($this->aDonationFund !== null) {
            if ($this->aDonationFund->isModified() || $this->aDonationFund->isNew()) {
                $affectedRows += $this->aDonationFund->save($con);
            }
            $this->setDonationFund($this->aDonationFund);
        }

        if ($this->aFamily !== null) {
            if ($this->aFamily->isModified() || $this->aFamily->isNew()) {
                $affectedRows += $this->aFamily->save($con);
            }
            $this->setFamily($this->aFamily);
        }

        if ($this->aPerson !== null) {
            if ($this->aPerson->isModified() || $this->aPerson->isNew()) {
                $affectedRows += $this->aPerson->save($con);
            }
            $this->setPerson($this->aPerson);
        }

        if ($this->isNew() || $this->isModified()) {
            // persist changes
            if ($this->isNew()) {
                $this->doInsert($con);
                $affectedRows += 1;
            } else {
                $affectedRows += $this->doUpdate($con);
            }
            $this->resetModified();
        }

        $this->alreadyInSave = false;

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @see static::doSave()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface $con
     *
     * @throws \RuntimeException
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return void
     */
    protected function doInsert(ConnectionInterface $con): void
    {
        $modifiedColumns = [];
        $index = 0;
        $this->modifiedColumns[PledgeTableMap::COL_PLG_PLGID] = true;
        if ($this->plg_plgid !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PledgeTableMap::COL_PLG_PLGID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_PLGID)) {
            $modifiedColumns[':p' . $index++] = 'plg_plgID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_FAMID)) {
            $modifiedColumns[':p' . $index++] = 'plg_FamID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_FYID)) {
            $modifiedColumns[':p' . $index++] = 'plg_FYID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_DATE)) {
            $modifiedColumns[':p' . $index++] = 'plg_date';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AMOUNT)) {
            $modifiedColumns[':p' . $index++] = 'plg_amount';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_SCHEDULE)) {
            $modifiedColumns[':p' . $index++] = 'plg_schedule';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_METHOD)) {
            $modifiedColumns[':p' . $index++] = 'plg_method';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_COMMENT)) {
            $modifiedColumns[':p' . $index++] = 'plg_comment';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_DATELASTEDITED)) {
            $modifiedColumns[':p' . $index++] = 'plg_DateLastEdited';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_EDITEDBY)) {
            $modifiedColumns[':p' . $index++] = 'plg_EditedBy';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_PLEDGEORPAYMENT)) {
            $modifiedColumns[':p' . $index++] = 'plg_PledgeOrPayment';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_FUNDID)) {
            $modifiedColumns[':p' . $index++] = 'plg_fundID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_DEPID)) {
            $modifiedColumns[':p' . $index++] = 'plg_depID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_CHECKNO)) {
            $modifiedColumns[':p' . $index++] = 'plg_CheckNo';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_PROBLEM)) {
            $modifiedColumns[':p' . $index++] = 'plg_Problem';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_SCANSTRING)) {
            $modifiedColumns[':p' . $index++] = 'plg_scanString';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AUT_ID)) {
            $modifiedColumns[':p' . $index++] = 'plg_aut_ID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AUT_CLEARED)) {
            $modifiedColumns[':p' . $index++] = 'plg_aut_Cleared';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AUT_RESULTID)) {
            $modifiedColumns[':p' . $index++] = 'plg_aut_ResultID';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_NONDEDUCTIBLE)) {
            $modifiedColumns[':p' . $index++] = 'plg_NonDeductible';
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_GROUPKEY)) {
            $modifiedColumns[':p' . $index++] = 'plg_GroupKey';
        }

        $sql = sprintf(
            'INSERT INTO pledge_plg (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns)),
        );

        try {
            $stmt = $con->prepare($sql);
            if (!$stmt) {
                throw new RuntimeException("Failed to build PreparedStatement for SQL '$sql'");
            }
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'plg_plgID':
                        $stmt->bindValue($identifier, $this->plg_plgid, PDO::PARAM_INT);

                        break;
                    case 'plg_FamID':
                        $stmt->bindValue($identifier, $this->plg_famid, PDO::PARAM_INT);

                        break;
                    case 'plg_FYID':
                        $stmt->bindValue($identifier, $this->plg_fyid, PDO::PARAM_INT);

                        break;
                    case 'plg_date':
                        $stmt->bindValue($identifier, $this->plg_date ? $this->plg_date->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'plg_amount':
                        $stmt->bindValue($identifier, $this->plg_amount, PDO::PARAM_STR);

                        break;
                    case 'plg_schedule':
                        $stmt->bindValue($identifier, $this->plg_schedule, PDO::PARAM_STR);

                        break;
                    case 'plg_method':
                        $stmt->bindValue($identifier, $this->plg_method, PDO::PARAM_STR);

                        break;
                    case 'plg_comment':
                        $stmt->bindValue($identifier, $this->plg_comment, PDO::PARAM_STR);

                        break;
                    case 'plg_DateLastEdited':
                        $stmt->bindValue($identifier, $this->plg_datelastedited ? $this->plg_datelastedited->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'plg_EditedBy':
                        $stmt->bindValue($identifier, $this->plg_editedby, PDO::PARAM_INT);

                        break;
                    case 'plg_PledgeOrPayment':
                        $stmt->bindValue($identifier, $this->plg_pledgeorpayment, PDO::PARAM_STR);

                        break;
                    case 'plg_fundID':
                        $stmt->bindValue($identifier, $this->plg_fundid, PDO::PARAM_INT);

                        break;
                    case 'plg_depID':
                        $stmt->bindValue($identifier, $this->plg_depid, PDO::PARAM_INT);

                        break;
                    case 'plg_CheckNo':
                        $stmt->bindValue($identifier, $this->plg_checkno, PDO::PARAM_INT);

                        break;
                    case 'plg_Problem':
                        $stmt->bindValue($identifier, (int)$this->plg_problem, PDO::PARAM_INT);

                        break;
                    case 'plg_scanString':
                        $stmt->bindValue($identifier, $this->plg_scanstring, PDO::PARAM_STR);

                        break;
                    case 'plg_aut_ID':
                        $stmt->bindValue($identifier, $this->plg_aut_id, PDO::PARAM_INT);

                        break;
                    case 'plg_aut_Cleared':
                        $stmt->bindValue($identifier, (int)$this->plg_aut_cleared, PDO::PARAM_INT);

                        break;
                    case 'plg_aut_ResultID':
                        $stmt->bindValue($identifier, $this->plg_aut_resultid, PDO::PARAM_INT);

                        break;
                    case 'plg_NonDeductible':
                        $stmt->bindValue($identifier, $this->plg_nondeductible, PDO::PARAM_STR);

                        break;
                    case 'plg_GroupKey':
                        $stmt->bindValue($identifier, $this->plg_groupkey, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId((int)$pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @see static::doSave()
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface $con
     *
     * @return int Number of updated rows
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     *
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        /** @var int $pos */
        $pos = PledgeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->getByPosition($pos);
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     *
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        return match ($pos) {
            0 => $this->getId(),
            1 => $this->getFamId(),
            2 => $this->getFyId(),
            3 => $this->getDate(),
            4 => $this->getAmount(),
            5 => $this->getSchedule(),
            6 => $this->getMethod(),
            7 => $this->getComment(),
            8 => $this->getDateLastEdited(),
            9 => $this->getEditedBy(),
            10 => $this->getPledgeOrPayment(),
            11 => $this->getFundId(),
            12 => $this->getDepId(),
            13 => $this->getCheckNo(),
            14 => $this->getProblem(),
            15 => $this->getScanString(),
            16 => $this->getAutId(),
            17 => $this->getAutCleared(),
            18 => $this->getAutResultId(),
            19 => $this->getNondeductible(),
            20 => $this->getGroupKey(),
            default => null
        };
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array<string, array<string|bool>> $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array<mixed> An associative array containing the field names (as keys) and field values
     */
    public function toArray(
        string $keyType = TableMap::TYPE_PHPNAME,
        bool $includeLazyLoadColumns = true,
        array $alreadyDumpedObjects = [],
        bool $includeForeignObjects = false
    ): array {
        if (isset($alreadyDumpedObjects['Pledge'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Pledge'][$this->hashCode()] = true;
        $keys = PledgeTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFamId(),
            $keys[2] => $this->getFyId(),
            $keys[3] => $this->getDate(),
            $keys[4] => $this->getAmount(),
            $keys[5] => $this->getSchedule(),
            $keys[6] => $this->getMethod(),
            $keys[7] => $this->getComment(),
            $keys[8] => $this->getDateLastEdited(),
            $keys[9] => $this->getEditedBy(),
            $keys[10] => $this->getPledgeOrPayment(),
            $keys[11] => $this->getFundId(),
            $keys[12] => $this->getDepId(),
            $keys[13] => $this->getCheckNo(),
            $keys[14] => $this->getProblem(),
            $keys[15] => $this->getScanString(),
            $keys[16] => $this->getAutId(),
            $keys[17] => $this->getAutCleared(),
            $keys[18] => $this->getAutResultId(),
            $keys[19] => $this->getNondeductible(),
            $keys[20] => $this->getGroupKey(),
        ];
        if ($result[$keys[3]] instanceof DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('Y-m-d');
        }

        if ($result[$keys[8]] instanceof DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('Y-m-d');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aDeposit !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'deposit',
                     TableMap::TYPE_FIELDNAME => 'deposit_dep',
                     default => 'Deposit',
                };
                $result[$key] = $this->aDeposit->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aDonationFund !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'donationFund',
                     TableMap::TYPE_FIELDNAME => 'donationfund_fun',
                     default => 'DonationFund',
                };
                $result[$key] = $this->aDonationFund->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aFamily !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'family',
                     TableMap::TYPE_FIELDNAME => 'family_fam',
                     default => 'Family',
                };
                $result[$key] = $this->aFamily->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aPerson !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'person',
                     TableMap::TYPE_FIELDNAME => 'person_per',
                     default => 'Person',
                };
                $result[$key] = $this->aPerson->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     *
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        /** @var int $pos */
        $pos = PledgeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     *
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);

                break;
            case 1:
                $this->setFamId($value);

                break;
            case 2:
                $this->setFyId($value);

                break;
            case 3:
                $this->setDate($value);

                break;
            case 4:
                $this->setAmount($value);

                break;
            case 5:
                $this->setSchedule($value);

                break;
            case 6:
                $this->setMethod($value);

                break;
            case 7:
                $this->setComment($value);

                break;
            case 8:
                $this->setDateLastEdited($value);

                break;
            case 9:
                $this->setEditedBy($value);

                break;
            case 10:
                $this->setPledgeOrPayment($value);

                break;
            case 11:
                $this->setFundId($value);

                break;
            case 12:
                $this->setDepId($value);

                break;
            case 13:
                $this->setCheckNo($value);

                break;
            case 14:
                $this->setProblem($value);

                break;
            case 15:
                $this->setScanString($value);

                break;
            case 16:
                $this->setAutId($value);

                break;
            case 17:
                $this->setAutCleared($value);

                break;
            case 18:
                $this->setAutResultId($value);

                break;
            case 19:
                $this->setNondeductible($value);

                break;
            case 20:
                $this->setGroupKey($value);

                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST). This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param array<mixed> $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PledgeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFamId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFyId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setAmount($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSchedule($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setMethod($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setComment($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDateLastEdited($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setEditedBy($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setPledgeOrPayment($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setFundId($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setDepId($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setCheckNo($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setProblem($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setScanString($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setAutId($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setAutCleared($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setAutResultId($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setNondeductible($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setGroupKey($arr[$keys[20]]);
        }

        return $this;
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $tableMap = PledgeTableMap::getTableMap();
        $criteria = new Criteria(PledgeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PledgeTableMap::COL_PLG_PLGID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_plgID'), $this->plg_plgid);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_FAMID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_FamID'), $this->plg_famid);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_FYID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_FYID'), $this->plg_fyid);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_DATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_date'), $this->plg_date);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AMOUNT)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_amount'), $this->plg_amount);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_SCHEDULE)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_schedule'), $this->plg_schedule);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_METHOD)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_method'), $this->plg_method);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_COMMENT)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_comment'), $this->plg_comment);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_DATELASTEDITED)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_DateLastEdited'), $this->plg_datelastedited);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_EDITEDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_EditedBy'), $this->plg_editedby);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_PLEDGEORPAYMENT)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_PledgeOrPayment'), $this->plg_pledgeorpayment);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_FUNDID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_fundID'), $this->plg_fundid);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_DEPID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_depID'), $this->plg_depid);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_CHECKNO)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_CheckNo'), $this->plg_checkno);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_PROBLEM)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_Problem'), $this->plg_problem);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_SCANSTRING)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_scanString'), $this->plg_scanstring);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AUT_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_aut_ID'), $this->plg_aut_id);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AUT_CLEARED)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_aut_Cleared'), $this->plg_aut_cleared);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_AUT_RESULTID)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_aut_ResultID'), $this->plg_aut_resultid);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_NONDEDUCTIBLE)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_NonDeductible'), $this->plg_nondeductible);
        }
        if ($this->isColumnModified(PledgeTableMap::COL_PLG_GROUPKEY)) {
            $criteria->setUpdateValue($tableMap->getColumn('plg_GroupKey'), $this->plg_groupkey);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $tableMap = PledgeTableMap::getTableMap();
        $query = ChildPledgeQuery::create();
        $plg_plgIDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('plg_plgID'));
        $query->addAnd($plg_plgIDColumn, $this->plg_plgid);

        return $query;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @throws \RuntimeException
     *
     * @return string|int Hashcode
     */
    public function hashCode()
    {
        $pkIsValid = $this->getId() !== null;

        if ($pkIsValid) {
            $json = json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE);
            if ($json === false) {
                throw new RuntimeException('Failed to encode PK as JSON.');
            }

            return crc32($json);
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     *
     * @return int|null
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (plg_plgid column).
     *
     * @param int|null $key Primary key.
     *
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return $this->getId() === null;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Pledge (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setFamId($this->getFamId());
        $copyObj->setFyId($this->getFyId());
        $copyObj->setDate($this->getDate());
        $copyObj->setAmount($this->getAmount());
        $copyObj->setSchedule($this->getSchedule());
        $copyObj->setMethod($this->getMethod());
        $copyObj->setComment($this->getComment());
        $copyObj->setDateLastEdited($this->getDateLastEdited());
        $copyObj->setEditedBy($this->getEditedBy());
        $copyObj->setPledgeOrPayment($this->getPledgeOrPayment());
        $copyObj->setFundId($this->getFundId());
        $copyObj->setDepId($this->getDepId());
        $copyObj->setCheckNo($this->getCheckNo());
        $copyObj->setProblem($this->getProblem());
        $copyObj->setScanString($this->getScanString());
        $copyObj->setAutId($this->getAutId());
        $copyObj->setAutCleared($this->getAutCleared());
        $copyObj->setAutResultId($this->getAutResultId());
        $copyObj->setNondeductible($this->getNondeductible());
        $copyObj->setGroupKey($this->getGroupKey());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(null); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     *
     * @return static Clone of current object.
     */
    public function copy(bool $deepCopy = false)
    {
        $clazz = static::class;
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a Deposit object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Deposit|null $deposit
     *
     * @return $this
     */
    public function setDeposit(?Deposit $deposit = null)
    {
        $depId = $deposit ? $deposit->getId() : null;
        $this->setDepId($depId);

        $this->aDeposit = $deposit;
        $deposit?->addPledge($this);

        return $this;
    }

    /**
     * Get the associated Deposit object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Deposit|null
     */
    public function getDeposit(?ConnectionInterface $con = null)
    {
        if ($this->aDeposit === null && ($this->plg_depid !== null && $this->plg_depid !== 0)) {
            $this->aDeposit = ChildDepositQuery::create()->findPk($this->plg_depid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDeposit->addPledges($this);
             */
        }

        return $this->aDeposit;
    }

    /**
     * Declares an association between this object and a DonationFund object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\DonationFund|null $donationFund
     *
     * @return $this
     */
    public function setDonationFund(?DonationFund $donationFund = null)
    {
        $fundId = $donationFund ? $donationFund->getId() : null;
        $this->setFundId($fundId);

        $this->aDonationFund = $donationFund;
        $donationFund?->addPledge($this);

        return $this;
    }

    /**
     * Get the associated DonationFund object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\DonationFund|null
     */
    public function getDonationFund(?ConnectionInterface $con = null)
    {
        if ($this->aDonationFund === null && ($this->plg_fundid !== null && $this->plg_fundid !== 0)) {
            $this->aDonationFund = ChildDonationFundQuery::create()->findPk($this->plg_fundid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDonationFund->addPledges($this);
             */
        }

        return $this->aDonationFund;
    }

    /**
     * Declares an association between this object and a Family object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Family|null $family
     *
     * @return $this
     */
    public function setFamily(?Family $family = null)
    {
        $famId = $family ? $family->getId() : null;
        $this->setFamId($famId);

        $this->aFamily = $family;
        $family?->addPledge($this);

        return $this;
    }

    /**
     * Get the associated Family object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Family|null
     */
    public function getFamily(?ConnectionInterface $con = null)
    {
        if ($this->aFamily === null && ($this->plg_famid !== null && $this->plg_famid !== 0)) {
            $this->aFamily = ChildFamilyQuery::create()->findPk($this->plg_famid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFamily->addPledges($this);
             */
        }

        return $this->aFamily;
    }

    /**
     * Declares an association between this object and a Person object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|null $person
     *
     * @return $this
     */
    public function setPerson(?Person $person = null)
    {
        $editedBy = $person ? $person->getId() : 0;
        $this->setEditedBy($editedBy);

        $this->aPerson = $person;
        $person?->addPledge($this);

        return $this;
    }

    /**
     * Get the associated Person object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Person|null
     */
    public function getPerson(?ConnectionInterface $con = null)
    {
        if ($this->aPerson === null && ($this->plg_editedby !== null && $this->plg_editedby !== 0)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->plg_editedby, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerson->addPledges($this);
             */
        }

        return $this->aPerson;
    }

    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     *
     * @return void
     */
    public function initRelation($relationName): void
    {
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        if ($this->aDeposit !== null) {
            $this->aDeposit->removePledge($this);
        }
        if ($this->aDonationFund !== null) {
            $this->aDonationFund->removePledge($this);
        }
        if ($this->aFamily !== null) {
            $this->aFamily->removePledge($this);
        }
        if ($this->aPerson !== null) {
            $this->aPerson->removePledge($this);
        }
        $this->plg_plgid = null;
        $this->plg_famid = null;
        $this->plg_fyid = null;
        $this->plg_date = null;
        $this->plg_amount = null;
        $this->plg_schedule = null;
        $this->plg_method = null;
        $this->plg_comment = null;
        $this->plg_datelastedited = null;
        $this->plg_editedby = null;
        $this->plg_pledgeorpayment = null;
        $this->plg_fundid = null;
        $this->plg_depid = null;
        $this->plg_checkno = null;
        $this->plg_problem = null;
        $this->plg_scanstring = null;
        $this->plg_aut_id = null;
        $this->plg_aut_cleared = null;
        $this->plg_aut_resultid = null;
        $this->plg_nondeductible = null;
        $this->plg_groupkey = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     *
     * @return static
     */
    public function clearAllReferences(bool $deep = false): static
    {
        $this->aDeposit = null;
        $this->aDonationFund = null;
        $this->aFamily = null;
        $this->aPerson = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(PledgeTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Code to be run before inserting to database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Code to be run before updating the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Code to be run before deleting the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null): bool
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
    }

    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
     *
     * @throws \Propel\Runtime\Exception\BadMethodCallException
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (strpos($name, 'get') === 0) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (strpos($name, 'from') === 0) {
            $format = substr($name, 4);
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (strpos($name, 'to') === 0) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }
}
