<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\DonatedItemQuery as ChildDonatedItemQuery;
use ChurchCRM\model\ChurchCRM\Map\DonatedItemTableMap;
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
 * Base class that represents a row from the 'donateditem_di' table.
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class DonatedItem implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\DonatedItemTableMap';

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
     * The value for the di_id field.
     */
    protected int|null $di_id = null;

    /**
     * The value for the di_item field.
     */
    protected string|null $di_item = null;

    /**
     * The value for the di_fr_id field.
     */
    protected int|null $di_fr_id = null;

    /**
     * The value for the di_donor_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $di_donor_id = null;

    /**
     * The value for the di_buyer_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $di_buyer_id = null;

    /**
     * The value for the di_multibuy field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $di_multibuy = null;

    /**
     * The value for the di_title field.
     */
    protected string|null $di_title = null;

    /**
     * The value for the di_description field.
     */
    protected string|null $di_description = null;

    /**
     * The value for the di_sellprice field.
     */
    protected string|null $di_sellprice = null;

    /**
     * The value for the di_estprice field.
     */
    protected string|null $di_estprice = null;

    /**
     * The value for the di_minimum field.
     */
    protected string|null $di_minimum = null;

    /**
     * The value for the di_materialvalue field.
     */
    protected string|null $di_materialvalue = null;

    /**
     * The value for the di_enteredby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $di_enteredby = null;

    /**
     * The value for the di_entereddate field.
     */
    protected DateTimeInterface|null $di_entereddate = null;

    /**
     * The value for the di_picture field.
     */
    protected string|null $di_picture = null;

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
        $this->di_donor_id = 0;
        $this->di_buyer_id = 0;
        $this->di_multibuy = 0;
        $this->di_enteredby = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\DonatedItem object.
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
     * Compares this with another <code>DonatedItem</code> instance. If
     * <code>obj</code> is an instance of <code>DonatedItem</code>, delegates to
     * <code>equals(DonatedItem)</code>. Otherwise, returns <code>false</code>.
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

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns));
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
     * Get the [di_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->di_id;
    }

    /**
     * Get the [di_item] column value.
     *
     * @return string|null
     */
    public function getItem()
    {
        return $this->di_item;
    }

    /**
     * Get the [di_fr_id] column value.
     *
     * @return int|null
     */
    public function getFrId()
    {
        return $this->di_fr_id;
    }

    /**
     * Get the [di_donor_id] column value.
     *
     * @return int|null
     */
    public function getDonorId()
    {
        return $this->di_donor_id;
    }

    /**
     * Get the [di_buyer_id] column value.
     *
     * @return int|null
     */
    public function getBuyerId()
    {
        return $this->di_buyer_id;
    }

    /**
     * Get the [di_multibuy] column value.
     *
     * @return int|null
     */
    public function getMultibuy()
    {
        return $this->di_multibuy;
    }

    /**
     * Get the [di_title] column value.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->di_title;
    }

    /**
     * Get the [di_description] column value.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->di_description;
    }

    /**
     * Get the [di_sellprice] column value.
     *
     * @return string|null
     */
    public function getSellprice()
    {
        return $this->di_sellprice;
    }

    /**
     * Get the [di_estprice] column value.
     *
     * @return string|null
     */
    public function getEstprice()
    {
        return $this->di_estprice;
    }

    /**
     * Get the [di_minimum] column value.
     *
     * @return string|null
     */
    public function getMinimum()
    {
        return $this->di_minimum;
    }

    /**
     * Get the [di_materialvalue] column value.
     *
     * @return string|null
     */
    public function getMaterialValue()
    {
        return $this->di_materialvalue;
    }

    /**
     * Get the [di_enteredby] column value.
     *
     * @return int|null
     */
    public function getEnteredby()
    {
        return $this->di_enteredby;
    }

    /**
     * Get the [optionally formatted] temporal [di_entereddate] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00.
     */
    public function getEntereddate($format = null)
    {
        if ($format === null) {
            return $this->di_entereddate;
        } else {
            return $this->di_entereddate instanceof DateTimeInterface ? $this->di_entereddate->format($format) : null;
        }
    }

    /**
     * Get the [di_picture] column value.
     *
     * @return string|null
     */
    public function getPicture()
    {
        return $this->di_picture;
    }

    /**
     * Set the value of [di_id] column.
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

        if ($this->di_id !== $v) {
            $this->di_id = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_item] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setItem($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_item !== $v) {
            $this->di_item = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_ITEM] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_fr_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFrId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->di_fr_id !== $v) {
            $this->di_fr_id = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_FR_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_donor_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setDonorId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->di_donor_id !== $v) {
            $this->di_donor_id = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_DONOR_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_buyer_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setBuyerId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->di_buyer_id !== $v) {
            $this->di_buyer_id = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_BUYER_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_multibuy] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setMultibuy($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->di_multibuy !== $v) {
            $this->di_multibuy = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_MULTIBUY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_title] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_title !== $v) {
            $this->di_title = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_description] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_description !== $v) {
            $this->di_description = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_DESCRIPTION] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_sellprice] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setSellprice($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_sellprice !== $v) {
            $this->di_sellprice = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_SELLPRICE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_estprice] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setEstprice($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_estprice !== $v) {
            $this->di_estprice = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_ESTPRICE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_minimum] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setMinimum($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_minimum !== $v) {
            $this->di_minimum = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_MINIMUM] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_materialvalue] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setMaterialValue($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_materialvalue !== $v) {
            $this->di_materialvalue = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_MATERIALVALUE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [di_enteredby] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setEnteredby($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->di_enteredby !== $v) {
            $this->di_enteredby = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_ENTEREDBY] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [di_entereddate] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setEntereddate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->di_entereddate !== null || $dt !== null) {
            if ($this->di_entereddate === null || $dt === null || $dt->format('Y-m-d') !== $this->di_entereddate->format('Y-m-d')) {
                $this->di_entereddate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DonatedItemTableMap::COL_DI_ENTEREDDATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [di_picture] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPicture($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->di_picture !== $v) {
            $this->di_picture = $v;
            $this->modifiedColumns[DonatedItemTableMap::COL_DI_PICTURE] = true;
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
        if ($this->di_donor_id !== 0) {
            return false;
        }

        if ($this->di_buyer_id !== 0) {
            return false;
        }

        if ($this->di_multibuy !== 0) {
            return false;
        }

        if ($this->di_enteredby !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : DonatedItemTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : DonatedItemTableMap::translateFieldName('Item', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_item = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : DonatedItemTableMap::translateFieldName('FrId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_fr_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : DonatedItemTableMap::translateFieldName('DonorId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_donor_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : DonatedItemTableMap::translateFieldName('BuyerId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_buyer_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : DonatedItemTableMap::translateFieldName('Multibuy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_multibuy = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : DonatedItemTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_title = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : DonatedItemTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_description = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : DonatedItemTableMap::translateFieldName('Sellprice', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_sellprice = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : DonatedItemTableMap::translateFieldName('Estprice', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_estprice = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : DonatedItemTableMap::translateFieldName('Minimum', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_minimum = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : DonatedItemTableMap::translateFieldName('MaterialValue', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_materialvalue = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 12 : DonatedItemTableMap::translateFieldName('Enteredby', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_enteredby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 13 : DonatedItemTableMap::translateFieldName('Entereddate', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->di_entereddate = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 14 : DonatedItemTableMap::translateFieldName('Picture', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->di_picture = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\DonatedItem object', 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(DonatedItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDonatedItemQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see DonatedItem::setDeleted()
     * @see DonatedItem::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DonatedItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDonatedItemQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DonatedItemTableMap::DATABASE_NAME);
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
                DonatedItemTableMap::addInstanceToPool($this);
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
        $this->modifiedColumns[DonatedItemTableMap::COL_DI_ID] = true;
        if ($this->di_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DonatedItemTableMap::COL_DI_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ID)) {
            $modifiedColumns[':p' . $index++] = 'di_ID';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ITEM)) {
            $modifiedColumns[':p' . $index++] = 'di_item';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_FR_ID)) {
            $modifiedColumns[':p' . $index++] = 'di_FR_ID';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_DONOR_ID)) {
            $modifiedColumns[':p' . $index++] = 'di_donor_ID';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_BUYER_ID)) {
            $modifiedColumns[':p' . $index++] = 'di_buyer_ID';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_MULTIBUY)) {
            $modifiedColumns[':p' . $index++] = 'di_multibuy';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_TITLE)) {
            $modifiedColumns[':p' . $index++] = 'di_title';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++] = 'di_description';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_SELLPRICE)) {
            $modifiedColumns[':p' . $index++] = 'di_sellprice';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ESTPRICE)) {
            $modifiedColumns[':p' . $index++] = 'di_estprice';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_MINIMUM)) {
            $modifiedColumns[':p' . $index++] = 'di_minimum';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_MATERIALVALUE)) {
            $modifiedColumns[':p' . $index++] = 'di_materialvalue';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ENTEREDBY)) {
            $modifiedColumns[':p' . $index++] = 'di_EnteredBy';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ENTEREDDATE)) {
            $modifiedColumns[':p' . $index++] = 'di_EnteredDate';
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_PICTURE)) {
            $modifiedColumns[':p' . $index++] = 'di_picture';
        }

        $sql = sprintf(
            'INSERT INTO donateditem_di (%s) VALUES (%s)',
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
                    case 'di_ID':
                        $stmt->bindValue($identifier, $this->di_id, PDO::PARAM_INT);

                        break;
                    case 'di_item':
                        $stmt->bindValue($identifier, $this->di_item, PDO::PARAM_STR);

                        break;
                    case 'di_FR_ID':
                        $stmt->bindValue($identifier, $this->di_fr_id, PDO::PARAM_INT);

                        break;
                    case 'di_donor_ID':
                        $stmt->bindValue($identifier, $this->di_donor_id, PDO::PARAM_INT);

                        break;
                    case 'di_buyer_ID':
                        $stmt->bindValue($identifier, $this->di_buyer_id, PDO::PARAM_INT);

                        break;
                    case 'di_multibuy':
                        $stmt->bindValue($identifier, $this->di_multibuy, PDO::PARAM_INT);

                        break;
                    case 'di_title':
                        $stmt->bindValue($identifier, $this->di_title, PDO::PARAM_STR);

                        break;
                    case 'di_description':
                        $stmt->bindValue($identifier, $this->di_description, PDO::PARAM_STR);

                        break;
                    case 'di_sellprice':
                        $stmt->bindValue($identifier, $this->di_sellprice, PDO::PARAM_STR);

                        break;
                    case 'di_estprice':
                        $stmt->bindValue($identifier, $this->di_estprice, PDO::PARAM_STR);

                        break;
                    case 'di_minimum':
                        $stmt->bindValue($identifier, $this->di_minimum, PDO::PARAM_STR);

                        break;
                    case 'di_materialvalue':
                        $stmt->bindValue($identifier, $this->di_materialvalue, PDO::PARAM_STR);

                        break;
                    case 'di_EnteredBy':
                        $stmt->bindValue($identifier, $this->di_enteredby, PDO::PARAM_INT);

                        break;
                    case 'di_EnteredDate':
                        $stmt->bindValue($identifier, $this->di_entereddate ? $this->di_entereddate->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'di_picture':
                        $stmt->bindValue($identifier, $this->di_picture, PDO::PARAM_STR);

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
        $pos = DonatedItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getItem(),
            2 => $this->getFrId(),
            3 => $this->getDonorId(),
            4 => $this->getBuyerId(),
            5 => $this->getMultibuy(),
            6 => $this->getTitle(),
            7 => $this->getDescription(),
            8 => $this->getSellprice(),
            9 => $this->getEstprice(),
            10 => $this->getMinimum(),
            11 => $this->getMaterialValue(),
            12 => $this->getEnteredby(),
            13 => $this->getEntereddate(),
            14 => $this->getPicture(),
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
     *
     * @return array<mixed> An associative array containing the field names (as keys) and field values
     */
    public function toArray(
        string $keyType = TableMap::TYPE_PHPNAME,
        bool $includeLazyLoadColumns = true,
        array $alreadyDumpedObjects = []
    ): array {
        if (isset($alreadyDumpedObjects['DonatedItem'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['DonatedItem'][$this->hashCode()] = true;
        $keys = DonatedItemTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getItem(),
            $keys[2] => $this->getFrId(),
            $keys[3] => $this->getDonorId(),
            $keys[4] => $this->getBuyerId(),
            $keys[5] => $this->getMultibuy(),
            $keys[6] => $this->getTitle(),
            $keys[7] => $this->getDescription(),
            $keys[8] => $this->getSellprice(),
            $keys[9] => $this->getEstprice(),
            $keys[10] => $this->getMinimum(),
            $keys[11] => $this->getMaterialValue(),
            $keys[12] => $this->getEnteredby(),
            $keys[13] => $this->getEntereddate(),
            $keys[14] => $this->getPicture(),
        ];
        if ($result[$keys[13]] instanceof DateTimeInterface) {
            $result[$keys[13]] = $result[$keys[13]]->format('Y-m-d');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
        $pos = DonatedItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setItem($value);

                break;
            case 2:
                $this->setFrId($value);

                break;
            case 3:
                $this->setDonorId($value);

                break;
            case 4:
                $this->setBuyerId($value);

                break;
            case 5:
                $this->setMultibuy($value);

                break;
            case 6:
                $this->setTitle($value);

                break;
            case 7:
                $this->setDescription($value);

                break;
            case 8:
                $this->setSellprice($value);

                break;
            case 9:
                $this->setEstprice($value);

                break;
            case 10:
                $this->setMinimum($value);

                break;
            case 11:
                $this->setMaterialValue($value);

                break;
            case 12:
                $this->setEnteredby($value);

                break;
            case 13:
                $this->setEntereddate($value);

                break;
            case 14:
                $this->setPicture($value);

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
        $keys = DonatedItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setItem($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFrId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDonorId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setBuyerId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setMultibuy($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setTitle($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setDescription($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSellprice($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setEstprice($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setMinimum($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setMaterialValue($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setEnteredby($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setEntereddate($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setPicture($arr[$keys[14]]);
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
        $tableMap = DonatedItemTableMap::getTableMap();
        $criteria = new Criteria(DonatedItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_ID'), $this->di_id);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ITEM)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_item'), $this->di_item);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_FR_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_FR_ID'), $this->di_fr_id);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_DONOR_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_donor_ID'), $this->di_donor_id);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_BUYER_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_buyer_ID'), $this->di_buyer_id);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_MULTIBUY)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_multibuy'), $this->di_multibuy);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_TITLE)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_title'), $this->di_title);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_DESCRIPTION)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_description'), $this->di_description);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_SELLPRICE)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_sellprice'), $this->di_sellprice);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ESTPRICE)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_estprice'), $this->di_estprice);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_MINIMUM)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_minimum'), $this->di_minimum);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_MATERIALVALUE)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_materialvalue'), $this->di_materialvalue);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ENTEREDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_EnteredBy'), $this->di_enteredby);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_ENTEREDDATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_EnteredDate'), $this->di_entereddate);
        }
        if ($this->isColumnModified(DonatedItemTableMap::COL_DI_PICTURE)) {
            $criteria->setUpdateValue($tableMap->getColumn('di_picture'), $this->di_picture);
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
        $tableMap = DonatedItemTableMap::getTableMap();
        $query = ChildDonatedItemQuery::create();
        $di_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('di_ID'));
        $query->addAnd($di_IDColumn, $this->di_id);

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
     * Generic method to set the primary key (di_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\DonatedItem (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setItem($this->getItem());
        $copyObj->setFrId($this->getFrId());
        $copyObj->setDonorId($this->getDonorId());
        $copyObj->setBuyerId($this->getBuyerId());
        $copyObj->setMultibuy($this->getMultibuy());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setSellprice($this->getSellprice());
        $copyObj->setEstprice($this->getEstprice());
        $copyObj->setMinimum($this->getMinimum());
        $copyObj->setMaterialValue($this->getMaterialValue());
        $copyObj->setEnteredby($this->getEnteredby());
        $copyObj->setEntereddate($this->getEntereddate());
        $copyObj->setPicture($this->getPicture());
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
        $this->di_id = null;
        $this->di_item = null;
        $this->di_fr_id = null;
        $this->di_donor_id = null;
        $this->di_buyer_id = null;
        $this->di_multibuy = null;
        $this->di_title = null;
        $this->di_description = null;
        $this->di_sellprice = null;
        $this->di_estprice = null;
        $this->di_minimum = null;
        $this->di_materialvalue = null;
        $this->di_enteredby = null;
        $this->di_entereddate = null;
        $this->di_picture = null;
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
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(DonatedItemTableMap::DEFAULT_STRING_FORMAT);
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
