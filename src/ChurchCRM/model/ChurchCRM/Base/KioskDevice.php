<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection;
use ChurchCRM\model\ChurchCRM\KioskAssignmentQuery as ChildKioskAssignmentQuery;
use ChurchCRM\model\ChurchCRM\KioskDeviceQuery as ChildKioskDeviceQuery;
use ChurchCRM\model\ChurchCRM\Map\KioskDeviceTableMap;
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
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * Base class that represents a row from the 'kioskdevice_kdev' table.
 *
 * This contains a list of all (un)registered kiosk devices
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class KioskDevice implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\KioskDeviceTableMap';

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
     * The value for the kdev_id field.
     */
    protected int|null $kdev_id = null;

    /**
     * The value for the kdev_guidhash field.
     *
     * SHA256 Hash of the GUID stored in the kiosk's cookie
     */
    protected string|null $kdev_guidhash = null;

    /**
     * The value for the kdev_name field.
     *
     * Name of the kiosk
     */
    protected string|null $kdev_name = null;

    /**
     * The value for the kdev_devicetype field.
     *
     * Kiosk device type
     */
    protected string|null $kdev_devicetype = null;

    /**
     * The value for the kdev_lastheartbeat field.
     *
     * Last time the kiosk sent a heartbeat
     */
    protected string|null $kdev_lastheartbeat = null;

    /**
     * The value for the kdev_accepted field.
     *
     * Has the admin accepted the kiosk after initial registration?
     */
    protected bool|null $kdev_accepted = null;

    /**
     * The value for the kdev_pendingcommands field.
     *
     * Commands waiting to be sent to the kiosk
     */
    protected string|null $kdev_pendingcommands = null;

    /**
     * Objects associated via KioskAssignment relation (1:n).
     */
    protected KioskAssignmentCollection|null $collKioskAssignments = null;

    /**
     * If $collKioskAssignments contains all objects in KioskAssignment relation.
     */
    protected bool $collKioskAssignmentsPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of KioskAssignments relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\KioskAssignment>|null
     */
    protected ObjectCollection|null $kioskAssignmentsScheduledForDeletion = null;

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\KioskDevice object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>KioskDevice</code> instance. If
     * <code>obj</code> is an instance of <code>KioskDevice</code>, delegates to
     * <code>equals(KioskDevice)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [kdev_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->kdev_id;
    }

    /**
     * Get the [kdev_guidhash] column value.
     *
     * SHA256 Hash of the GUID stored in the kiosk's cookie
     *
     * @return string|null
     */
    public function getGUIDHash()
    {
        return $this->kdev_guidhash;
    }

    /**
     * Get the [kdev_name] column value.
     *
     * Name of the kiosk
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->kdev_name;
    }

    /**
     * Get the [kdev_devicetype] column value.
     *
     * Kiosk device type
     *
     * @return string|null
     */
    public function getDeviceType()
    {
        return $this->kdev_devicetype;
    }

    /**
     * Get the [kdev_lastheartbeat] column value.
     *
     * Last time the kiosk sent a heartbeat
     *
     * @return string|null
     */
    public function getLastHeartbeat()
    {
        return $this->kdev_lastheartbeat;
    }

    /**
     * Get the [kdev_accepted] column value.
     *
     * Has the admin accepted the kiosk after initial registration?
     *
     * @return bool|null
     */
    public function getAccepted()
    {
        return $this->kdev_accepted;
    }

    /**
     * Get the [kdev_accepted] column value.
     *
     * Has the admin accepted the kiosk after initial registration?
     *
     * @return bool|null
     */
    public function isAccepted()
    {
        return $this->getAccepted();
    }

    /**
     * Get the [kdev_pendingcommands] column value.
     *
     * Commands waiting to be sent to the kiosk
     *
     * @return string|null
     */
    public function getPendingCommands()
    {
        return $this->kdev_pendingcommands;
    }

    /**
     * Set the value of [kdev_id] column.
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

        if ($this->kdev_id !== $v) {
            $this->kdev_id = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [kdev_guidhash] column.
     *
     * SHA256 Hash of the GUID stored in the kiosk's cookie
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setGUIDHash($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->kdev_guidhash !== $v) {
            $this->kdev_guidhash = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_GUIDHASH] = true;
        }

        return $this;
    }

    /**
     * Set the value of [kdev_name] column.
     *
     * Name of the kiosk
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

        if ($this->kdev_name !== $v) {
            $this->kdev_name = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [kdev_devicetype] column.
     *
     * Kiosk device type
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDeviceType($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->kdev_devicetype !== $v) {
            $this->kdev_devicetype = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_DEVICETYPE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [kdev_lastheartbeat] column.
     *
     * Last time the kiosk sent a heartbeat
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLastHeartbeat($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->kdev_lastheartbeat !== $v) {
            $this->kdev_lastheartbeat = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [kdev_accepted] column.
     *
     * Non-boolean arguments are converted using the following rules:
     * - 1, '1', 'true', 'on', 'yes' are converted to boolean true
     * - 0, '0', 'false', 'off', 'no' are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * Has the admin accepted the kiosk after initial registration?
     *
     * @param string|int|bool|null $v The new value
     *
     * @return $this
     */
    public function setAccepted($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->kdev_accepted !== $v) {
            $this->kdev_accepted = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_ACCEPTED] = true;
        }

        return $this;
    }

    /**
     * Set the value of [kdev_pendingcommands] column.
     *
     * Commands waiting to be sent to the kiosk
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPendingCommands($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->kdev_pendingcommands !== $v) {
            $this->kdev_pendingcommands = $v;
            $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS] = true;
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : KioskDeviceTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : KioskDeviceTableMap::translateFieldName('GUIDHash', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_guidhash = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : KioskDeviceTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : KioskDeviceTableMap::translateFieldName('DeviceType', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_devicetype = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : KioskDeviceTableMap::translateFieldName('LastHeartbeat', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_lastheartbeat = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : KioskDeviceTableMap::translateFieldName('Accepted', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_accepted = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : KioskDeviceTableMap::translateFieldName('PendingCommands', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->kdev_pendingcommands = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\KioskDevice object', 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildKioskDeviceQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->collKioskAssignments = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see KioskDevice::setDeleted()
     * @see KioskDevice::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(KioskDeviceTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildKioskDeviceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(KioskDeviceTableMap::DATABASE_NAME);
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
                KioskDeviceTableMap::addInstanceToPool($this);
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

        if ($this->kioskAssignmentsScheduledForDeletion !== null) {
            if (!$this->kioskAssignmentsScheduledForDeletion->isEmpty()) {
                foreach ($this->kioskAssignmentsScheduledForDeletion as $kioskAssignment) {
                    // need to save related object because we set the relation to null
                    $kioskAssignment->save($con);
                }
                $this->kioskAssignmentsScheduledForDeletion = null;
            }
        }

        if ($this->collKioskAssignments !== null) {
            foreach ($this->collKioskAssignments as $referrerFK) {
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
        $this->modifiedColumns[KioskDeviceTableMap::COL_KDEV_ID] = true;
        if ($this->kdev_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . KioskDeviceTableMap::COL_KDEV_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_ID)) {
            $modifiedColumns[':p' . $index++] = 'kdev_ID';
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_GUIDHASH)) {
            $modifiedColumns[':p' . $index++] = 'kdev_GUIDHash';
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_NAME)) {
            $modifiedColumns[':p' . $index++] = 'kdev_Name';
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_DEVICETYPE)) {
            $modifiedColumns[':p' . $index++] = 'kdev_deviceType';
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT)) {
            $modifiedColumns[':p' . $index++] = 'kdev_lastHeartbeat';
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_ACCEPTED)) {
            $modifiedColumns[':p' . $index++] = 'kdev_Accepted';
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS)) {
            $modifiedColumns[':p' . $index++] = 'kdev_PendingCommands';
        }

        $sql = sprintf(
            'INSERT INTO kioskdevice_kdev (%s) VALUES (%s)',
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
                    case 'kdev_ID':
                        $stmt->bindValue($identifier, $this->kdev_id, PDO::PARAM_INT);

                        break;
                    case 'kdev_GUIDHash':
                        $stmt->bindValue($identifier, $this->kdev_guidhash, PDO::PARAM_STR);

                        break;
                    case 'kdev_Name':
                        $stmt->bindValue($identifier, $this->kdev_name, PDO::PARAM_STR);

                        break;
                    case 'kdev_deviceType':
                        $stmt->bindValue($identifier, $this->kdev_devicetype, PDO::PARAM_STR);

                        break;
                    case 'kdev_lastHeartbeat':
                        $stmt->bindValue($identifier, $this->kdev_lastheartbeat, PDO::PARAM_STR);

                        break;
                    case 'kdev_Accepted':
                        $stmt->bindValue($identifier, (int)$this->kdev_accepted, PDO::PARAM_INT);

                        break;
                    case 'kdev_PendingCommands':
                        $stmt->bindValue($identifier, $this->kdev_pendingcommands, PDO::PARAM_STR);

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
        $pos = KioskDeviceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getGUIDHash(),
            2 => $this->getName(),
            3 => $this->getDeviceType(),
            4 => $this->getLastHeartbeat(),
            5 => $this->getAccepted(),
            6 => $this->getPendingCommands(),
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
        if (isset($alreadyDumpedObjects['KioskDevice'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['KioskDevice'][$this->hashCode()] = true;
        $keys = KioskDeviceTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getGUIDHash(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDeviceType(),
            $keys[4] => $this->getLastHeartbeat(),
            $keys[5] => $this->getAccepted(),
            $keys[6] => $this->getPendingCommands(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->collKioskAssignments !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'kioskAssignments',
                     TableMap::TYPE_FIELDNAME => 'kioskassginment_kasms',
                     default => 'KioskAssignments',
                };
                $result[$key] = $this->collKioskAssignments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = KioskDeviceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setGUIDHash($value);

                break;
            case 2:
                $this->setName($value);

                break;
            case 3:
                $this->setDeviceType($value);

                break;
            case 4:
                $this->setLastHeartbeat($value);

                break;
            case 5:
                $this->setAccepted($value);

                break;
            case 6:
                $this->setPendingCommands($value);

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
        $keys = KioskDeviceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setGUIDHash($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDeviceType($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLastHeartbeat($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAccepted($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPendingCommands($arr[$keys[6]]);
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
        $tableMap = KioskDeviceTableMap::getTableMap();
        $criteria = new Criteria(KioskDeviceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_ID'), $this->kdev_id);
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_GUIDHASH)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_GUIDHash'), $this->kdev_guidhash);
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_Name'), $this->kdev_name);
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_DEVICETYPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_deviceType'), $this->kdev_devicetype);
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_LASTHEARTBEAT)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_lastHeartbeat'), $this->kdev_lastheartbeat);
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_ACCEPTED)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_Accepted'), $this->kdev_accepted);
        }
        if ($this->isColumnModified(KioskDeviceTableMap::COL_KDEV_PENDINGCOMMANDS)) {
            $criteria->setUpdateValue($tableMap->getColumn('kdev_PendingCommands'), $this->kdev_pendingcommands);
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
        $tableMap = KioskDeviceTableMap::getTableMap();
        $query = ChildKioskDeviceQuery::create();
        $kdev_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('kdev_ID'));
        $query->addAnd($kdev_IDColumn, $this->kdev_id);

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
     * Generic method to set the primary key (kdev_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\KioskDevice (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setGUIDHash($this->getGUIDHash());
        $copyObj->setName($this->getName());
        $copyObj->setDeviceType($this->getDeviceType());
        $copyObj->setLastHeartbeat($this->getLastHeartbeat());
        $copyObj->setAccepted($this->getAccepted());
        $copyObj->setPendingCommands($this->getPendingCommands());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getKioskAssignments() as $relObj) {
                $copyObj->addKioskAssignment($relObj->copy($deepCopy));
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
            'KioskAssignment' => $this->initKioskAssignments(),
            default => null
        };
    }

    /**
     * Initializes the collKioskAssignments collection.
     *
     * By default this just sets the collKioskAssignments collection to an empty array (like clearcollKioskAssignments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initKioskAssignments(bool $overrideExisting = true): void
    {
        if ($this->collKioskAssignments !== null && !$overrideExisting) {
            return;
        }

        $this->collKioskAssignments = new KioskAssignmentCollection();
        $this->collKioskAssignments->setModel('\ChurchCRM\model\ChurchCRM\KioskAssignment');
    }

    /**
     * Reset is the collKioskAssignments collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialKioskAssignments(bool $isPartial = true): void
    {
        $this->collKioskAssignmentsPartial = $isPartial;
    }

    /**
     * Clears out the collKioskAssignments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearKioskAssignments(): static
    {
        $this->collKioskAssignments = null;

        return $this;
    }

    /**
     * Gets kioskdevice_kdev objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this KioskDevice is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection
     */
    public function getKioskAssignments(?Criteria $criteria = null, ?ConnectionInterface $con = null): KioskAssignmentCollection
    {
        $partial = $this->collKioskAssignmentsPartial && !$this->isNew();
        if ($this->collKioskAssignments && !$criteria && !$partial) {
            return $this->collKioskAssignments;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collKioskAssignments === null) {
                $this->initKioskAssignments();

                return $this->collKioskAssignments;
            }

            $collKioskAssignments = new KioskAssignmentCollection();
            $collKioskAssignments->setModel('\ChurchCRM\model\ChurchCRM\Base\KioskAssignment');

            return $collKioskAssignments;
        }

        $collKioskAssignments = ChildKioskAssignmentQuery::create(null, $criteria)
            ->filterByKioskDevice($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collKioskAssignmentsPartial !== false && count($collKioskAssignments)) {
                $this->initKioskAssignments(false);

                foreach ($collKioskAssignments as $obj) {
                    if (!$this->collKioskAssignments->contains($obj)) {
                        $this->collKioskAssignments->append($obj);
                    }
                }

                $this->collKioskAssignmentsPartial = true;
            }

            return $collKioskAssignments;
        }

        if ($this->collKioskAssignmentsPartial && $this->collKioskAssignments) {
            foreach ($this->collKioskAssignments as $obj) {
                if ($obj->isNew()) {
                    $collKioskAssignments[] = $obj;
                }
            }
        }

        $this->collKioskAssignments = $collKioskAssignments;
        $this->collKioskAssignmentsPartial = false;

        return $this->collKioskAssignments;
    }

    /**
     * Sets a collection of kioskdevice_kdev objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\KioskAssignment> $kioskAssignments
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setKioskAssignments(Collection $kioskAssignments, ?ConnectionInterface $con = null): static
    {
        $kioskAssignmentsToDelete = $this->getKioskAssignments(null, $con)->diff($kioskAssignments);

        $this->kioskAssignmentsScheduledForDeletion = $kioskAssignmentsToDelete;

        foreach ($kioskAssignmentsToDelete as $kioskAssignmentRemoved) {
            $kioskAssignmentRemoved->setKioskDevice(null);
        }

        $this->collKioskAssignments = null;
        foreach ($kioskAssignments as $kioskAssignment) {
            $this->addKioskAssignment($kioskAssignment);
        }

        $this->collKioskAssignmentsPartial = false;
        $this->collKioskAssignments = $kioskAssignments instanceof KioskAssignmentCollection
            ? $kioskAssignments : new KioskAssignmentCollection($kioskAssignments->getData());

        return $this;
    }

    /**
     * Returns the number of related kioskdevice_kdev objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related kioskdevice_kdev objects.
     */
    public function countKioskAssignments(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collKioskAssignmentsPartial && !$this->isNew();
        if ($this->collKioskAssignments === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collKioskAssignments === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getKioskAssignments());
            }

            $query = ChildKioskAssignmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByKioskDevice($this)
                ->count($con);
        }

        return count($this->collKioskAssignments);
    }

    /**
     * Method called to associate a KioskAssignment object to this object
     * through the KioskAssignment foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\KioskAssignment $kioskAssignment
     *
     * @return $this
     */
    public function addKioskAssignment(KioskAssignment $kioskAssignment)
    {
        if ($this->collKioskAssignments === null) {
            $this->initKioskAssignments();
            $this->collKioskAssignmentsPartial = true;
        }

        if (!$this->collKioskAssignments->contains($kioskAssignment)) {
            $this->doAddKioskAssignment($kioskAssignment);

            if ($this->kioskAssignmentsScheduledForDeletion && $this->kioskAssignmentsScheduledForDeletion->contains($kioskAssignment)) {
                $this->kioskAssignmentsScheduledForDeletion->remove($this->kioskAssignmentsScheduledForDeletion->search($kioskAssignment));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\KioskAssignment $kioskAssignment The KioskAssignment object to add.
     *
     * @return void
     */
    protected function doAddKioskAssignment(KioskAssignment $kioskAssignment): void
    {
        $this->collKioskAssignments->append($kioskAssignment);
        $kioskAssignment->setKioskDevice($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\KioskAssignment $kioskAssignment The KioskAssignment object to remove.
     *
     * @return static
     */
    public function removeKioskAssignment(KioskAssignment $kioskAssignment): static
    {
        if ($this->getKioskAssignments()->contains($kioskAssignment)) {
            $pos = $this->collKioskAssignments->search($kioskAssignment);
            $this->collKioskAssignments->remove($pos);
            if ($this->kioskAssignmentsScheduledForDeletion === null) {
                $this->kioskAssignmentsScheduledForDeletion = clone $this->collKioskAssignments;
                $this->kioskAssignmentsScheduledForDeletion->clear();
            }
            $this->kioskAssignmentsScheduledForDeletion->append($kioskAssignment);
            $kioskAssignment->setKioskDevice(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this kioskdevice_kdev is new, it will return
     * an empty collection; or if this kioskdevice_kdev has previously
     * been saved, it will retrieve related KioskAssignments from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection
     */
    public function getKioskAssignmentsJoinEvent(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): KioskAssignmentCollection {
        $query = ChildKioskAssignmentQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getKioskAssignments($query, $con);
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
        $this->kdev_id = null;
        $this->kdev_guidhash = null;
        $this->kdev_name = null;
        $this->kdev_devicetype = null;
        $this->kdev_lastheartbeat = null;
        $this->kdev_accepted = null;
        $this->kdev_pendingcommands = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collKioskAssignments) {
                foreach ($this->collKioskAssignments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collKioskAssignments = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(KioskDeviceTableMap::DEFAULT_STRING_FORMAT);
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
