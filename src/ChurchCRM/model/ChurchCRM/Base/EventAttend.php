<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\EventAttendQuery as ChildEventAttendQuery;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\Map\EventAttendTableMap;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
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
 * Base class that represents a row from the 'event_attend' table.
 *
 * this indicates which people attended which events
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class EventAttend implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\EventAttendTableMap';

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
     * The value for the attend_id field.
     */
    protected int|null $attend_id = null;

    /**
     * The value for the event_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $event_id = null;

    /**
     * The value for the person_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $person_id = null;

    /**
     * The value for the checkin_date field.
     */
    protected DateTimeInterface|null $checkin_date = null;

    /**
     * The value for the checkin_id field.
     */
    protected int|null $checkin_id = null;

    /**
     * The value for the checkout_date field.
     */
    protected DateTimeInterface|null $checkout_date = null;

    /**
     * The value for the checkout_id field.
     */
    protected int|null $checkout_id = null;

    /**
     * Event associated via Event relation (n:1).
     */
    protected Event|null $aEvent = null;

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
        $this->event_id = 0;
        $this->person_id = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\EventAttend object.
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
     * Compares this with another <code>EventAttend</code> instance. If
     * <code>obj</code> is an instance of <code>EventAttend</code>, delegates to
     * <code>equals(EventAttend)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [attend_id] column value.
     *
     * @return int|null
     */
    public function getAttendId()
    {
        return $this->attend_id;
    }

    /**
     * Get the [event_id] column value.
     *
     * @return int|null
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Get the [person_id] column value.
     *
     * @return int|null
     */
    public function getPersonId()
    {
        return $this->person_id;
    }

    /**
     * Get the [optionally formatted] temporal [checkin_date] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getCheckinDate($format = null)
    {
        if ($format === null) {
            return $this->checkin_date;
        } else {
            return $this->checkin_date instanceof DateTimeInterface ? $this->checkin_date->format($format) : null;
        }
    }

    /**
     * Get the [checkin_id] column value.
     *
     * @return int|null
     */
    public function getCheckinId()
    {
        return $this->checkin_id;
    }

    /**
     * Get the [optionally formatted] temporal [checkout_date] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getCheckoutDate($format = null)
    {
        if ($format === null) {
            return $this->checkout_date;
        } else {
            return $this->checkout_date instanceof DateTimeInterface ? $this->checkout_date->format($format) : null;
        }
    }

    /**
     * Get the [checkout_id] column value.
     *
     * @return int|null
     */
    public function getCheckoutId()
    {
        return $this->checkout_id;
    }

    /**
     * Set the value of [attend_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setAttendId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->attend_id !== $v) {
            $this->attend_id = $v;
            $this->modifiedColumns[EventAttendTableMap::COL_ATTEND_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [event_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setEventId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[EventAttendTableMap::COL_EVENT_ID] = true;
        }

        if ($this->aEvent !== null && $this->aEvent->getId() !== $v) {
            $this->aEvent = null;
        }

        return $this;
    }

    /**
     * Set the value of [person_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setPersonId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->person_id !== $v) {
            $this->person_id = $v;
            $this->modifiedColumns[EventAttendTableMap::COL_PERSON_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    }

    /**
     * Sets the value of [checkin_date] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCheckinDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->checkin_date !== null || $dt !== null) {
            if ($this->checkin_date === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->checkin_date->format('Y-m-d H:i:s.u')) {
                $this->checkin_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventAttendTableMap::COL_CHECKIN_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [checkin_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setCheckinId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->checkin_id !== $v) {
            $this->checkin_id = $v;
            $this->modifiedColumns[EventAttendTableMap::COL_CHECKIN_ID] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [checkout_date] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCheckoutDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->checkout_date !== null || $dt !== null) {
            if ($this->checkout_date === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->checkout_date->format('Y-m-d H:i:s.u')) {
                $this->checkout_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventAttendTableMap::COL_CHECKOUT_DATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [checkout_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setCheckoutId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->checkout_id !== $v) {
            $this->checkout_id = $v;
            $this->modifiedColumns[EventAttendTableMap::COL_CHECKOUT_ID] = true;
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
        if ($this->event_id !== 0) {
            return false;
        }

        if ($this->person_id !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : EventAttendTableMap::translateFieldName('AttendId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->attend_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : EventAttendTableMap::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : EventAttendTableMap::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->person_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : EventAttendTableMap::translateFieldName('CheckinDate', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->checkin_date = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : EventAttendTableMap::translateFieldName('CheckinId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->checkin_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : EventAttendTableMap::translateFieldName('CheckoutDate', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->checkout_date = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : EventAttendTableMap::translateFieldName('CheckoutId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->checkout_id = $columnValue !== null ? (int)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\EventAttend object', 0, $e);
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
        if ($this->aEvent !== null && $this->event_id !== $this->aEvent->getId()) {
            $this->aEvent = null;
        }
        if ($this->aPerson !== null && $this->person_id !== $this->aPerson->getId()) {
            $this->aPerson = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(EventAttendTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventAttendQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aEvent = null;
            $this->aPerson = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see EventAttend::setDeleted()
     * @see EventAttend::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventAttendTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventAttendQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventAttendTableMap::DATABASE_NAME);
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
                EventAttendTableMap::addInstanceToPool($this);
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

        if ($this->aEvent !== null) {
            if ($this->aEvent->isModified() || $this->aEvent->isNew()) {
                $affectedRows += $this->aEvent->save($con);
            }
            $this->setEvent($this->aEvent);
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
        $this->modifiedColumns[EventAttendTableMap::COL_ATTEND_ID] = true;
        if ($this->attend_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventAttendTableMap::COL_ATTEND_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventAttendTableMap::COL_ATTEND_ID)) {
            $modifiedColumns[':p' . $index++] = 'attend_id';
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++] = 'event_id';
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_PERSON_ID)) {
            $modifiedColumns[':p' . $index++] = 'person_id';
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKIN_DATE)) {
            $modifiedColumns[':p' . $index++] = 'checkin_date';
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKIN_ID)) {
            $modifiedColumns[':p' . $index++] = 'checkin_id';
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKOUT_DATE)) {
            $modifiedColumns[':p' . $index++] = 'checkout_date';
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKOUT_ID)) {
            $modifiedColumns[':p' . $index++] = 'checkout_id';
        }

        $sql = sprintf(
            'INSERT INTO event_attend (%s) VALUES (%s)',
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
                    case 'attend_id':
                        $stmt->bindValue($identifier, $this->attend_id, PDO::PARAM_INT);

                        break;
                    case 'event_id':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);

                        break;
                    case 'person_id':
                        $stmt->bindValue($identifier, $this->person_id, PDO::PARAM_INT);

                        break;
                    case 'checkin_date':
                        $stmt->bindValue($identifier, $this->checkin_date ? $this->checkin_date->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'checkin_id':
                        $stmt->bindValue($identifier, $this->checkin_id, PDO::PARAM_INT);

                        break;
                    case 'checkout_date':
                        $stmt->bindValue($identifier, $this->checkout_date ? $this->checkout_date->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'checkout_id':
                        $stmt->bindValue($identifier, $this->checkout_id, PDO::PARAM_INT);

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
        $this->setAttendId((int)$pk);

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
        $pos = EventAttendTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            0 => $this->getAttendId(),
            1 => $this->getEventId(),
            2 => $this->getPersonId(),
            3 => $this->getCheckinDate(),
            4 => $this->getCheckinId(),
            5 => $this->getCheckoutDate(),
            6 => $this->getCheckoutId(),
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
        if (isset($alreadyDumpedObjects['EventAttend'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['EventAttend'][$this->hashCode()] = true;
        $keys = EventAttendTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getAttendId(),
            $keys[1] => $this->getEventId(),
            $keys[2] => $this->getPersonId(),
            $keys[3] => $this->getCheckinDate(),
            $keys[4] => $this->getCheckinId(),
            $keys[5] => $this->getCheckoutDate(),
            $keys[6] => $this->getCheckoutId(),
        ];
        if ($result[$keys[3]] instanceof DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[5]] instanceof DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aEvent !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'event',
                     TableMap::TYPE_FIELDNAME => 'events_event',
                     default => 'Event',
                };
                $result[$key] = $this->aEvent->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
        $pos = EventAttendTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setAttendId($value);

                break;
            case 1:
                $this->setEventId($value);

                break;
            case 2:
                $this->setPersonId($value);

                break;
            case 3:
                $this->setCheckinDate($value);

                break;
            case 4:
                $this->setCheckinId($value);

                break;
            case 5:
                $this->setCheckoutDate($value);

                break;
            case 6:
                $this->setCheckoutId($value);

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
        $keys = EventAttendTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setAttendId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEventId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPersonId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCheckinDate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCheckinId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCheckoutDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCheckoutId($arr[$keys[6]]);
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
        $tableMap = EventAttendTableMap::getTableMap();
        $criteria = new Criteria(EventAttendTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventAttendTableMap::COL_ATTEND_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('attend_id'), $this->attend_id);
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_EVENT_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_id'), $this->event_id);
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_PERSON_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('person_id'), $this->person_id);
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKIN_DATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('checkin_date'), $this->checkin_date);
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKIN_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('checkin_id'), $this->checkin_id);
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKOUT_DATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('checkout_date'), $this->checkout_date);
        }
        if ($this->isColumnModified(EventAttendTableMap::COL_CHECKOUT_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('checkout_id'), $this->checkout_id);
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
        $tableMap = EventAttendTableMap::getTableMap();
        $query = ChildEventAttendQuery::create();
        $attend_idColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('attend_id'));
        $query->addAnd($attend_idColumn, $this->attend_id);

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
        $pkIsValid = $this->getAttendId() !== null;

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
        return $this->getAttendId();
    }

    /**
     * Generic method to set the primary key (attend_id column).
     *
     * @param int|null $key Primary key.
     *
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setAttendId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return $this->getAttendId() === null;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\EventAttend (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setEventId($this->getEventId());
        $copyObj->setPersonId($this->getPersonId());
        $copyObj->setCheckinDate($this->getCheckinDate());
        $copyObj->setCheckinId($this->getCheckinId());
        $copyObj->setCheckoutDate($this->getCheckoutDate());
        $copyObj->setCheckoutId($this->getCheckoutId());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setAttendId(null); // this is a auto-increment column, so set to default value
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
     * Declares an association between this object and a Event object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event|null $event
     *
     * @return $this
     */
    public function setEvent(?Event $event = null)
    {
        $eventId = $event ? $event->getId() : 0;
        $this->setEventId($eventId);

        $this->aEvent = $event;
        $event?->addEventAttend($this);

        return $this;
    }

    /**
     * Get the associated Event object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Event|null
     */
    public function getEvent(?ConnectionInterface $con = null)
    {
        if ($this->aEvent === null && ($this->event_id !== null && $this->event_id !== 0)) {
            $this->aEvent = ChildEventQuery::create()->findPk($this->event_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEvent->addEventAttends($this);
             */
        }

        return $this->aEvent;
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
        $personId = $person ? $person->getId() : 0;
        $this->setPersonId($personId);

        $this->aPerson = $person;
        $person?->addEventAttend($this);

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
        if ($this->aPerson === null && ($this->person_id !== null && $this->person_id !== 0)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->person_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerson->addEventAttends($this);
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
        if ($this->aEvent !== null) {
            $this->aEvent->removeEventAttend($this);
        }
        if ($this->aPerson !== null) {
            $this->aPerson->removeEventAttend($this);
        }
        $this->attend_id = null;
        $this->event_id = null;
        $this->person_id = null;
        $this->checkin_date = null;
        $this->checkin_id = null;
        $this->checkout_date = null;
        $this->checkout_id = null;
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
        $this->aEvent = null;
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
        return (string)$this->exportTo(EventAttendTableMap::DEFAULT_STRING_FORMAT);
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
