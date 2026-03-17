<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\EventTypeQuery as ChildEventTypeQuery;
use ChurchCRM\model\ChurchCRM\GroupQuery as ChildGroupQuery;
use ChurchCRM\model\ChurchCRM\Map\EventTypeTableMap;
use DateTimeInterface;
use Exception;
use PDO;
use Propel\Runtime\ActiveQuery\ColumnResolver\ColumnExpression\LocalColumnExpression;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
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
 * Base class that represents a row from the 'event_types' table.
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class EventType implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\EventTypeTableMap';

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
     * The value for the type_id field.
     */
    protected int|null $type_id = null;

    /**
     * The value for the type_name field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $type_name = null;

    /**
     * The value for the type_defstarttime field.
     *
     * Note: this column has a database default value of: '00:00:00.000000'
     */
    protected DateTimeInterface|null $type_defstarttime = null;

    /**
     * The value for the type_defrecurtype field.
     *
     * Note: this column has a database default value of: 'none'
     */
    protected string|null $type_defrecurtype = null;

    /**
     * The value for the type_defrecurdow field.
     *
     * Note: this column has a database default value of: 'Sunday'
     */
    protected string|null $type_defrecurdow = null;

    /**
     * The value for the type_defrecurdom field.
     *
     * Note: this column has a database default value of: '0'
     */
    protected string|null $type_defrecurdom = null;

    /**
     * The value for the type_defrecurdoy field.
     *
     * Note: this column has a database default value of: '2016-01-01'
     */
    protected DateTimeInterface|null $type_defrecurdoy = null;

    /**
     * The value for the type_active field.
     *
     * Note: this column has a database default value of: 1
     */
    protected int|null $type_active = null;

    /**
     * The value for the type_grpid field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $type_grpid = null;

    /**
     * Group associated via Group relation (n:1).
     */
    protected Group|null $aGroup = null;

    /**
     * Objects associated via EventType relation (1:n).
     */
    protected EventCollection|null $collEventTypes = null;

    /**
     * If $collEventTypes contains all objects in EventType relation.
     */
    protected bool $collEventTypesPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of EventTypes relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event>|null
     */
    protected ObjectCollection|null $eventTypesScheduledForDeletion = null;

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
        $this->type_name = '';
        $this->type_defstarttime = PropelDateTime::newInstance('00:00:00.000000', null, '\DateTime');
        $this->type_defrecurtype = 'none';
        $this->type_defrecurdow = 'Sunday';
        $this->type_defrecurdom = '0';
        $this->type_defrecurdoy = PropelDateTime::newInstance('2016-01-01', null, '\DateTime');
        $this->type_active = 1;
        $this->type_grpid = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\EventType object.
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
     * Compares this with another <code>EventType</code> instance. If
     * <code>obj</code> is an instance of <code>EventType</code>, delegates to
     * <code>equals(EventType)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [type_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->type_id;
    }

    /**
     * Get the [type_name] column value.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->type_name;
    }

    /**
     * Get the [optionally formatted] temporal [type_defstarttime] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL).
     */
    public function getDefStartTime($format = null)
    {
        if ($format === null) {
            return $this->type_defstarttime;
        } else {
            return $this->type_defstarttime instanceof DateTimeInterface ? $this->type_defstarttime->format($format) : null;
        }
    }

    /**
     * Get the [type_defrecurtype] column value.
     *
     * @return string|null
     */
    public function getDefRecurType()
    {
        return $this->type_defrecurtype;
    }

    /**
     * Get the [type_defrecurdow] column value.
     *
     * @return string|null
     */
    public function getDefRecurDOW()
    {
        return $this->type_defrecurdow;
    }

    /**
     * Get the [type_defrecurdom] column value.
     *
     * @return string|null
     */
    public function getDefRecurDOM()
    {
        return $this->type_defrecurdom;
    }

    /**
     * Get the [optionally formatted] temporal [type_defrecurdoy] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00.
     */
    public function getDefRecurDOY($format = null)
    {
        if ($format === null) {
            return $this->type_defrecurdoy;
        } else {
            return $this->type_defrecurdoy instanceof DateTimeInterface ? $this->type_defrecurdoy->format($format) : null;
        }
    }

    /**
     * Get the [type_active] column value.
     *
     * @return int|null
     */
    public function getActive()
    {
        return $this->type_active;
    }

    /**
     * Get the [type_grpid] column value.
     *
     * @return int|null
     */
    public function getGroupId()
    {
        return $this->type_grpid;
    }

    /**
     * Set the value of [type_id] column.
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

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [type_name] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->type_name !== $v) {
            $this->type_name = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_NAME] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [type_defstarttime] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDefStartTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->type_defstarttime !== null || $dt !== null) {
            if (
                $dt !== $this->type_defstarttime // normalized values don't match
                || $dt->format('H:i:s.u') === '00:00:00.000000' // or the entered value matches the default
            ) {
                $this->type_defstarttime = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTypeTableMap::COL_TYPE_DEFSTARTTIME] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [type_defrecurtype] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDefRecurType($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->type_defrecurtype !== $v) {
            $this->type_defrecurtype = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_DEFRECURTYPE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [type_defrecurdow] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDefRecurDOW($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->type_defrecurdow !== $v) {
            $this->type_defrecurdow = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_DEFRECURDOW] = true;
        }

        return $this;
    }

    /**
     * Set the value of [type_defrecurdom] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDefRecurDOM($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->type_defrecurdom !== $v) {
            $this->type_defrecurdom = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_DEFRECURDOM] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [type_defrecurdoy] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDefRecurDOY($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->type_defrecurdoy !== null || $dt !== null) {
            if (
                $dt !== $this->type_defrecurdoy // normalized values don't match
                || $dt->format('Y-m-d') === '2016-01-01' // or the entered value matches the default
            ) {
                $this->type_defrecurdoy = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTypeTableMap::COL_TYPE_DEFRECURDOY] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [type_active] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setActive($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->type_active !== $v) {
            $this->type_active = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_ACTIVE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [type_grpid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setGroupId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->type_grpid !== $v) {
            $this->type_grpid = $v;
            $this->modifiedColumns[EventTypeTableMap::COL_TYPE_GRPID] = true;
        }

        if ($this->aGroup !== null && $this->aGroup->getId() !== $v) {
            $this->aGroup = null;
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
        if ($this->type_name !== '') {
            return false;
        }

        if ($this->type_defstarttime && $this->type_defstarttime->format('H:i:s.u') !== '00:00:00.000000') {
            return false;
        }

        if ($this->type_defrecurtype !== 'none') {
            return false;
        }

        if ($this->type_defrecurdow !== 'Sunday') {
            return false;
        }

        if ($this->type_defrecurdom !== '0') {
            return false;
        }

        if ($this->type_defrecurdoy && $this->type_defrecurdoy->format('Y-m-d') !== '2016-01-01') {
            return false;
        }

        if ($this->type_active !== 1) {
            return false;
        }

        if ($this->type_grpid !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : EventTypeTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : EventTypeTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : EventTypeTableMap::translateFieldName('DefStartTime', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_defstarttime = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : EventTypeTableMap::translateFieldName('DefRecurType', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_defrecurtype = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : EventTypeTableMap::translateFieldName('DefRecurDOW', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_defrecurdow = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : EventTypeTableMap::translateFieldName('DefRecurDOM', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_defrecurdom = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : EventTypeTableMap::translateFieldName('DefRecurDOY', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->type_defrecurdoy = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : EventTypeTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_active = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : EventTypeTableMap::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->type_grpid = $columnValue !== null ? (int)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\EventType object', 0, $e);
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
        if ($this->aGroup !== null && $this->type_grpid !== $this->aGroup->getId()) {
            $this->aGroup = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(EventTypeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventTypeQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aGroup = null;
            $this->collEventTypes = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see EventType::setDeleted()
     * @see EventType::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTypeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventTypeQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTypeTableMap::DATABASE_NAME);
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
                EventTypeTableMap::addInstanceToPool($this);
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

        if ($this->aGroup !== null) {
            if ($this->aGroup->isModified() || $this->aGroup->isNew()) {
                $affectedRows += $this->aGroup->save($con);
            }
            $this->setGroup($this->aGroup);
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

        if ($this->eventTypesScheduledForDeletion !== null) {
            if (!$this->eventTypesScheduledForDeletion->isEmpty()) {
                ChildEventQuery::create()
                    ->filterByPrimaryKeys($this->eventTypesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->eventTypesScheduledForDeletion = null;
            }
        }

        if ($this->collEventTypes !== null) {
            foreach ($this->collEventTypes as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
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
        $this->modifiedColumns[EventTypeTableMap::COL_TYPE_ID] = true;
        if ($this->type_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventTypeTableMap::COL_TYPE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_ID)) {
            $modifiedColumns[':p' . $index++] = 'type_id';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_NAME)) {
            $modifiedColumns[':p' . $index++] = 'type_name';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFSTARTTIME)) {
            $modifiedColumns[':p' . $index++] = 'type_defstarttime';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURTYPE)) {
            $modifiedColumns[':p' . $index++] = 'type_defrecurtype';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURDOW)) {
            $modifiedColumns[':p' . $index++] = 'type_defrecurDOW';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURDOM)) {
            $modifiedColumns[':p' . $index++] = 'type_defrecurDOM';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURDOY)) {
            $modifiedColumns[':p' . $index++] = 'type_defrecurDOY';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_ACTIVE)) {
            $modifiedColumns[':p' . $index++] = 'type_active';
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_GRPID)) {
            $modifiedColumns[':p' . $index++] = 'type_grpid';
        }

        $sql = sprintf(
            'INSERT INTO event_types (%s) VALUES (%s)',
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
                    case 'type_id':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);

                        break;
                    case 'type_name':
                        $stmt->bindValue($identifier, $this->type_name, PDO::PARAM_STR);

                        break;
                    case 'type_defstarttime':
                        $stmt->bindValue($identifier, $this->type_defstarttime ? $this->type_defstarttime->format('H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'type_defrecurtype':
                        $stmt->bindValue($identifier, $this->type_defrecurtype, PDO::PARAM_STR);

                        break;
                    case 'type_defrecurDOW':
                        $stmt->bindValue($identifier, $this->type_defrecurdow, PDO::PARAM_STR);

                        break;
                    case 'type_defrecurDOM':
                        $stmt->bindValue($identifier, $this->type_defrecurdom, PDO::PARAM_STR);

                        break;
                    case 'type_defrecurDOY':
                        $stmt->bindValue($identifier, $this->type_defrecurdoy ? $this->type_defrecurdoy->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'type_active':
                        $stmt->bindValue($identifier, $this->type_active, PDO::PARAM_INT);

                        break;
                    case 'type_grpid':
                        $stmt->bindValue($identifier, $this->type_grpid, PDO::PARAM_INT);

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
        $pos = EventTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getName(),
            2 => $this->getDefStartTime(),
            3 => $this->getDefRecurType(),
            4 => $this->getDefRecurDOW(),
            5 => $this->getDefRecurDOM(),
            6 => $this->getDefRecurDOY(),
            7 => $this->getActive(),
            8 => $this->getGroupId(),
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
        if (isset($alreadyDumpedObjects['EventType'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['EventType'][$this->hashCode()] = true;
        $keys = EventTypeTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDefStartTime(),
            $keys[3] => $this->getDefRecurType(),
            $keys[4] => $this->getDefRecurDOW(),
            $keys[5] => $this->getDefRecurDOM(),
            $keys[6] => $this->getDefRecurDOY(),
            $keys[7] => $this->getActive(),
            $keys[8] => $this->getGroupId(),
        ];
        if ($result[$keys[2]] instanceof DateTimeInterface) {
            $result[$keys[2]] = $result[$keys[2]]->format('H:i:s.u');
        }

        if ($result[$keys[6]] instanceof DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('Y-m-d');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aGroup !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'group',
                     TableMap::TYPE_FIELDNAME => 'group_grp',
                     default => 'Group',
                };
                $result[$key] = $this->aGroup->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collEventTypes !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'events',
                     TableMap::TYPE_FIELDNAME => 'events_events',
                     default => 'EventTypes',
                };
                $result[$key] = $this->collEventTypes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = EventTypeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setName($value);

                break;
            case 2:
                $this->setDefStartTime($value);

                break;
            case 3:
                $this->setDefRecurType($value);

                break;
            case 4:
                $this->setDefRecurDOW($value);

                break;
            case 5:
                $this->setDefRecurDOM($value);

                break;
            case 6:
                $this->setDefRecurDOY($value);

                break;
            case 7:
                $this->setActive($value);

                break;
            case 8:
                $this->setGroupId($value);

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
        $keys = EventTypeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDefStartTime($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDefRecurType($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDefRecurDOW($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDefRecurDOM($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDefRecurDOY($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setActive($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setGroupId($arr[$keys[8]]);
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
        $tableMap = EventTypeTableMap::getTableMap();
        $criteria = new Criteria(EventTypeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_id'), $this->type_id);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_name'), $this->type_name);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFSTARTTIME)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_defstarttime'), $this->type_defstarttime);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURTYPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_defrecurtype'), $this->type_defrecurtype);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURDOW)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_defrecurDOW'), $this->type_defrecurdow);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURDOM)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_defrecurDOM'), $this->type_defrecurdom);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_DEFRECURDOY)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_defrecurDOY'), $this->type_defrecurdoy);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_ACTIVE)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_active'), $this->type_active);
        }
        if ($this->isColumnModified(EventTypeTableMap::COL_TYPE_GRPID)) {
            $criteria->setUpdateValue($tableMap->getColumn('type_grpid'), $this->type_grpid);
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
        $tableMap = EventTypeTableMap::getTableMap();
        $query = ChildEventTypeQuery::create();
        $type_idColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('type_id'));
        $query->addAnd($type_idColumn, $this->type_id);

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
     * Generic method to set the primary key (type_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\EventType (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());
        $copyObj->setDefStartTime($this->getDefStartTime());
        $copyObj->setDefRecurType($this->getDefRecurType());
        $copyObj->setDefRecurDOW($this->getDefRecurDOW());
        $copyObj->setDefRecurDOM($this->getDefRecurDOM());
        $copyObj->setDefRecurDOY($this->getDefRecurDOY());
        $copyObj->setActive($this->getActive());
        $copyObj->setGroupId($this->getGroupId());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEventTypes() as $relObj) {
                $copyObj->addEventType($relObj->copy($deepCopy));
            }
        }

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
     * Declares an association between this object and a Group object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Group|null $group
     *
     * @return $this
     */
    public function setGroup(?Group $group = null)
    {
        $groupId = $group ? $group->getId() : 0;
        $this->setGroupId($groupId);

        $this->aGroup = $group;
        $group?->addEventType($this);

        return $this;
    }

    /**
     * Get the associated Group object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Group|null
     */
    public function getGroup(?ConnectionInterface $con = null)
    {
        if ($this->aGroup === null && ($this->type_grpid !== null && $this->type_grpid !== 0)) {
            $this->aGroup = ChildGroupQuery::create()->findPk($this->type_grpid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGroup->addEventTypes($this);
             */
        }

        return $this->aGroup;
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
        match ($relationName) {
            'EventType' => $this->initEventTypes(),
            default => null
        };
    }

    /**
     * Initializes the collEventTypes collection.
     *
     * By default this just sets the collEventTypes collection to an empty array (like clearcollEventTypes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventTypes(bool $overrideExisting = true): void
    {
        if ($this->collEventTypes !== null && !$overrideExisting) {
            return;
        }

        $this->collEventTypes = new EventCollection();
        $this->collEventTypes->setModel('\ChurchCRM\model\ChurchCRM\Event');
    }

    /**
     * Reset is the collEventTypes collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialEventTypes(bool $isPartial = true): void
    {
        $this->collEventTypesPartial = $isPartial;
    }

    /**
     * Clears out the collEventTypes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearEventTypes(): static
    {
        $this->collEventTypes = null;

        return $this;
    }

    /**
     * Gets event_types objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this EventType is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventTypes(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        $partial = $this->collEventTypesPartial && !$this->isNew();
        if ($this->collEventTypes && !$criteria && !$partial) {
            return $this->collEventTypes;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collEventTypes === null) {
                $this->initEventTypes();

                return $this->collEventTypes;
            }

            $collEventTypes = new EventCollection();
            $collEventTypes->setModel('\ChurchCRM\model\ChurchCRM\Base\Event');

            return $collEventTypes;
        }

        $collEventTypes = ChildEventQuery::create(null, $criteria)
            ->filterByEventType($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collEventTypesPartial !== false && count($collEventTypes)) {
                $this->initEventTypes(false);

                foreach ($collEventTypes as $obj) {
                    if (!$this->collEventTypes->contains($obj)) {
                        $this->collEventTypes->append($obj);
                    }
                }

                $this->collEventTypesPartial = true;
            }

            return $collEventTypes;
        }

        if ($this->collEventTypesPartial && $this->collEventTypes) {
            foreach ($this->collEventTypes as $obj) {
                if ($obj->isNew()) {
                    $collEventTypes[] = $obj;
                }
            }
        }

        $this->collEventTypes = $collEventTypes;
        $this->collEventTypesPartial = false;

        return $this->collEventTypes;
    }

    /**
     * Sets a collection of event_types objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Event> $eventTypes
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setEventTypes(Collection $eventTypes, ?ConnectionInterface $con = null): static
    {
        $eventTypesToDelete = $this->getEventTypes(null, $con)->diff($eventTypes);

        $this->eventTypesScheduledForDeletion = $eventTypesToDelete;

        foreach ($eventTypesToDelete as $eventTypeRemoved) {
            $eventTypeRemoved->setEventType(null);
        }

        $this->collEventTypes = null;
        foreach ($eventTypes as $eventType) {
            $this->addEventType($eventType);
        }

        $this->collEventTypesPartial = false;
        $this->collEventTypes = $eventTypes instanceof EventCollection
            ? $eventTypes : new EventCollection($eventTypes->getData());

        return $this;
    }

    /**
     * Returns the number of related event_types objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related event_types objects.
     */
    public function countEventTypes(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collEventTypesPartial && !$this->isNew();
        if ($this->collEventTypes === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collEventTypes === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventTypes());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEventType($this)
                ->count($con);
        }

        return count($this->collEventTypes);
    }

    /**
     * Method called to associate a Event object to this object
     * through the Event foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return $this
     */
    public function addEventType(Event $event)
    {
        if ($this->collEventTypes === null) {
            $this->initEventTypes();
            $this->collEventTypesPartial = true;
        }

        if (!$this->collEventTypes->contains($event)) {
            $this->doAddEventType($event);

            if ($this->eventTypesScheduledForDeletion && $this->eventTypesScheduledForDeletion->contains($event)) {
                $this->eventTypesScheduledForDeletion->remove($this->eventTypesScheduledForDeletion->search($event));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $eventType The Event object to add.
     *
     * @return void
     */
    protected function doAddEventType(Event $eventType): void
    {
        $this->collEventTypes->append($eventType);
        $eventType->setEventType($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $eventType The Event object to remove.
     *
     * @return static
     */
    public function removeEventType(Event $eventType): static
    {
        if ($this->getEventTypes()->contains($eventType)) {
            $pos = $this->collEventTypes->search($eventType);
            $this->collEventTypes->remove($pos);
            if ($this->eventTypesScheduledForDeletion === null) {
                $this->eventTypesScheduledForDeletion = clone $this->collEventTypes;
                $this->eventTypesScheduledForDeletion->clear();
            }
            $this->eventTypesScheduledForDeletion->append(clone $eventType);
            $eventType->setEventType(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this event_types is new, it will return
     * an empty collection; or if this event_types has previously
     * been saved, it will retrieve related EventTypes from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventTypesJoinPersonRelatedByType(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('PersonRelatedByType', $joinBehavior);

        return $this->getEventTypes($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this event_types is new, it will return
     * an empty collection; or if this event_types has previously
     * been saved, it will retrieve related EventTypes from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventTypesJoinPersonRelatedBySecondaryContactPersonId(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('PersonRelatedBySecondaryContactPersonId', $joinBehavior);

        return $this->getEventTypes($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this event_types is new, it will return
     * an empty collection; or if this event_types has previously
     * been saved, it will retrieve related EventTypes from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventTypesJoinLocation(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getEventTypes($query, $con);
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
        if ($this->aGroup !== null) {
            $this->aGroup->removeEventType($this);
        }
        $this->type_id = null;
        $this->type_name = null;
        $this->type_defstarttime = null;
        $this->type_defrecurtype = null;
        $this->type_defrecurdow = null;
        $this->type_defrecurdom = null;
        $this->type_defrecurdoy = null;
        $this->type_active = null;
        $this->type_grpid = null;
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
        if ($deep) {
            if ($this->collEventTypes) {
                foreach ($this->collEventTypes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collEventTypes = null;
        $this->aGroup = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(EventTypeTableMap::DEFAULT_STRING_FORMAT);
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
