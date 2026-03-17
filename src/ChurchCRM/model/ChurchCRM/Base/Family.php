<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection;
use ChurchCRM\model\ChurchCRM\FamilyCustomQuery as ChildFamilyCustomQuery;
use ChurchCRM\model\ChurchCRM\FamilyQuery as ChildFamilyQuery;
use ChurchCRM\model\ChurchCRM\Map\FamilyTableMap;
use ChurchCRM\model\ChurchCRM\NoteQuery as ChildNoteQuery;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
use ChurchCRM\model\ChurchCRM\PledgeQuery as ChildPledgeQuery;
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
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'family_fam' table.
 *
 * This contains the main family data, including family name, family addresses, and family phone numbers
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Family implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\FamilyTableMap';

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
     * The value for the fam_id field.
     */
    protected int|null $fam_id = null;

    /**
     * The value for the fam_name field.
     */
    protected string|null $fam_name = null;

    /**
     * The value for the fam_address1 field.
     */
    protected string|null $fam_address1 = null;

    /**
     * The value for the fam_address2 field.
     */
    protected string|null $fam_address2 = null;

    /**
     * The value for the fam_city field.
     */
    protected string|null $fam_city = null;

    /**
     * The value for the fam_state field.
     */
    protected string|null $fam_state = null;

    /**
     * The value for the fam_zip field.
     */
    protected string|null $fam_zip = null;

    /**
     * The value for the fam_country field.
     */
    protected string|null $fam_country = null;

    /**
     * The value for the fam_homephone field.
     */
    protected string|null $fam_homephone = null;

    /**
     * The value for the fam_email field.
     */
    protected string|null $fam_email = null;

    /**
     * The value for the fam_weddingdate field.
     */
    protected DateTimeInterface|null $fam_weddingdate = null;

    /**
     * The value for the fam_dateentered field.
     */
    protected DateTimeInterface|null $fam_dateentered = null;

    /**
     * The value for the fam_datelastedited field.
     */
    protected DateTimeInterface|null $fam_datelastedited = null;

    /**
     * The value for the fam_enteredby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $fam_enteredby = null;

    /**
     * The value for the fam_editedby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $fam_editedby = null;

    /**
     * The value for the fam_scancheck field.
     */
    protected string|null $fam_scancheck = null;

    /**
     * The value for the fam_scancredit field.
     */
    protected string|null $fam_scancredit = null;

    /**
     * The value for the fam_sendnewsletter field.
     *
     * Note: this column has a database default value of: 'FALSE'
     */
    protected string|null $fam_sendnewsletter = null;

    /**
     * The value for the fam_datedeactivated field.
     */
    protected DateTimeInterface|null $fam_datedeactivated = null;

    /**
     * The value for the fam_latitude field.
     */
    protected float|null $fam_latitude = null;

    /**
     * The value for the fam_longitude field.
     */
    protected float|null $fam_longitude = null;

    /**
     * The value for the fam_envelope field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $fam_envelope = null;

    /**
     * Objects associated via Person relation (1:n).
     */
    protected PersonCollection|null $collPeople = null;

    /**
     * If $collPeople contains all objects in Person relation.
     */
    protected bool $collPeoplePartial = false;

    /**
     * FamilyCustom associated via FamilyCustom relation (1:1).
     */
    protected FamilyCustom|null $singleFamilyCustom = null;

    /**
     * Objects associated via Note relation (1:n).
     */
    protected NoteCollection|null $collNotes = null;

    /**
     * If $collNotes contains all objects in Note relation.
     */
    protected bool $collNotesPartial = false;

    /**
     * Objects associated via Pledge relation (1:n).
     */
    protected PledgeCollection|null $collPledges = null;

    /**
     * If $collPledges contains all objects in Pledge relation.
     */
    protected bool $collPledgesPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     *
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * Items of People relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person>|null
     */
    protected ObjectCollection|null $peopleScheduledForDeletion = null;

    /**
     * Items of FamilyCustoms relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\FamilyCustom>|null
     */
    protected ObjectCollection|null $familyCustomsScheduledForDeletion = null;

    /**
     * Items of Notes relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Note>|null
     */
    protected ObjectCollection|null $notesScheduledForDeletion = null;

    /**
     * Items of Pledges relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Pledge>|null
     */
    protected ObjectCollection|null $pledgesScheduledForDeletion = null;

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
        $this->fam_enteredby = 0;
        $this->fam_editedby = 0;
        $this->fam_sendnewsletter = 'FALSE';
        $this->fam_envelope = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Family object.
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
     * Compares this with another <code>Family</code> instance. If
     * <code>obj</code> is an instance of <code>Family</code>, delegates to
     * <code>equals(Family)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [fam_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->fam_id;
    }

    /**
     * Get the [fam_name] column value.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->fam_name;
    }

    /**
     * Get the [fam_address1] column value.
     *
     * @return string|null
     */
    public function getAddress1()
    {
        return $this->fam_address1;
    }

    /**
     * Get the [fam_address2] column value.
     *
     * @return string|null
     */
    public function getAddress2()
    {
        return $this->fam_address2;
    }

    /**
     * Get the [fam_city] column value.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->fam_city;
    }

    /**
     * Get the [fam_state] column value.
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->fam_state;
    }

    /**
     * Get the [fam_zip] column value.
     *
     * @return string|null
     */
    public function getZip()
    {
        return $this->fam_zip;
    }

    /**
     * Get the [fam_country] column value.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->fam_country;
    }

    /**
     * Get the [fam_homephone] column value.
     *
     * @return string|null
     */
    public function getHomePhone()
    {
        return $this->fam_homephone;
    }

    /**
     * Get the [fam_email] column value.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->fam_email;
    }

    /**
     * Get the [optionally formatted] temporal [fam_weddingdate] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getWeddingdate($format = null)
    {
        if ($format === null) {
            return $this->fam_weddingdate;
        } else {
            return $this->fam_weddingdate instanceof DateTimeInterface ? $this->fam_weddingdate->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [fam_dateentered] column value.
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
            return $this->fam_dateentered;
        } else {
            return $this->fam_dateentered instanceof DateTimeInterface ? $this->fam_dateentered->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [fam_datelastedited] column value.
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
            return $this->fam_datelastedited;
        } else {
            return $this->fam_datelastedited instanceof DateTimeInterface ? $this->fam_datelastedited->format($format) : null;
        }
    }

    /**
     * Get the [fam_enteredby] column value.
     *
     * @return int|null
     */
    public function getEnteredBy()
    {
        return $this->fam_enteredby;
    }

    /**
     * Get the [fam_editedby] column value.
     *
     * @return int|null
     */
    public function getEditedBy()
    {
        return $this->fam_editedby;
    }

    /**
     * Get the [fam_scancheck] column value.
     *
     * @return string|null
     */
    public function getScanCheck()
    {
        return $this->fam_scancheck;
    }

    /**
     * Get the [fam_scancredit] column value.
     *
     * @return string|null
     */
    public function getScanCredit()
    {
        return $this->fam_scancredit;
    }

    /**
     * Get the [fam_sendnewsletter] column value.
     *
     * @return string|null
     */
    public function getSendNewsletter()
    {
        return $this->fam_sendnewsletter;
    }

    /**
     * Get the [optionally formatted] temporal [fam_datedeactivated] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getDateDeactivated($format = null)
    {
        if ($format === null) {
            return $this->fam_datedeactivated;
        } else {
            return $this->fam_datedeactivated instanceof DateTimeInterface ? $this->fam_datedeactivated->format($format) : null;
        }
    }

    /**
     * Get the [fam_latitude] column value.
     *
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->fam_latitude;
    }

    /**
     * Get the [fam_longitude] column value.
     *
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->fam_longitude;
    }

    /**
     * Get the [fam_envelope] column value.
     *
     * @return int|null
     */
    public function getEnvelope()
    {
        return $this->fam_envelope;
    }

    /**
     * Set the value of [fam_id] column.
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

        if ($this->fam_id !== $v) {
            $this->fam_id = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_name] column.
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

        if ($this->fam_name !== $v) {
            $this->fam_name = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_NAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_address1] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setAddress1($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_address1 !== $v) {
            $this->fam_address1 = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_ADDRESS1] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_address2] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setAddress2($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_address2 !== $v) {
            $this->fam_address2 = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_ADDRESS2] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_city] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setCity($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_city !== $v) {
            $this->fam_city = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_CITY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_state] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_state !== $v) {
            $this->fam_state = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_STATE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_zip] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setZip($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_zip !== $v) {
            $this->fam_zip = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_ZIP] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_country] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setCountry($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_country !== $v) {
            $this->fam_country = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_COUNTRY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_homephone] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setHomePhone($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_homephone !== $v) {
            $this->fam_homephone = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_HOMEPHONE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_email] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_email !== $v) {
            $this->fam_email = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_EMAIL] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [fam_weddingdate] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setWeddingdate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->fam_weddingdate !== null || $dt !== null) {
            if ($this->fam_weddingdate === null || $dt === null || $dt->format('Y-m-d') !== $this->fam_weddingdate->format('Y-m-d')) {
                $this->fam_weddingdate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FamilyTableMap::COL_FAM_WEDDINGDATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [fam_dateentered] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateEntered($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->fam_dateentered !== null || $dt !== null) {
            if ($this->fam_dateentered === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->fam_dateentered->format('Y-m-d H:i:s.u')) {
                $this->fam_dateentered = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FamilyTableMap::COL_FAM_DATEENTERED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [fam_datelastedited] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateLastEdited($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->fam_datelastedited !== null || $dt !== null) {
            if ($this->fam_datelastedited === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->fam_datelastedited->format('Y-m-d H:i:s.u')) {
                $this->fam_datelastedited = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FamilyTableMap::COL_FAM_DATELASTEDITED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [fam_enteredby] column.
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

        if ($this->fam_enteredby !== $v) {
            $this->fam_enteredby = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_ENTEREDBY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_editedby] column.
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

        if ($this->fam_editedby !== $v) {
            $this->fam_editedby = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_EDITEDBY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_scancheck] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setScanCheck($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_scancheck !== $v) {
            $this->fam_scancheck = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_SCANCHECK] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_scancredit] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setScanCredit($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_scancredit !== $v) {
            $this->fam_scancredit = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_SCANCREDIT] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_sendnewsletter] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setSendNewsletter($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->fam_sendnewsletter !== $v) {
            $this->fam_sendnewsletter = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_SENDNEWSLETTER] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [fam_datedeactivated] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateDeactivated($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->fam_datedeactivated !== null || $dt !== null) {
            if ($this->fam_datedeactivated === null || $dt === null || $dt->format('Y-m-d') !== $this->fam_datedeactivated->format('Y-m-d')) {
                $this->fam_datedeactivated = $dt === null ? null : clone $dt;
                $this->modifiedColumns[FamilyTableMap::COL_FAM_DATEDEACTIVATED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [fam_latitude] column.
     *
     * @param float|null $v New value
     *
     * @return $this
     */
    public function setLatitude($v)
    {
        if ($v !== null) {
            $v = (float)$v;
        }

        if ($this->fam_latitude !== $v) {
            $this->fam_latitude = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_LATITUDE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_longitude] column.
     *
     * @param float|null $v New value
     *
     * @return $this
     */
    public function setLongitude($v)
    {
        if ($v !== null) {
            $v = (float)$v;
        }

        if ($this->fam_longitude !== $v) {
            $this->fam_longitude = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_LONGITUDE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [fam_envelope] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setEnvelope($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->fam_envelope !== $v) {
            $this->fam_envelope = $v;
            $this->modifiedColumns[FamilyTableMap::COL_FAM_ENVELOPE] = true;
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
        if ($this->fam_enteredby !== 0) {
            return false;
        }

        if ($this->fam_editedby !== 0) {
            return false;
        }

        if ($this->fam_sendnewsletter !== 'FALSE') {
            return false;
        }

        if ($this->fam_envelope !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : FamilyTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : FamilyTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_name = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : FamilyTableMap::translateFieldName('Address1', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_address1 = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : FamilyTableMap::translateFieldName('Address2', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_address2 = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : FamilyTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_city = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : FamilyTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_state = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : FamilyTableMap::translateFieldName('Zip', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_zip = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : FamilyTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_country = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : FamilyTableMap::translateFieldName('HomePhone', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_homephone = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : FamilyTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_email = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : FamilyTableMap::translateFieldName('Weddingdate', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->fam_weddingdate = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : FamilyTableMap::translateFieldName('DateEntered', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->fam_dateentered = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 12 : FamilyTableMap::translateFieldName('DateLastEdited', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->fam_datelastedited = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 13 : FamilyTableMap::translateFieldName('EnteredBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_enteredby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 14 : FamilyTableMap::translateFieldName('EditedBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_editedby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 15 : FamilyTableMap::translateFieldName('ScanCheck', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_scancheck = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 16 : FamilyTableMap::translateFieldName('ScanCredit', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_scancredit = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 17 : FamilyTableMap::translateFieldName('SendNewsletter', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_sendnewsletter = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 18 : FamilyTableMap::translateFieldName('DateDeactivated', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->fam_datedeactivated = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 19 : FamilyTableMap::translateFieldName('Latitude', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_latitude = $columnValue !== null ? (float)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 20 : FamilyTableMap::translateFieldName('Longitude', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_longitude = $columnValue !== null ? (float)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 21 : FamilyTableMap::translateFieldName('Envelope', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->fam_envelope = $columnValue !== null ? (int)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 22;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Family object', 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(FamilyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildFamilyQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->collPeople = null;
            $this->singleFamilyCustom = null;
            $this->collNotes = null;
            $this->collPledges = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Family::setDeleted()
     * @see Family::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildFamilyQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(FamilyTableMap::DATABASE_NAME);
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
                FamilyTableMap::addInstanceToPool($this);
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

        if ($this->peopleScheduledForDeletion !== null) {
            if (!$this->peopleScheduledForDeletion->isEmpty()) {
                ChildPersonQuery::create()
                    ->filterByPrimaryKeys($this->peopleScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->peopleScheduledForDeletion = null;
            }
        }

        if ($this->collPeople !== null) {
            foreach ($this->collPeople as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->singleFamilyCustom !== null) {
            if (!$this->singleFamilyCustom->isDeleted() && ($this->singleFamilyCustom->isNew() || $this->singleFamilyCustom->isModified())) {
                $affectedRows += $this->singleFamilyCustom->save($con);
            }
        }

        if ($this->notesScheduledForDeletion !== null) {
            if (!$this->notesScheduledForDeletion->isEmpty()) {
                ChildNoteQuery::create()
                    ->filterByPrimaryKeys($this->notesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->notesScheduledForDeletion = null;
            }
        }

        if ($this->collNotes !== null) {
            foreach ($this->collNotes as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->pledgesScheduledForDeletion !== null) {
            if (!$this->pledgesScheduledForDeletion->isEmpty()) {
                foreach ($this->pledgesScheduledForDeletion as $pledge) {
                    // need to save related object because we set the relation to null
                    $pledge->save($con);
                }
                $this->pledgesScheduledForDeletion = null;
            }
        }

        if ($this->collPledges !== null) {
            foreach ($this->collPledges as $referrerFK) {
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
        $this->modifiedColumns[FamilyTableMap::COL_FAM_ID] = true;
        if ($this->fam_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FamilyTableMap::COL_FAM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ID)) {
            $modifiedColumns[':p' . $index++] = 'fam_ID';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_NAME)) {
            $modifiedColumns[':p' . $index++] = 'fam_Name';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ADDRESS1)) {
            $modifiedColumns[':p' . $index++] = 'fam_Address1';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ADDRESS2)) {
            $modifiedColumns[':p' . $index++] = 'fam_Address2';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_CITY)) {
            $modifiedColumns[':p' . $index++] = 'fam_City';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_STATE)) {
            $modifiedColumns[':p' . $index++] = 'fam_State';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ZIP)) {
            $modifiedColumns[':p' . $index++] = 'fam_Zip';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_COUNTRY)) {
            $modifiedColumns[':p' . $index++] = 'fam_Country';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_HOMEPHONE)) {
            $modifiedColumns[':p' . $index++] = 'fam_HomePhone';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_EMAIL)) {
            $modifiedColumns[':p' . $index++] = 'fam_Email';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_WEDDINGDATE)) {
            $modifiedColumns[':p' . $index++] = 'fam_WeddingDate';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_DATEENTERED)) {
            $modifiedColumns[':p' . $index++] = 'fam_DateEntered';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_DATELASTEDITED)) {
            $modifiedColumns[':p' . $index++] = 'fam_DateLastEdited';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ENTEREDBY)) {
            $modifiedColumns[':p' . $index++] = 'fam_EnteredBy';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_EDITEDBY)) {
            $modifiedColumns[':p' . $index++] = 'fam_EditedBy';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_SCANCHECK)) {
            $modifiedColumns[':p' . $index++] = 'fam_scanCheck';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_SCANCREDIT)) {
            $modifiedColumns[':p' . $index++] = 'fam_scanCredit';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_SENDNEWSLETTER)) {
            $modifiedColumns[':p' . $index++] = 'fam_SendNewsLetter';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_DATEDEACTIVATED)) {
            $modifiedColumns[':p' . $index++] = 'fam_DateDeactivated';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_LATITUDE)) {
            $modifiedColumns[':p' . $index++] = 'fam_Latitude';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_LONGITUDE)) {
            $modifiedColumns[':p' . $index++] = 'fam_Longitude';
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ENVELOPE)) {
            $modifiedColumns[':p' . $index++] = 'fam_Envelope';
        }

        $sql = sprintf(
            'INSERT INTO family_fam (%s) VALUES (%s)',
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
                    case 'fam_ID':
                        $stmt->bindValue($identifier, $this->fam_id, PDO::PARAM_INT);

                        break;
                    case 'fam_Name':
                        $stmt->bindValue($identifier, $this->fam_name, PDO::PARAM_STR);

                        break;
                    case 'fam_Address1':
                        $stmt->bindValue($identifier, $this->fam_address1, PDO::PARAM_STR);

                        break;
                    case 'fam_Address2':
                        $stmt->bindValue($identifier, $this->fam_address2, PDO::PARAM_STR);

                        break;
                    case 'fam_City':
                        $stmt->bindValue($identifier, $this->fam_city, PDO::PARAM_STR);

                        break;
                    case 'fam_State':
                        $stmt->bindValue($identifier, $this->fam_state, PDO::PARAM_STR);

                        break;
                    case 'fam_Zip':
                        $stmt->bindValue($identifier, $this->fam_zip, PDO::PARAM_STR);

                        break;
                    case 'fam_Country':
                        $stmt->bindValue($identifier, $this->fam_country, PDO::PARAM_STR);

                        break;
                    case 'fam_HomePhone':
                        $stmt->bindValue($identifier, $this->fam_homephone, PDO::PARAM_STR);

                        break;
                    case 'fam_Email':
                        $stmt->bindValue($identifier, $this->fam_email, PDO::PARAM_STR);

                        break;
                    case 'fam_WeddingDate':
                        $stmt->bindValue($identifier, $this->fam_weddingdate ? $this->fam_weddingdate->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'fam_DateEntered':
                        $stmt->bindValue($identifier, $this->fam_dateentered ? $this->fam_dateentered->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'fam_DateLastEdited':
                        $stmt->bindValue($identifier, $this->fam_datelastedited ? $this->fam_datelastedited->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'fam_EnteredBy':
                        $stmt->bindValue($identifier, $this->fam_enteredby, PDO::PARAM_INT);

                        break;
                    case 'fam_EditedBy':
                        $stmt->bindValue($identifier, $this->fam_editedby, PDO::PARAM_INT);

                        break;
                    case 'fam_scanCheck':
                        $stmt->bindValue($identifier, $this->fam_scancheck, PDO::PARAM_STR);

                        break;
                    case 'fam_scanCredit':
                        $stmt->bindValue($identifier, $this->fam_scancredit, PDO::PARAM_STR);

                        break;
                    case 'fam_SendNewsLetter':
                        $stmt->bindValue($identifier, $this->fam_sendnewsletter, PDO::PARAM_STR);

                        break;
                    case 'fam_DateDeactivated':
                        $stmt->bindValue($identifier, $this->fam_datedeactivated ? $this->fam_datedeactivated->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'fam_Latitude':
                        $stmt->bindValue($identifier, $this->fam_latitude, PDO::PARAM_STR);

                        break;
                    case 'fam_Longitude':
                        $stmt->bindValue($identifier, $this->fam_longitude, PDO::PARAM_STR);

                        break;
                    case 'fam_Envelope':
                        $stmt->bindValue($identifier, $this->fam_envelope, PDO::PARAM_INT);

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
        $pos = FamilyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            2 => $this->getAddress1(),
            3 => $this->getAddress2(),
            4 => $this->getCity(),
            5 => $this->getState(),
            6 => $this->getZip(),
            7 => $this->getCountry(),
            8 => $this->getHomePhone(),
            9 => $this->getEmail(),
            10 => $this->getWeddingdate(),
            11 => $this->getDateEntered(),
            12 => $this->getDateLastEdited(),
            13 => $this->getEnteredBy(),
            14 => $this->getEditedBy(),
            15 => $this->getScanCheck(),
            16 => $this->getScanCredit(),
            17 => $this->getSendNewsletter(),
            18 => $this->getDateDeactivated(),
            19 => $this->getLatitude(),
            20 => $this->getLongitude(),
            21 => $this->getEnvelope(),
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
        if (isset($alreadyDumpedObjects['Family'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Family'][$this->hashCode()] = true;
        $keys = FamilyTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAddress1(),
            $keys[3] => $this->getAddress2(),
            $keys[4] => $this->getCity(),
            $keys[5] => $this->getState(),
            $keys[6] => $this->getZip(),
            $keys[7] => $this->getCountry(),
            $keys[8] => $this->getHomePhone(),
            $keys[9] => $this->getEmail(),
            $keys[10] => $this->getWeddingdate(),
            $keys[11] => $this->getDateEntered(),
            $keys[12] => $this->getDateLastEdited(),
            $keys[13] => $this->getEnteredBy(),
            $keys[14] => $this->getEditedBy(),
            $keys[15] => $this->getScanCheck(),
            $keys[16] => $this->getScanCredit(),
            $keys[17] => $this->getSendNewsletter(),
            $keys[18] => $this->getDateDeactivated(),
            $keys[19] => $this->getLatitude(),
            $keys[20] => $this->getLongitude(),
            $keys[21] => $this->getEnvelope(),
        ];
        if ($result[$keys[10]] instanceof DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('Y-m-d');
        }

        if ($result[$keys[11]] instanceof DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[12]] instanceof DateTimeInterface) {
            $result[$keys[12]] = $result[$keys[12]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[18]] instanceof DateTimeInterface) {
            $result[$keys[18]] = $result[$keys[18]]->format('Y-m-d');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->collPeople !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'people',
                     TableMap::TYPE_FIELDNAME => 'person_pers',
                     default => 'People',
                };
                $result[$key] = $this->collPeople->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->singleFamilyCustom !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'familyCustom',
                     TableMap::TYPE_FIELDNAME => 'family_custom',
                     default => 'FamilyCustom',
                };
                $result[$key] = $this->singleFamilyCustom->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collNotes !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'notes',
                     TableMap::TYPE_FIELDNAME => 'note_ntes',
                     default => 'Notes',
                };
                $result[$key] = $this->collNotes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collPledges !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'pledges',
                     TableMap::TYPE_FIELDNAME => 'pledge_plgs',
                     default => 'Pledges',
                };
                $result[$key] = $this->collPledges->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FamilyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setAddress1($value);

                break;
            case 3:
                $this->setAddress2($value);

                break;
            case 4:
                $this->setCity($value);

                break;
            case 5:
                $this->setState($value);

                break;
            case 6:
                $this->setZip($value);

                break;
            case 7:
                $this->setCountry($value);

                break;
            case 8:
                $this->setHomePhone($value);

                break;
            case 9:
                $this->setEmail($value);

                break;
            case 10:
                $this->setWeddingdate($value);

                break;
            case 11:
                $this->setDateEntered($value);

                break;
            case 12:
                $this->setDateLastEdited($value);

                break;
            case 13:
                $this->setEnteredBy($value);

                break;
            case 14:
                $this->setEditedBy($value);

                break;
            case 15:
                $this->setScanCheck($value);

                break;
            case 16:
                $this->setScanCredit($value);

                break;
            case 17:
                $this->setSendNewsletter($value);

                break;
            case 18:
                $this->setDateDeactivated($value);

                break;
            case 19:
                $this->setLatitude($value);

                break;
            case 20:
                $this->setLongitude($value);

                break;
            case 21:
                $this->setEnvelope($value);

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
        $keys = FamilyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAddress1($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAddress2($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCity($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setState($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setZip($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCountry($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setHomePhone($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setEmail($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setWeddingdate($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setDateEntered($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setDateLastEdited($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setEnteredBy($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setEditedBy($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setScanCheck($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setScanCredit($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setSendNewsletter($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setDateDeactivated($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setLatitude($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setLongitude($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setEnvelope($arr[$keys[21]]);
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
        $tableMap = FamilyTableMap::getTableMap();
        $criteria = new Criteria(FamilyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_ID'), $this->fam_id);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_NAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Name'), $this->fam_name);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ADDRESS1)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Address1'), $this->fam_address1);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ADDRESS2)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Address2'), $this->fam_address2);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_CITY)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_City'), $this->fam_city);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_STATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_State'), $this->fam_state);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ZIP)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Zip'), $this->fam_zip);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_COUNTRY)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Country'), $this->fam_country);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_HOMEPHONE)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_HomePhone'), $this->fam_homephone);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_EMAIL)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Email'), $this->fam_email);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_WEDDINGDATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_WeddingDate'), $this->fam_weddingdate);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_DATEENTERED)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_DateEntered'), $this->fam_dateentered);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_DATELASTEDITED)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_DateLastEdited'), $this->fam_datelastedited);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ENTEREDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_EnteredBy'), $this->fam_enteredby);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_EDITEDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_EditedBy'), $this->fam_editedby);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_SCANCHECK)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_scanCheck'), $this->fam_scancheck);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_SCANCREDIT)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_scanCredit'), $this->fam_scancredit);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_SENDNEWSLETTER)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_SendNewsLetter'), $this->fam_sendnewsletter);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_DATEDEACTIVATED)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_DateDeactivated'), $this->fam_datedeactivated);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_LATITUDE)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Latitude'), $this->fam_latitude);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_LONGITUDE)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Longitude'), $this->fam_longitude);
        }
        if ($this->isColumnModified(FamilyTableMap::COL_FAM_ENVELOPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('fam_Envelope'), $this->fam_envelope);
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
        $tableMap = FamilyTableMap::getTableMap();
        $query = ChildFamilyQuery::create();
        $fam_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('fam_ID'));
        $query->addAnd($fam_IDColumn, $this->fam_id);

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
     * Generic method to set the primary key (fam_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Family (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setName($this->getName());
        $copyObj->setAddress1($this->getAddress1());
        $copyObj->setAddress2($this->getAddress2());
        $copyObj->setCity($this->getCity());
        $copyObj->setState($this->getState());
        $copyObj->setZip($this->getZip());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setHomePhone($this->getHomePhone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setWeddingdate($this->getWeddingdate());
        $copyObj->setDateEntered($this->getDateEntered());
        $copyObj->setDateLastEdited($this->getDateLastEdited());
        $copyObj->setEnteredBy($this->getEnteredBy());
        $copyObj->setEditedBy($this->getEditedBy());
        $copyObj->setScanCheck($this->getScanCheck());
        $copyObj->setScanCredit($this->getScanCredit());
        $copyObj->setSendNewsletter($this->getSendNewsletter());
        $copyObj->setDateDeactivated($this->getDateDeactivated());
        $copyObj->setLatitude($this->getLatitude());
        $copyObj->setLongitude($this->getLongitude());
        $copyObj->setEnvelope($this->getEnvelope());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPeople() as $relObj) {
                $copyObj->addPerson($relObj->copy($deepCopy));
            }
            $relObj = $this->getFamilyCustom();
            if ($relObj) {
                $copyObj->setFamilyCustom($relObj->copy($deepCopy));
            }
            foreach ($this->getNotes() as $relObj) {
                $copyObj->addNote($relObj->copy($deepCopy));
            }
            foreach ($this->getPledges() as $relObj) {
                $copyObj->addPledge($relObj->copy($deepCopy));
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
            'Person' => $this->initPeople(),
            'Note' => $this->initNotes(),
            'Pledge' => $this->initPledges(),
            default => null
        };
    }

    /**
     * Initializes the collPeople collection.
     *
     * By default this just sets the collPeople collection to an empty array (like clearcollPeople());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPeople(bool $overrideExisting = true): void
    {
        if ($this->collPeople !== null && !$overrideExisting) {
            return;
        }

        $this->collPeople = new PersonCollection();
        $this->collPeople->setModel('\ChurchCRM\model\ChurchCRM\Person');
    }

    /**
     * Reset is the collPeople collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialPeople(bool $isPartial = true): void
    {
        $this->collPeoplePartial = $isPartial;
    }

    /**
     * Clears out the collPeople collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearPeople(): static
    {
        $this->collPeople = null;

        return $this;
    }

    /**
     * Gets family_fam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Family is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection
     */
    public function getPeople(?Criteria $criteria = null, ?ConnectionInterface $con = null): PersonCollection
    {
        $partial = $this->collPeoplePartial && !$this->isNew();
        if ($this->collPeople && !$criteria && !$partial) {
            return $this->collPeople;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collPeople === null) {
                $this->initPeople();

                return $this->collPeople;
            }

            $collPeople = new PersonCollection();
            $collPeople->setModel('\ChurchCRM\model\ChurchCRM\Base\Person');

            return $collPeople;
        }

        $collPeople = ChildPersonQuery::create(null, $criteria)
            ->filterByFamily($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collPeoplePartial !== false && count($collPeople)) {
                $this->initPeople(false);

                foreach ($collPeople as $obj) {
                    if (!$this->collPeople->contains($obj)) {
                        $this->collPeople->append($obj);
                    }
                }

                $this->collPeoplePartial = true;
            }

            return $collPeople;
        }

        if ($this->collPeoplePartial && $this->collPeople) {
            foreach ($this->collPeople as $obj) {
                if ($obj->isNew()) {
                    $collPeople[] = $obj;
                }
            }
        }

        $this->collPeople = $collPeople;
        $this->collPeoplePartial = false;

        return $this->collPeople;
    }

    /**
     * Sets a collection of family_fam objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Person> $people
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setPeople(Collection $people, ?ConnectionInterface $con = null): static
    {
        $peopleToDelete = $this->getPeople(null, $con)->diff($people);

        $this->peopleScheduledForDeletion = $peopleToDelete;

        foreach ($peopleToDelete as $personRemoved) {
            $personRemoved->setFamily(null);
        }

        $this->collPeople = null;
        foreach ($people as $person) {
            $this->addPerson($person);
        }

        $this->collPeoplePartial = false;
        $this->collPeople = $people instanceof PersonCollection
            ? $people : new PersonCollection($people->getData());

        return $this;
    }

    /**
     * Returns the number of related family_fam objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related family_fam objects.
     */
    public function countPeople(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPeoplePartial && !$this->isNew();
        if ($this->collPeople === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collPeople === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPeople());
            }

            $query = ChildPersonQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFamily($this)
                ->count($con);
        }

        return count($this->collPeople);
    }

    /**
     * Method called to associate a Person object to this object
     * through the Person foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person $person
     *
     * @return $this
     */
    public function addPerson(Person $person)
    {
        if ($this->collPeople === null) {
            $this->initPeople();
            $this->collPeoplePartial = true;
        }

        if (!$this->collPeople->contains($person)) {
            $this->doAddPerson($person);

            if ($this->peopleScheduledForDeletion && $this->peopleScheduledForDeletion->contains($person)) {
                $this->peopleScheduledForDeletion->remove($this->peopleScheduledForDeletion->search($person));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Person $person The Person object to add.
     *
     * @return void
     */
    protected function doAddPerson(Person $person): void
    {
        $this->collPeople->append($person);
        $person->setFamily($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Person $person The Person object to remove.
     *
     * @return static
     */
    public function removePerson(Person $person): static
    {
        if ($this->getPeople()->contains($person)) {
            $pos = $this->collPeople->search($person);
            $this->collPeople->remove($pos);
            if ($this->peopleScheduledForDeletion === null) {
                $this->peopleScheduledForDeletion = clone $this->collPeople;
                $this->peopleScheduledForDeletion->clear();
            }
            $this->peopleScheduledForDeletion->append(clone $person);
            $person->setFamily(null);
        }

        return $this;
    }

    /**
     * Gets a single FamilyCustom object, which is related to this object by a one-to-one relationship.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\FamilyCustom|null
     */
    public function getFamilyCustom(?ConnectionInterface $con = null)
    {
        if ($this->singleFamilyCustom === null && !$this->isNew()) {
            $this->singleFamilyCustom = ChildFamilyCustomQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleFamilyCustom;
    }

    /**
     * Sets a single FamilyCustom object as related to this object by a one-to-one relationship.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\FamilyCustom|null $v
     *
     * @return $this
     */
    public function setFamilyCustom(?FamilyCustom $v = null)
    {
        $this->singleFamilyCustom = $v;

        // Make sure that that the passed-in FamilyCustom isn't already associated with this object
        if ($v && $v->getFamily() === null) {
            $v->setFamily($this);
        }

        return $this;
    }

    /**
     * Initializes the collNotes collection.
     *
     * By default this just sets the collNotes collection to an empty array (like clearcollNotes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initNotes(bool $overrideExisting = true): void
    {
        if ($this->collNotes !== null && !$overrideExisting) {
            return;
        }

        $this->collNotes = new NoteCollection();
        $this->collNotes->setModel('\ChurchCRM\model\ChurchCRM\Note');
    }

    /**
     * Reset is the collNotes collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialNotes(bool $isPartial = true): void
    {
        $this->collNotesPartial = $isPartial;
    }

    /**
     * Clears out the collNotes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearNotes(): static
    {
        $this->collNotes = null;

        return $this;
    }

    /**
     * Gets family_fam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Family is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection
     */
    public function getNotes(?Criteria $criteria = null, ?ConnectionInterface $con = null): NoteCollection
    {
        $partial = $this->collNotesPartial && !$this->isNew();
        if ($this->collNotes && !$criteria && !$partial) {
            return $this->collNotes;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collNotes === null) {
                $this->initNotes();

                return $this->collNotes;
            }

            $collNotes = new NoteCollection();
            $collNotes->setModel('\ChurchCRM\model\ChurchCRM\Base\Note');

            return $collNotes;
        }

        $collNotes = ChildNoteQuery::create(null, $criteria)
            ->filterByFamily($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collNotesPartial !== false && count($collNotes)) {
                $this->initNotes(false);

                foreach ($collNotes as $obj) {
                    if (!$this->collNotes->contains($obj)) {
                        $this->collNotes->append($obj);
                    }
                }

                $this->collNotesPartial = true;
            }

            return $collNotes;
        }

        if ($this->collNotesPartial && $this->collNotes) {
            foreach ($this->collNotes as $obj) {
                if ($obj->isNew()) {
                    $collNotes[] = $obj;
                }
            }
        }

        $this->collNotes = $collNotes;
        $this->collNotesPartial = false;

        return $this->collNotes;
    }

    /**
     * Sets a collection of family_fam objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Note> $notes
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setNotes(Collection $notes, ?ConnectionInterface $con = null): static
    {
        $notesToDelete = $this->getNotes(null, $con)->diff($notes);

        $this->notesScheduledForDeletion = $notesToDelete;

        foreach ($notesToDelete as $noteRemoved) {
            $noteRemoved->setFamily(null);
        }

        $this->collNotes = null;
        foreach ($notes as $note) {
            $this->addNote($note);
        }

        $this->collNotesPartial = false;
        $this->collNotes = $notes instanceof NoteCollection
            ? $notes : new NoteCollection($notes->getData());

        return $this;
    }

    /**
     * Returns the number of related family_fam objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related family_fam objects.
     */
    public function countNotes(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collNotesPartial && !$this->isNew();
        if ($this->collNotes === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collNotes === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getNotes());
            }

            $query = ChildNoteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFamily($this)
                ->count($con);
        }

        return count($this->collNotes);
    }

    /**
     * Method called to associate a Note object to this object
     * through the Note foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Note $note
     *
     * @return $this
     */
    public function addNote(Note $note)
    {
        if ($this->collNotes === null) {
            $this->initNotes();
            $this->collNotesPartial = true;
        }

        if (!$this->collNotes->contains($note)) {
            $this->doAddNote($note);

            if ($this->notesScheduledForDeletion && $this->notesScheduledForDeletion->contains($note)) {
                $this->notesScheduledForDeletion->remove($this->notesScheduledForDeletion->search($note));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Note $note The Note object to add.
     *
     * @return void
     */
    protected function doAddNote(Note $note): void
    {
        $this->collNotes->append($note);
        $note->setFamily($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Note $note The Note object to remove.
     *
     * @return static
     */
    public function removeNote(Note $note): static
    {
        if ($this->getNotes()->contains($note)) {
            $pos = $this->collNotes->search($note);
            $this->collNotes->remove($pos);
            if ($this->notesScheduledForDeletion === null) {
                $this->notesScheduledForDeletion = clone $this->collNotes;
                $this->notesScheduledForDeletion->clear();
            }
            $this->notesScheduledForDeletion->append(clone $note);
            $note->setFamily(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this family_fam is new, it will return
     * an empty collection; or if this family_fam has previously
     * been saved, it will retrieve related Notes from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection
     */
    public function getNotesJoinPerson(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): NoteCollection {
        $query = ChildNoteQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getNotes($query, $con);
    }

    /**
     * Initializes the collPledges collection.
     *
     * By default this just sets the collPledges collection to an empty array (like clearcollPledges());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPledges(bool $overrideExisting = true): void
    {
        if ($this->collPledges !== null && !$overrideExisting) {
            return;
        }

        $this->collPledges = new PledgeCollection();
        $this->collPledges->setModel('\ChurchCRM\model\ChurchCRM\Pledge');
    }

    /**
     * Reset is the collPledges collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialPledges(bool $isPartial = true): void
    {
        $this->collPledgesPartial = $isPartial;
    }

    /**
     * Clears out the collPledges collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearPledges(): static
    {
        $this->collPledges = null;

        return $this;
    }

    /**
     * Gets family_fam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Family is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection
     */
    public function getPledges(?Criteria $criteria = null, ?ConnectionInterface $con = null): PledgeCollection
    {
        $partial = $this->collPledgesPartial && !$this->isNew();
        if ($this->collPledges && !$criteria && !$partial) {
            return $this->collPledges;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collPledges === null) {
                $this->initPledges();

                return $this->collPledges;
            }

            $collPledges = new PledgeCollection();
            $collPledges->setModel('\ChurchCRM\model\ChurchCRM\Base\Pledge');

            return $collPledges;
        }

        $collPledges = ChildPledgeQuery::create(null, $criteria)
            ->filterByFamily($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collPledgesPartial !== false && count($collPledges)) {
                $this->initPledges(false);

                foreach ($collPledges as $obj) {
                    if (!$this->collPledges->contains($obj)) {
                        $this->collPledges->append($obj);
                    }
                }

                $this->collPledgesPartial = true;
            }

            return $collPledges;
        }

        if ($this->collPledgesPartial && $this->collPledges) {
            foreach ($this->collPledges as $obj) {
                if ($obj->isNew()) {
                    $collPledges[] = $obj;
                }
            }
        }

        $this->collPledges = $collPledges;
        $this->collPledgesPartial = false;

        return $this->collPledges;
    }

    /**
     * Sets a collection of family_fam objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Pledge> $pledges
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setPledges(Collection $pledges, ?ConnectionInterface $con = null): static
    {
        $pledgesToDelete = $this->getPledges(null, $con)->diff($pledges);

        $this->pledgesScheduledForDeletion = $pledgesToDelete;

        foreach ($pledgesToDelete as $pledgeRemoved) {
            $pledgeRemoved->setFamily(null);
        }

        $this->collPledges = null;
        foreach ($pledges as $pledge) {
            $this->addPledge($pledge);
        }

        $this->collPledgesPartial = false;
        $this->collPledges = $pledges instanceof PledgeCollection
            ? $pledges : new PledgeCollection($pledges->getData());

        return $this;
    }

    /**
     * Returns the number of related family_fam objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related family_fam objects.
     */
    public function countPledges(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPledgesPartial && !$this->isNew();
        if ($this->collPledges === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collPledges === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPledges());
            }

            $query = ChildPledgeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFamily($this)
                ->count($con);
        }

        return count($this->collPledges);
    }

    /**
     * Method called to associate a Pledge object to this object
     * through the Pledge foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Pledge $pledge
     *
     * @return $this
     */
    public function addPledge(Pledge $pledge)
    {
        if ($this->collPledges === null) {
            $this->initPledges();
            $this->collPledgesPartial = true;
        }

        if (!$this->collPledges->contains($pledge)) {
            $this->doAddPledge($pledge);

            if ($this->pledgesScheduledForDeletion && $this->pledgesScheduledForDeletion->contains($pledge)) {
                $this->pledgesScheduledForDeletion->remove($this->pledgesScheduledForDeletion->search($pledge));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Pledge $pledge The Pledge object to add.
     *
     * @return void
     */
    protected function doAddPledge(Pledge $pledge): void
    {
        $this->collPledges->append($pledge);
        $pledge->setFamily($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Pledge $pledge The Pledge object to remove.
     *
     * @return static
     */
    public function removePledge(Pledge $pledge): static
    {
        if ($this->getPledges()->contains($pledge)) {
            $pos = $this->collPledges->search($pledge);
            $this->collPledges->remove($pos);
            if ($this->pledgesScheduledForDeletion === null) {
                $this->pledgesScheduledForDeletion = clone $this->collPledges;
                $this->pledgesScheduledForDeletion->clear();
            }
            $this->pledgesScheduledForDeletion->append($pledge);
            $pledge->setFamily(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this family_fam is new, it will return
     * an empty collection; or if this family_fam has previously
     * been saved, it will retrieve related Pledges from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection
     */
    public function getPledgesJoinDeposit(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): PledgeCollection {
        $query = ChildPledgeQuery::create(null, $criteria);
        $query->joinWith('Deposit', $joinBehavior);

        return $this->getPledges($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this family_fam is new, it will return
     * an empty collection; or if this family_fam has previously
     * been saved, it will retrieve related Pledges from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection
     */
    public function getPledgesJoinDonationFund(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): PledgeCollection {
        $query = ChildPledgeQuery::create(null, $criteria);
        $query->joinWith('DonationFund', $joinBehavior);

        return $this->getPledges($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this family_fam is new, it will return
     * an empty collection; or if this family_fam has previously
     * been saved, it will retrieve related Pledges from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection
     */
    public function getPledgesJoinPerson(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): PledgeCollection {
        $query = ChildPledgeQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getPledges($query, $con);
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
        $this->fam_id = null;
        $this->fam_name = null;
        $this->fam_address1 = null;
        $this->fam_address2 = null;
        $this->fam_city = null;
        $this->fam_state = null;
        $this->fam_zip = null;
        $this->fam_country = null;
        $this->fam_homephone = null;
        $this->fam_email = null;
        $this->fam_weddingdate = null;
        $this->fam_dateentered = null;
        $this->fam_datelastedited = null;
        $this->fam_enteredby = null;
        $this->fam_editedby = null;
        $this->fam_scancheck = null;
        $this->fam_scancredit = null;
        $this->fam_sendnewsletter = null;
        $this->fam_datedeactivated = null;
        $this->fam_latitude = null;
        $this->fam_longitude = null;
        $this->fam_envelope = null;
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
            if ($this->collPeople) {
                foreach ($this->collPeople as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleFamilyCustom) {
                $this->singleFamilyCustom->clearAllReferences($deep);
            }
            if ($this->collNotes) {
                foreach ($this->collNotes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPledges) {
                foreach ($this->collPledges as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collPeople = null;
        $this->singleFamilyCustom = null;
        $this->collNotes = null;
        $this->collPledges = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(FamilyTableMap::DEFAULT_STRING_FORMAT);
    }

    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('fam_name', new NotNull());
        $metadata->addPropertyConstraint('fam_name', new NotBlank());
        $metadata->addPropertyConstraint('fam_name', new Length(array ('min' => 2,'max' => 50,)));
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param ValidatorInterface|null $validator A Validator class instance
     * @return bool Whether all objects pass validation.
     */
    public function validate(?ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new RecursiveValidator(
                new ExecutionContextFactory(new IdentityTranslator()),
                new LazyLoadingMetadataFactory(new StaticMethodLoader()),
                new ConstraintValidatorFactory()
            );
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;


            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collPeople) {
                foreach ($this->collPeople as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collNotes) {
                foreach ($this->collNotes as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPledges) {
                foreach ($this->collPledges as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (bool) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
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
