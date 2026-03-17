<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\LocationQuery as ChildLocationQuery;
use ChurchCRM\model\ChurchCRM\Map\LocationTableMap;
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
 * Base class that represents a row from the 'locations' table.
 *
 * This is a table for storing all physical locations (Church Offices, Events, etc)
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Location implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\LocationTableMap';

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
     * The value for the location_id field.
     */
    protected int|null $location_id = null;

    /**
     * The value for the location_typeid field.
     */
    protected int|null $location_typeid = null;

    /**
     * The value for the location_name field.
     *
     * Location Name (e.g 'Main Campus')
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_name = null;

    /**
     * The value for the location_address field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_address = null;

    /**
     * The value for the location_city field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_city = null;

    /**
     * The value for the location_state field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_state = null;

    /**
     * The value for the location_zip field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_zip = null;

    /**
     * The value for the location_country field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_country = null;

    /**
     * The value for the location_phone field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_phone = null;

    /**
     * The value for the location_email field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_email = null;

    /**
     * The value for the location_timzezone field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $location_timzezone = null;

    /**
     * Objects associated via Event relation (1:n).
     */
    protected EventCollection|null $collEvents = null;

    /**
     * If $collEvents contains all objects in Event relation.
     */
    protected bool $collEventsPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of Events relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event>|null
     */
    protected ObjectCollection|null $eventsScheduledForDeletion = null;

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
        $this->location_name = '';
        $this->location_address = '';
        $this->location_city = '';
        $this->location_state = '';
        $this->location_zip = '';
        $this->location_country = '';
        $this->location_phone = '';
        $this->location_email = '';
        $this->location_timzezone = '';
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Location object.
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
     * Compares this with another <code>Location</code> instance. If
     * <code>obj</code> is an instance of <code>Location</code>, delegates to
     * <code>equals(Location)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [location_id] column value.
     *
     * @return int|null
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * Get the [location_typeid] column value.
     *
     * @return int|null
     */
    public function getLocationType()
    {
        return $this->location_typeid;
    }

    /**
     * Get the [location_name] column value.
     *
     * Location Name (e.g 'Main Campus')
     *
     * @return string|null
     */
    public function getLocationName()
    {
        return $this->location_name;
    }

    /**
     * Get the [location_address] column value.
     *
     * @return string|null
     */
    public function getLocationAddress()
    {
        return $this->location_address;
    }

    /**
     * Get the [location_city] column value.
     *
     * @return string|null
     */
    public function getLocationCity()
    {
        return $this->location_city;
    }

    /**
     * Get the [location_state] column value.
     *
     * @return string|null
     */
    public function getLocationState()
    {
        return $this->location_state;
    }

    /**
     * Get the [location_zip] column value.
     *
     * @return string|null
     */
    public function getLocationZip()
    {
        return $this->location_zip;
    }

    /**
     * Get the [location_country] column value.
     *
     * @return string|null
     */
    public function getLocationCountry()
    {
        return $this->location_country;
    }

    /**
     * Get the [location_phone] column value.
     *
     * @return string|null
     */
    public function getLocationPhone()
    {
        return $this->location_phone;
    }

    /**
     * Get the [location_email] column value.
     *
     * @return string|null
     */
    public function getLocationEmail()
    {
        return $this->location_email;
    }

    /**
     * Get the [location_timzezone] column value.
     *
     * @return string|null
     */
    public function getLocationTimzezone()
    {
        return $this->location_timzezone;
    }

    /**
     * Set the value of [location_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setLocationId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->location_id !== $v) {
            $this->location_id = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_typeid] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setLocationType($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->location_typeid !== $v) {
            $this->location_typeid = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_TYPEID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_name] column.
     *
     * Location Name (e.g 'Main Campus')
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_name !== $v) {
            $this->location_name = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_address] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationAddress($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_address !== $v) {
            $this->location_address = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_ADDRESS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_city] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationCity($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_city !== $v) {
            $this->location_city = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_CITY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_state] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationState($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_state !== $v) {
            $this->location_state = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_STATE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_zip] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationZip($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_zip !== $v) {
            $this->location_zip = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_ZIP] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_country] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationCountry($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_country !== $v) {
            $this->location_country = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_COUNTRY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_phone] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationPhone($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_phone !== $v) {
            $this->location_phone = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_PHONE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_email] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationEmail($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_email !== $v) {
            $this->location_email = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_EMAIL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [location_timzezone] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLocationTimzezone($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->location_timzezone !== $v) {
            $this->location_timzezone = $v;
            $this->modifiedColumns[LocationTableMap::COL_LOCATION_TIMZEZONE] = true;
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
        if ($this->location_name !== '') {
            return false;
        }

        if ($this->location_address !== '') {
            return false;
        }

        if ($this->location_city !== '') {
            return false;
        }

        if ($this->location_state !== '') {
            return false;
        }

        if ($this->location_zip !== '') {
            return false;
        }

        if ($this->location_country !== '') {
            return false;
        }

        if ($this->location_phone !== '') {
            return false;
        }

        if ($this->location_email !== '') {
            return false;
        }

        if ($this->location_timzezone !== '') {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : LocationTableMap::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : LocationTableMap::translateFieldName('LocationType', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_typeid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : LocationTableMap::translateFieldName('LocationName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : LocationTableMap::translateFieldName('LocationAddress', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_address = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : LocationTableMap::translateFieldName('LocationCity', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_city = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : LocationTableMap::translateFieldName('LocationState', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_state = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : LocationTableMap::translateFieldName('LocationZip', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_zip = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : LocationTableMap::translateFieldName('LocationCountry', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_country = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : LocationTableMap::translateFieldName('LocationPhone', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_phone = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : LocationTableMap::translateFieldName('LocationEmail', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_email = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : LocationTableMap::translateFieldName('LocationTimzezone', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_timzezone = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Location object', 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(LocationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildLocationQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->collEvents = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Location::setDeleted()
     * @see Location::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildLocationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
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
                LocationTableMap::addInstanceToPool($this);
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

        if ($this->eventsScheduledForDeletion !== null) {
            if (!$this->eventsScheduledForDeletion->isEmpty()) {
                ChildEventQuery::create()
                    ->filterByPrimaryKeys($this->eventsScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->eventsScheduledForDeletion = null;
            }
        }

        if ($this->collEvents !== null) {
            foreach ($this->collEvents as $referrerFK) {
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

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_ID)) {
            $modifiedColumns[':p' . $index++] = 'location_id';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_TYPEID)) {
            $modifiedColumns[':p' . $index++] = 'location_typeID';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_NAME)) {
            $modifiedColumns[':p' . $index++] = 'location_name';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_ADDRESS)) {
            $modifiedColumns[':p' . $index++] = 'location_address';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_CITY)) {
            $modifiedColumns[':p' . $index++] = 'location_city';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_STATE)) {
            $modifiedColumns[':p' . $index++] = 'location_state';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_ZIP)) {
            $modifiedColumns[':p' . $index++] = 'location_zip';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_COUNTRY)) {
            $modifiedColumns[':p' . $index++] = 'location_country';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_PHONE)) {
            $modifiedColumns[':p' . $index++] = 'location_phone';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_EMAIL)) {
            $modifiedColumns[':p' . $index++] = 'location_email';
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_TIMZEZONE)) {
            $modifiedColumns[':p' . $index++] = 'location_timzezone';
        }

        $sql = sprintf(
            'INSERT INTO locations (%s) VALUES (%s)',
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
                    case 'location_id':
                        $stmt->bindValue($identifier, $this->location_id, PDO::PARAM_INT);

                        break;
                    case 'location_typeID':
                        $stmt->bindValue($identifier, $this->location_typeid, PDO::PARAM_INT);

                        break;
                    case 'location_name':
                        $stmt->bindValue($identifier, $this->location_name, PDO::PARAM_STR);

                        break;
                    case 'location_address':
                        $stmt->bindValue($identifier, $this->location_address, PDO::PARAM_STR);

                        break;
                    case 'location_city':
                        $stmt->bindValue($identifier, $this->location_city, PDO::PARAM_STR);

                        break;
                    case 'location_state':
                        $stmt->bindValue($identifier, $this->location_state, PDO::PARAM_STR);

                        break;
                    case 'location_zip':
                        $stmt->bindValue($identifier, $this->location_zip, PDO::PARAM_STR);

                        break;
                    case 'location_country':
                        $stmt->bindValue($identifier, $this->location_country, PDO::PARAM_STR);

                        break;
                    case 'location_phone':
                        $stmt->bindValue($identifier, $this->location_phone, PDO::PARAM_STR);

                        break;
                    case 'location_email':
                        $stmt->bindValue($identifier, $this->location_email, PDO::PARAM_STR);

                        break;
                    case 'location_timzezone':
                        $stmt->bindValue($identifier, $this->location_timzezone, PDO::PARAM_STR);

                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);

            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = LocationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            0 => $this->getLocationId(),
            1 => $this->getLocationType(),
            2 => $this->getLocationName(),
            3 => $this->getLocationAddress(),
            4 => $this->getLocationCity(),
            5 => $this->getLocationState(),
            6 => $this->getLocationZip(),
            7 => $this->getLocationCountry(),
            8 => $this->getLocationPhone(),
            9 => $this->getLocationEmail(),
            10 => $this->getLocationTimzezone(),
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
        if (isset($alreadyDumpedObjects['Location'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Location'][$this->hashCode()] = true;
        $keys = LocationTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getLocationId(),
            $keys[1] => $this->getLocationType(),
            $keys[2] => $this->getLocationName(),
            $keys[3] => $this->getLocationAddress(),
            $keys[4] => $this->getLocationCity(),
            $keys[5] => $this->getLocationState(),
            $keys[6] => $this->getLocationZip(),
            $keys[7] => $this->getLocationCountry(),
            $keys[8] => $this->getLocationPhone(),
            $keys[9] => $this->getLocationEmail(),
            $keys[10] => $this->getLocationTimzezone(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->collEvents !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'events',
                     TableMap::TYPE_FIELDNAME => 'events_events',
                     default => 'Events',
                };
                $result[$key] = $this->collEvents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = LocationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setLocationId($value);

                break;
            case 1:
                $this->setLocationType($value);

                break;
            case 2:
                $this->setLocationName($value);

                break;
            case 3:
                $this->setLocationAddress($value);

                break;
            case 4:
                $this->setLocationCity($value);

                break;
            case 5:
                $this->setLocationState($value);

                break;
            case 6:
                $this->setLocationZip($value);

                break;
            case 7:
                $this->setLocationCountry($value);

                break;
            case 8:
                $this->setLocationPhone($value);

                break;
            case 9:
                $this->setLocationEmail($value);

                break;
            case 10:
                $this->setLocationTimzezone($value);

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
        $keys = LocationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setLocationId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocationType($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLocationName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLocationAddress($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLocationCity($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLocationState($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLocationZip($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLocationCountry($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLocationPhone($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setLocationEmail($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setLocationTimzezone($arr[$keys[10]]);
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
        $tableMap = LocationTableMap::getTableMap();
        $criteria = new Criteria(LocationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_id'), $this->location_id);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_TYPEID)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_typeID'), $this->location_typeid);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_name'), $this->location_name);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_ADDRESS)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_address'), $this->location_address);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_CITY)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_city'), $this->location_city);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_STATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_state'), $this->location_state);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_ZIP)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_zip'), $this->location_zip);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_COUNTRY)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_country'), $this->location_country);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_PHONE)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_phone'), $this->location_phone);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_EMAIL)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_email'), $this->location_email);
        }
        if ($this->isColumnModified(LocationTableMap::COL_LOCATION_TIMZEZONE)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_timzezone'), $this->location_timzezone);
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
        $tableMap = LocationTableMap::getTableMap();
        $query = ChildLocationQuery::create();
        $location_idColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('location_id'));
        $query->addAnd($location_idColumn, $this->location_id);

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
        $pkIsValid = $this->getLocationId() !== null;

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
        return $this->getLocationId();
    }

    /**
     * Generic method to set the primary key (location_id column).
     *
     * @param int|null $key Primary key.
     *
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setLocationId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return $this->getLocationId() === null;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Location (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setLocationId($this->getLocationId());
        $copyObj->setLocationType($this->getLocationType());
        $copyObj->setLocationName($this->getLocationName());
        $copyObj->setLocationAddress($this->getLocationAddress());
        $copyObj->setLocationCity($this->getLocationCity());
        $copyObj->setLocationState($this->getLocationState());
        $copyObj->setLocationZip($this->getLocationZip());
        $copyObj->setLocationCountry($this->getLocationCountry());
        $copyObj->setLocationPhone($this->getLocationPhone());
        $copyObj->setLocationEmail($this->getLocationEmail());
        $copyObj->setLocationTimzezone($this->getLocationTimzezone());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEvents() as $relObj) {
                $copyObj->addEvent($relObj->copy($deepCopy));
            }
        }

        if ($makeNew) {
            $copyObj->setNew(true);
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
            'Event' => $this->initEvents(),
            default => null
        };
    }

    /**
     * Initializes the collEvents collection.
     *
     * By default this just sets the collEvents collection to an empty array (like clearcollEvents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEvents(bool $overrideExisting = true): void
    {
        if ($this->collEvents !== null && !$overrideExisting) {
            return;
        }

        $this->collEvents = new EventCollection();
        $this->collEvents->setModel('\ChurchCRM\model\ChurchCRM\Event');
    }

    /**
     * Reset is the collEvents collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialEvents(bool $isPartial = true): void
    {
        $this->collEventsPartial = $isPartial;
    }

    /**
     * Clears out the collEvents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearEvents(): static
    {
        $this->collEvents = null;

        return $this;
    }

    /**
     * Gets locations objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Location is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEvents(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        $partial = $this->collEventsPartial && !$this->isNew();
        if ($this->collEvents && !$criteria && !$partial) {
            return $this->collEvents;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collEvents === null) {
                $this->initEvents();

                return $this->collEvents;
            }

            $collEvents = new EventCollection();
            $collEvents->setModel('\ChurchCRM\model\ChurchCRM\Base\Event');

            return $collEvents;
        }

        $collEvents = ChildEventQuery::create(null, $criteria)
            ->filterByLocation($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collEventsPartial !== false && count($collEvents)) {
                $this->initEvents(false);

                foreach ($collEvents as $obj) {
                    if (!$this->collEvents->contains($obj)) {
                        $this->collEvents->append($obj);
                    }
                }

                $this->collEventsPartial = true;
            }

            return $collEvents;
        }

        if ($this->collEventsPartial && $this->collEvents) {
            foreach ($this->collEvents as $obj) {
                if ($obj->isNew()) {
                    $collEvents[] = $obj;
                }
            }
        }

        $this->collEvents = $collEvents;
        $this->collEventsPartial = false;

        return $this->collEvents;
    }

    /**
     * Sets a collection of locations objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Event> $events
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setEvents(Collection $events, ?ConnectionInterface $con = null): static
    {
        $eventsToDelete = $this->getEvents(null, $con)->diff($events);

        $this->eventsScheduledForDeletion = $eventsToDelete;

        foreach ($eventsToDelete as $eventRemoved) {
            $eventRemoved->setLocation(null);
        }

        $this->collEvents = null;
        foreach ($events as $event) {
            $this->addEvent($event);
        }

        $this->collEventsPartial = false;
        $this->collEvents = $events instanceof EventCollection
            ? $events : new EventCollection($events->getData());

        return $this;
    }

    /**
     * Returns the number of related locations objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related locations objects.
     */
    public function countEvents(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collEventsPartial && !$this->isNew();
        if ($this->collEvents === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collEvents === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEvents());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByLocation($this)
                ->count($con);
        }

        return count($this->collEvents);
    }

    /**
     * Method called to associate a Event object to this object
     * through the Event foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return $this
     */
    public function addEvent(Event $event)
    {
        if ($this->collEvents === null) {
            $this->initEvents();
            $this->collEventsPartial = true;
        }

        if (!$this->collEvents->contains($event)) {
            $this->doAddEvent($event);

            if ($this->eventsScheduledForDeletion && $this->eventsScheduledForDeletion->contains($event)) {
                $this->eventsScheduledForDeletion->remove($this->eventsScheduledForDeletion->search($event));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event The Event object to add.
     *
     * @return void
     */
    protected function doAddEvent(Event $event): void
    {
        $this->collEvents->append($event);
        $event->setLocation($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event The Event object to remove.
     *
     * @return static
     */
    public function removeEvent(Event $event): static
    {
        if ($this->getEvents()->contains($event)) {
            $pos = $this->collEvents->search($event);
            $this->collEvents->remove($pos);
            if ($this->eventsScheduledForDeletion === null) {
                $this->eventsScheduledForDeletion = clone $this->collEvents;
                $this->eventsScheduledForDeletion->clear();
            }
            $this->eventsScheduledForDeletion->append(clone $event);
            $event->setLocation(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this locations is new, it will return
     * an empty collection; or if this locations has previously
     * been saved, it will retrieve related Events from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventsJoinEventType(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('EventType', $joinBehavior);

        return $this->getEvents($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this locations is new, it will return
     * an empty collection; or if this locations has previously
     * been saved, it will retrieve related Events from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventsJoinPersonRelatedByType(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('PersonRelatedByType', $joinBehavior);

        return $this->getEvents($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this locations is new, it will return
     * an empty collection; or if this locations has previously
     * been saved, it will retrieve related Events from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEventsJoinPersonRelatedBySecondaryContactPersonId(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('PersonRelatedBySecondaryContactPersonId', $joinBehavior);

        return $this->getEvents($query, $con);
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
        $this->location_id = null;
        $this->location_typeid = null;
        $this->location_name = null;
        $this->location_address = null;
        $this->location_city = null;
        $this->location_state = null;
        $this->location_zip = null;
        $this->location_country = null;
        $this->location_phone = null;
        $this->location_email = null;
        $this->location_timzezone = null;
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
            if ($this->collEvents) {
                foreach ($this->collEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collEvents = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(LocationTableMap::DEFAULT_STRING_FORMAT);
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
