<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\FamilyQuery as ChildFamilyQuery;
use ChurchCRM\model\ChurchCRM\Map\NoteTableMap;
use ChurchCRM\model\ChurchCRM\NoteQuery as ChildNoteQuery;
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
 * Base class that represents a row from the 'note_nte' table.
 *
 * Contains all person and family notes, including the date, time, and person who entered the note
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Note implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\NoteTableMap';

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
     * The value for the nte_id field.
     */
    protected int|null $nte_id = null;

    /**
     * The value for the nte_per_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $nte_per_id = null;

    /**
     * The value for the nte_fam_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $nte_fam_id = null;

    /**
     * The value for the nte_private field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $nte_private = null;

    /**
     * The value for the nte_text field.
     */
    protected string|null $nte_text = null;

    /**
     * The value for the nte_dateentered field.
     */
    protected DateTimeInterface|null $nte_dateentered = null;

    /**
     * The value for the nte_datelastedited field.
     */
    protected DateTimeInterface|null $nte_datelastedited = null;

    /**
     * The value for the nte_enteredby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $nte_enteredby = null;

    /**
     * The value for the nte_editedby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $nte_editedby = null;

    /**
     * The value for the nte_type field.
     */
    protected string|null $nte_type = null;

    /**
     * Person associated via Person relation (n:1).
     */
    protected Person|null $aPerson = null;

    /**
     * Family associated via Family relation (n:1).
     */
    protected Family|null $aFamily = null;

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
        $this->nte_per_id = 0;
        $this->nte_fam_id = 0;
        $this->nte_private = 0;
        $this->nte_enteredby = 0;
        $this->nte_editedby = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Note object.
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
     * Compares this with another <code>Note</code> instance. If
     * <code>obj</code> is an instance of <code>Note</code>, delegates to
     * <code>equals(Note)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [nte_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->nte_id;
    }

    /**
     * Get the [nte_per_id] column value.
     *
     * @return int|null
     */
    public function getPerId()
    {
        return $this->nte_per_id;
    }

    /**
     * Get the [nte_fam_id] column value.
     *
     * @return int|null
     */
    public function getFamId()
    {
        return $this->nte_fam_id;
    }

    /**
     * Get the [nte_private] column value.
     *
     * @return int|null
     */
    public function getPrivate()
    {
        return $this->nte_private;
    }

    /**
     * Get the [nte_text] column value.
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->nte_text;
    }

    /**
     * Get the [optionally formatted] temporal [nte_dateentered] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getDateEntered($format = null)
    {
        if ($format === null) {
            return $this->nte_dateentered;
        } else {
            return $this->nte_dateentered instanceof DateTimeInterface ? $this->nte_dateentered->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [nte_datelastedited] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getDateLastEdited($format = null)
    {
        if ($format === null) {
            return $this->nte_datelastedited;
        } else {
            return $this->nte_datelastedited instanceof DateTimeInterface ? $this->nte_datelastedited->format($format) : null;
        }
    }

    /**
     * Get the [nte_enteredby] column value.
     *
     * @return int|null
     */
    public function getEnteredBy()
    {
        return $this->nte_enteredby;
    }

    /**
     * Get the [nte_editedby] column value.
     *
     * @return int|null
     */
    public function getEditedBy()
    {
        return $this->nte_editedby;
    }

    /**
     * Get the [nte_type] column value.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->nte_type;
    }

    /**
     * Set the value of [nte_id] column.
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

        if ($this->nte_id !== $v) {
            $this->nte_id = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [nte_per_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setPerId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->nte_per_id !== $v) {
            $this->nte_per_id = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_PER_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    }

    /**
     * Set the value of [nte_fam_id] column.
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

        if ($this->nte_fam_id !== $v) {
            $this->nte_fam_id = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_FAM_ID] = true;
        }

        if ($this->aFamily !== null && $this->aFamily->getId() !== $v) {
            $this->aFamily = null;
        }

        return $this;
    }

    /**
     * Set the value of [nte_private] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setPrivate($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->nte_private !== $v) {
            $this->nte_private = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_PRIVATE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [nte_text] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->nte_text !== $v) {
            $this->nte_text = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_TEXT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [nte_dateentered] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateEntered($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->nte_dateentered !== null || $dt !== null) {
            if ($this->nte_dateentered === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->nte_dateentered->format('Y-m-d H:i:s.u')) {
                $this->nte_dateentered = $dt === null ? null : clone $dt;
                $this->modifiedColumns[NoteTableMap::COL_NTE_DATEENTERED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [nte_datelastedited] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateLastEdited($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->nte_datelastedited !== null || $dt !== null) {
            if ($this->nte_datelastedited === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->nte_datelastedited->format('Y-m-d H:i:s.u')) {
                $this->nte_datelastedited = $dt === null ? null : clone $dt;
                $this->modifiedColumns[NoteTableMap::COL_NTE_DATELASTEDITED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [nte_enteredby] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setEnteredBy($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->nte_enteredby !== $v) {
            $this->nte_enteredby = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_ENTEREDBY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [nte_editedby] column.
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

        if ($this->nte_editedby !== $v) {
            $this->nte_editedby = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_EDITEDBY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [nte_type] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->nte_type !== $v) {
            $this->nte_type = $v;
            $this->modifiedColumns[NoteTableMap::COL_NTE_TYPE] = true;
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
        if ($this->nte_per_id !== 0) {
            return false;
        }

        if ($this->nte_fam_id !== 0) {
            return false;
        }

        if ($this->nte_private !== 0) {
            return false;
        }

        if ($this->nte_enteredby !== 0) {
            return false;
        }

        if ($this->nte_editedby !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : NoteTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : NoteTableMap::translateFieldName('PerId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_per_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : NoteTableMap::translateFieldName('FamId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_fam_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : NoteTableMap::translateFieldName('Private', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_private = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : NoteTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_text = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : NoteTableMap::translateFieldName('DateEntered', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->nte_dateentered = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : NoteTableMap::translateFieldName('DateLastEdited', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->nte_datelastedited = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : NoteTableMap::translateFieldName('EnteredBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_enteredby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : NoteTableMap::translateFieldName('EditedBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_editedby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : NoteTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->nte_type = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Note object', 0, $e);
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
        if ($this->aPerson !== null && $this->nte_per_id !== $this->aPerson->getId()) {
            $this->aPerson = null;
        }
        if ($this->aFamily !== null && $this->nte_fam_id !== $this->aFamily->getId()) {
            $this->aFamily = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(NoteTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildNoteQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aPerson = null;
            $this->aFamily = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Note::setDeleted()
     * @see Note::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(NoteTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildNoteQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(NoteTableMap::DATABASE_NAME);
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
                NoteTableMap::addInstanceToPool($this);
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

        if ($this->aPerson !== null) {
            if ($this->aPerson->isModified() || $this->aPerson->isNew()) {
                $affectedRows += $this->aPerson->save($con);
            }
            $this->setPerson($this->aPerson);
        }

        if ($this->aFamily !== null) {
            if ($this->aFamily->isModified() || $this->aFamily->isNew()) {
                $affectedRows += $this->aFamily->save($con);
            }
            $this->setFamily($this->aFamily);
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
        $this->modifiedColumns[NoteTableMap::COL_NTE_ID] = true;
        if ($this->nte_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . NoteTableMap::COL_NTE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(NoteTableMap::COL_NTE_ID)) {
            $modifiedColumns[':p' . $index++] = 'nte_ID';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_PER_ID)) {
            $modifiedColumns[':p' . $index++] = 'nte_per_ID';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_FAM_ID)) {
            $modifiedColumns[':p' . $index++] = 'nte_fam_ID';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_PRIVATE)) {
            $modifiedColumns[':p' . $index++] = 'nte_Private';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_TEXT)) {
            $modifiedColumns[':p' . $index++] = 'nte_Text';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_DATEENTERED)) {
            $modifiedColumns[':p' . $index++] = 'nte_DateEntered';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_DATELASTEDITED)) {
            $modifiedColumns[':p' . $index++] = 'nte_DateLastEdited';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_ENTEREDBY)) {
            $modifiedColumns[':p' . $index++] = 'nte_EnteredBy';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_EDITEDBY)) {
            $modifiedColumns[':p' . $index++] = 'nte_EditedBy';
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_TYPE)) {
            $modifiedColumns[':p' . $index++] = 'nte_Type';
        }

        $sql = sprintf(
            'INSERT INTO note_nte (%s) VALUES (%s)',
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
                    case 'nte_ID':
                        $stmt->bindValue($identifier, $this->nte_id, PDO::PARAM_INT);

                        break;
                    case 'nte_per_ID':
                        $stmt->bindValue($identifier, $this->nte_per_id, PDO::PARAM_INT);

                        break;
                    case 'nte_fam_ID':
                        $stmt->bindValue($identifier, $this->nte_fam_id, PDO::PARAM_INT);

                        break;
                    case 'nte_Private':
                        $stmt->bindValue($identifier, $this->nte_private, PDO::PARAM_INT);

                        break;
                    case 'nte_Text':
                        $stmt->bindValue($identifier, $this->nte_text, PDO::PARAM_STR);

                        break;
                    case 'nte_DateEntered':
                        $stmt->bindValue($identifier, $this->nte_dateentered ? $this->nte_dateentered->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'nte_DateLastEdited':
                        $stmt->bindValue($identifier, $this->nte_datelastedited ? $this->nte_datelastedited->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'nte_EnteredBy':
                        $stmt->bindValue($identifier, $this->nte_enteredby, PDO::PARAM_INT);

                        break;
                    case 'nte_EditedBy':
                        $stmt->bindValue($identifier, $this->nte_editedby, PDO::PARAM_INT);

                        break;
                    case 'nte_Type':
                        $stmt->bindValue($identifier, $this->nte_type, PDO::PARAM_STR);

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
        $pos = NoteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getPerId(),
            2 => $this->getFamId(),
            3 => $this->getPrivate(),
            4 => $this->getText(),
            5 => $this->getDateEntered(),
            6 => $this->getDateLastEdited(),
            7 => $this->getEnteredBy(),
            8 => $this->getEditedBy(),
            9 => $this->getType(),
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
        if (isset($alreadyDumpedObjects['Note'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Note'][$this->hashCode()] = true;
        $keys = NoteTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPerId(),
            $keys[2] => $this->getFamId(),
            $keys[3] => $this->getPrivate(),
            $keys[4] => $this->getText(),
            $keys[5] => $this->getDateEntered(),
            $keys[6] => $this->getDateLastEdited(),
            $keys[7] => $this->getEnteredBy(),
            $keys[8] => $this->getEditedBy(),
            $keys[9] => $this->getType(),
        ];
        if ($result[$keys[5]] instanceof DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[6]] instanceof DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aPerson !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'person',
                     TableMap::TYPE_FIELDNAME => 'person_per',
                     default => 'Person',
                };
                $result[$key] = $this->aPerson->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aFamily !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'family',
                     TableMap::TYPE_FIELDNAME => 'family_fam',
                     default => 'Family',
                };
                $result[$key] = $this->aFamily->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
        $pos = NoteTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setPerId($value);

                break;
            case 2:
                $this->setFamId($value);

                break;
            case 3:
                $this->setPrivate($value);

                break;
            case 4:
                $this->setText($value);

                break;
            case 5:
                $this->setDateEntered($value);

                break;
            case 6:
                $this->setDateLastEdited($value);

                break;
            case 7:
                $this->setEnteredBy($value);

                break;
            case 8:
                $this->setEditedBy($value);

                break;
            case 9:
                $this->setType($value);

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
        $keys = NoteTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPerId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFamId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPrivate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setText($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDateEntered($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDateLastEdited($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEnteredBy($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setEditedBy($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setType($arr[$keys[9]]);
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
        $tableMap = NoteTableMap::getTableMap();
        $criteria = new Criteria(NoteTableMap::DATABASE_NAME);

        if ($this->isColumnModified(NoteTableMap::COL_NTE_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_ID'), $this->nte_id);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_PER_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_per_ID'), $this->nte_per_id);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_FAM_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_fam_ID'), $this->nte_fam_id);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_PRIVATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_Private'), $this->nte_private);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_TEXT)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_Text'), $this->nte_text);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_DATEENTERED)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_DateEntered'), $this->nte_dateentered);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_DATELASTEDITED)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_DateLastEdited'), $this->nte_datelastedited);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_ENTEREDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_EnteredBy'), $this->nte_enteredby);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_EDITEDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_EditedBy'), $this->nte_editedby);
        }
        if ($this->isColumnModified(NoteTableMap::COL_NTE_TYPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('nte_Type'), $this->nte_type);
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
        $tableMap = NoteTableMap::getTableMap();
        $query = ChildNoteQuery::create();
        $nte_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('nte_ID'));
        $query->addAnd($nte_IDColumn, $this->nte_id);

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
     * Generic method to set the primary key (nte_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Note (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setPerId($this->getPerId());
        $copyObj->setFamId($this->getFamId());
        $copyObj->setPrivate($this->getPrivate());
        $copyObj->setText($this->getText());
        $copyObj->setDateEntered($this->getDateEntered());
        $copyObj->setDateLastEdited($this->getDateLastEdited());
        $copyObj->setEnteredBy($this->getEnteredBy());
        $copyObj->setEditedBy($this->getEditedBy());
        $copyObj->setType($this->getType());
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
     * Declares an association between this object and a Person object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|null $person
     *
     * @return $this
     */
    public function setPerson(?Person $person = null)
    {
        $perId = $person ? $person->getId() : 0;
        $this->setPerId($perId);

        $this->aPerson = $person;
        $person?->addNote($this);

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
        if ($this->aPerson === null && ($this->nte_per_id !== null && $this->nte_per_id !== 0)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->nte_per_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPerson->addNotes($this);
             */
        }

        return $this->aPerson;
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
        $famId = $family ? $family->getId() : 0;
        $this->setFamId($famId);

        $this->aFamily = $family;
        $family?->addNote($this);

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
        if ($this->aFamily === null && ($this->nte_fam_id !== null && $this->nte_fam_id !== 0)) {
            $this->aFamily = ChildFamilyQuery::create()->findPk($this->nte_fam_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFamily->addNotes($this);
             */
        }

        return $this->aFamily;
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
        if ($this->aPerson !== null) {
            $this->aPerson->removeNote($this);
        }
        if ($this->aFamily !== null) {
            $this->aFamily->removeNote($this);
        }
        $this->nte_id = null;
        $this->nte_per_id = null;
        $this->nte_fam_id = null;
        $this->nte_private = null;
        $this->nte_text = null;
        $this->nte_dateentered = null;
        $this->nte_datelastedited = null;
        $this->nte_enteredby = null;
        $this->nte_editedby = null;
        $this->nte_type = null;
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
        $this->aPerson = null;
        $this->aFamily = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(NoteTableMap::DEFAULT_STRING_FORMAT);
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
