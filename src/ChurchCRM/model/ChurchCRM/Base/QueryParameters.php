<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Map\QueryParametersTableMap;
use ChurchCRM\model\ChurchCRM\QueryParametersQuery as ChildQueryParametersQuery;
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
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * Base class that represents a row from the 'queryparameters_qrp' table.
 *
 * defines the parameters for each query
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class QueryParameters implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\QueryParametersTableMap';

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
     * The value for the qrp_id field.
     */
    protected int|null $qrp_id = null;

    /**
     * The value for the qrp_qry_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $qrp_qry_id = null;

    /**
     * The value for the qrp_type field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $qrp_type = null;

    /**
     * The value for the qrp_optionsql field.
     */
    protected string|null $qrp_optionsql = null;

    /**
     * The value for the qrp_name field.
     */
    protected string|null $qrp_name = null;

    /**
     * The value for the qrp_description field.
     */
    protected string|null $qrp_description = null;

    /**
     * The value for the qrp_alias field.
     */
    protected string|null $qrp_alias = null;

    /**
     * The value for the qrp_default field.
     */
    protected string|null $qrp_default = null;

    /**
     * The value for the qrp_required field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $qrp_required = null;

    /**
     * The value for the qrp_inputboxsize field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $qrp_inputboxsize = null;

    /**
     * The value for the qrp_validation field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $qrp_validation = null;

    /**
     * The value for the qrp_numericmax field.
     */
    protected int|null $qrp_numericmax = null;

    /**
     * The value for the qrp_numericmin field.
     */
    protected int|null $qrp_numericmin = null;

    /**
     * The value for the qrp_alphaminlength field.
     */
    protected int|null $qrp_alphaminlength = null;

    /**
     * The value for the qrp_alphamaxlength field.
     */
    protected int|null $qrp_alphamaxlength = null;

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
        $this->qrp_qry_id = 0;
        $this->qrp_type = 0;
        $this->qrp_required = 0;
        $this->qrp_inputboxsize = 0;
        $this->qrp_validation = '';
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\QueryParameters object.
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
     * Compares this with another <code>QueryParameters</code> instance. If
     * <code>obj</code> is an instance of <code>QueryParameters</code>, delegates to
     * <code>equals(QueryParameters)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [qrp_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->qrp_id;
    }

    /**
     * Get the [qrp_qry_id] column value.
     *
     * @return int|null
     */
    public function getQryId()
    {
        return $this->qrp_qry_id;
    }

    /**
     * Get the [qrp_type] column value.
     *
     * @return int|null
     */
    public function getType()
    {
        return $this->qrp_type;
    }

    /**
     * Get the [qrp_optionsql] column value.
     *
     * @return string|null
     */
    public function getOptionSQL()
    {
        return $this->qrp_optionsql;
    }

    /**
     * Get the [qrp_name] column value.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->qrp_name;
    }

    /**
     * Get the [qrp_description] column value.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->qrp_description;
    }

    /**
     * Get the [qrp_alias] column value.
     *
     * @return string|null
     */
    public function getAlias()
    {
        return $this->qrp_alias;
    }

    /**
     * Get the [qrp_default] column value.
     *
     * @return string|null
     */
    public function getDefault()
    {
        return $this->qrp_default;
    }

    /**
     * Get the [qrp_required] column value.
     *
     * @return int|null
     */
    public function getRequired()
    {
        return $this->qrp_required;
    }

    /**
     * Get the [qrp_inputboxsize] column value.
     *
     * @return int|null
     */
    public function getInputBoxSize()
    {
        return $this->qrp_inputboxsize;
    }

    /**
     * Get the [qrp_validation] column value.
     *
     * @return string|null
     */
    public function getValidation()
    {
        return $this->qrp_validation;
    }

    /**
     * Get the [qrp_numericmax] column value.
     *
     * @return int|null
     */
    public function getNumericMax()
    {
        return $this->qrp_numericmax;
    }

    /**
     * Get the [qrp_numericmin] column value.
     *
     * @return int|null
     */
    public function getNumericMin()
    {
        return $this->qrp_numericmin;
    }

    /**
     * Get the [qrp_alphaminlength] column value.
     *
     * @return int|null
     */
    public function getAlphaMinLength()
    {
        return $this->qrp_alphaminlength;
    }

    /**
     * Get the [qrp_alphamaxlength] column value.
     *
     * @return int|null
     */
    public function getAlphaMaxLength()
    {
        return $this->qrp_alphamaxlength;
    }

    /**
     * Set the value of [qrp_id] column.
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

        if ($this->qrp_id !== $v) {
            $this->qrp_id = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_qry_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setQryId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_qry_id !== $v) {
            $this->qrp_qry_id = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_QRY_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_type] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_type !== $v) {
            $this->qrp_type = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_TYPE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_optionsql] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setOptionSQL($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->qrp_optionsql !== $v) {
            $this->qrp_optionsql = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_OPTIONSQL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_name] column.
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

        if ($this->qrp_name !== $v) {
            $this->qrp_name = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_description] column.
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

        if ($this->qrp_description !== $v) {
            $this->qrp_description = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_DESCRIPTION] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_alias] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->qrp_alias !== $v) {
            $this->qrp_alias = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_ALIAS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_default] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDefault($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->qrp_default !== $v) {
            $this->qrp_default = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_DEFAULT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_required] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setRequired($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_required !== $v) {
            $this->qrp_required = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_REQUIRED] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_inputboxsize] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setInputBoxSize($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_inputboxsize !== $v) {
            $this->qrp_inputboxsize = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_INPUTBOXSIZE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_validation] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setValidation($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->qrp_validation !== $v) {
            $this->qrp_validation = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_VALIDATION] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_numericmax] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setNumericMax($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_numericmax !== $v) {
            $this->qrp_numericmax = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_NUMERICMAX] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_numericmin] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setNumericMin($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_numericmin !== $v) {
            $this->qrp_numericmin = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_NUMERICMIN] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_alphaminlength] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setAlphaMinLength($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_alphaminlength !== $v) {
            $this->qrp_alphaminlength = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH] = true;
        }

        return $this;
    }

    /**
     * Set the value of [qrp_alphamaxlength] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setAlphaMaxLength($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->qrp_alphamaxlength !== $v) {
            $this->qrp_alphamaxlength = $v;
            $this->modifiedColumns[QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH] = true;
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
        if ($this->qrp_qry_id !== 0) {
            return false;
        }

        if ($this->qrp_type !== 0) {
            return false;
        }

        if ($this->qrp_required !== 0) {
            return false;
        }

        if ($this->qrp_inputboxsize !== 0) {
            return false;
        }

        if ($this->qrp_validation !== '') {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : QueryParametersTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : QueryParametersTableMap::translateFieldName('QryId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_qry_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : QueryParametersTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_type = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : QueryParametersTableMap::translateFieldName('OptionSQL', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_optionsql = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : QueryParametersTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : QueryParametersTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_description = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : QueryParametersTableMap::translateFieldName('Alias', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_alias = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : QueryParametersTableMap::translateFieldName('Default', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_default = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : QueryParametersTableMap::translateFieldName('Required', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_required = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : QueryParametersTableMap::translateFieldName('InputBoxSize', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_inputboxsize = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : QueryParametersTableMap::translateFieldName('Validation', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_validation = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : QueryParametersTableMap::translateFieldName('NumericMax', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_numericmax = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 12 : QueryParametersTableMap::translateFieldName('NumericMin', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_numericmin = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 13 : QueryParametersTableMap::translateFieldName('AlphaMinLength', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_alphaminlength = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 14 : QueryParametersTableMap::translateFieldName('AlphaMaxLength', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->qrp_alphamaxlength = $columnValue !== null ? (int)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 15;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\QueryParameters object', 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildQueryParametersQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
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
     * @see QueryParameters::setDeleted()
     * @see QueryParameters::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParametersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildQueryParametersQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(QueryParametersTableMap::DATABASE_NAME);
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
                QueryParametersTableMap::addInstanceToPool($this);
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
        $this->modifiedColumns[QueryParametersTableMap::COL_QRP_ID] = true;
        if ($this->qrp_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . QueryParametersTableMap::COL_QRP_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ID)) {
            $modifiedColumns[':p' . $index++] = 'qrp_ID';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_QRY_ID)) {
            $modifiedColumns[':p' . $index++] = 'qrp_qry_ID';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_TYPE)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Type';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_OPTIONSQL)) {
            $modifiedColumns[':p' . $index++] = 'qrp_OptionSQL';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_NAME)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Name';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Description';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ALIAS)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Alias';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_DEFAULT)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Default';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_REQUIRED)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Required';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_INPUTBOXSIZE)) {
            $modifiedColumns[':p' . $index++] = 'qrp_InputBoxSize';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_VALIDATION)) {
            $modifiedColumns[':p' . $index++] = 'qrp_Validation';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_NUMERICMAX)) {
            $modifiedColumns[':p' . $index++] = 'qrp_NumericMax';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_NUMERICMIN)) {
            $modifiedColumns[':p' . $index++] = 'qrp_NumericMin';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH)) {
            $modifiedColumns[':p' . $index++] = 'qrp_AlphaMinLength';
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH)) {
            $modifiedColumns[':p' . $index++] = 'qrp_AlphaMaxLength';
        }

        $sql = sprintf(
            'INSERT INTO queryparameters_qrp (%s) VALUES (%s)',
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
                    case 'qrp_ID':
                        $stmt->bindValue($identifier, $this->qrp_id, PDO::PARAM_INT);

                        break;
                    case 'qrp_qry_ID':
                        $stmt->bindValue($identifier, $this->qrp_qry_id, PDO::PARAM_INT);

                        break;
                    case 'qrp_Type':
                        $stmt->bindValue($identifier, $this->qrp_type, PDO::PARAM_INT);

                        break;
                    case 'qrp_OptionSQL':
                        $stmt->bindValue($identifier, $this->qrp_optionsql, PDO::PARAM_STR);

                        break;
                    case 'qrp_Name':
                        $stmt->bindValue($identifier, $this->qrp_name, PDO::PARAM_STR);

                        break;
                    case 'qrp_Description':
                        $stmt->bindValue($identifier, $this->qrp_description, PDO::PARAM_STR);

                        break;
                    case 'qrp_Alias':
                        $stmt->bindValue($identifier, $this->qrp_alias, PDO::PARAM_STR);

                        break;
                    case 'qrp_Default':
                        $stmt->bindValue($identifier, $this->qrp_default, PDO::PARAM_STR);

                        break;
                    case 'qrp_Required':
                        $stmt->bindValue($identifier, $this->qrp_required, PDO::PARAM_INT);

                        break;
                    case 'qrp_InputBoxSize':
                        $stmt->bindValue($identifier, $this->qrp_inputboxsize, PDO::PARAM_INT);

                        break;
                    case 'qrp_Validation':
                        $stmt->bindValue($identifier, $this->qrp_validation, PDO::PARAM_STR);

                        break;
                    case 'qrp_NumericMax':
                        $stmt->bindValue($identifier, $this->qrp_numericmax, PDO::PARAM_INT);

                        break;
                    case 'qrp_NumericMin':
                        $stmt->bindValue($identifier, $this->qrp_numericmin, PDO::PARAM_INT);

                        break;
                    case 'qrp_AlphaMinLength':
                        $stmt->bindValue($identifier, $this->qrp_alphaminlength, PDO::PARAM_INT);

                        break;
                    case 'qrp_AlphaMaxLength':
                        $stmt->bindValue($identifier, $this->qrp_alphamaxlength, PDO::PARAM_INT);

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
        $pos = QueryParametersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getQryId(),
            2 => $this->getType(),
            3 => $this->getOptionSQL(),
            4 => $this->getName(),
            5 => $this->getDescription(),
            6 => $this->getAlias(),
            7 => $this->getDefault(),
            8 => $this->getRequired(),
            9 => $this->getInputBoxSize(),
            10 => $this->getValidation(),
            11 => $this->getNumericMax(),
            12 => $this->getNumericMin(),
            13 => $this->getAlphaMinLength(),
            14 => $this->getAlphaMaxLength(),
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
        if (isset($alreadyDumpedObjects['QueryParameters'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['QueryParameters'][$this->hashCode()] = true;
        $keys = QueryParametersTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getQryId(),
            $keys[2] => $this->getType(),
            $keys[3] => $this->getOptionSQL(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getDescription(),
            $keys[6] => $this->getAlias(),
            $keys[7] => $this->getDefault(),
            $keys[8] => $this->getRequired(),
            $keys[9] => $this->getInputBoxSize(),
            $keys[10] => $this->getValidation(),
            $keys[11] => $this->getNumericMax(),
            $keys[12] => $this->getNumericMin(),
            $keys[13] => $this->getAlphaMinLength(),
            $keys[14] => $this->getAlphaMaxLength(),
        ];
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
        $pos = QueryParametersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setQryId($value);

                break;
            case 2:
                $this->setType($value);

                break;
            case 3:
                $this->setOptionSQL($value);

                break;
            case 4:
                $this->setName($value);

                break;
            case 5:
                $this->setDescription($value);

                break;
            case 6:
                $this->setAlias($value);

                break;
            case 7:
                $this->setDefault($value);

                break;
            case 8:
                $this->setRequired($value);

                break;
            case 9:
                $this->setInputBoxSize($value);

                break;
            case 10:
                $this->setValidation($value);

                break;
            case 11:
                $this->setNumericMax($value);

                break;
            case 12:
                $this->setNumericMin($value);

                break;
            case 13:
                $this->setAlphaMinLength($value);

                break;
            case 14:
                $this->setAlphaMaxLength($value);

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
        $keys = QueryParametersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setQryId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setOptionSQL($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDescription($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAlias($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setDefault($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setRequired($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setInputBoxSize($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setValidation($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setNumericMax($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setNumericMin($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setAlphaMinLength($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setAlphaMaxLength($arr[$keys[14]]);
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
        $tableMap = QueryParametersTableMap::getTableMap();
        $criteria = new Criteria(QueryParametersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_ID'), $this->qrp_id);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_QRY_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_qry_ID'), $this->qrp_qry_id);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_TYPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Type'), $this->qrp_type);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_OPTIONSQL)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_OptionSQL'), $this->qrp_optionsql);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Name'), $this->qrp_name);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_DESCRIPTION)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Description'), $this->qrp_description);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ALIAS)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Alias'), $this->qrp_alias);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_DEFAULT)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Default'), $this->qrp_default);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_REQUIRED)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Required'), $this->qrp_required);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_INPUTBOXSIZE)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_InputBoxSize'), $this->qrp_inputboxsize);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_VALIDATION)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_Validation'), $this->qrp_validation);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_NUMERICMAX)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_NumericMax'), $this->qrp_numericmax);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_NUMERICMIN)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_NumericMin'), $this->qrp_numericmin);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ALPHAMINLENGTH)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_AlphaMinLength'), $this->qrp_alphaminlength);
        }
        if ($this->isColumnModified(QueryParametersTableMap::COL_QRP_ALPHAMAXLENGTH)) {
            $criteria->setUpdateValue($tableMap->getColumn('qrp_AlphaMaxLength'), $this->qrp_alphamaxlength);
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
        $tableMap = QueryParametersTableMap::getTableMap();
        $query = ChildQueryParametersQuery::create();
        $qrp_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('qrp_ID'));
        $query->addAnd($qrp_IDColumn, $this->qrp_id);

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
     * Generic method to set the primary key (qrp_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\QueryParameters (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setQryId($this->getQryId());
        $copyObj->setType($this->getType());
        $copyObj->setOptionSQL($this->getOptionSQL());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setDefault($this->getDefault());
        $copyObj->setRequired($this->getRequired());
        $copyObj->setInputBoxSize($this->getInputBoxSize());
        $copyObj->setValidation($this->getValidation());
        $copyObj->setNumericMax($this->getNumericMax());
        $copyObj->setNumericMin($this->getNumericMin());
        $copyObj->setAlphaMinLength($this->getAlphaMinLength());
        $copyObj->setAlphaMaxLength($this->getAlphaMaxLength());
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
        $this->qrp_id = null;
        $this->qrp_qry_id = null;
        $this->qrp_type = null;
        $this->qrp_optionsql = null;
        $this->qrp_name = null;
        $this->qrp_description = null;
        $this->qrp_alias = null;
        $this->qrp_default = null;
        $this->qrp_required = null;
        $this->qrp_inputboxsize = null;
        $this->qrp_validation = null;
        $this->qrp_numericmax = null;
        $this->qrp_numericmin = null;
        $this->qrp_alphaminlength = null;
        $this->qrp_alphamaxlength = null;
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
        return (string)$this->exportTo(QueryParametersTableMap::DEFAULT_STRING_FORMAT);
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
