<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\UserConfigCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection;
use ChurchCRM\model\ChurchCRM\Map\UserTableMap;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
use ChurchCRM\model\ChurchCRM\UserConfigQuery as ChildUserConfigQuery;
use ChurchCRM\model\ChurchCRM\UserQuery as ChildUserQuery;
use ChurchCRM\model\ChurchCRM\UserSettingQuery as ChildUserSettingQuery;
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
 * Base class that represents a row from the 'user_usr' table.
 *
 * This contains the login information and specific settings for each ChurchCRM user
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\UserTableMap';

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
     * The value for the usr_per_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $usr_per_id = null;

    /**
     * The value for the usr_password field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $usr_password = null;

    /**
     * The value for the usr_needpasswordchange field.
     *
     * Note: this column has a database default value of: true
     */
    protected bool|null $usr_needpasswordchange = null;

    /**
     * The value for the usr_lastlogin field.
     *
     * Note: this column has a database default value of: '2016-01-01 00:00:00.000000'
     */
    protected DateTimeInterface|null $usr_lastlogin = null;

    /**
     * The value for the usr_logincount field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $usr_logincount = null;

    /**
     * The value for the usr_failedlogins field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $usr_failedlogins = null;

    /**
     * The value for the usr_addrecords field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_addrecords = null;

    /**
     * The value for the usr_editrecords field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_editrecords = null;

    /**
     * The value for the usr_deleterecords field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_deleterecords = null;

    /**
     * The value for the usr_menuoptions field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_menuoptions = null;

    /**
     * The value for the usr_managegroups field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_managegroups = null;

    /**
     * The value for the usr_finance field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_finance = null;

    /**
     * The value for the usr_notes field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_notes = null;

    /**
     * The value for the usr_admin field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_admin = null;

    /**
     * The value for the usr_defaultfy field.
     *
     * Note: this column has a database default value of: 10
     */
    protected int|null $usr_defaultfy = null;

    /**
     * The value for the usr_currentdeposit field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $usr_currentdeposit = null;

    /**
     * The value for the usr_username field.
     */
    protected string|null $usr_username = null;

    /**
     * The value for the usr_style field.
     */
    protected string|null $usr_style = null;

    /**
     * The value for the usr_apikey field.
     */
    protected string|null $usr_apikey = null;

    /**
     * The value for the usr_twofactorauthsecret field.
     */
    protected string|null $usr_twofactorauthsecret = null;

    /**
     * The value for the usr_twofactorauthlastkeytimestamp field.
     */
    protected int|null $usr_twofactorauthlastkeytimestamp = null;

    /**
     * The value for the usr_twofactorauthrecoverycodes field.
     */
    protected string|null $usr_twofactorauthrecoverycodes = null;

    /**
     * The value for the usr_editself field.
     *
     * Note: this column has a database default value of: false
     */
    protected bool|null $usr_editself = null;

    /**
     * The value for the usr_calstart field.
     */
    protected DateTimeInterface|null $usr_calstart = null;

    /**
     * The value for the usr_calend field.
     */
    protected DateTimeInterface|null $usr_calend = null;

    /**
     * The value for the usr_calnoschool1 field.
     */
    protected DateTimeInterface|null $usr_calnoschool1 = null;

    /**
     * The value for the usr_calnoschool2 field.
     */
    protected DateTimeInterface|null $usr_calnoschool2 = null;

    /**
     * The value for the usr_calnoschool3 field.
     */
    protected DateTimeInterface|null $usr_calnoschool3 = null;

    /**
     * The value for the usr_calnoschool4 field.
     */
    protected DateTimeInterface|null $usr_calnoschool4 = null;

    /**
     * The value for the usr_calnoschool5 field.
     */
    protected DateTimeInterface|null $usr_calnoschool5 = null;

    /**
     * The value for the usr_calnoschool6 field.
     */
    protected DateTimeInterface|null $usr_calnoschool6 = null;

    /**
     * The value for the usr_calnoschool7 field.
     */
    protected DateTimeInterface|null $usr_calnoschool7 = null;

    /**
     * The value for the usr_calnoschool8 field.
     */
    protected DateTimeInterface|null $usr_calnoschool8 = null;

    /**
     * The value for the usr_searchfamily field.
     */
    protected int|null $usr_searchfamily = null;

    /**
     * Person associated via Person relation (n:1).
     */
    protected Person|null $aPerson = null;

    /**
     * Objects associated via UserConfig relation (1:n).
     */
    protected UserConfigCollection|null $collUserConfigs = null;

    /**
     * If $collUserConfigs contains all objects in UserConfig relation.
     */
    protected bool $collUserConfigsPartial = false;

    /**
     * Objects associated via UserSetting relation (1:n).
     */
    protected UserSettingCollection|null $collUserSettings = null;

    /**
     * If $collUserSettings contains all objects in UserSetting relation.
     */
    protected bool $collUserSettingsPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of UserConfigs relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\UserConfig>|null
     */
    protected ObjectCollection|null $userConfigsScheduledForDeletion = null;

    /**
     * Items of UserSettings relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\UserSetting>|null
     */
    protected ObjectCollection|null $userSettingsScheduledForDeletion = null;

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
        $this->usr_per_id = 0;
        $this->usr_password = '';
        $this->usr_needpasswordchange = true;
        $this->usr_lastlogin = PropelDateTime::newInstance('2016-01-01 00:00:00.000000', null, '\DateTime');
        $this->usr_logincount = 0;
        $this->usr_failedlogins = 0;
        $this->usr_addrecords = false;
        $this->usr_editrecords = false;
        $this->usr_deleterecords = false;
        $this->usr_menuoptions = false;
        $this->usr_managegroups = false;
        $this->usr_finance = false;
        $this->usr_notes = false;
        $this->usr_admin = false;
        $this->usr_defaultfy = 10;
        $this->usr_currentdeposit = 0;
        $this->usr_editself = false;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\User object.
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
     * Compares this with another <code>User</code> instance. If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [usr_per_id] column value.
     *
     * @return int|null
     */
    public function getPersonId()
    {
        return $this->usr_per_id;
    }

    /**
     * Get the [usr_password] column value.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->usr_password;
    }

    /**
     * Get the [usr_needpasswordchange] column value.
     *
     * @return bool|null
     */
    public function getNeedPasswordChange()
    {
        return $this->usr_needpasswordchange;
    }

    /**
     * Get the [usr_needpasswordchange] column value.
     *
     * @return bool|null
     */
    public function isNeedPasswordChange()
    {
        return $this->getNeedPasswordChange();
    }

    /**
     * Get the [optionally formatted] temporal [usr_lastlogin] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getLastLogin($format = null)
    {
        if ($format === null) {
            return $this->usr_lastlogin;
        } else {
            return $this->usr_lastlogin instanceof DateTimeInterface ? $this->usr_lastlogin->format($format) : null;
        }
    }

    /**
     * Get the [usr_logincount] column value.
     *
     * @return int|null
     */
    public function getLoginCount()
    {
        return $this->usr_logincount;
    }

    /**
     * Get the [usr_failedlogins] column value.
     *
     * @return int|null
     */
    public function getFailedLogins()
    {
        return $this->usr_failedlogins;
    }

    /**
     * Get the [usr_addrecords] column value.
     *
     * @return bool|null
     */
    public function getAddRecords()
    {
        return $this->usr_addrecords;
    }

    /**
     * Get the [usr_addrecords] column value.
     *
     * @return bool|null
     */
    public function isAddRecords()
    {
        return $this->getAddRecords();
    }

    /**
     * Get the [usr_editrecords] column value.
     *
     * @return bool|null
     */
    public function getEditRecords()
    {
        return $this->usr_editrecords;
    }

    /**
     * Get the [usr_editrecords] column value.
     *
     * @return bool|null
     */
    public function isEditRecords()
    {
        return $this->getEditRecords();
    }

    /**
     * Get the [usr_deleterecords] column value.
     *
     * @return bool|null
     */
    public function getDeleteRecords()
    {
        return $this->usr_deleterecords;
    }

    /**
     * Get the [usr_deleterecords] column value.
     *
     * @return bool|null
     */
    public function isDeleteRecords()
    {
        return $this->getDeleteRecords();
    }

    /**
     * Get the [usr_menuoptions] column value.
     *
     * @return bool|null
     */
    public function getMenuOptions()
    {
        return $this->usr_menuoptions;
    }

    /**
     * Get the [usr_menuoptions] column value.
     *
     * @return bool|null
     */
    public function isMenuOptions()
    {
        return $this->getMenuOptions();
    }

    /**
     * Get the [usr_managegroups] column value.
     *
     * @return bool|null
     */
    public function getManageGroups()
    {
        return $this->usr_managegroups;
    }

    /**
     * Get the [usr_managegroups] column value.
     *
     * @return bool|null
     */
    public function isManageGroups()
    {
        return $this->getManageGroups();
    }

    /**
     * Get the [usr_finance] column value.
     *
     * @return bool|null
     */
    public function getFinance()
    {
        return $this->usr_finance;
    }

    /**
     * Get the [usr_finance] column value.
     *
     * @return bool|null
     */
    public function isFinance()
    {
        return $this->getFinance();
    }

    /**
     * Get the [usr_notes] column value.
     *
     * @return bool|null
     */
    public function getNotes()
    {
        return $this->usr_notes;
    }

    /**
     * Get the [usr_notes] column value.
     *
     * @return bool|null
     */
    public function isNotes()
    {
        return $this->getNotes();
    }

    /**
     * Get the [usr_admin] column value.
     *
     * @return bool|null
     */
    public function getAdmin()
    {
        return $this->usr_admin;
    }

    /**
     * Get the [usr_admin] column value.
     *
     * @return bool|null
     */
    public function isAdmin()
    {
        return $this->getAdmin();
    }

    /**
     * Get the [usr_defaultfy] column value.
     *
     * @return int|null
     */
    public function getDefaultFY()
    {
        return $this->usr_defaultfy;
    }

    /**
     * Get the [usr_currentdeposit] column value.
     *
     * @return int|null
     */
    public function getCurrentDeposit()
    {
        return $this->usr_currentdeposit;
    }

    /**
     * Get the [usr_username] column value.
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->usr_username;
    }

    /**
     * Get the [usr_style] column value.
     *
     * @return string|null
     */
    public function getUserStyle()
    {
        return $this->usr_style;
    }

    /**
     * Get the [usr_apikey] column value.
     *
     * @return string|null
     */
    public function getApiKey()
    {
        return $this->usr_apikey;
    }

    /**
     * Get the [usr_twofactorauthsecret] column value.
     *
     * @return string|null
     */
    public function getTwoFactorAuthSecret()
    {
        return $this->usr_twofactorauthsecret;
    }

    /**
     * Get the [usr_twofactorauthlastkeytimestamp] column value.
     *
     * @return int|null
     */
    public function getTwoFactorAuthLastKeyTimestamp()
    {
        return $this->usr_twofactorauthlastkeytimestamp;
    }

    /**
     * Get the [usr_twofactorauthrecoverycodes] column value.
     *
     * @return string|null
     */
    public function getTwoFactorAuthRecoveryCodes()
    {
        return $this->usr_twofactorauthrecoverycodes;
    }

    /**
     * Get the [usr_editself] column value.
     *
     * @return bool|null
     */
    public function getEditSelf()
    {
        return $this->usr_editself;
    }

    /**
     * Get the [usr_editself] column value.
     *
     * @return bool|null
     */
    public function isEditSelf()
    {
        return $this->getEditSelf();
    }

    /**
     * Get the [optionally formatted] temporal [usr_calstart] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalStart($format = null)
    {
        if ($format === null) {
            return $this->usr_calstart;
        } else {
            return $this->usr_calstart instanceof DateTimeInterface ? $this->usr_calstart->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calend] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalEnd($format = null)
    {
        if ($format === null) {
            return $this->usr_calend;
        } else {
            return $this->usr_calend instanceof DateTimeInterface ? $this->usr_calend->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool1] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool1($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool1;
        } else {
            return $this->usr_calnoschool1 instanceof DateTimeInterface ? $this->usr_calnoschool1->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool2] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool2($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool2;
        } else {
            return $this->usr_calnoschool2 instanceof DateTimeInterface ? $this->usr_calnoschool2->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool3] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool3($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool3;
        } else {
            return $this->usr_calnoschool3 instanceof DateTimeInterface ? $this->usr_calnoschool3->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool4] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool4($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool4;
        } else {
            return $this->usr_calnoschool4 instanceof DateTimeInterface ? $this->usr_calnoschool4->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool5] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool5($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool5;
        } else {
            return $this->usr_calnoschool5 instanceof DateTimeInterface ? $this->usr_calnoschool5->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool6] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool6($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool6;
        } else {
            return $this->usr_calnoschool6 instanceof DateTimeInterface ? $this->usr_calnoschool6->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool7] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool7($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool7;
        } else {
            return $this->usr_calnoschool7 instanceof DateTimeInterface ? $this->usr_calnoschool7->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [usr_calnoschool8] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getCalNoSchool8($format = null)
    {
        if ($format === null) {
            return $this->usr_calnoschool8;
        } else {
            return $this->usr_calnoschool8 instanceof DateTimeInterface ? $this->usr_calnoschool8->format($format) : null;
        }
    }

    /**
     * Get the [usr_searchfamily] column value.
     *
     * @return int|null
     */
    public function getSearchfamily()
    {
        return $this->usr_searchfamily;
    }

    /**
     * Set the value of [usr_per_id] column.
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

        if ($this->usr_per_id !== $v) {
            $this->usr_per_id = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_PER_ID] = true;
        }

        if ($this->aPerson !== null && $this->aPerson->getId() !== $v) {
            $this->aPerson = null;
        }

        return $this;
    }

    /**
     * Set the value of [usr_password] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->usr_password !== $v) {
            $this->usr_password = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_PASSWORD] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_needpasswordchange] column.
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
    public function setNeedPasswordChange($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_needpasswordchange !== $v) {
            $this->usr_needpasswordchange = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_NEEDPASSWORDCHANGE] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [usr_lastlogin] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setLastLogin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_lastlogin !== null || $dt !== null) {
            if (
                $dt !== $this->usr_lastlogin // normalized values don't match
                || $dt->format('Y-m-d H:i:s.u') === '2016-01-01 00:00:00.000000' // or the entered value matches the default
            ) {
                $this->usr_lastlogin = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_LASTLOGIN] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [usr_logincount] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setLoginCount($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->usr_logincount !== $v) {
            $this->usr_logincount = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_LOGINCOUNT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_failedlogins] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFailedLogins($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->usr_failedlogins !== $v) {
            $this->usr_failedlogins = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_FAILEDLOGINS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_addrecords] column.
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
    public function setAddRecords($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_addrecords !== $v) {
            $this->usr_addrecords = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_ADDRECORDS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_editrecords] column.
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
    public function setEditRecords($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_editrecords !== $v) {
            $this->usr_editrecords = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_EDITRECORDS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_deleterecords] column.
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
    public function setDeleteRecords($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_deleterecords !== $v) {
            $this->usr_deleterecords = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_DELETERECORDS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_menuoptions] column.
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
    public function setMenuOptions($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_menuoptions !== $v) {
            $this->usr_menuoptions = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_MENUOPTIONS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_managegroups] column.
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
    public function setManageGroups($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_managegroups !== $v) {
            $this->usr_managegroups = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_MANAGEGROUPS] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_finance] column.
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
    public function setFinance($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_finance !== $v) {
            $this->usr_finance = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_FINANCE] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_notes] column.
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
    public function setNotes($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_notes !== $v) {
            $this->usr_notes = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_NOTES] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_admin] column.
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
    public function setAdmin($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_admin !== $v) {
            $this->usr_admin = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_ADMIN] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_defaultfy] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setDefaultFY($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->usr_defaultfy !== $v) {
            $this->usr_defaultfy = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_DEFAULTFY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_currentdeposit] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setCurrentDeposit($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->usr_currentdeposit !== $v) {
            $this->usr_currentdeposit = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_CURRENTDEPOSIT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_username] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setUserName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->usr_username !== $v) {
            $this->usr_username = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_USERNAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_style] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setUserStyle($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->usr_style !== $v) {
            $this->usr_style = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_STYLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_apikey] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setApiKey($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->usr_apikey !== $v) {
            $this->usr_apikey = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_APIKEY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_twofactorauthsecret] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setTwoFactorAuthSecret($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->usr_twofactorauthsecret !== $v) {
            $this->usr_twofactorauthsecret = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_TWOFACTORAUTHSECRET] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_twofactorauthlastkeytimestamp] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setTwoFactorAuthLastKeyTimestamp($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->usr_twofactorauthlastkeytimestamp !== $v) {
            $this->usr_twofactorauthlastkeytimestamp = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP] = true;
        }

        return $this;
    }

    /**
     * Set the value of [usr_twofactorauthrecoverycodes] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setTwoFactorAuthRecoveryCodes($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->usr_twofactorauthrecoverycodes !== $v) {
            $this->usr_twofactorauthrecoverycodes = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES] = true;
        }

        return $this;
    }

    /**
     * Sets the value of the [usr_editself] column.
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
    public function setEditSelf($v)
    {
        if ($v !== null) {
            $v = is_string($v)
                ? !in_array(strtolower($v), ['false', 'off', '-', 'no', 'n', '0', ''])
                : (bool)$v;
        }

        if ($this->usr_editself !== $v) {
            $this->usr_editself = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_EDITSELF] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [usr_calstart] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calstart !== null || $dt !== null) {
            if ($this->usr_calstart === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calstart->format('Y-m-d')) {
                $this->usr_calstart = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALSTART] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calend] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calend !== null || $dt !== null) {
            if ($this->usr_calend === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calend->format('Y-m-d')) {
                $this->usr_calend = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALEND] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool1] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool1($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool1 !== null || $dt !== null) {
            if ($this->usr_calnoschool1 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool1->format('Y-m-d')) {
                $this->usr_calnoschool1 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL1] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool2] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool2($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool2 !== null || $dt !== null) {
            if ($this->usr_calnoschool2 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool2->format('Y-m-d')) {
                $this->usr_calnoschool2 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL2] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool3] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool3($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool3 !== null || $dt !== null) {
            if ($this->usr_calnoschool3 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool3->format('Y-m-d')) {
                $this->usr_calnoschool3 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL3] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool4] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool4($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool4 !== null || $dt !== null) {
            if ($this->usr_calnoschool4 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool4->format('Y-m-d')) {
                $this->usr_calnoschool4 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL4] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool5] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool5($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool5 !== null || $dt !== null) {
            if ($this->usr_calnoschool5 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool5->format('Y-m-d')) {
                $this->usr_calnoschool5 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL5] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool6] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool6($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool6 !== null || $dt !== null) {
            if ($this->usr_calnoschool6 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool6->format('Y-m-d')) {
                $this->usr_calnoschool6 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL6] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool7] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool7($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool7 !== null || $dt !== null) {
            if ($this->usr_calnoschool7 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool7->format('Y-m-d')) {
                $this->usr_calnoschool7 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL7] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [usr_calnoschool8] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setCalNoSchool8($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->usr_calnoschool8 !== null || $dt !== null) {
            if ($this->usr_calnoschool8 === null || $dt === null || $dt->format('Y-m-d') !== $this->usr_calnoschool8->format('Y-m-d')) {
                $this->usr_calnoschool8 = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_USR_CALNOSCHOOL8] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [usr_searchfamily] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setSearchfamily($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->usr_searchfamily !== $v) {
            $this->usr_searchfamily = $v;
            $this->modifiedColumns[UserTableMap::COL_USR_SEARCHFAMILY] = true;
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
        if ($this->usr_per_id !== 0) {
            return false;
        }

        if ($this->usr_password !== '') {
            return false;
        }

        if ($this->usr_needpasswordchange !== true) {
            return false;
        }

        if ($this->usr_lastlogin && $this->usr_lastlogin->format('Y-m-d H:i:s.u') !== '2016-01-01 00:00:00.000000') {
            return false;
        }

        if ($this->usr_logincount !== 0) {
            return false;
        }

        if ($this->usr_failedlogins !== 0) {
            return false;
        }

        if ($this->usr_addrecords !== false) {
            return false;
        }

        if ($this->usr_editrecords !== false) {
            return false;
        }

        if ($this->usr_deleterecords !== false) {
            return false;
        }

        if ($this->usr_menuoptions !== false) {
            return false;
        }

        if ($this->usr_managegroups !== false) {
            return false;
        }

        if ($this->usr_finance !== false) {
            return false;
        }

        if ($this->usr_notes !== false) {
            return false;
        }

        if ($this->usr_admin !== false) {
            return false;
        }

        if ($this->usr_defaultfy !== 10) {
            return false;
        }

        if ($this->usr_currentdeposit !== 0) {
            return false;
        }

        if ($this->usr_editself !== false) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : UserTableMap::translateFieldName('PersonId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_per_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_password = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : UserTableMap::translateFieldName('NeedPasswordChange', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_needpasswordchange = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : UserTableMap::translateFieldName('LastLogin', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->usr_lastlogin = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : UserTableMap::translateFieldName('LoginCount', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_logincount = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : UserTableMap::translateFieldName('FailedLogins', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_failedlogins = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : UserTableMap::translateFieldName('AddRecords', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_addrecords = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : UserTableMap::translateFieldName('EditRecords', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_editrecords = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : UserTableMap::translateFieldName('DeleteRecords', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_deleterecords = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : UserTableMap::translateFieldName('MenuOptions', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_menuoptions = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : UserTableMap::translateFieldName('ManageGroups', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_managegroups = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : UserTableMap::translateFieldName('Finance', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_finance = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 12 : UserTableMap::translateFieldName('Notes', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_notes = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 13 : UserTableMap::translateFieldName('Admin', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_admin = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 14 : UserTableMap::translateFieldName('DefaultFY', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_defaultfy = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 15 : UserTableMap::translateFieldName('CurrentDeposit', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_currentdeposit = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 16 : UserTableMap::translateFieldName('UserName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_username = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 17 : UserTableMap::translateFieldName('UserStyle', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_style = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 18 : UserTableMap::translateFieldName('ApiKey', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_apikey = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 19 : UserTableMap::translateFieldName('TwoFactorAuthSecret', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_twofactorauthsecret = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 20 : UserTableMap::translateFieldName('TwoFactorAuthLastKeyTimestamp', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_twofactorauthlastkeytimestamp = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 21 : UserTableMap::translateFieldName('TwoFactorAuthRecoveryCodes', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_twofactorauthrecoverycodes = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 22 : UserTableMap::translateFieldName('EditSelf', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_editself = $columnValue !== null ? (bool)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 23 : UserTableMap::translateFieldName('CalStart', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calstart = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 24 : UserTableMap::translateFieldName('CalEnd', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calend = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 25 : UserTableMap::translateFieldName('CalNoSchool1', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool1 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 26 : UserTableMap::translateFieldName('CalNoSchool2', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool2 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 27 : UserTableMap::translateFieldName('CalNoSchool3', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool3 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 28 : UserTableMap::translateFieldName('CalNoSchool4', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool4 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 29 : UserTableMap::translateFieldName('CalNoSchool5', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool5 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 30 : UserTableMap::translateFieldName('CalNoSchool6', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool6 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 31 : UserTableMap::translateFieldName('CalNoSchool7', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool7 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 32 : UserTableMap::translateFieldName('CalNoSchool8', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->usr_calnoschool8 = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 33 : UserTableMap::translateFieldName('Searchfamily', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->usr_searchfamily = $columnValue !== null ? (int)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 34;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\User object', 0, $e);
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
        if ($this->aPerson !== null && $this->usr_per_id !== $this->aPerson->getId()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aPerson = null;
            $this->collUserConfigs = null;
            $this->collUserSettings = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see User::setDeleted()
     * @see User::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
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
                UserTableMap::addInstanceToPool($this);
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

        if ($this->userConfigsScheduledForDeletion !== null) {
            if (!$this->userConfigsScheduledForDeletion->isEmpty()) {
                ChildUserConfigQuery::create()
                    ->filterByPrimaryKeys($this->userConfigsScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->userConfigsScheduledForDeletion = null;
            }
        }

        if ($this->collUserConfigs !== null) {
            foreach ($this->collUserConfigs as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->userSettingsScheduledForDeletion !== null) {
            if (!$this->userSettingsScheduledForDeletion->isEmpty()) {
                ChildUserSettingQuery::create()
                    ->filterByPrimaryKeys($this->userSettingsScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->userSettingsScheduledForDeletion = null;
            }
        }

        if ($this->collUserSettings !== null) {
            foreach ($this->collUserSettings as $referrerFK) {
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
        if ($this->isColumnModified(UserTableMap::COL_USR_PER_ID)) {
            $modifiedColumns[':p' . $index++] = 'usr_per_ID';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_PASSWORD)) {
            $modifiedColumns[':p' . $index++] = 'usr_Password';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_NEEDPASSWORDCHANGE)) {
            $modifiedColumns[':p' . $index++] = 'usr_NeedPasswordChange';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_LASTLOGIN)) {
            $modifiedColumns[':p' . $index++] = 'usr_LastLogin';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_LOGINCOUNT)) {
            $modifiedColumns[':p' . $index++] = 'usr_LoginCount';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_FAILEDLOGINS)) {
            $modifiedColumns[':p' . $index++] = 'usr_FailedLogins';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_ADDRECORDS)) {
            $modifiedColumns[':p' . $index++] = 'usr_AddRecords';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_EDITRECORDS)) {
            $modifiedColumns[':p' . $index++] = 'usr_EditRecords';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_DELETERECORDS)) {
            $modifiedColumns[':p' . $index++] = 'usr_DeleteRecords';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_MENUOPTIONS)) {
            $modifiedColumns[':p' . $index++] = 'usr_MenuOptions';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_MANAGEGROUPS)) {
            $modifiedColumns[':p' . $index++] = 'usr_ManageGroups';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_FINANCE)) {
            $modifiedColumns[':p' . $index++] = 'usr_Finance';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_NOTES)) {
            $modifiedColumns[':p' . $index++] = 'usr_Notes';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_ADMIN)) {
            $modifiedColumns[':p' . $index++] = 'usr_Admin';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_DEFAULTFY)) {
            $modifiedColumns[':p' . $index++] = 'usr_defaultFY';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CURRENTDEPOSIT)) {
            $modifiedColumns[':p' . $index++] = 'usr_currentDeposit';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_USERNAME)) {
            $modifiedColumns[':p' . $index++] = 'usr_UserName';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_STYLE)) {
            $modifiedColumns[':p' . $index++] = 'usr_Style';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_APIKEY)) {
            $modifiedColumns[':p' . $index++] = 'usr_ApiKey';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_TWOFACTORAUTHSECRET)) {
            $modifiedColumns[':p' . $index++] = 'usr_TwoFactorAuthSecret';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP)) {
            $modifiedColumns[':p' . $index++] = 'usr_TwoFactorAuthLastKeyTimestamp';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES)) {
            $modifiedColumns[':p' . $index++] = 'usr_TwoFactorAuthRecoveryCodes';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_EDITSELF)) {
            $modifiedColumns[':p' . $index++] = 'usr_EditSelf';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALSTART)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalStart';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALEND)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalEnd';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL1)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool1';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL2)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool2';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL3)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool3';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL4)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool4';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL5)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool5';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL6)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool6';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL7)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool7';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL8)) {
            $modifiedColumns[':p' . $index++] = 'usr_CalNoSchool8';
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_SEARCHFAMILY)) {
            $modifiedColumns[':p' . $index++] = 'usr_SearchFamily';
        }

        $sql = sprintf(
            'INSERT INTO user_usr (%s) VALUES (%s)',
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
                    case 'usr_per_ID':
                        $stmt->bindValue($identifier, $this->usr_per_id, PDO::PARAM_INT);

                        break;
                    case 'usr_Password':
                        $stmt->bindValue($identifier, $this->usr_password, PDO::PARAM_STR);

                        break;
                    case 'usr_NeedPasswordChange':
                        $stmt->bindValue($identifier, (int)$this->usr_needpasswordchange, PDO::PARAM_INT);

                        break;
                    case 'usr_LastLogin':
                        $stmt->bindValue($identifier, $this->usr_lastlogin ? $this->usr_lastlogin->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_LoginCount':
                        $stmt->bindValue($identifier, $this->usr_logincount, PDO::PARAM_INT);

                        break;
                    case 'usr_FailedLogins':
                        $stmt->bindValue($identifier, $this->usr_failedlogins, PDO::PARAM_INT);

                        break;
                    case 'usr_AddRecords':
                        $stmt->bindValue($identifier, (int)$this->usr_addrecords, PDO::PARAM_INT);

                        break;
                    case 'usr_EditRecords':
                        $stmt->bindValue($identifier, (int)$this->usr_editrecords, PDO::PARAM_INT);

                        break;
                    case 'usr_DeleteRecords':
                        $stmt->bindValue($identifier, (int)$this->usr_deleterecords, PDO::PARAM_INT);

                        break;
                    case 'usr_MenuOptions':
                        $stmt->bindValue($identifier, (int)$this->usr_menuoptions, PDO::PARAM_INT);

                        break;
                    case 'usr_ManageGroups':
                        $stmt->bindValue($identifier, (int)$this->usr_managegroups, PDO::PARAM_INT);

                        break;
                    case 'usr_Finance':
                        $stmt->bindValue($identifier, (int)$this->usr_finance, PDO::PARAM_INT);

                        break;
                    case 'usr_Notes':
                        $stmt->bindValue($identifier, (int)$this->usr_notes, PDO::PARAM_INT);

                        break;
                    case 'usr_Admin':
                        $stmt->bindValue($identifier, (int)$this->usr_admin, PDO::PARAM_INT);

                        break;
                    case 'usr_defaultFY':
                        $stmt->bindValue($identifier, $this->usr_defaultfy, PDO::PARAM_INT);

                        break;
                    case 'usr_currentDeposit':
                        $stmt->bindValue($identifier, $this->usr_currentdeposit, PDO::PARAM_INT);

                        break;
                    case 'usr_UserName':
                        $stmt->bindValue($identifier, $this->usr_username, PDO::PARAM_STR);

                        break;
                    case 'usr_Style':
                        $stmt->bindValue($identifier, $this->usr_style, PDO::PARAM_STR);

                        break;
                    case 'usr_ApiKey':
                        $stmt->bindValue($identifier, $this->usr_apikey, PDO::PARAM_STR);

                        break;
                    case 'usr_TwoFactorAuthSecret':
                        $stmt->bindValue($identifier, $this->usr_twofactorauthsecret, PDO::PARAM_STR);

                        break;
                    case 'usr_TwoFactorAuthLastKeyTimestamp':
                        $stmt->bindValue($identifier, $this->usr_twofactorauthlastkeytimestamp, PDO::PARAM_INT);

                        break;
                    case 'usr_TwoFactorAuthRecoveryCodes':
                        $stmt->bindValue($identifier, $this->usr_twofactorauthrecoverycodes, PDO::PARAM_STR);

                        break;
                    case 'usr_EditSelf':
                        $stmt->bindValue($identifier, (int)$this->usr_editself, PDO::PARAM_INT);

                        break;
                    case 'usr_CalStart':
                        $stmt->bindValue($identifier, $this->usr_calstart ? $this->usr_calstart->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalEnd':
                        $stmt->bindValue($identifier, $this->usr_calend ? $this->usr_calend->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool1':
                        $stmt->bindValue($identifier, $this->usr_calnoschool1 ? $this->usr_calnoschool1->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool2':
                        $stmt->bindValue($identifier, $this->usr_calnoschool2 ? $this->usr_calnoschool2->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool3':
                        $stmt->bindValue($identifier, $this->usr_calnoschool3 ? $this->usr_calnoschool3->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool4':
                        $stmt->bindValue($identifier, $this->usr_calnoschool4 ? $this->usr_calnoschool4->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool5':
                        $stmt->bindValue($identifier, $this->usr_calnoschool5 ? $this->usr_calnoschool5->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool6':
                        $stmt->bindValue($identifier, $this->usr_calnoschool6 ? $this->usr_calnoschool6->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool7':
                        $stmt->bindValue($identifier, $this->usr_calnoschool7 ? $this->usr_calnoschool7->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_CalNoSchool8':
                        $stmt->bindValue($identifier, $this->usr_calnoschool8 ? $this->usr_calnoschool8->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'usr_SearchFamily':
                        $stmt->bindValue($identifier, $this->usr_searchfamily, PDO::PARAM_INT);

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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            0 => $this->getPersonId(),
            1 => $this->getPassword(),
            2 => $this->getNeedPasswordChange(),
            3 => $this->getLastLogin(),
            4 => $this->getLoginCount(),
            5 => $this->getFailedLogins(),
            6 => $this->getAddRecords(),
            7 => $this->getEditRecords(),
            8 => $this->getDeleteRecords(),
            9 => $this->getMenuOptions(),
            10 => $this->getManageGroups(),
            11 => $this->getFinance(),
            12 => $this->getNotes(),
            13 => $this->getAdmin(),
            14 => $this->getDefaultFY(),
            15 => $this->getCurrentDeposit(),
            16 => $this->getUserName(),
            17 => $this->getUserStyle(),
            18 => $this->getApiKey(),
            19 => $this->getTwoFactorAuthSecret(),
            20 => $this->getTwoFactorAuthLastKeyTimestamp(),
            21 => $this->getTwoFactorAuthRecoveryCodes(),
            22 => $this->getEditSelf(),
            23 => $this->getCalStart(),
            24 => $this->getCalEnd(),
            25 => $this->getCalNoSchool1(),
            26 => $this->getCalNoSchool2(),
            27 => $this->getCalNoSchool3(),
            28 => $this->getCalNoSchool4(),
            29 => $this->getCalNoSchool5(),
            30 => $this->getCalNoSchool6(),
            31 => $this->getCalNoSchool7(),
            32 => $this->getCalNoSchool8(),
            33 => $this->getSearchfamily(),
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
        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getPersonId(),
            $keys[1] => $this->getPassword(),
            $keys[2] => $this->getNeedPasswordChange(),
            $keys[3] => $this->getLastLogin(),
            $keys[4] => $this->getLoginCount(),
            $keys[5] => $this->getFailedLogins(),
            $keys[6] => $this->getAddRecords(),
            $keys[7] => $this->getEditRecords(),
            $keys[8] => $this->getDeleteRecords(),
            $keys[9] => $this->getMenuOptions(),
            $keys[10] => $this->getManageGroups(),
            $keys[11] => $this->getFinance(),
            $keys[12] => $this->getNotes(),
            $keys[13] => $this->getAdmin(),
            $keys[14] => $this->getDefaultFY(),
            $keys[15] => $this->getCurrentDeposit(),
            $keys[16] => $this->getUserName(),
            $keys[17] => $this->getUserStyle(),
            $keys[18] => $this->getApiKey(),
            $keys[19] => $this->getTwoFactorAuthSecret(),
            $keys[20] => $this->getTwoFactorAuthLastKeyTimestamp(),
            $keys[21] => $this->getTwoFactorAuthRecoveryCodes(),
            $keys[22] => $this->getEditSelf(),
            $keys[23] => $this->getCalStart(),
            $keys[24] => $this->getCalEnd(),
            $keys[25] => $this->getCalNoSchool1(),
            $keys[26] => $this->getCalNoSchool2(),
            $keys[27] => $this->getCalNoSchool3(),
            $keys[28] => $this->getCalNoSchool4(),
            $keys[29] => $this->getCalNoSchool5(),
            $keys[30] => $this->getCalNoSchool6(),
            $keys[31] => $this->getCalNoSchool7(),
            $keys[32] => $this->getCalNoSchool8(),
            $keys[33] => $this->getSearchfamily(),
        ];
        if ($result[$keys[3]] instanceof DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[23]] instanceof DateTimeInterface) {
            $result[$keys[23]] = $result[$keys[23]]->format('Y-m-d');
        }

        if ($result[$keys[24]] instanceof DateTimeInterface) {
            $result[$keys[24]] = $result[$keys[24]]->format('Y-m-d');
        }

        if ($result[$keys[25]] instanceof DateTimeInterface) {
            $result[$keys[25]] = $result[$keys[25]]->format('Y-m-d');
        }

        if ($result[$keys[26]] instanceof DateTimeInterface) {
            $result[$keys[26]] = $result[$keys[26]]->format('Y-m-d');
        }

        if ($result[$keys[27]] instanceof DateTimeInterface) {
            $result[$keys[27]] = $result[$keys[27]]->format('Y-m-d');
        }

        if ($result[$keys[28]] instanceof DateTimeInterface) {
            $result[$keys[28]] = $result[$keys[28]]->format('Y-m-d');
        }

        if ($result[$keys[29]] instanceof DateTimeInterface) {
            $result[$keys[29]] = $result[$keys[29]]->format('Y-m-d');
        }

        if ($result[$keys[30]] instanceof DateTimeInterface) {
            $result[$keys[30]] = $result[$keys[30]]->format('Y-m-d');
        }

        if ($result[$keys[31]] instanceof DateTimeInterface) {
            $result[$keys[31]] = $result[$keys[31]]->format('Y-m-d');
        }

        if ($result[$keys[32]] instanceof DateTimeInterface) {
            $result[$keys[32]] = $result[$keys[32]]->format('Y-m-d');
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
            if ($this->collUserConfigs !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'userConfigs',
                     TableMap::TYPE_FIELDNAME => 'userconfig_ucfgs',
                     default => 'UserConfigs',
                };
                $result[$key] = $this->collUserConfigs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collUserSettings !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'userSettings',
                     TableMap::TYPE_FIELDNAME => 'user_settingss',
                     default => 'UserSettings',
                };
                $result[$key] = $this->collUserSettings->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setPersonId($value);

                break;
            case 1:
                $this->setPassword($value);

                break;
            case 2:
                $this->setNeedPasswordChange($value);

                break;
            case 3:
                $this->setLastLogin($value);

                break;
            case 4:
                $this->setLoginCount($value);

                break;
            case 5:
                $this->setFailedLogins($value);

                break;
            case 6:
                $this->setAddRecords($value);

                break;
            case 7:
                $this->setEditRecords($value);

                break;
            case 8:
                $this->setDeleteRecords($value);

                break;
            case 9:
                $this->setMenuOptions($value);

                break;
            case 10:
                $this->setManageGroups($value);

                break;
            case 11:
                $this->setFinance($value);

                break;
            case 12:
                $this->setNotes($value);

                break;
            case 13:
                $this->setAdmin($value);

                break;
            case 14:
                $this->setDefaultFY($value);

                break;
            case 15:
                $this->setCurrentDeposit($value);

                break;
            case 16:
                $this->setUserName($value);

                break;
            case 17:
                $this->setUserStyle($value);

                break;
            case 18:
                $this->setApiKey($value);

                break;
            case 19:
                $this->setTwoFactorAuthSecret($value);

                break;
            case 20:
                $this->setTwoFactorAuthLastKeyTimestamp($value);

                break;
            case 21:
                $this->setTwoFactorAuthRecoveryCodes($value);

                break;
            case 22:
                $this->setEditSelf($value);

                break;
            case 23:
                $this->setCalStart($value);

                break;
            case 24:
                $this->setCalEnd($value);

                break;
            case 25:
                $this->setCalNoSchool1($value);

                break;
            case 26:
                $this->setCalNoSchool2($value);

                break;
            case 27:
                $this->setCalNoSchool3($value);

                break;
            case 28:
                $this->setCalNoSchool4($value);

                break;
            case 29:
                $this->setCalNoSchool5($value);

                break;
            case 30:
                $this->setCalNoSchool6($value);

                break;
            case 31:
                $this->setCalNoSchool7($value);

                break;
            case 32:
                $this->setCalNoSchool8($value);

                break;
            case 33:
                $this->setSearchfamily($value);

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
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPersonId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPassword($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNeedPasswordChange($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLastLogin($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLoginCount($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFailedLogins($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAddRecords($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEditRecords($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDeleteRecords($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setMenuOptions($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setManageGroups($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setFinance($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setNotes($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setAdmin($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setDefaultFY($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setCurrentDeposit($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setUserName($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setUserStyle($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setApiKey($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setTwoFactorAuthSecret($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setTwoFactorAuthLastKeyTimestamp($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setTwoFactorAuthRecoveryCodes($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setEditSelf($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setCalStart($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setCalEnd($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setCalNoSchool1($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setCalNoSchool2($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setCalNoSchool3($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setCalNoSchool4($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setCalNoSchool5($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setCalNoSchool6($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->setCalNoSchool7($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->setCalNoSchool8($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->setSearchfamily($arr[$keys[33]]);
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
        $tableMap = UserTableMap::getTableMap();
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_USR_PER_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_per_ID'), $this->usr_per_id);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_PASSWORD)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_Password'), $this->usr_password);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_NEEDPASSWORDCHANGE)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_NeedPasswordChange'), $this->usr_needpasswordchange);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_LASTLOGIN)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_LastLogin'), $this->usr_lastlogin);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_LOGINCOUNT)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_LoginCount'), $this->usr_logincount);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_FAILEDLOGINS)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_FailedLogins'), $this->usr_failedlogins);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_ADDRECORDS)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_AddRecords'), $this->usr_addrecords);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_EDITRECORDS)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_EditRecords'), $this->usr_editrecords);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_DELETERECORDS)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_DeleteRecords'), $this->usr_deleterecords);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_MENUOPTIONS)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_MenuOptions'), $this->usr_menuoptions);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_MANAGEGROUPS)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_ManageGroups'), $this->usr_managegroups);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_FINANCE)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_Finance'), $this->usr_finance);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_NOTES)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_Notes'), $this->usr_notes);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_ADMIN)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_Admin'), $this->usr_admin);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_DEFAULTFY)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_defaultFY'), $this->usr_defaultfy);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CURRENTDEPOSIT)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_currentDeposit'), $this->usr_currentdeposit);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_USERNAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_UserName'), $this->usr_username);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_STYLE)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_Style'), $this->usr_style);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_APIKEY)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_ApiKey'), $this->usr_apikey);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_TWOFACTORAUTHSECRET)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_TwoFactorAuthSecret'), $this->usr_twofactorauthsecret);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_TWOFACTORAUTHLASTKEYTIMESTAMP)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_TwoFactorAuthLastKeyTimestamp'), $this->usr_twofactorauthlastkeytimestamp);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_TWOFACTORAUTHRECOVERYCODES)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_TwoFactorAuthRecoveryCodes'), $this->usr_twofactorauthrecoverycodes);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_EDITSELF)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_EditSelf'), $this->usr_editself);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALSTART)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalStart'), $this->usr_calstart);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALEND)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalEnd'), $this->usr_calend);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL1)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool1'), $this->usr_calnoschool1);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL2)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool2'), $this->usr_calnoschool2);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL3)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool3'), $this->usr_calnoschool3);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL4)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool4'), $this->usr_calnoschool4);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL5)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool5'), $this->usr_calnoschool5);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL6)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool6'), $this->usr_calnoschool6);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL7)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool7'), $this->usr_calnoschool7);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_CALNOSCHOOL8)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_CalNoSchool8'), $this->usr_calnoschool8);
        }
        if ($this->isColumnModified(UserTableMap::COL_USR_SEARCHFAMILY)) {
            $criteria->setUpdateValue($tableMap->getColumn('usr_SearchFamily'), $this->usr_searchfamily);
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
        $tableMap = UserTableMap::getTableMap();
        $query = ChildUserQuery::create();
        $usr_per_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('usr_per_ID'));
        $query->addAnd($usr_per_IDColumn, $this->usr_per_id);

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
        $pkIsValid = $this->getPersonId() !== null;

        if ($pkIsValid) {
            $json = json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE);
            if ($json === false) {
                throw new RuntimeException('Failed to encode PK as JSON.');
            }

            return crc32($json);
        }

        $fkFieldNames = ['aPerson'];
        $foreignPksAreValid = true;
        $primaryKeyFKs = [];
        foreach ($fkFieldNames as $fkFieldName) {
            $fkObject = $this->$fkFieldName;
            if (!$fkObject) {
                $foreignPksAreValid = false;

                break;
            }
            $primaryKeyFKs[] = spl_object_hash($fkObject);
        }

        if ($foreignPksAreValid) {
            $json = json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE);
            if ($json === false) {
                throw new RuntimeException('Failed to encode combined PK as JSON.');
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
        return $this->getPersonId();
    }

    /**
     * Generic method to set the primary key (usr_per_id column).
     *
     * @param int|null $key Primary key.
     *
     * @return void
     */
    public function setPrimaryKey(?int $key = null): void
    {
        $this->setPersonId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return $this->getPersonId() === null;
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\User (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setPersonId($this->getPersonId());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setNeedPasswordChange($this->getNeedPasswordChange());
        $copyObj->setLastLogin($this->getLastLogin());
        $copyObj->setLoginCount($this->getLoginCount());
        $copyObj->setFailedLogins($this->getFailedLogins());
        $copyObj->setAddRecords($this->getAddRecords());
        $copyObj->setEditRecords($this->getEditRecords());
        $copyObj->setDeleteRecords($this->getDeleteRecords());
        $copyObj->setMenuOptions($this->getMenuOptions());
        $copyObj->setManageGroups($this->getManageGroups());
        $copyObj->setFinance($this->getFinance());
        $copyObj->setNotes($this->getNotes());
        $copyObj->setAdmin($this->getAdmin());
        $copyObj->setDefaultFY($this->getDefaultFY());
        $copyObj->setCurrentDeposit($this->getCurrentDeposit());
        $copyObj->setUserName($this->getUserName());
        $copyObj->setUserStyle($this->getUserStyle());
        $copyObj->setApiKey($this->getApiKey());
        $copyObj->setTwoFactorAuthSecret($this->getTwoFactorAuthSecret());
        $copyObj->setTwoFactorAuthLastKeyTimestamp($this->getTwoFactorAuthLastKeyTimestamp());
        $copyObj->setTwoFactorAuthRecoveryCodes($this->getTwoFactorAuthRecoveryCodes());
        $copyObj->setEditSelf($this->getEditSelf());
        $copyObj->setCalStart($this->getCalStart());
        $copyObj->setCalEnd($this->getCalEnd());
        $copyObj->setCalNoSchool1($this->getCalNoSchool1());
        $copyObj->setCalNoSchool2($this->getCalNoSchool2());
        $copyObj->setCalNoSchool3($this->getCalNoSchool3());
        $copyObj->setCalNoSchool4($this->getCalNoSchool4());
        $copyObj->setCalNoSchool5($this->getCalNoSchool5());
        $copyObj->setCalNoSchool6($this->getCalNoSchool6());
        $copyObj->setCalNoSchool7($this->getCalNoSchool7());
        $copyObj->setCalNoSchool8($this->getCalNoSchool8());
        $copyObj->setSearchfamily($this->getSearchfamily());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getUserConfigs() as $relObj) {
                $copyObj->addUserConfig($relObj->copy($deepCopy));
            }
            foreach ($this->getUserSettings() as $relObj) {
                $copyObj->addUserSetting($relObj->copy($deepCopy));
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
        $person?->setUser($this);

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
        if ($this->aPerson === null && ($this->usr_per_id !== null && $this->usr_per_id !== 0)) {
            $this->aPerson = ChildPersonQuery::create()->findPk($this->usr_per_id, $con);
            // Because this foreign key represents a one-to-one relationship, we will create a bi-directional association.
            $this->aPerson->setUser($this);
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
        match ($relationName) {
            'UserConfig' => $this->initUserConfigs(),
            'UserSetting' => $this->initUserSettings(),
            default => null
        };
    }

    /**
     * Initializes the collUserConfigs collection.
     *
     * By default this just sets the collUserConfigs collection to an empty array (like clearcollUserConfigs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserConfigs(bool $overrideExisting = true): void
    {
        if ($this->collUserConfigs !== null && !$overrideExisting) {
            return;
        }

        $this->collUserConfigs = new UserConfigCollection();
        $this->collUserConfigs->setModel('\ChurchCRM\model\ChurchCRM\UserConfig');
    }

    /**
     * Reset is the collUserConfigs collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialUserConfigs(bool $isPartial = true): void
    {
        $this->collUserConfigsPartial = $isPartial;
    }

    /**
     * Clears out the collUserConfigs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearUserConfigs(): static
    {
        $this->collUserConfigs = null;

        return $this;
    }

    /**
     * Gets user_usr objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\UserConfigCollection
     */
    public function getUserConfigs(?Criteria $criteria = null, ?ConnectionInterface $con = null): UserConfigCollection
    {
        $partial = $this->collUserConfigsPartial && !$this->isNew();
        if ($this->collUserConfigs && !$criteria && !$partial) {
            return $this->collUserConfigs;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collUserConfigs === null) {
                $this->initUserConfigs();

                return $this->collUserConfigs;
            }

            $collUserConfigs = new UserConfigCollection();
            $collUserConfigs->setModel('\ChurchCRM\model\ChurchCRM\Base\UserConfig');

            return $collUserConfigs;
        }

        $collUserConfigs = ChildUserConfigQuery::create(null, $criteria)
            ->filterByUser($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collUserConfigsPartial !== false && count($collUserConfigs)) {
                $this->initUserConfigs(false);

                foreach ($collUserConfigs as $obj) {
                    if (!$this->collUserConfigs->contains($obj)) {
                        $this->collUserConfigs->append($obj);
                    }
                }

                $this->collUserConfigsPartial = true;
            }

            return $collUserConfigs;
        }

        if ($this->collUserConfigsPartial && $this->collUserConfigs) {
            foreach ($this->collUserConfigs as $obj) {
                if ($obj->isNew()) {
                    $collUserConfigs[] = $obj;
                }
            }
        }

        $this->collUserConfigs = $collUserConfigs;
        $this->collUserConfigsPartial = false;

        return $this->collUserConfigs;
    }

    /**
     * Sets a collection of user_usr objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\UserConfig> $userConfigs
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setUserConfigs(Collection $userConfigs, ?ConnectionInterface $con = null): static
    {
        $userConfigsToDelete = $this->getUserConfigs(null, $con)->diff($userConfigs);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userConfigsScheduledForDeletion = clone $userConfigsToDelete;

        foreach ($userConfigsToDelete as $userConfigRemoved) {
            $userConfigRemoved->setUser(null);
        }

        $this->collUserConfigs = null;
        foreach ($userConfigs as $userConfig) {
            $this->addUserConfig($userConfig);
        }

        $this->collUserConfigsPartial = false;
        $this->collUserConfigs = $userConfigs instanceof UserConfigCollection
            ? $userConfigs : new UserConfigCollection($userConfigs->getData());

        return $this;
    }

    /**
     * Returns the number of related user_usr objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related user_usr objects.
     */
    public function countUserConfigs(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collUserConfigsPartial && !$this->isNew();
        if ($this->collUserConfigs === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collUserConfigs === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserConfigs());
            }

            $query = ChildUserConfigQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserConfigs);
    }

    /**
     * Method called to associate a UserConfig object to this object
     * through the UserConfig foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\UserConfig $userConfig
     *
     * @return $this
     */
    public function addUserConfig(UserConfig $userConfig)
    {
        if ($this->collUserConfigs === null) {
            $this->initUserConfigs();
            $this->collUserConfigsPartial = true;
        }

        if (!$this->collUserConfigs->contains($userConfig)) {
            $this->doAddUserConfig($userConfig);

            if ($this->userConfigsScheduledForDeletion && $this->userConfigsScheduledForDeletion->contains($userConfig)) {
                $this->userConfigsScheduledForDeletion->remove($this->userConfigsScheduledForDeletion->search($userConfig));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\UserConfig $userConfig The UserConfig object to add.
     *
     * @return void
     */
    protected function doAddUserConfig(UserConfig $userConfig): void
    {
        $this->collUserConfigs->append($userConfig);
        $userConfig->setUser($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\UserConfig $userConfig The UserConfig object to remove.
     *
     * @return static
     */
    public function removeUserConfig(UserConfig $userConfig): static
    {
        if ($this->getUserConfigs()->contains($userConfig)) {
            $pos = $this->collUserConfigs->search($userConfig);
            $this->collUserConfigs->remove($pos);
            if ($this->userConfigsScheduledForDeletion === null) {
                $this->userConfigsScheduledForDeletion = clone $this->collUserConfigs;
                $this->userConfigsScheduledForDeletion->clear();
            }
            $this->userConfigsScheduledForDeletion->append(clone $userConfig);
            $userConfig->setUser(null);
        }

        return $this;
    }

    /**
     * Initializes the collUserSettings collection.
     *
     * By default this just sets the collUserSettings collection to an empty array (like clearcollUserSettings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserSettings(bool $overrideExisting = true): void
    {
        if ($this->collUserSettings !== null && !$overrideExisting) {
            return;
        }

        $this->collUserSettings = new UserSettingCollection();
        $this->collUserSettings->setModel('\ChurchCRM\model\ChurchCRM\UserSetting');
    }

    /**
     * Reset is the collUserSettings collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialUserSettings(bool $isPartial = true): void
    {
        $this->collUserSettingsPartial = $isPartial;
    }

    /**
     * Clears out the collUserSettings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearUserSettings(): static
    {
        $this->collUserSettings = null;

        return $this;
    }

    /**
     * Gets user_usr objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this User is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection
     */
    public function getUserSettings(?Criteria $criteria = null, ?ConnectionInterface $con = null): UserSettingCollection
    {
        $partial = $this->collUserSettingsPartial && !$this->isNew();
        if ($this->collUserSettings && !$criteria && !$partial) {
            return $this->collUserSettings;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collUserSettings === null) {
                $this->initUserSettings();

                return $this->collUserSettings;
            }

            $collUserSettings = new UserSettingCollection();
            $collUserSettings->setModel('\ChurchCRM\model\ChurchCRM\Base\UserSetting');

            return $collUserSettings;
        }

        $collUserSettings = ChildUserSettingQuery::create(null, $criteria)
            ->filterByUser($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collUserSettingsPartial !== false && count($collUserSettings)) {
                $this->initUserSettings(false);

                foreach ($collUserSettings as $obj) {
                    if (!$this->collUserSettings->contains($obj)) {
                        $this->collUserSettings->append($obj);
                    }
                }

                $this->collUserSettingsPartial = true;
            }

            return $collUserSettings;
        }

        if ($this->collUserSettingsPartial && $this->collUserSettings) {
            foreach ($this->collUserSettings as $obj) {
                if ($obj->isNew()) {
                    $collUserSettings[] = $obj;
                }
            }
        }

        $this->collUserSettings = $collUserSettings;
        $this->collUserSettingsPartial = false;

        return $this->collUserSettings;
    }

    /**
     * Sets a collection of user_usr objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\UserSetting> $userSettings
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setUserSettings(Collection $userSettings, ?ConnectionInterface $con = null): static
    {
        $userSettingsToDelete = $this->getUserSettings(null, $con)->diff($userSettings);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userSettingsScheduledForDeletion = clone $userSettingsToDelete;

        foreach ($userSettingsToDelete as $userSettingRemoved) {
            $userSettingRemoved->setUser(null);
        }

        $this->collUserSettings = null;
        foreach ($userSettings as $userSetting) {
            $this->addUserSetting($userSetting);
        }

        $this->collUserSettingsPartial = false;
        $this->collUserSettings = $userSettings instanceof UserSettingCollection
            ? $userSettings : new UserSettingCollection($userSettings->getData());

        return $this;
    }

    /**
     * Returns the number of related user_usr objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related user_usr objects.
     */
    public function countUserSettings(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collUserSettingsPartial && !$this->isNew();
        if ($this->collUserSettings === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collUserSettings === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserSettings());
            }

            $query = ChildUserSettingQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collUserSettings);
    }

    /**
     * Method called to associate a UserSetting object to this object
     * through the UserSetting foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\UserSetting $userSetting
     *
     * @return $this
     */
    public function addUserSetting(UserSetting $userSetting)
    {
        if ($this->collUserSettings === null) {
            $this->initUserSettings();
            $this->collUserSettingsPartial = true;
        }

        if (!$this->collUserSettings->contains($userSetting)) {
            $this->doAddUserSetting($userSetting);

            if ($this->userSettingsScheduledForDeletion && $this->userSettingsScheduledForDeletion->contains($userSetting)) {
                $this->userSettingsScheduledForDeletion->remove($this->userSettingsScheduledForDeletion->search($userSetting));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\UserSetting $userSetting The UserSetting object to add.
     *
     * @return void
     */
    protected function doAddUserSetting(UserSetting $userSetting): void
    {
        $this->collUserSettings->append($userSetting);
        $userSetting->setUser($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\UserSetting $userSetting The UserSetting object to remove.
     *
     * @return static
     */
    public function removeUserSetting(UserSetting $userSetting): static
    {
        if ($this->getUserSettings()->contains($userSetting)) {
            $pos = $this->collUserSettings->search($userSetting);
            $this->collUserSettings->remove($pos);
            if ($this->userSettingsScheduledForDeletion === null) {
                $this->userSettingsScheduledForDeletion = clone $this->collUserSettings;
                $this->userSettingsScheduledForDeletion->clear();
            }
            $this->userSettingsScheduledForDeletion->append(clone $userSetting);
            $userSetting->setUser(null);
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
        if ($this->aPerson !== null) {
            $this->aPerson->setUser(null);
        }
        $this->usr_per_id = null;
        $this->usr_password = null;
        $this->usr_needpasswordchange = null;
        $this->usr_lastlogin = null;
        $this->usr_logincount = null;
        $this->usr_failedlogins = null;
        $this->usr_addrecords = null;
        $this->usr_editrecords = null;
        $this->usr_deleterecords = null;
        $this->usr_menuoptions = null;
        $this->usr_managegroups = null;
        $this->usr_finance = null;
        $this->usr_notes = null;
        $this->usr_admin = null;
        $this->usr_defaultfy = null;
        $this->usr_currentdeposit = null;
        $this->usr_username = null;
        $this->usr_style = null;
        $this->usr_apikey = null;
        $this->usr_twofactorauthsecret = null;
        $this->usr_twofactorauthlastkeytimestamp = null;
        $this->usr_twofactorauthrecoverycodes = null;
        $this->usr_editself = null;
        $this->usr_calstart = null;
        $this->usr_calend = null;
        $this->usr_calnoschool1 = null;
        $this->usr_calnoschool2 = null;
        $this->usr_calnoschool3 = null;
        $this->usr_calnoschool4 = null;
        $this->usr_calnoschool5 = null;
        $this->usr_calnoschool6 = null;
        $this->usr_calnoschool7 = null;
        $this->usr_calnoschool8 = null;
        $this->usr_searchfamily = null;
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
            if ($this->collUserConfigs) {
                foreach ($this->collUserConfigs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserSettings) {
                foreach ($this->collUserSettings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collUserConfigs = null;
        $this->collUserSettings = null;
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
        return (string)$this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
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
