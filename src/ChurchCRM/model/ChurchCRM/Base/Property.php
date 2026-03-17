<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection;
use ChurchCRM\model\ChurchCRM\Map\PropertyTableMap;
use ChurchCRM\model\ChurchCRM\PropertyQuery as ChildPropertyQuery;
use ChurchCRM\model\ChurchCRM\PropertyTypeQuery as ChildPropertyTypeQuery;
use ChurchCRM\model\ChurchCRM\RecordPropertyQuery as ChildRecordPropertyQuery;
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
 * Base class that represents a row from the 'property_pro' table.
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Property implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\PropertyTableMap';

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
     * The value for the pro_id field.
     */
    protected int|null $pro_id = null;

    /**
     * The value for the pro_class field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $pro_class = null;

    /**
     * The value for the pro_prt_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $pro_prt_id = null;

    /**
     * The value for the pro_name field.
     *
     * Note: this column has a database default value of: '0'
     */
    protected string|null $pro_name = null;

    /**
     * The value for the pro_description field.
     */
    protected string|null $pro_description = null;

    /**
     * The value for the pro_prompt field.
     */
    protected string|null $pro_prompt = null;

    /**
     * PropertyType associated via PropertyType relation (n:1).
     */
    protected PropertyType|null $aPropertyType = null;

    /**
     * Objects associated via RecordProperty relation (1:n).
     */
    protected RecordPropertyCollection|null $collRecordProperties = null;

    /**
     * If $collRecordProperties contains all objects in RecordProperty relation.
     */
    protected bool $collRecordPropertiesPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of RecordProperties relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\RecordProperty>|null
     */
    protected ObjectCollection|null $recordPropertiesScheduledForDeletion = null;

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
        $this->pro_class = '';
        $this->pro_prt_id = 0;
        $this->pro_name = '0';
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Property object.
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
     * Compares this with another <code>Property</code> instance. If
     * <code>obj</code> is an instance of <code>Property</code>, delegates to
     * <code>equals(Property)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [pro_id] column value.
     *
     * @return int|null
     */
    public function getProId()
    {
        return $this->pro_id;
    }

    /**
     * Get the [pro_class] column value.
     *
     * @return string|null
     */
    public function getProClass()
    {
        return $this->pro_class;
    }

    /**
     * Get the [pro_prt_id] column value.
     *
     * @return int|null
     */
    public function getProPrtId()
    {
        return $this->pro_prt_id;
    }

    /**
     * Get the [pro_name] column value.
     *
     * @return string|null
     */
    public function getProName()
    {
        return $this->pro_name;
    }

    /**
     * Get the [pro_description] column value.
     *
     * @return string|null
     */
    public function getProDescription()
    {
        return $this->pro_description;
    }

    /**
     * Get the [pro_prompt] column value.
     *
     * @return string|null
     */
    public function getProPrompt()
    {
        return $this->pro_prompt;
    }

    /**
     * Set the value of [pro_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setProId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->pro_id !== $v) {
            $this->pro_id = $v;
            $this->modifiedColumns[PropertyTableMap::COL_PRO_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [pro_class] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setProClass($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->pro_class !== $v) {
            $this->pro_class = $v;
            $this->modifiedColumns[PropertyTableMap::COL_PRO_CLASS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [pro_prt_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setProPrtId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->pro_prt_id !== $v) {
            $this->pro_prt_id = $v;
            $this->modifiedColumns[PropertyTableMap::COL_PRO_PRT_ID] = true;
        }

        if ($this->aPropertyType !== null && $this->aPropertyType->getPrtId() !== $v) {
            $this->aPropertyType = null;
        }

        return $this;
    }

    /**
     * Set the value of [pro_name] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setProName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->pro_name !== $v) {
            $this->pro_name = $v;
            $this->modifiedColumns[PropertyTableMap::COL_PRO_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [pro_description] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setProDescription($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->pro_description !== $v) {
            $this->pro_description = $v;
            $this->modifiedColumns[PropertyTableMap::COL_PRO_DESCRIPTION] = true;
        }

        return $this;
    }

    /**
     * Set the value of [pro_prompt] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setProPrompt($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->pro_prompt !== $v) {
            $this->pro_prompt = $v;
            $this->modifiedColumns[PropertyTableMap::COL_PRO_PROMPT] = true;
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
        if ($this->pro_class !== '') {
            return false;
        }

        if ($this->pro_prt_id !== 0) {
            return false;
        }

        if ($this->pro_name !== '0') {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : PropertyTableMap::translateFieldName('ProId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->pro_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : PropertyTableMap::translateFieldName('ProClass', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->pro_class = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : PropertyTableMap::translateFieldName('ProPrtId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->pro_prt_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : PropertyTableMap::translateFieldName('ProName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->pro_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : PropertyTableMap::translateFieldName('ProDescription', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->pro_description = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : PropertyTableMap::translateFieldName('ProPrompt', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->pro_prompt = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Property object', 0, $e);
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
        if ($this->aPropertyType !== null && $this->pro_prt_id !== $this->aPropertyType->getPrtId()) {
            $this->aPropertyType = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PropertyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPropertyQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aPropertyType = null;
            $this->collRecordProperties = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Property::setDeleted()
     * @see Property::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPropertyQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PropertyTableMap::DATABASE_NAME);
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
                PropertyTableMap::addInstanceToPool($this);
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

        if ($this->aPropertyType !== null) {
            if ($this->aPropertyType->isModified() || $this->aPropertyType->isNew()) {
                $affectedRows += $this->aPropertyType->save($con);
            }
            $this->setPropertyType($this->aPropertyType);
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

        if ($this->recordPropertiesScheduledForDeletion !== null) {
            if (!$this->recordPropertiesScheduledForDeletion->isEmpty()) {
                ChildRecordPropertyQuery::create()
                    ->filterByPrimaryKeys($this->recordPropertiesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->recordPropertiesScheduledForDeletion = null;
            }
        }

        if ($this->collRecordProperties !== null) {
            foreach ($this->collRecordProperties as $referrerFK) {
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
        $this->modifiedColumns[PropertyTableMap::COL_PRO_ID] = true;
        if ($this->pro_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PropertyTableMap::COL_PRO_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_ID)) {
            $modifiedColumns[':p' . $index++] = 'pro_ID';
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_CLASS)) {
            $modifiedColumns[':p' . $index++] = 'pro_Class';
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_PRT_ID)) {
            $modifiedColumns[':p' . $index++] = 'pro_prt_ID';
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_NAME)) {
            $modifiedColumns[':p' . $index++] = 'pro_Name';
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++] = 'pro_Description';
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_PROMPT)) {
            $modifiedColumns[':p' . $index++] = 'pro_Prompt';
        }

        $sql = sprintf(
            'INSERT INTO property_pro (%s) VALUES (%s)',
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
                    case 'pro_ID':
                        $stmt->bindValue($identifier, $this->pro_id, PDO::PARAM_INT);

                        break;
                    case 'pro_Class':
                        $stmt->bindValue($identifier, $this->pro_class, PDO::PARAM_STR);

                        break;
                    case 'pro_prt_ID':
                        $stmt->bindValue($identifier, $this->pro_prt_id, PDO::PARAM_INT);

                        break;
                    case 'pro_Name':
                        $stmt->bindValue($identifier, $this->pro_name, PDO::PARAM_STR);

                        break;
                    case 'pro_Description':
                        $stmt->bindValue($identifier, $this->pro_description, PDO::PARAM_STR);

                        break;
                    case 'pro_Prompt':
                        $stmt->bindValue($identifier, $this->pro_prompt, PDO::PARAM_STR);

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
        $this->setProId((int)$pk);

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
        $pos = PropertyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            0 => $this->getProId(),
            1 => $this->getProClass(),
            2 => $this->getProPrtId(),
            3 => $this->getProName(),
            4 => $this->getProDescription(),
            5 => $this->getProPrompt(),
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
        if (isset($alreadyDumpedObjects['Property'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Property'][$this->hashCode()] = true;
        $keys = PropertyTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getProId(),
            $keys[1] => $this->getProClass(),
            $keys[2] => $this->getProPrtId(),
            $keys[3] => $this->getProName(),
            $keys[4] => $this->getProDescription(),
            $keys[5] => $this->getProPrompt(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aPropertyType !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'propertyType',
                     TableMap::TYPE_FIELDNAME => 'propertytype_prt',
                     default => 'PropertyType',
                };
                $result[$key] = $this->aPropertyType->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collRecordProperties !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'recordProperties',
                     TableMap::TYPE_FIELDNAME => 'record2property_r2ps',
                     default => 'RecordProperties',
                };
                $result[$key] = $this->collRecordProperties->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = PropertyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setProId($value);

                break;
            case 1:
                $this->setProClass($value);

                break;
            case 2:
                $this->setProPrtId($value);

                break;
            case 3:
                $this->setProName($value);

                break;
            case 4:
                $this->setProDescription($value);

                break;
            case 5:
                $this->setProPrompt($value);

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
        $keys = PropertyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setProId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setProClass($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setProPrtId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setProName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setProDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setProPrompt($arr[$keys[5]]);
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
        $tableMap = PropertyTableMap::getTableMap();
        $criteria = new Criteria(PropertyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PropertyTableMap::COL_PRO_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('pro_ID'), $this->pro_id);
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_CLASS)) {
            $criteria->setUpdateValue($tableMap->getColumn('pro_Class'), $this->pro_class);
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_PRT_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('pro_prt_ID'), $this->pro_prt_id);
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('pro_Name'), $this->pro_name);
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_DESCRIPTION)) {
            $criteria->setUpdateValue($tableMap->getColumn('pro_Description'), $this->pro_description);
        }
        if ($this->isColumnModified(PropertyTableMap::COL_PRO_PROMPT)) {
            $criteria->setUpdateValue($tableMap->getColumn('pro_Prompt'), $this->pro_prompt);
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
        $tableMap = PropertyTableMap::getTableMap();
        $query = ChildPropertyQuery::create();
        $pro_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('pro_ID'));
        $query->addAnd($pro_IDColumn, $this->pro_id);

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
        $pkIsValid = $this->getProId() !== null;

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
        return $this->getProId();
    }

    /**
     * Generic method to set the primary key (pro_id column).
     *
     * @param int|null $key Primary key.
     *
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setProId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return $this->getProId() === null;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Property (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setProClass($this->getProClass());
        $copyObj->setProPrtId($this->getProPrtId());
        $copyObj->setProName($this->getProName());
        $copyObj->setProDescription($this->getProDescription());
        $copyObj->setProPrompt($this->getProPrompt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRecordProperties() as $relObj) {
                $copyObj->addRecordProperty($relObj->copy($deepCopy));
            }
        }

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setProId(null); // this is a auto-increment column, so set to default value
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
     * Declares an association between this object and a PropertyType object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\PropertyType|null $propertyType
     *
     * @return $this
     */
    public function setPropertyType(?PropertyType $propertyType = null)
    {
        $proPrtId = $propertyType ? $propertyType->getPrtId() : 0;
        $this->setProPrtId($proPrtId);

        $this->aPropertyType = $propertyType;
        $propertyType?->addProperty($this);

        return $this;
    }

    /**
     * Get the associated PropertyType object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\PropertyType|null
     */
    public function getPropertyType(?ConnectionInterface $con = null)
    {
        if ($this->aPropertyType === null && ($this->pro_prt_id !== null && $this->pro_prt_id !== 0)) {
            $this->aPropertyType = ChildPropertyTypeQuery::create()->findPk($this->pro_prt_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPropertyType->addProperties($this);
             */
        }

        return $this->aPropertyType;
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
            'RecordProperty' => $this->initRecordProperties(),
            default => null
        };
    }

    /**
     * Initializes the collRecordProperties collection.
     *
     * By default this just sets the collRecordProperties collection to an empty array (like clearcollRecordProperties());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRecordProperties(bool $overrideExisting = true): void
    {
        if ($this->collRecordProperties !== null && !$overrideExisting) {
            return;
        }

        $this->collRecordProperties = new RecordPropertyCollection();
        $this->collRecordProperties->setModel('\ChurchCRM\model\ChurchCRM\RecordProperty');
    }

    /**
     * Reset is the collRecordProperties collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialRecordProperties(bool $isPartial = true): void
    {
        $this->collRecordPropertiesPartial = $isPartial;
    }

    /**
     * Clears out the collRecordProperties collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearRecordProperties(): static
    {
        $this->collRecordProperties = null;

        return $this;
    }

    /**
     * Gets property_pro objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Property is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection
     */
    public function getRecordProperties(?Criteria $criteria = null, ?ConnectionInterface $con = null): RecordPropertyCollection
    {
        $partial = $this->collRecordPropertiesPartial && !$this->isNew();
        if ($this->collRecordProperties && !$criteria && !$partial) {
            return $this->collRecordProperties;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collRecordProperties === null) {
                $this->initRecordProperties();

                return $this->collRecordProperties;
            }

            $collRecordProperties = new RecordPropertyCollection();
            $collRecordProperties->setModel('\ChurchCRM\model\ChurchCRM\Base\RecordProperty');

            return $collRecordProperties;
        }

        $collRecordProperties = ChildRecordPropertyQuery::create(null, $criteria)
            ->filterByProperty($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collRecordPropertiesPartial !== false && count($collRecordProperties)) {
                $this->initRecordProperties(false);

                foreach ($collRecordProperties as $obj) {
                    if (!$this->collRecordProperties->contains($obj)) {
                        $this->collRecordProperties->append($obj);
                    }
                }

                $this->collRecordPropertiesPartial = true;
            }

            return $collRecordProperties;
        }

        if ($this->collRecordPropertiesPartial && $this->collRecordProperties) {
            foreach ($this->collRecordProperties as $obj) {
                if ($obj->isNew()) {
                    $collRecordProperties[] = $obj;
                }
            }
        }

        $this->collRecordProperties = $collRecordProperties;
        $this->collRecordPropertiesPartial = false;

        return $this->collRecordProperties;
    }

    /**
     * Sets a collection of property_pro objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\RecordProperty> $recordProperties
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setRecordProperties(Collection $recordProperties, ?ConnectionInterface $con = null): static
    {
        $recordPropertiesToDelete = $this->getRecordProperties(null, $con)->diff($recordProperties);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->recordPropertiesScheduledForDeletion = clone $recordPropertiesToDelete;

        foreach ($recordPropertiesToDelete as $recordPropertyRemoved) {
            $recordPropertyRemoved->setProperty(null);
        }

        $this->collRecordProperties = null;
        foreach ($recordProperties as $recordProperty) {
            $this->addRecordProperty($recordProperty);
        }

        $this->collRecordPropertiesPartial = false;
        $this->collRecordProperties = $recordProperties instanceof RecordPropertyCollection
            ? $recordProperties : new RecordPropertyCollection($recordProperties->getData());

        return $this;
    }

    /**
     * Returns the number of related property_pro objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related property_pro objects.
     */
    public function countRecordProperties(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collRecordPropertiesPartial && !$this->isNew();
        if ($this->collRecordProperties === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collRecordProperties === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRecordProperties());
            }

            $query = ChildRecordPropertyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProperty($this)
                ->count($con);
        }

        return count($this->collRecordProperties);
    }

    /**
     * Method called to associate a RecordProperty object to this object
     * through the RecordProperty foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\RecordProperty $recordProperty
     *
     * @return $this
     */
    public function addRecordProperty(RecordProperty $recordProperty)
    {
        if ($this->collRecordProperties === null) {
            $this->initRecordProperties();
            $this->collRecordPropertiesPartial = true;
        }

        if (!$this->collRecordProperties->contains($recordProperty)) {
            $this->doAddRecordProperty($recordProperty);

            if ($this->recordPropertiesScheduledForDeletion && $this->recordPropertiesScheduledForDeletion->contains($recordProperty)) {
                $this->recordPropertiesScheduledForDeletion->remove($this->recordPropertiesScheduledForDeletion->search($recordProperty));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\RecordProperty $recordProperty The RecordProperty object to add.
     *
     * @return void
     */
    protected function doAddRecordProperty(RecordProperty $recordProperty): void
    {
        $this->collRecordProperties->append($recordProperty);
        $recordProperty->setProperty($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\RecordProperty $recordProperty The RecordProperty object to remove.
     *
     * @return static
     */
    public function removeRecordProperty(RecordProperty $recordProperty): static
    {
        if ($this->getRecordProperties()->contains($recordProperty)) {
            $pos = $this->collRecordProperties->search($recordProperty);
            $this->collRecordProperties->remove($pos);
            if ($this->recordPropertiesScheduledForDeletion === null) {
                $this->recordPropertiesScheduledForDeletion = clone $this->collRecordProperties;
                $this->recordPropertiesScheduledForDeletion->clear();
            }
            $this->recordPropertiesScheduledForDeletion->append(clone $recordProperty);
            $recordProperty->setProperty(null);
        }

        return $this;
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
        if ($this->aPropertyType !== null) {
            $this->aPropertyType->removeProperty($this);
        }
        $this->pro_id = null;
        $this->pro_class = null;
        $this->pro_prt_id = null;
        $this->pro_name = null;
        $this->pro_description = null;
        $this->pro_prompt = null;
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
            if ($this->collRecordProperties) {
                foreach ($this->collRecordProperties as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collRecordProperties = null;
        $this->aPropertyType = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(PropertyTableMap::DEFAULT_STRING_FORMAT);
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
