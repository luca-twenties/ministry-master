<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection;
use ChurchCRM\model\ChurchCRM\EventAudience as ChildEventAudience;
use ChurchCRM\model\ChurchCRM\EventAudienceQuery as ChildEventAudienceQuery;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\EventTypeQuery as ChildEventTypeQuery;
use ChurchCRM\model\ChurchCRM\GroupQuery as ChildGroupQuery;
use ChurchCRM\model\ChurchCRM\ListOptionQuery as ChildListOptionQuery;
use ChurchCRM\model\ChurchCRM\Map\GroupTableMap;
use ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery as ChildPerson2group2roleP2g2rQuery;
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
 * Base class that represents a row from the 'group_grp' table.
 *
 * This contains the name and description for each group, as well as foreign keys to the list of group roles
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Group implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\GroupTableMap';

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
     * The value for the grp_id field.
     */
    protected int|null $grp_id = null;

    /**
     * The value for the grp_type field.
     *
     * The group type.  This is defined in list_lst.OptionId where lst_ID=3
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $grp_type = null;

    /**
     * The value for the grp_rolelistid field.
     *
     * The lst_ID containing the names of the roles for this group
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $grp_rolelistid = null;

    /**
     * The value for the grp_defaultrole field.
     *
     * The ID of the default role in this group's RoleList
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $grp_defaultrole = null;

    /**
     * The value for the grp_name field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $grp_name = null;

    /**
     * The value for the grp_description field.
     */
    protected string|null $grp_description = null;

    /**
     * The value for the grp_hasspecialprops field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $grp_hasspecialprops = null;

    /**
     * The value for the grp_active field.
     */
    protected bool|null $grp_active = null;

    /**
     * The value for the grp_include_email_export field.
     *
     * Should members of this group be included in MailChimp Export
     */
    protected bool|null $grp_include_email_export = null;

    /**
     * ListOption associated via ListOption relation (n:1).
     */
    protected ListOption|null $aListOption = null;

    /**
     * Objects associated via Person2group2roleP2g2r relation (1:n).
     */
    protected Person2group2roleP2g2rCollection|null $collPerson2group2roleP2g2rs = null;

    /**
     * If $collPerson2group2roleP2g2rs contains all objects in Person2group2roleP2g2r relation.
     */
    protected bool $collPerson2group2roleP2g2rsPartial = false;

    /**
     * Objects associated via EventType relation (1:n).
     */
    protected EventTypeCollection|null $collEventTypes = null;

    /**
     * If $collEventTypes contains all objects in EventType relation.
     */
    protected bool $collEventTypesPartial = false;

    /**
     * Objects associated via EventAudience relation (1:n).
     */
    protected EventAudienceCollection|null $collEventAudiences = null;

    /**
     * If $collEventAudiences contains all objects in EventAudience relation.
     */
    protected bool $collEventAudiencesPartial = false;

    /**
     * Objects associated via Event relation (n:m).
     */
    protected EventCollection|null $collEvents = null;

    /**
     * If $collEvents contains all objects in Event relation.
     */
    protected bool $collEventsIsPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of Event relation marked for deletion.
     */
    protected EventCollection|null $eventsScheduledForDeletion = null;

    /**
     * Items of Person2group2roleP2g2rs relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r>|null
     */
    protected ObjectCollection|null $person2group2roleP2g2rsScheduledForDeletion = null;

    /**
     * Items of EventTypes relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventType>|null
     */
    protected ObjectCollection|null $eventTypesScheduledForDeletion = null;

    /**
     * Items of EventAudiences relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAudience>|null
     */
    protected ObjectCollection|null $eventAudiencesScheduledForDeletion = null;

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
        $this->grp_type = 0;
        $this->grp_rolelistid = 0;
        $this->grp_defaultrole = 0;
        $this->grp_name = '';
        $this->grp_hasspecialprops = false;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Group object.
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
     * Compares this with another <code>Group</code> instance. If
     * <code>obj</code> is an instance of <code>Group</code>, delegates to
     * <code>equals(Group)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [grp_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->grp_id;
    }

    /**
     * Get the [grp_type] column value.
     *
     * The group type.  This is defined in list_lst.OptionId where lst_ID=3
     *
     * @return int|null
     */
    public function getType()
    {
        return $this->grp_type;
    }

    /**
     * Get the [grp_rolelistid] column value.
     *
     * The lst_ID containing the names of the roles for this group
     *
     * @return int|null
     */
    public function getRoleListId()
    {
        return $this->grp_rolelistid;
    }

    /**
     * Get the [grp_defaultrole] column value.
     *
     * The ID of the default role in this group's RoleList
     *
     * @return int|null
     */
    public function getDefaultRole()
    {
        return $this->grp_defaultrole;
    }

    /**
     * Get the [grp_name] column value.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->grp_name;
    }

    /**
     * Get the [grp_description] column value.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->grp_description;
    }

    /**
     * Get the [grp_hasspecialprops] column value.
     *
     * @return bool|null
     */
    public function getHasSpecialProps()
    {
        return $this->grp_hasspecialprops;
    }

    /**
     * Get the [grp_hasspecialprops] column value.
     *
     * @return bool|null
     */
    public function hasSpecialProps()
    {
        return $this->getHasSpecialProps();
    }

    /**
     * Get the [grp_active] column value.
     *
     * @return bool|null
     */
    public function getActive()
    {
        return $this->grp_active;
    }

    /**
     * Get the [grp_active] column value.
     *
     * @return bool|null
     */
    public function isActive()
    {
        return $this->getActive();
    }

    /**
     * Get the [grp_include_email_export] column value.
     *
     * Should members of this group be included in MailChimp Export
     *
     * @return bool|null
     */
    public function getIncludeInEmailExport()
    {
        return $this->grp_include_email_export;
    }

    /**
     * Get the [grp_include_email_export] column value.
     *
     * Should members of this group be included in MailChimp Export
     *
     * @return bool|null
     */
    public function isIncludeInEmailExport()
    {
        return $this->getIncludeInEmailExport();
    }

    /**
     * Set the value of [grp_id] column.
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

        if ($this->grp_id !== $v) {
            $this->grp_id = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [grp_type] column.
     *
     * The group type.  This is defined in list_lst.OptionId where lst_ID=3
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

        if ($this->grp_type !== $v) {
            $this->grp_type = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_TYPE] = true;
        }

        if ($this->aListOption !== null && $this->aListOption->getOptionId() !== $v) {
            $this->aListOption = null;
        }

        return $this;
    }

    /**
     * Set the value of [grp_rolelistid] column.
     *
     * The lst_ID containing the names of the roles for this group
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setRoleListId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->grp_rolelistid !== $v) {
            $this->grp_rolelistid = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_ROLELISTID] = true;
        }

        if ($this->aListOption !== null && $this->aListOption->getId() !== $v) {
            $this->aListOption = null;
        }

        return $this;
    }

    /**
     * Set the value of [grp_defaultrole] column.
     *
     * The ID of the default role in this group's RoleList
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setDefaultRole($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->grp_defaultrole !== $v) {
            $this->grp_defaultrole = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_DEFAULTROLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [grp_name] column.
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

        if ($this->grp_name !== $v) {
            $this->grp_name = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [grp_description] column.
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

        if ($this->grp_description !== $v) {
            $this->grp_description = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_DESCRIPTION] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [grp_hasspecialprops] column.
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
    public function setHasSpecialProps($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->grp_hasspecialprops !== $v) {
            $this->grp_hasspecialprops = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_HASSPECIALPROPS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [grp_active] column.
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
    public function setActive($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->grp_active !== $v) {
            $this->grp_active = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_ACTIVE] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [grp_include_email_export] column.
     *
     * Non-boolean arguments are converted using the following rules:
     * - 1, '1', 'true', 'on', 'yes' are converted to boolean true
     * - 0, '0', 'false', 'off', 'no' are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * Should members of this group be included in MailChimp Export
     *
     * @param string|int|bool|null $v The new value
     *
     * @return $this
     */
    public function setIncludeInEmailExport($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->grp_include_email_export !== $v) {
            $this->grp_include_email_export = $v;
            $this->modifiedColumns[GroupTableMap::COL_GRP_INCLUDE_EMAIL_EXPORT] = true;
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
        if ($this->grp_type !== 0) {
            return false;
        }

        if ($this->grp_rolelistid !== 0) {
            return false;
        }

        if ($this->grp_defaultrole !== 0) {
            return false;
        }

        if ($this->grp_name !== '') {
            return false;
        }

        if ($this->grp_hasspecialprops !== false) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : GroupTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : GroupTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_type = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : GroupTableMap::translateFieldName('RoleListId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_rolelistid = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : GroupTableMap::translateFieldName('DefaultRole', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_defaultrole = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : GroupTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : GroupTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_description = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : GroupTableMap::translateFieldName('HasSpecialProps', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_hasspecialprops = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : GroupTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_active = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : GroupTableMap::translateFieldName('IncludeInEmailExport', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->grp_include_email_export = $columnValue !== null ? (bool)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Group object', 0, $e);
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
        if ($this->aListOption !== null && $this->grp_type !== $this->aListOption->getOptionId()) {
            $this->aListOption = null;
        }
        if ($this->aListOption !== null && $this->grp_rolelistid !== $this->aListOption->getId()) {
            $this->aListOption = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(GroupTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildGroupQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aListOption = null;
            $this->collPerson2group2roleP2g2rs = null;
            $this->collEventTypes = null;
            $this->collEventAudiences = null;
            $this->collEvents = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Group::setDeleted()
     * @see Group::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildGroupQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
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
                GroupTableMap::addInstanceToPool($this);
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

        if ($this->aListOption !== null) {
            if ($this->aListOption->isModified() || $this->aListOption->isNew()) {
                $affectedRows += $this->aListOption->save($con);
            }
            $this->setListOption($this->aListOption);
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

        if ($this->eventsScheduledForDeletion !== null && !$this->eventsScheduledForDeletion->isEmpty()) {
            $pks = [];
            foreach ($this->eventsScheduledForDeletion as $entry) {
                $entryPk = [];

                $entryPk[1] = $this->getId();
                $entryPk[0] = $entry->getId();
                $pks[] = $entryPk;
            }

            ChildEventAudienceQuery::create()
                ->filterByPrimaryKeys($pks)
                ->delete($con);

            $this->eventsScheduledForDeletion = null;
        }

        if ($this->collEvents) {
            foreach ($this->collEvents as $event) {
                if (!$event->isDeleted() && ($event->isNew() || $event->isModified())) {
                    $event->save($con);
                }
            }
        }

        if ($this->person2group2roleP2g2rsScheduledForDeletion !== null) {
            if (!$this->person2group2roleP2g2rsScheduledForDeletion->isEmpty()) {
                ChildPerson2group2roleP2g2rQuery::create()
                    ->filterByPrimaryKeys($this->person2group2roleP2g2rsScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->person2group2roleP2g2rsScheduledForDeletion = null;
            }
        }

        if ($this->collPerson2group2roleP2g2rs !== null) {
            foreach ($this->collPerson2group2roleP2g2rs as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->eventTypesScheduledForDeletion !== null) {
            if (!$this->eventTypesScheduledForDeletion->isEmpty()) {
                foreach ($this->eventTypesScheduledForDeletion as $eventType) {
                    // need to save related object because we set the relation to null
                    $eventType->save($con);
                }
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

        if ($this->eventAudiencesScheduledForDeletion !== null) {
            if (!$this->eventAudiencesScheduledForDeletion->isEmpty()) {
                ChildEventAudienceQuery::create()
                    ->filterByPrimaryKeys($this->eventAudiencesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->eventAudiencesScheduledForDeletion = null;
            }
        }

        if ($this->collEventAudiences !== null) {
            foreach ($this->collEventAudiences as $referrerFK) {
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
        $this->modifiedColumns[GroupTableMap::COL_GRP_ID] = true;
        if ($this->grp_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . GroupTableMap::COL_GRP_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(GroupTableMap::COL_GRP_ID)) {
            $modifiedColumns[':p' . $index++] = 'grp_ID';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_TYPE)) {
            $modifiedColumns[':p' . $index++] = 'grp_Type';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_ROLELISTID)) {
            $modifiedColumns[':p' . $index++] = 'grp_RoleListID';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_DEFAULTROLE)) {
            $modifiedColumns[':p' . $index++] = 'grp_DefaultRole';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_NAME)) {
            $modifiedColumns[':p' . $index++] = 'grp_Name';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++] = 'grp_Description';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_HASSPECIALPROPS)) {
            $modifiedColumns[':p' . $index++] = 'grp_hasSpecialProps';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_ACTIVE)) {
            $modifiedColumns[':p' . $index++] = 'grp_active';
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_INCLUDE_EMAIL_EXPORT)) {
            $modifiedColumns[':p' . $index++] = 'grp_include_email_export';
        }

        $sql = sprintf(
            'INSERT INTO group_grp (%s) VALUES (%s)',
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
                    case 'grp_ID':
                        $stmt->bindValue($identifier, $this->grp_id, PDO::PARAM_INT);

                        break;
                    case 'grp_Type':
                        $stmt->bindValue($identifier, $this->grp_type, PDO::PARAM_INT);

                        break;
                    case 'grp_RoleListID':
                        $stmt->bindValue($identifier, $this->grp_rolelistid, PDO::PARAM_INT);

                        break;
                    case 'grp_DefaultRole':
                        $stmt->bindValue($identifier, $this->grp_defaultrole, PDO::PARAM_INT);

                        break;
                    case 'grp_Name':
                        $stmt->bindValue($identifier, $this->grp_name, PDO::PARAM_STR);

                        break;
                    case 'grp_Description':
                        $stmt->bindValue($identifier, $this->grp_description, PDO::PARAM_STR);

                        break;
                    case 'grp_hasSpecialProps':
                        $stmt->bindValue($identifier, (int)$this->grp_hasspecialprops, PDO::PARAM_INT);

                        break;
                    case 'grp_active':
                        $stmt->bindValue($identifier, (int)$this->grp_active, PDO::PARAM_INT);

                        break;
                    case 'grp_include_email_export':
                        $stmt->bindValue($identifier, (int)$this->grp_include_email_export, PDO::PARAM_INT);

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
        $pos = GroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getType(),
            2 => $this->getRoleListId(),
            3 => $this->getDefaultRole(),
            4 => $this->getName(),
            5 => $this->getDescription(),
            6 => $this->getHasSpecialProps(),
            7 => $this->getActive(),
            8 => $this->getIncludeInEmailExport(),
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
        if (isset($alreadyDumpedObjects['Group'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Group'][$this->hashCode()] = true;
        $keys = GroupTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getType(),
            $keys[2] => $this->getRoleListId(),
            $keys[3] => $this->getDefaultRole(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getDescription(),
            $keys[6] => $this->getHasSpecialProps(),
            $keys[7] => $this->getActive(),
            $keys[8] => $this->getIncludeInEmailExport(),
        ];
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aListOption !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'listOption',
                     TableMap::TYPE_FIELDNAME => 'list_lst',
                     default => 'ListOption',
                };
                $result[$key] = $this->aListOption->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collPerson2group2roleP2g2rs !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'person2group2roleP2g2rs',
                     TableMap::TYPE_FIELDNAME => 'person2group2role_p2g2rs',
                     default => 'Person2group2roleP2g2rs',
                };
                $result[$key] = $this->collPerson2group2roleP2g2rs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collEventTypes !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'eventTypes',
                     TableMap::TYPE_FIELDNAME => 'event_typess',
                     default => 'EventTypes',
                };
                $result[$key] = $this->collEventTypes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collEventAudiences !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'eventAudiences',
                     TableMap::TYPE_FIELDNAME => 'event_audiences',
                     default => 'EventAudiences',
                };
                $result[$key] = $this->collEventAudiences->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = GroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setType($value);

                break;
            case 2:
                $this->setRoleListId($value);

                break;
            case 3:
                $this->setDefaultRole($value);

                break;
            case 4:
                $this->setName($value);

                break;
            case 5:
                $this->setDescription($value);

                break;
            case 6:
                $this->setHasSpecialProps($value);

                break;
            case 7:
                $this->setActive($value);

                break;
            case 8:
                $this->setIncludeInEmailExport($value);

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
        $keys = GroupTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setType($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRoleListId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDefaultRole($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDescription($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHasSpecialProps($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setActive($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setIncludeInEmailExport($arr[$keys[8]]);
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
        $tableMap = GroupTableMap::getTableMap();
        $criteria = new Criteria(GroupTableMap::DATABASE_NAME);

        if ($this->isColumnModified(GroupTableMap::COL_GRP_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_ID'), $this->grp_id);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_TYPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_Type'), $this->grp_type);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_ROLELISTID)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_RoleListID'), $this->grp_rolelistid);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_DEFAULTROLE)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_DefaultRole'), $this->grp_defaultrole);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_Name'), $this->grp_name);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_DESCRIPTION)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_Description'), $this->grp_description);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_HASSPECIALPROPS)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_hasSpecialProps'), $this->grp_hasspecialprops);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_ACTIVE)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_active'), $this->grp_active);
        }
        if ($this->isColumnModified(GroupTableMap::COL_GRP_INCLUDE_EMAIL_EXPORT)) {
            $criteria->setUpdateValue($tableMap->getColumn('grp_include_email_export'), $this->grp_include_email_export);
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
        $tableMap = GroupTableMap::getTableMap();
        $query = ChildGroupQuery::create();
        $grp_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('grp_ID'));
        $query->addAnd($grp_IDColumn, $this->grp_id);

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
     * Generic method to set the primary key (grp_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Group (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setType($this->getType());
        $copyObj->setRoleListId($this->getRoleListId());
        $copyObj->setDefaultRole($this->getDefaultRole());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setHasSpecialProps($this->getHasSpecialProps());
        $copyObj->setActive($this->getActive());
        $copyObj->setIncludeInEmailExport($this->getIncludeInEmailExport());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPerson2group2roleP2g2rs() as $relObj) {
                $copyObj->addPerson2group2roleP2g2r($relObj->copy($deepCopy));
            }
            foreach ($this->getEventTypes() as $relObj) {
                $copyObj->addEventType($relObj->copy($deepCopy));
            }
            foreach ($this->getEventAudiences() as $relObj) {
                $copyObj->addEventAudience($relObj->copy($deepCopy));
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
     * Declares an association between this object and a ListOption object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\ListOption|null $listOption
     *
     * @return $this
     */
    public function setListOption(?ListOption $listOption = null)
    {
        $roleListId = $listOption ? $listOption->getId() : 0;
        $this->setRoleListId($roleListId);
        $type = $listOption ? $listOption->getOptionId() : 0;
        $this->setType($type);

        $this->aListOption = $listOption;
        $listOption?->addGroup($this);

        return $this;
    }

    /**
     * Get the associated ListOption object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\ListOption|null
     */
    public function getListOption(?ConnectionInterface $con = null)
    {
        if ($this->aListOption === null && ($this->grp_rolelistid !== null && $this->grp_rolelistid !== 0 && $this->grp_type !== null && $this->grp_type !== 0)) {
            $this->aListOption = ChildListOptionQuery::create()->findPk([$this->grp_rolelistid, $this->grp_type], $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aListOption->addGroups($this);
             */
        }

        return $this->aListOption;
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
            'Person2group2roleP2g2r' => $this->initPerson2group2roleP2g2rs(),
            'EventType' => $this->initEventTypes(),
            'EventAudience' => $this->initEventAudiences(),
            default => null
        };
    }

    /**
     * Initializes the collPerson2group2roleP2g2rs collection.
     *
     * By default this just sets the collPerson2group2roleP2g2rs collection to an empty array (like clearcollPerson2group2roleP2g2rs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPerson2group2roleP2g2rs(bool $overrideExisting = true): void
    {
        if ($this->collPerson2group2roleP2g2rs !== null && !$overrideExisting) {
            return;
        }

        $this->collPerson2group2roleP2g2rs = new Person2group2roleP2g2rCollection();
        $this->collPerson2group2roleP2g2rs->setModel('\ChurchCRM\model\ChurchCRM\Person2group2roleP2g2r');
    }

    /**
     * Reset is the collPerson2group2roleP2g2rs collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialPerson2group2roleP2g2rs(bool $isPartial = true): void
    {
        $this->collPerson2group2roleP2g2rsPartial = $isPartial;
    }

    /**
     * Clears out the collPerson2group2roleP2g2rs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearPerson2group2roleP2g2rs(): static
    {
        $this->collPerson2group2roleP2g2rs = null;

        return $this;
    }

    /**
     * Gets group_grp objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Group is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection
     */
    public function getPerson2group2roleP2g2rs(?Criteria $criteria = null, ?ConnectionInterface $con = null): Person2group2roleP2g2rCollection
    {
        $partial = $this->collPerson2group2roleP2g2rsPartial && !$this->isNew();
        if ($this->collPerson2group2roleP2g2rs && !$criteria && !$partial) {
            return $this->collPerson2group2roleP2g2rs;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collPerson2group2roleP2g2rs === null) {
                $this->initPerson2group2roleP2g2rs();

                return $this->collPerson2group2roleP2g2rs;
            }

            $collPerson2group2roleP2g2rs = new Person2group2roleP2g2rCollection();
            $collPerson2group2roleP2g2rs->setModel('\ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r');

            return $collPerson2group2roleP2g2rs;
        }

        $collPerson2group2roleP2g2rs = ChildPerson2group2roleP2g2rQuery::create(null, $criteria)
            ->filterByGroup($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collPerson2group2roleP2g2rsPartial !== false && count($collPerson2group2roleP2g2rs)) {
                $this->initPerson2group2roleP2g2rs(false);

                foreach ($collPerson2group2roleP2g2rs as $obj) {
                    if (!$this->collPerson2group2roleP2g2rs->contains($obj)) {
                        $this->collPerson2group2roleP2g2rs->append($obj);
                    }
                }

                $this->collPerson2group2roleP2g2rsPartial = true;
            }

            return $collPerson2group2roleP2g2rs;
        }

        if ($this->collPerson2group2roleP2g2rsPartial && $this->collPerson2group2roleP2g2rs) {
            foreach ($this->collPerson2group2roleP2g2rs as $obj) {
                if ($obj->isNew()) {
                    $collPerson2group2roleP2g2rs[] = $obj;
                }
            }
        }

        $this->collPerson2group2roleP2g2rs = $collPerson2group2roleP2g2rs;
        $this->collPerson2group2roleP2g2rsPartial = false;

        return $this->collPerson2group2roleP2g2rs;
    }

    /**
     * Sets a collection of group_grp objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r> $person2group2roleP2g2rs
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setPerson2group2roleP2g2rs(Collection $person2group2roleP2g2rs, ?ConnectionInterface $con = null): static
    {
        $person2group2roleP2g2rsToDelete = $this->getPerson2group2roleP2g2rs(null, $con)->diff($person2group2roleP2g2rs);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->person2group2roleP2g2rsScheduledForDeletion = clone $person2group2roleP2g2rsToDelete;

        foreach ($person2group2roleP2g2rsToDelete as $person2group2roleP2g2rRemoved) {
            $person2group2roleP2g2rRemoved->setGroup(null);
        }

        $this->collPerson2group2roleP2g2rs = null;
        foreach ($person2group2roleP2g2rs as $person2group2roleP2g2r) {
            $this->addPerson2group2roleP2g2r($person2group2roleP2g2r);
        }

        $this->collPerson2group2roleP2g2rsPartial = false;
        $this->collPerson2group2roleP2g2rs = $person2group2roleP2g2rs instanceof Person2group2roleP2g2rCollection
            ? $person2group2roleP2g2rs : new Person2group2roleP2g2rCollection($person2group2roleP2g2rs->getData());

        return $this;
    }

    /**
     * Returns the number of related group_grp objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related group_grp objects.
     */
    public function countPerson2group2roleP2g2rs(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPerson2group2roleP2g2rsPartial && !$this->isNew();
        if ($this->collPerson2group2roleP2g2rs === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collPerson2group2roleP2g2rs === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPerson2group2roleP2g2rs());
            }

            $query = ChildPerson2group2roleP2g2rQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collPerson2group2roleP2g2rs);
    }

    /**
     * Method called to associate a Person2group2roleP2g2r object to this object
     * through the Person2group2roleP2g2r foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r $person2group2roleP2g2r
     *
     * @return $this
     */
    public function addPerson2group2roleP2g2r(Person2group2roleP2g2r $person2group2roleP2g2r)
    {
        if ($this->collPerson2group2roleP2g2rs === null) {
            $this->initPerson2group2roleP2g2rs();
            $this->collPerson2group2roleP2g2rsPartial = true;
        }

        if (!$this->collPerson2group2roleP2g2rs->contains($person2group2roleP2g2r)) {
            $this->doAddPerson2group2roleP2g2r($person2group2roleP2g2r);

            if ($this->person2group2roleP2g2rsScheduledForDeletion && $this->person2group2roleP2g2rsScheduledForDeletion->contains($person2group2roleP2g2r)) {
                $this->person2group2roleP2g2rsScheduledForDeletion->remove($this->person2group2roleP2g2rsScheduledForDeletion->search($person2group2roleP2g2r));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r $person2group2roleP2g2r The Person2group2roleP2g2r object to add.
     *
     * @return void
     */
    protected function doAddPerson2group2roleP2g2r(Person2group2roleP2g2r $person2group2roleP2g2r): void
    {
        $this->collPerson2group2roleP2g2rs->append($person2group2roleP2g2r);
        $person2group2roleP2g2r->setGroup($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r $person2group2roleP2g2r The Person2group2roleP2g2r object to remove.
     *
     * @return static
     */
    public function removePerson2group2roleP2g2r(Person2group2roleP2g2r $person2group2roleP2g2r): static
    {
        if ($this->getPerson2group2roleP2g2rs()->contains($person2group2roleP2g2r)) {
            $pos = $this->collPerson2group2roleP2g2rs->search($person2group2roleP2g2r);
            $this->collPerson2group2roleP2g2rs->remove($pos);
            if ($this->person2group2roleP2g2rsScheduledForDeletion === null) {
                $this->person2group2roleP2g2rsScheduledForDeletion = clone $this->collPerson2group2roleP2g2rs;
                $this->person2group2roleP2g2rsScheduledForDeletion->clear();
            }
            $this->person2group2roleP2g2rsScheduledForDeletion->append(clone $person2group2roleP2g2r);
            $person2group2roleP2g2r->setGroup(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this group_grp is new, it will return
     * an empty collection; or if this group_grp has previously
     * been saved, it will retrieve related Person2group2roleP2g2rs from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection
     */
    public function getPerson2group2roleP2g2rsJoinPerson(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): Person2group2roleP2g2rCollection {
        $query = ChildPerson2group2roleP2g2rQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getPerson2group2roleP2g2rs($query, $con);
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

        $this->collEventTypes = new EventTypeCollection();
        $this->collEventTypes->setModel('\ChurchCRM\model\ChurchCRM\EventType');
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
     * Gets group_grp objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Group is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection
     */
    public function getEventTypes(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventTypeCollection
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

            $collEventTypes = new EventTypeCollection();
            $collEventTypes->setModel('\ChurchCRM\model\ChurchCRM\Base\EventType');

            return $collEventTypes;
        }

        $collEventTypes = ChildEventTypeQuery::create(null, $criteria)
            ->filterByGroup($this)
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
     * Sets a collection of group_grp objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventType> $eventTypes
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setEventTypes(Collection $eventTypes, ?ConnectionInterface $con = null): static
    {
        $eventTypesToDelete = $this->getEventTypes(null, $con)->diff($eventTypes);

        $this->eventTypesScheduledForDeletion = $eventTypesToDelete;

        foreach ($eventTypesToDelete as $eventTypeRemoved) {
            $eventTypeRemoved->setGroup(null);
        }

        $this->collEventTypes = null;
        foreach ($eventTypes as $eventType) {
            $this->addEventType($eventType);
        }

        $this->collEventTypesPartial = false;
        $this->collEventTypes = $eventTypes instanceof EventTypeCollection
            ? $eventTypes : new EventTypeCollection($eventTypes->getData());

        return $this;
    }

    /**
     * Returns the number of related group_grp objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related group_grp objects.
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

            $query = ChildEventTypeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collEventTypes);
    }

    /**
     * Method called to associate a EventType object to this object
     * through the EventType foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventType $eventType
     *
     * @return $this
     */
    public function addEventType(EventType $eventType)
    {
        if ($this->collEventTypes === null) {
            $this->initEventTypes();
            $this->collEventTypesPartial = true;
        }

        if (!$this->collEventTypes->contains($eventType)) {
            $this->doAddEventType($eventType);

            if ($this->eventTypesScheduledForDeletion && $this->eventTypesScheduledForDeletion->contains($eventType)) {
                $this->eventTypesScheduledForDeletion->remove($this->eventTypesScheduledForDeletion->search($eventType));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\EventType $eventType The EventType object to add.
     *
     * @return void
     */
    protected function doAddEventType(EventType $eventType): void
    {
        $this->collEventTypes->append($eventType);
        $eventType->setGroup($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\EventType $eventType The EventType object to remove.
     *
     * @return static
     */
    public function removeEventType(EventType $eventType): static
    {
        if ($this->getEventTypes()->contains($eventType)) {
            $pos = $this->collEventTypes->search($eventType);
            $this->collEventTypes->remove($pos);
            if ($this->eventTypesScheduledForDeletion === null) {
                $this->eventTypesScheduledForDeletion = clone $this->collEventTypes;
                $this->eventTypesScheduledForDeletion->clear();
            }
            $this->eventTypesScheduledForDeletion->append($eventType);
            $eventType->setGroup(null);
        }

        return $this;
    }

    /**
     * Initializes the collEventAudiences collection.
     *
     * By default this just sets the collEventAudiences collection to an empty array (like clearcollEventAudiences());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventAudiences(bool $overrideExisting = true): void
    {
        if ($this->collEventAudiences !== null && !$overrideExisting) {
            return;
        }

        $this->collEventAudiences = new EventAudienceCollection();
        $this->collEventAudiences->setModel('\ChurchCRM\model\ChurchCRM\EventAudience');
    }

    /**
     * Reset is the collEventAudiences collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialEventAudiences(bool $isPartial = true): void
    {
        $this->collEventAudiencesPartial = $isPartial;
    }

    /**
     * Clears out the collEventAudiences collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearEventAudiences(): static
    {
        $this->collEventAudiences = null;

        return $this;
    }

    /**
     * Gets group_grp objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Group is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection
     */
    public function getEventAudiences(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventAudienceCollection
    {
        $partial = $this->collEventAudiencesPartial && !$this->isNew();
        if ($this->collEventAudiences && !$criteria && !$partial) {
            return $this->collEventAudiences;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collEventAudiences === null) {
                $this->initEventAudiences();

                return $this->collEventAudiences;
            }

            $collEventAudiences = new EventAudienceCollection();
            $collEventAudiences->setModel('\ChurchCRM\model\ChurchCRM\Base\EventAudience');

            return $collEventAudiences;
        }

        $collEventAudiences = ChildEventAudienceQuery::create(null, $criteria)
            ->filterByGroup($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collEventAudiencesPartial !== false && count($collEventAudiences)) {
                $this->initEventAudiences(false);

                foreach ($collEventAudiences as $obj) {
                    if (!$this->collEventAudiences->contains($obj)) {
                        $this->collEventAudiences->append($obj);
                    }
                }

                $this->collEventAudiencesPartial = true;
            }

            return $collEventAudiences;
        }

        if ($this->collEventAudiencesPartial && $this->collEventAudiences) {
            foreach ($this->collEventAudiences as $obj) {
                if ($obj->isNew()) {
                    $collEventAudiences[] = $obj;
                }
            }
        }

        $this->collEventAudiences = $collEventAudiences;
        $this->collEventAudiencesPartial = false;

        return $this->collEventAudiences;
    }

    /**
     * Sets a collection of group_grp objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventAudience> $eventAudiences
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setEventAudiences(Collection $eventAudiences, ?ConnectionInterface $con = null): static
    {
        $eventAudiencesToDelete = $this->getEventAudiences(null, $con)->diff($eventAudiences);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->eventAudiencesScheduledForDeletion = clone $eventAudiencesToDelete;

        foreach ($eventAudiencesToDelete as $eventAudienceRemoved) {
            $eventAudienceRemoved->setGroup(null);
        }

        $this->collEventAudiences = null;
        foreach ($eventAudiences as $eventAudience) {
            $this->addEventAudience($eventAudience);
        }

        $this->collEventAudiencesPartial = false;
        $this->collEventAudiences = $eventAudiences instanceof EventAudienceCollection
            ? $eventAudiences : new EventAudienceCollection($eventAudiences->getData());

        return $this;
    }

    /**
     * Returns the number of related group_grp objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related group_grp objects.
     */
    public function countEventAudiences(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collEventAudiencesPartial && !$this->isNew();
        if ($this->collEventAudiences === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collEventAudiences === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventAudiences());
            }

            $query = ChildEventAudienceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByGroup($this)
                ->count($con);
        }

        return count($this->collEventAudiences);
    }

    /**
     * Method called to associate a EventAudience object to this object
     * through the EventAudience foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAudience $eventAudience
     *
     * @return $this
     */
    public function addEventAudience(EventAudience $eventAudience)
    {
        if ($this->collEventAudiences === null) {
            $this->initEventAudiences();
            $this->collEventAudiencesPartial = true;
        }

        if (!$this->collEventAudiences->contains($eventAudience)) {
            $this->doAddEventAudience($eventAudience);

            if ($this->eventAudiencesScheduledForDeletion && $this->eventAudiencesScheduledForDeletion->contains($eventAudience)) {
                $this->eventAudiencesScheduledForDeletion->remove($this->eventAudiencesScheduledForDeletion->search($eventAudience));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAudience $eventAudience The EventAudience object to add.
     *
     * @return void
     */
    protected function doAddEventAudience(EventAudience $eventAudience): void
    {
        $this->collEventAudiences->append($eventAudience);
        $eventAudience->setGroup($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAudience $eventAudience The EventAudience object to remove.
     *
     * @return static
     */
    public function removeEventAudience(EventAudience $eventAudience): static
    {
        if ($this->getEventAudiences()->contains($eventAudience)) {
            $pos = $this->collEventAudiences->search($eventAudience);
            $this->collEventAudiences->remove($pos);
            if ($this->eventAudiencesScheduledForDeletion === null) {
                $this->eventAudiencesScheduledForDeletion = clone $this->collEventAudiences;
                $this->eventAudiencesScheduledForDeletion->clear();
            }
            $this->eventAudiencesScheduledForDeletion->append(clone $eventAudience);
            $eventAudience->setGroup(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this group_grp is new, it will return
     * an empty collection; or if this group_grp has previously
     * been saved, it will retrieve related EventAudiences from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection
     */
    public function getEventAudiencesJoinEvent(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventAudienceCollection {
        $query = ChildEventAudienceQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getEventAudiences($query, $con);
    }

    /**
     * Clears out the collEvents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     */
    public function clearEvents(): void
    {
        $this->collEvents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collEvents crossRef collection.
     *
     * By default this just sets the collEvents collection to an empty collection (like clearEvents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initEvents(): void
    {
        $this->collEvents = new EventCollection();
        $this->collEventsIsPartial = true;
        $this->collEvents->setModel('\ChurchCRM\model\ChurchCRM\Event');
    }

    /**
     * Checks if the collEvents collection is loaded.
     *
     * @return bool
     */
    public function isEventsLoaded(): bool
    {
        return $this->collEvents !== null;
    }

    /**
     * Gets a collection of Event objects related by a many-to-many relationship
     * to the current object by way of the event_audience cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Group is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional query object to filter the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getEvents(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        $partial = $this->collEventsIsPartial && !$this->isNew();
        if ($this->collEvents === null || $criteria !== null || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if ($this->collEvents === null) {
                    $this->initEvents();
                }
            } else {
                $query = ChildEventQuery::create(null, $criteria)
                    ->filterByGroup($this);
                $collEvents = $query->findObjects($con);
                if ($criteria !== null) {
                    return $collEvents;
                }

                if ($partial && $this->collEvents) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collEvents as $obj) {
                        if (!$collEvents->contains($obj)) {
                            $collEvents[] = $obj;
                        }
                    }
                }

                $this->collEvents = $collEvents;
                $this->collEventsIsPartial = false;
            }
        }

        return $this->collEvents;
    }

    /**
     * Sets a collection of Event objects related by a many-to-many relationship
     * to the current object by way of the event_audience cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Event> $events A Propel collection.
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return static
     */
    public function setEvents(Collection $events, ?ConnectionInterface $con = null): static
    {
        $this->clearEvents();
        $currentEvents = $this->getEvents();

        $eventsScheduledForDeletion = $currentEvents->diff($events);

        foreach ($eventsScheduledForDeletion as $toDelete) {
            $this->removeEvent($toDelete);
        }

        foreach ($events as $event) {
            if (!$currentEvents->contains($event)) {
                $this->doAddEvent($event);
            }
        }

        $this->collEventsIsPartial = false;
        $this->collEvents = $events instanceof EventCollection
            ? $events : new EventCollection($events->getData());

        return $this;
    }

    /**
     * Gets the number of Event objects related by a many-to-many relationship
     * to the current object by way of the event_audience cross-reference table.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return int The number of related Event objects
     */
    public function countEvents(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collEventsIsPartial && !$this->isNew();
        if ($this->collEvents && !$criteria && !$partial) {
            return count($this->collEvents);
        }

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
            ->filterByGroup($this)
            ->count($con);
    }

    /**
     * Associate a Event with this object through the event_audience cross reference table.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return static
     */
    public function addEvent(Event $event): static
    {
        if ($this->collEvents === null) {
            $this->initEvents();
        }

        if (!$this->getEvents()->contains($event)) {
            // only add it if the **same** object is not already associated
            $this->collEvents->push($event);
            $this->doAddEvent($event);
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return void
     */
    protected function doAddEvent(Event $event): void
    {
        $eventAudience = new ChildEventAudience();
        $eventAudience->setEvent($event);
        $eventAudience->setGroup($this);

        $this->addEventAudience($eventAudience);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$event->isGroupsLoaded()) {
            $event->initGroups();
            $event->getGroups()->push($this);
        } elseif (!$event->getGroups()->contains($this)) {
            $event->getGroups()->push($this);
        }
    }

    /**
     * Remove event of this object through the event_audience cross reference table.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return static
     */
    public function removeEvent(Event $event): static
    {
        if (!$this->getEvents()->contains($event)) {
            return $this;
        }

        $eventAudience = new ChildEventAudience();
        $eventAudience->setEvent($event);
        if ($event->isGroupsLoaded()) {
            //remove the back reference if available
            $event->getGroups()->removeObject($this);
        }

        $eventAudience->setGroup($this);
        $this->removeEventAudience(clone $eventAudience);
        $eventAudience->clear();

        $this->collEvents->remove($this->collEvents->search($event));

        if ($this->eventsScheduledForDeletion === null) {
            $this->eventsScheduledForDeletion = clone $this->collEvents;
            $this->eventsScheduledForDeletion->clear();
        }

        $this->eventsScheduledForDeletion->push($event);

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
        if ($this->aListOption !== null) {
            $this->aListOption->removeGroup($this);
        }
        $this->grp_id = null;
        $this->grp_type = null;
        $this->grp_rolelistid = null;
        $this->grp_defaultrole = null;
        $this->grp_name = null;
        $this->grp_description = null;
        $this->grp_hasspecialprops = null;
        $this->grp_active = null;
        $this->grp_include_email_export = null;
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
            if ($this->collPerson2group2roleP2g2rs) {
                foreach ($this->collPerson2group2roleP2g2rs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventTypes) {
                foreach ($this->collEventTypes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventAudiences) {
                foreach ($this->collEventAudiences as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEvents) {
                foreach ($this->collEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collPerson2group2roleP2g2rs = null;
        $this->collEventTypes = null;
        $this->collEventAudiences = null;
        $this->collEvents = null;
        $this->aListOption = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(GroupTableMap::DEFAULT_STRING_FORMAT);
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
