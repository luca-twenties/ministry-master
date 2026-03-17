<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\WhyCameCollection;
use ChurchCRM\model\ChurchCRM\EventAttendQuery as ChildEventAttendQuery;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\FamilyQuery as ChildFamilyQuery;
use ChurchCRM\model\ChurchCRM\Map\PersonTableMap;
use ChurchCRM\model\ChurchCRM\NoteQuery as ChildNoteQuery;
use ChurchCRM\model\ChurchCRM\Person2group2roleP2g2rQuery as ChildPerson2group2roleP2g2rQuery;
use ChurchCRM\model\ChurchCRM\PersonCustomQuery as ChildPersonCustomQuery;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
use ChurchCRM\model\ChurchCRM\PledgeQuery as ChildPledgeQuery;
use ChurchCRM\model\ChurchCRM\UserQuery as ChildUserQuery;
use ChurchCRM\model\ChurchCRM\WhyCameQuery as ChildWhyCameQuery;
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
 * Base class that represents a row from the 'person_per' table.
 *
 * This contains the main person data, including person names, person addresses, person phone numbers, and foreign keys to the family table
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Person implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\PersonTableMap';

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
     * The value for the per_id field.
     */
    protected int|null $per_id = null;

    /**
     * The value for the per_title field.
     */
    protected string|null $per_title = null;

    /**
     * The value for the per_firstname field.
     */
    protected string|null $per_firstname = null;

    /**
     * The value for the per_middlename field.
     */
    protected string|null $per_middlename = null;

    /**
     * The value for the per_lastname field.
     */
    protected string|null $per_lastname = null;

    /**
     * The value for the per_suffix field.
     */
    protected string|null $per_suffix = null;

    /**
     * The value for the per_address1 field.
     */
    protected string|null $per_address1 = null;

    /**
     * The value for the per_address2 field.
     */
    protected string|null $per_address2 = null;

    /**
     * The value for the per_city field.
     */
    protected string|null $per_city = null;

    /**
     * The value for the per_state field.
     */
    protected string|null $per_state = null;

    /**
     * The value for the per_zip field.
     */
    protected string|null $per_zip = null;

    /**
     * The value for the per_country field.
     */
    protected string|null $per_country = null;

    /**
     * The value for the per_homephone field.
     */
    protected string|null $per_homephone = null;

    /**
     * The value for the per_workphone field.
     */
    protected string|null $per_workphone = null;

    /**
     * The value for the per_cellphone field.
     */
    protected string|null $per_cellphone = null;

    /**
     * The value for the per_email field.
     */
    protected string|null $per_email = null;

    /**
     * The value for the per_workemail field.
     */
    protected string|null $per_workemail = null;

    /**
     * The value for the per_birthmonth field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_birthmonth = null;

    /**
     * The value for the per_birthday field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_birthday = null;

    /**
     * The value for the per_birthyear field.
     */
    protected int|null $per_birthyear = null;

    /**
     * The value for the per_membershipdate field.
     */
    protected DateTimeInterface|null $per_membershipdate = null;

    /**
     * The value for the per_gender field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_gender = null;

    /**
     * The value for the per_fmr_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_fmr_id = null;

    /**
     * The value for the per_cls_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_cls_id = null;

    /**
     * The value for the per_fam_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_fam_id = null;

    /**
     * The value for the per_envelope field.
     */
    protected int|null $per_envelope = null;

    /**
     * The value for the per_datelastedited field.
     */
    protected DateTimeInterface|null $per_datelastedited = null;

    /**
     * The value for the per_dateentered field.
     */
    protected DateTimeInterface|null $per_dateentered = null;

    /**
     * The value for the per_enteredby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_enteredby = null;

    /**
     * The value for the per_editedby field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_editedby = null;

    /**
     * The value for the per_frienddate field.
     */
    protected DateTimeInterface|null $per_frienddate = null;

    /**
     * The value for the per_flags field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $per_flags = null;

    /**
     * The value for the per_facebook field.
     *
     * Facebook username
     */
    protected string|null $per_facebook = null;

    /**
     * The value for the per_twitter field.
     *
     * Twitter username
     */
    protected string|null $per_twitter = null;

    /**
     * The value for the per_linkedin field.
     *
     * LinkedIn name
     */
    protected string|null $per_linkedin = null;

    /**
     * Family associated via Family relation (n:1).
     */
    protected Family|null $aFamily = null;

    /**
     * Objects associated via WhyCame relation (1:n).
     */
    protected WhyCameCollection|null $collWhyCames = null;

    /**
     * If $collWhyCames contains all objects in WhyCame relation.
     */
    protected bool $collWhyCamesPartial = false;

    /**
     * PersonCustom associated via PersonCustom relation (1:1).
     */
    protected PersonCustom|null $singlePersonCustom = null;

    /**
     * Objects associated via Note relation (1:n).
     */
    protected NoteCollection|null $collNotes = null;

    /**
     * If $collNotes contains all objects in Note relation.
     */
    protected bool $collNotesPartial = false;

    /**
     * Objects associated via Person2group2roleP2g2r relation (1:n).
     */
    protected Person2group2roleP2g2rCollection|null $collPerson2group2roleP2g2rs = null;

    /**
     * If $collPerson2group2roleP2g2rs contains all objects in Person2group2roleP2g2r relation.
     */
    protected bool $collPerson2group2roleP2g2rsPartial = false;

    /**
     * Objects associated via EventAttend relation (1:n).
     */
    protected EventAttendCollection|null $collEventAttends = null;

    /**
     * If $collEventAttends contains all objects in EventAttend relation.
     */
    protected bool $collEventAttendsPartial = false;

    /**
     * Objects associated via PrimaryContactPerson relation (1:n).
     */
    protected EventCollection|null $collPrimaryContactpeople = null;

    /**
     * If $collPrimaryContactpeople contains all objects in PrimaryContactPerson relation.
     */
    protected bool $collPrimaryContactpeoplePartial = false;

    /**
     * Objects associated via SecondaryContactPerson relation (1:n).
     */
    protected EventCollection|null $collSecondaryContactpeople = null;

    /**
     * If $collSecondaryContactpeople contains all objects in SecondaryContactPerson relation.
     */
    protected bool $collSecondaryContactpeoplePartial = false;

    /**
     * Objects associated via Pledge relation (1:n).
     */
    protected PledgeCollection|null $collPledges = null;

    /**
     * If $collPledges contains all objects in Pledge relation.
     */
    protected bool $collPledgesPartial = false;

    /**
     * User associated via User relation (1:1).
     */
    protected User|null $singleUser = null;

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
     * Items of WhyCames relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\WhyCame>|null
     */
    protected ObjectCollection|null $whyCamesScheduledForDeletion = null;

    /**
     * Items of PersonCustoms relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\PersonCustom>|null
     */
    protected ObjectCollection|null $personCustomsScheduledForDeletion = null;

    /**
     * Items of Notes relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Note>|null
     */
    protected ObjectCollection|null $notesScheduledForDeletion = null;

    /**
     * Items of Person2group2roleP2g2rs relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person2group2roleP2g2r>|null
     */
    protected ObjectCollection|null $person2group2roleP2g2rsScheduledForDeletion = null;

    /**
     * Items of EventAttends relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAttend>|null
     */
    protected ObjectCollection|null $eventAttendsScheduledForDeletion = null;

    /**
     * Items of PrimaryContactpeople relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event>|null
     */
    protected ObjectCollection|null $primaryContactpeopleScheduledForDeletion = null;

    /**
     * Items of SecondaryContactpeople relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event>|null
     */
    protected ObjectCollection|null $secondaryContactpeopleScheduledForDeletion = null;

    /**
     * Items of Pledges relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Pledge>|null
     */
    protected ObjectCollection|null $pledgesScheduledForDeletion = null;

    /**
     * Items of Users relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\User>|null
     */
    protected ObjectCollection|null $usersScheduledForDeletion = null;

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
        $this->per_birthmonth = 0;
        $this->per_birthday = 0;
        $this->per_gender = 0;
        $this->per_fmr_id = 0;
        $this->per_cls_id = 0;
        $this->per_fam_id = 0;
        $this->per_enteredby = 0;
        $this->per_editedby = 0;
        $this->per_flags = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Person object.
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
     * Compares this with another <code>Person</code> instance. If
     * <code>obj</code> is an instance of <code>Person</code>, delegates to
     * <code>equals(Person)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [per_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->per_id;
    }

    /**
     * Get the [per_title] column value.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->per_title;
    }

    /**
     * Get the [per_firstname] column value.
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->per_firstname;
    }

    /**
     * Get the [per_middlename] column value.
     *
     * @return string|null
     */
    public function getMiddleName()
    {
        return $this->per_middlename;
    }

    /**
     * Get the [per_lastname] column value.
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->per_lastname;
    }

    /**
     * Get the [per_suffix] column value.
     *
     * @return string|null
     */
    public function getSuffix()
    {
        return $this->per_suffix;
    }

    /**
     * Get the [per_address1] column value.
     *
     * @return string|null
     */
    public function getAddress1()
    {
        return $this->per_address1;
    }

    /**
     * Get the [per_address2] column value.
     *
     * @return string|null
     */
    public function getAddress2()
    {
        return $this->per_address2;
    }

    /**
     * Get the [per_city] column value.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->per_city;
    }

    /**
     * Get the [per_state] column value.
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->per_state;
    }

    /**
     * Get the [per_zip] column value.
     *
     * @return string|null
     */
    public function getZip()
    {
        return $this->per_zip;
    }

    /**
     * Get the [per_country] column value.
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->per_country;
    }

    /**
     * Get the [per_homephone] column value.
     *
     * @return string|null
     */
    public function getHomePhone()
    {
        return $this->per_homephone;
    }

    /**
     * Get the [per_workphone] column value.
     *
     * @return string|null
     */
    public function getWorkPhone()
    {
        return $this->per_workphone;
    }

    /**
     * Get the [per_cellphone] column value.
     *
     * @return string|null
     */
    public function getCellPhone()
    {
        return $this->per_cellphone;
    }

    /**
     * Get the [per_email] column value.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->per_email;
    }

    /**
     * Get the [per_workemail] column value.
     *
     * @return string|null
     */
    public function getWorkEmail()
    {
        return $this->per_workemail;
    }

    /**
     * Get the [per_birthmonth] column value.
     *
     * @return int|null
     */
    public function getBirthMonth()
    {
        return $this->per_birthmonth;
    }

    /**
     * Get the [per_birthday] column value.
     *
     * @return int|null
     */
    public function getBirthDay()
    {
        return $this->per_birthday;
    }

    /**
     * Get the [per_birthyear] column value.
     *
     * @return int|null
     */
    public function getBirthYear()
    {
        return $this->per_birthyear;
    }

    /**
     * Get the [optionally formatted] temporal [per_membershipdate] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getMembershipDate($format = null)
    {
        if ($format === null) {
            return $this->per_membershipdate;
        } else {
            return $this->per_membershipdate instanceof DateTimeInterface ? $this->per_membershipdate->format($format) : null;
        }
    }

    /**
     * Get the [per_gender] column value.
     *
     * @return int|null
     */
    public function getGender()
    {
        return $this->per_gender;
    }

    /**
     * Get the [per_fmr_id] column value.
     *
     * @return int|null
     */
    public function getFmrId()
    {
        return $this->per_fmr_id;
    }

    /**
     * Get the [per_cls_id] column value.
     *
     * @return int|null
     */
    public function getClsId()
    {
        return $this->per_cls_id;
    }

    /**
     * Get the [per_fam_id] column value.
     *
     * @return int|null
     */
    public function getFamId()
    {
        return $this->per_fam_id;
    }

    /**
     * Get the [per_envelope] column value.
     *
     * @return int|null
     */
    public function getEnvelope()
    {
        return $this->per_envelope;
    }

    /**
     * Get the [optionally formatted] temporal [per_datelastedited] column value.
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
            return $this->per_datelastedited;
        } else {
            return $this->per_datelastedited instanceof DateTimeInterface ? $this->per_datelastedited->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [per_dateentered] column value.
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
            return $this->per_dateentered;
        } else {
            return $this->per_dateentered instanceof DateTimeInterface ? $this->per_dateentered->format($format) : null;
        }
    }

    /**
     * Get the [per_enteredby] column value.
     *
     * @return int|null
     */
    public function getEnteredBy()
    {
        return $this->per_enteredby;
    }

    /**
     * Get the [per_editedby] column value.
     *
     * @return int|null
     */
    public function getEditedBy()
    {
        return $this->per_editedby;
    }

    /**
     * Get the [optionally formatted] temporal [per_frienddate] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00.
     */
    public function getFriendDate($format = null)
    {
        if ($format === null) {
            return $this->per_frienddate;
        } else {
            return $this->per_frienddate instanceof DateTimeInterface ? $this->per_frienddate->format($format) : null;
        }
    }

    /**
     * Get the [per_flags] column value.
     *
     * @return int|null
     */
    public function getFlags()
    {
        return $this->per_flags;
    }

    /**
     * Get the [per_facebook] column value.
     *
     * Facebook username
     *
     * @return string|null
     */
    public function getFacebook()
    {
        return $this->per_facebook;
    }

    /**
     * Get the [per_twitter] column value.
     *
     * Twitter username
     *
     * @return string|null
     */
    public function getTwitter()
    {
        return $this->per_twitter;
    }

    /**
     * Get the [per_linkedin] column value.
     *
     * LinkedIn name
     *
     * @return string|null
     */
    public function getLinkedIn()
    {
        return $this->per_linkedin;
    }

    /**
     * Set the value of [per_id] column.
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

        if ($this->per_id !== $v) {
            $this->per_id = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_title] column.
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

        if ($this->per_title !== $v) {
            $this->per_title = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_firstname] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_firstname !== $v) {
            $this->per_firstname = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_FIRSTNAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_middlename] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setMiddleName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_middlename !== $v) {
            $this->per_middlename = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_MIDDLENAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_lastname] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_lastname !== $v) {
            $this->per_lastname = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_LASTNAME] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_suffix] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setSuffix($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_suffix !== $v) {
            $this->per_suffix = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_SUFFIX] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_address1] column.
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

        if ($this->per_address1 !== $v) {
            $this->per_address1 = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_ADDRESS1] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_address2] column.
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

        if ($this->per_address2 !== $v) {
            $this->per_address2 = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_ADDRESS2] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_city] column.
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

        if ($this->per_city !== $v) {
            $this->per_city = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_CITY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_state] column.
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

        if ($this->per_state !== $v) {
            $this->per_state = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_STATE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_zip] column.
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

        if ($this->per_zip !== $v) {
            $this->per_zip = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_ZIP] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_country] column.
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

        if ($this->per_country !== $v) {
            $this->per_country = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_COUNTRY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_homephone] column.
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

        if ($this->per_homephone !== $v) {
            $this->per_homephone = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_HOMEPHONE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_workphone] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setWorkPhone($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_workphone !== $v) {
            $this->per_workphone = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_WORKPHONE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_cellphone] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setCellPhone($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_cellphone !== $v) {
            $this->per_cellphone = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_CELLPHONE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_email] column.
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

        if ($this->per_email !== $v) {
            $this->per_email = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_EMAIL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_workemail] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setWorkEmail($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_workemail !== $v) {
            $this->per_workemail = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_WORKEMAIL] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_birthmonth] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setBirthMonth($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_birthmonth !== $v) {
            $this->per_birthmonth = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_BIRTHMONTH] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_birthday] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setBirthDay($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_birthday !== $v) {
            $this->per_birthday = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_BIRTHDAY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_birthyear] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setBirthYear($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_birthyear !== $v) {
            $this->per_birthyear = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_BIRTHYEAR] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [per_membershipdate] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setMembershipDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->per_membershipdate !== null || $dt !== null) {
            if ($this->per_membershipdate === null || $dt === null || $dt->format('Y-m-d') !== $this->per_membershipdate->format('Y-m-d')) {
                $this->per_membershipdate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_PER_MEMBERSHIPDATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [per_gender] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setGender($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_gender !== $v) {
            $this->per_gender = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_GENDER] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_fmr_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFmrId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_fmr_id !== $v) {
            $this->per_fmr_id = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_FMR_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_cls_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setClsId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_cls_id !== $v) {
            $this->per_cls_id = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_CLS_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_fam_id] column.
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

        if ($this->per_fam_id !== $v) {
            $this->per_fam_id = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_FAM_ID] = true;
        }

        if ($this->aFamily !== null && $this->aFamily->getId() !== $v) {
            $this->aFamily = null;
        }

        return $this;
    }

    /**
     * Set the value of [per_envelope] column.
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

        if ($this->per_envelope !== $v) {
            $this->per_envelope = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_ENVELOPE] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [per_datelastedited] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateLastEdited($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->per_datelastedited !== null || $dt !== null) {
            if ($this->per_datelastedited === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->per_datelastedited->format('Y-m-d H:i:s.u')) {
                $this->per_datelastedited = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_PER_DATELASTEDITED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [per_dateentered] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setDateEntered($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->per_dateentered !== null || $dt !== null) {
            if ($this->per_dateentered === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->per_dateentered->format('Y-m-d H:i:s.u')) {
                $this->per_dateentered = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_PER_DATEENTERED] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [per_enteredby] column.
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

        if ($this->per_enteredby !== $v) {
            $this->per_enteredby = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_ENTEREDBY] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_editedby] column.
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

        if ($this->per_editedby !== $v) {
            $this->per_editedby = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_EDITEDBY] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [per_frienddate] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setFriendDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->per_frienddate !== null || $dt !== null) {
            if ($this->per_frienddate === null || $dt === null || $dt->format('Y-m-d') !== $this->per_frienddate->format('Y-m-d')) {
                $this->per_frienddate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PersonTableMap::COL_PER_FRIENDDATE] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [per_flags] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setFlags($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->per_flags !== $v) {
            $this->per_flags = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_FLAGS] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_facebook] column.
     *
     * Facebook username
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setFacebook($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_facebook !== $v) {
            $this->per_facebook = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_FACEBOOK] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_twitter] column.
     *
     * Twitter username
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setTwitter($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_twitter !== $v) {
            $this->per_twitter = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_TWITTER] = true;
        }

        return $this;
    }

    /**
     * Set the value of [per_linkedin] column.
     *
     * LinkedIn name
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setLinkedIn($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->per_linkedin !== $v) {
            $this->per_linkedin = $v;
            $this->modifiedColumns[PersonTableMap::COL_PER_LINKEDIN] = true;
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
        if ($this->per_birthmonth !== 0) {
            return false;
        }

        if ($this->per_birthday !== 0) {
            return false;
        }

        if ($this->per_gender !== 0) {
            return false;
        }

        if ($this->per_fmr_id !== 0) {
            return false;
        }

        if ($this->per_cls_id !== 0) {
            return false;
        }

        if ($this->per_fam_id !== 0) {
            return false;
        }

        if ($this->per_enteredby !== 0) {
            return false;
        }

        if ($this->per_editedby !== 0) {
            return false;
        }

        if ($this->per_flags !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : PersonTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : PersonTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_title = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : PersonTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_firstname = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : PersonTableMap::translateFieldName('MiddleName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_middlename = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : PersonTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_lastname = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : PersonTableMap::translateFieldName('Suffix', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_suffix = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : PersonTableMap::translateFieldName('Address1', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_address1 = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : PersonTableMap::translateFieldName('Address2', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_address2 = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : PersonTableMap::translateFieldName('City', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_city = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : PersonTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_state = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : PersonTableMap::translateFieldName('Zip', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_zip = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : PersonTableMap::translateFieldName('Country', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_country = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 12 : PersonTableMap::translateFieldName('HomePhone', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_homephone = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 13 : PersonTableMap::translateFieldName('WorkPhone', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_workphone = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 14 : PersonTableMap::translateFieldName('CellPhone', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_cellphone = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 15 : PersonTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_email = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 16 : PersonTableMap::translateFieldName('WorkEmail', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_workemail = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 17 : PersonTableMap::translateFieldName('BirthMonth', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_birthmonth = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 18 : PersonTableMap::translateFieldName('BirthDay', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_birthday = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 19 : PersonTableMap::translateFieldName('BirthYear', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_birthyear = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 20 : PersonTableMap::translateFieldName('MembershipDate', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->per_membershipdate = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 21 : PersonTableMap::translateFieldName('Gender', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_gender = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 22 : PersonTableMap::translateFieldName('FmrId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_fmr_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 23 : PersonTableMap::translateFieldName('ClsId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_cls_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 24 : PersonTableMap::translateFieldName('FamId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_fam_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 25 : PersonTableMap::translateFieldName('Envelope', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_envelope = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 26 : PersonTableMap::translateFieldName('DateLastEdited', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->per_datelastedited = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 27 : PersonTableMap::translateFieldName('DateEntered', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->per_dateentered = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 28 : PersonTableMap::translateFieldName('EnteredBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_enteredby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 29 : PersonTableMap::translateFieldName('EditedBy', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_editedby = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 30 : PersonTableMap::translateFieldName('FriendDate', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00') {
                $columnValue = null;
            }
            $this->per_frienddate = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 31 : PersonTableMap::translateFieldName('Flags', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_flags = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 32 : PersonTableMap::translateFieldName('Facebook', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_facebook = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 33 : PersonTableMap::translateFieldName('Twitter', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_twitter = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 34 : PersonTableMap::translateFieldName('LinkedIn', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->per_linkedin = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 35;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Person object', 0, $e);
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
        if ($this->aFamily !== null && $this->per_fam_id !== $this->aFamily->getId()) {
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
            $con = Propel::getServiceContainer()->getReadConnection(PersonTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPersonQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aFamily = null;
            $this->collWhyCames = null;
            $this->singlePersonCustom = null;
            $this->collNotes = null;
            $this->collPerson2group2roleP2g2rs = null;
            $this->collEventAttends = null;
            $this->collPrimaryContactpeople = null;
            $this->collSecondaryContactpeople = null;
            $this->collPledges = null;
            $this->singleUser = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Person::setDeleted()
     * @see Person::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPersonQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PersonTableMap::DATABASE_NAME);
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
                PersonTableMap::addInstanceToPool($this);
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

        if ($this->whyCamesScheduledForDeletion !== null) {
            if (!$this->whyCamesScheduledForDeletion->isEmpty()) {
                ChildWhyCameQuery::create()
                    ->filterByPrimaryKeys($this->whyCamesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->whyCamesScheduledForDeletion = null;
            }
        }

        if ($this->collWhyCames !== null) {
            foreach ($this->collWhyCames as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->singlePersonCustom !== null) {
            if (!$this->singlePersonCustom->isDeleted() && ($this->singlePersonCustom->isNew() || $this->singlePersonCustom->isModified())) {
                $affectedRows += $this->singlePersonCustom->save($con);
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

        if ($this->eventAttendsScheduledForDeletion !== null) {
            if (!$this->eventAttendsScheduledForDeletion->isEmpty()) {
                ChildEventAttendQuery::create()
                    ->filterByPrimaryKeys($this->eventAttendsScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->eventAttendsScheduledForDeletion = null;
            }
        }

        if ($this->collEventAttends !== null) {
            foreach ($this->collEventAttends as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->primaryContactpeopleScheduledForDeletion !== null) {
            if (!$this->primaryContactpeopleScheduledForDeletion->isEmpty()) {
                ChildEventQuery::create()
                    ->filterByPrimaryKeys($this->primaryContactpeopleScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->primaryContactpeopleScheduledForDeletion = null;
            }
        }

        if ($this->collPrimaryContactpeople !== null) {
            foreach ($this->collPrimaryContactpeople as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->secondaryContactpeopleScheduledForDeletion !== null) {
            if (!$this->secondaryContactpeopleScheduledForDeletion->isEmpty()) {
                ChildEventQuery::create()
                    ->filterByPrimaryKeys($this->secondaryContactpeopleScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->secondaryContactpeopleScheduledForDeletion = null;
            }
        }

        if ($this->collSecondaryContactpeople !== null) {
            foreach ($this->collSecondaryContactpeople as $referrerFK) {
                if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                    $affectedRows += $referrerFK->save($con);
                }
            }
        }

        if ($this->pledgesScheduledForDeletion !== null) {
            if (!$this->pledgesScheduledForDeletion->isEmpty()) {
                ChildPledgeQuery::create()
                    ->filterByPrimaryKeys($this->pledgesScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
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

        if ($this->singleUser !== null) {
            if (!$this->singleUser->isDeleted() && ($this->singleUser->isNew() || $this->singleUser->isModified())) {
                $affectedRows += $this->singleUser->save($con);
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
        $this->modifiedColumns[PersonTableMap::COL_PER_ID] = true;
        if ($this->per_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PersonTableMap::COL_PER_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PersonTableMap::COL_PER_ID)) {
            $modifiedColumns[':p' . $index++] = 'per_ID';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_TITLE)) {
            $modifiedColumns[':p' . $index++] = 'per_Title';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++] = 'per_FirstName';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_MIDDLENAME)) {
            $modifiedColumns[':p' . $index++] = 'per_MiddleName';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_LASTNAME)) {
            $modifiedColumns[':p' . $index++] = 'per_LastName';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_SUFFIX)) {
            $modifiedColumns[':p' . $index++] = 'per_Suffix';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ADDRESS1)) {
            $modifiedColumns[':p' . $index++] = 'per_Address1';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ADDRESS2)) {
            $modifiedColumns[':p' . $index++] = 'per_Address2';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_CITY)) {
            $modifiedColumns[':p' . $index++] = 'per_City';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_STATE)) {
            $modifiedColumns[':p' . $index++] = 'per_State';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ZIP)) {
            $modifiedColumns[':p' . $index++] = 'per_Zip';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_COUNTRY)) {
            $modifiedColumns[':p' . $index++] = 'per_Country';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_HOMEPHONE)) {
            $modifiedColumns[':p' . $index++] = 'per_HomePhone';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_WORKPHONE)) {
            $modifiedColumns[':p' . $index++] = 'per_WorkPhone';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_CELLPHONE)) {
            $modifiedColumns[':p' . $index++] = 'per_CellPhone';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_EMAIL)) {
            $modifiedColumns[':p' . $index++] = 'per_Email';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_WORKEMAIL)) {
            $modifiedColumns[':p' . $index++] = 'per_WorkEmail';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_BIRTHMONTH)) {
            $modifiedColumns[':p' . $index++] = 'per_BirthMonth';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_BIRTHDAY)) {
            $modifiedColumns[':p' . $index++] = 'per_BirthDay';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_BIRTHYEAR)) {
            $modifiedColumns[':p' . $index++] = 'per_BirthYear';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_MEMBERSHIPDATE)) {
            $modifiedColumns[':p' . $index++] = 'per_MembershipDate';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_GENDER)) {
            $modifiedColumns[':p' . $index++] = 'per_Gender';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FMR_ID)) {
            $modifiedColumns[':p' . $index++] = 'per_fmr_ID';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_CLS_ID)) {
            $modifiedColumns[':p' . $index++] = 'per_cls_ID';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FAM_ID)) {
            $modifiedColumns[':p' . $index++] = 'per_fam_ID';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ENVELOPE)) {
            $modifiedColumns[':p' . $index++] = 'per_Envelope';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_DATELASTEDITED)) {
            $modifiedColumns[':p' . $index++] = 'per_DateLastEdited';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_DATEENTERED)) {
            $modifiedColumns[':p' . $index++] = 'per_DateEntered';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ENTEREDBY)) {
            $modifiedColumns[':p' . $index++] = 'per_EnteredBy';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_EDITEDBY)) {
            $modifiedColumns[':p' . $index++] = 'per_EditedBy';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FRIENDDATE)) {
            $modifiedColumns[':p' . $index++] = 'per_FriendDate';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FLAGS)) {
            $modifiedColumns[':p' . $index++] = 'per_Flags';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FACEBOOK)) {
            $modifiedColumns[':p' . $index++] = 'per_Facebook';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_TWITTER)) {
            $modifiedColumns[':p' . $index++] = 'per_Twitter';
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_LINKEDIN)) {
            $modifiedColumns[':p' . $index++] = 'per_LinkedIn';
        }

        $sql = sprintf(
            'INSERT INTO person_per (%s) VALUES (%s)',
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
                    case 'per_ID':
                        $stmt->bindValue($identifier, $this->per_id, PDO::PARAM_INT);

                        break;
                    case 'per_Title':
                        $stmt->bindValue($identifier, $this->per_title, PDO::PARAM_STR);

                        break;
                    case 'per_FirstName':
                        $stmt->bindValue($identifier, $this->per_firstname, PDO::PARAM_STR);

                        break;
                    case 'per_MiddleName':
                        $stmt->bindValue($identifier, $this->per_middlename, PDO::PARAM_STR);

                        break;
                    case 'per_LastName':
                        $stmt->bindValue($identifier, $this->per_lastname, PDO::PARAM_STR);

                        break;
                    case 'per_Suffix':
                        $stmt->bindValue($identifier, $this->per_suffix, PDO::PARAM_STR);

                        break;
                    case 'per_Address1':
                        $stmt->bindValue($identifier, $this->per_address1, PDO::PARAM_STR);

                        break;
                    case 'per_Address2':
                        $stmt->bindValue($identifier, $this->per_address2, PDO::PARAM_STR);

                        break;
                    case 'per_City':
                        $stmt->bindValue($identifier, $this->per_city, PDO::PARAM_STR);

                        break;
                    case 'per_State':
                        $stmt->bindValue($identifier, $this->per_state, PDO::PARAM_STR);

                        break;
                    case 'per_Zip':
                        $stmt->bindValue($identifier, $this->per_zip, PDO::PARAM_STR);

                        break;
                    case 'per_Country':
                        $stmt->bindValue($identifier, $this->per_country, PDO::PARAM_STR);

                        break;
                    case 'per_HomePhone':
                        $stmt->bindValue($identifier, $this->per_homephone, PDO::PARAM_STR);

                        break;
                    case 'per_WorkPhone':
                        $stmt->bindValue($identifier, $this->per_workphone, PDO::PARAM_STR);

                        break;
                    case 'per_CellPhone':
                        $stmt->bindValue($identifier, $this->per_cellphone, PDO::PARAM_STR);

                        break;
                    case 'per_Email':
                        $stmt->bindValue($identifier, $this->per_email, PDO::PARAM_STR);

                        break;
                    case 'per_WorkEmail':
                        $stmt->bindValue($identifier, $this->per_workemail, PDO::PARAM_STR);

                        break;
                    case 'per_BirthMonth':
                        $stmt->bindValue($identifier, $this->per_birthmonth, PDO::PARAM_INT);

                        break;
                    case 'per_BirthDay':
                        $stmt->bindValue($identifier, $this->per_birthday, PDO::PARAM_INT);

                        break;
                    case 'per_BirthYear':
                        $stmt->bindValue($identifier, $this->per_birthyear, PDO::PARAM_INT);

                        break;
                    case 'per_MembershipDate':
                        $stmt->bindValue($identifier, $this->per_membershipdate ? $this->per_membershipdate->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'per_Gender':
                        $stmt->bindValue($identifier, $this->per_gender, PDO::PARAM_INT);

                        break;
                    case 'per_fmr_ID':
                        $stmt->bindValue($identifier, $this->per_fmr_id, PDO::PARAM_INT);

                        break;
                    case 'per_cls_ID':
                        $stmt->bindValue($identifier, $this->per_cls_id, PDO::PARAM_INT);

                        break;
                    case 'per_fam_ID':
                        $stmt->bindValue($identifier, $this->per_fam_id, PDO::PARAM_INT);

                        break;
                    case 'per_Envelope':
                        $stmt->bindValue($identifier, $this->per_envelope, PDO::PARAM_INT);

                        break;
                    case 'per_DateLastEdited':
                        $stmt->bindValue($identifier, $this->per_datelastedited ? $this->per_datelastedited->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'per_DateEntered':
                        $stmt->bindValue($identifier, $this->per_dateentered ? $this->per_dateentered->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'per_EnteredBy':
                        $stmt->bindValue($identifier, $this->per_enteredby, PDO::PARAM_INT);

                        break;
                    case 'per_EditedBy':
                        $stmt->bindValue($identifier, $this->per_editedby, PDO::PARAM_INT);

                        break;
                    case 'per_FriendDate':
                        $stmt->bindValue($identifier, $this->per_frienddate ? $this->per_frienddate->format('Y-m-d') : null, PDO::PARAM_STR);

                        break;
                    case 'per_Flags':
                        $stmt->bindValue($identifier, $this->per_flags, PDO::PARAM_INT);

                        break;
                    case 'per_Facebook':
                        $stmt->bindValue($identifier, $this->per_facebook, PDO::PARAM_STR);

                        break;
                    case 'per_Twitter':
                        $stmt->bindValue($identifier, $this->per_twitter, PDO::PARAM_STR);

                        break;
                    case 'per_LinkedIn':
                        $stmt->bindValue($identifier, $this->per_linkedin, PDO::PARAM_STR);

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
        $pos = PersonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            1 => $this->getTitle(),
            2 => $this->getFirstName(),
            3 => $this->getMiddleName(),
            4 => $this->getLastName(),
            5 => $this->getSuffix(),
            6 => $this->getAddress1(),
            7 => $this->getAddress2(),
            8 => $this->getCity(),
            9 => $this->getState(),
            10 => $this->getZip(),
            11 => $this->getCountry(),
            12 => $this->getHomePhone(),
            13 => $this->getWorkPhone(),
            14 => $this->getCellPhone(),
            15 => $this->getEmail(),
            16 => $this->getWorkEmail(),
            17 => $this->getBirthMonth(),
            18 => $this->getBirthDay(),
            19 => $this->getBirthYear(),
            20 => $this->getMembershipDate(),
            21 => $this->getGender(),
            22 => $this->getFmrId(),
            23 => $this->getClsId(),
            24 => $this->getFamId(),
            25 => $this->getEnvelope(),
            26 => $this->getDateLastEdited(),
            27 => $this->getDateEntered(),
            28 => $this->getEnteredBy(),
            29 => $this->getEditedBy(),
            30 => $this->getFriendDate(),
            31 => $this->getFlags(),
            32 => $this->getFacebook(),
            33 => $this->getTwitter(),
            34 => $this->getLinkedIn(),
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
        if (isset($alreadyDumpedObjects['Person'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Person'][$this->hashCode()] = true;
        $keys = PersonTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getFirstName(),
            $keys[3] => $this->getMiddleName(),
            $keys[4] => $this->getLastName(),
            $keys[5] => $this->getSuffix(),
            $keys[6] => $this->getAddress1(),
            $keys[7] => $this->getAddress2(),
            $keys[8] => $this->getCity(),
            $keys[9] => $this->getState(),
            $keys[10] => $this->getZip(),
            $keys[11] => $this->getCountry(),
            $keys[12] => $this->getHomePhone(),
            $keys[13] => $this->getWorkPhone(),
            $keys[14] => $this->getCellPhone(),
            $keys[15] => $this->getEmail(),
            $keys[16] => $this->getWorkEmail(),
            $keys[17] => $this->getBirthMonth(),
            $keys[18] => $this->getBirthDay(),
            $keys[19] => $this->getBirthYear(),
            $keys[20] => $this->getMembershipDate(),
            $keys[21] => $this->getGender(),
            $keys[22] => $this->getFmrId(),
            $keys[23] => $this->getClsId(),
            $keys[24] => $this->getFamId(),
            $keys[25] => $this->getEnvelope(),
            $keys[26] => $this->getDateLastEdited(),
            $keys[27] => $this->getDateEntered(),
            $keys[28] => $this->getEnteredBy(),
            $keys[29] => $this->getEditedBy(),
            $keys[30] => $this->getFriendDate(),
            $keys[31] => $this->getFlags(),
            $keys[32] => $this->getFacebook(),
            $keys[33] => $this->getTwitter(),
            $keys[34] => $this->getLinkedIn(),
        ];
        if ($result[$keys[20]] instanceof DateTimeInterface) {
            $result[$keys[20]] = $result[$keys[20]]->format('Y-m-d');
        }

        if ($result[$keys[26]] instanceof DateTimeInterface) {
            $result[$keys[26]] = $result[$keys[26]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[27]] instanceof DateTimeInterface) {
            $result[$keys[27]] = $result[$keys[27]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[30]] instanceof DateTimeInterface) {
            $result[$keys[30]] = $result[$keys[30]]->format('Y-m-d');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if ($this->aFamily !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'family',
                     TableMap::TYPE_FIELDNAME => 'family_fam',
                     default => 'Family',
                };
                $result[$key] = $this->aFamily->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collWhyCames !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'whyCames',
                     TableMap::TYPE_FIELDNAME => 'whycame_whies',
                     default => 'WhyCames',
                };
                $result[$key] = $this->collWhyCames->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->singlePersonCustom !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'personCustom',
                     TableMap::TYPE_FIELDNAME => 'person_custom',
                     default => 'PersonCustom',
                };
                $result[$key] = $this->singlePersonCustom->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collNotes !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'notes',
                     TableMap::TYPE_FIELDNAME => 'note_ntes',
                     default => 'Notes',
                };
                $result[$key] = $this->collNotes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collPerson2group2roleP2g2rs !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'person2group2roleP2g2rs',
                     TableMap::TYPE_FIELDNAME => 'person2group2role_p2g2rs',
                     default => 'Person2group2roleP2g2rs',
                };
                $result[$key] = $this->collPerson2group2roleP2g2rs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collEventAttends !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'eventAttends',
                     TableMap::TYPE_FIELDNAME => 'event_attends',
                     default => 'EventAttends',
                };
                $result[$key] = $this->collEventAttends->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collPrimaryContactpeople !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'events',
                     TableMap::TYPE_FIELDNAME => 'events_events',
                     default => 'PrimaryContactpeople',
                };
                $result[$key] = $this->collPrimaryContactpeople->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collSecondaryContactpeople !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'events',
                     TableMap::TYPE_FIELDNAME => 'events_events',
                     default => 'SecondaryContactpeople',
                };
                $result[$key] = $this->collSecondaryContactpeople->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collPledges !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'pledges',
                     TableMap::TYPE_FIELDNAME => 'pledge_plgs',
                     default => 'Pledges',
                };
                $result[$key] = $this->collPledges->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->singleUser !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'user',
                     TableMap::TYPE_FIELDNAME => 'user_usr',
                     default => 'User',
                };
                $result[$key] = $this->singleUser->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
        $pos = PersonTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTitle($value);

                break;
            case 2:
                $this->setFirstName($value);

                break;
            case 3:
                $this->setMiddleName($value);

                break;
            case 4:
                $this->setLastName($value);

                break;
            case 5:
                $this->setSuffix($value);

                break;
            case 6:
                $this->setAddress1($value);

                break;
            case 7:
                $this->setAddress2($value);

                break;
            case 8:
                $this->setCity($value);

                break;
            case 9:
                $this->setState($value);

                break;
            case 10:
                $this->setZip($value);

                break;
            case 11:
                $this->setCountry($value);

                break;
            case 12:
                $this->setHomePhone($value);

                break;
            case 13:
                $this->setWorkPhone($value);

                break;
            case 14:
                $this->setCellPhone($value);

                break;
            case 15:
                $this->setEmail($value);

                break;
            case 16:
                $this->setWorkEmail($value);

                break;
            case 17:
                $this->setBirthMonth($value);

                break;
            case 18:
                $this->setBirthDay($value);

                break;
            case 19:
                $this->setBirthYear($value);

                break;
            case 20:
                $this->setMembershipDate($value);

                break;
            case 21:
                $this->setGender($value);

                break;
            case 22:
                $this->setFmrId($value);

                break;
            case 23:
                $this->setClsId($value);

                break;
            case 24:
                $this->setFamId($value);

                break;
            case 25:
                $this->setEnvelope($value);

                break;
            case 26:
                $this->setDateLastEdited($value);

                break;
            case 27:
                $this->setDateEntered($value);

                break;
            case 28:
                $this->setEnteredBy($value);

                break;
            case 29:
                $this->setEditedBy($value);

                break;
            case 30:
                $this->setFriendDate($value);

                break;
            case 31:
                $this->setFlags($value);

                break;
            case 32:
                $this->setFacebook($value);

                break;
            case 33:
                $this->setTwitter($value);

                break;
            case 34:
                $this->setLinkedIn($value);

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
        $keys = PersonTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitle($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFirstName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMiddleName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLastName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSuffix($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAddress1($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAddress2($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCity($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setState($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setZip($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCountry($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setHomePhone($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setWorkPhone($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setCellPhone($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setEmail($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setWorkEmail($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setBirthMonth($arr[$keys[17]]);
        }
        if (array_key_exists($keys[18], $arr)) {
            $this->setBirthDay($arr[$keys[18]]);
        }
        if (array_key_exists($keys[19], $arr)) {
            $this->setBirthYear($arr[$keys[19]]);
        }
        if (array_key_exists($keys[20], $arr)) {
            $this->setMembershipDate($arr[$keys[20]]);
        }
        if (array_key_exists($keys[21], $arr)) {
            $this->setGender($arr[$keys[21]]);
        }
        if (array_key_exists($keys[22], $arr)) {
            $this->setFmrId($arr[$keys[22]]);
        }
        if (array_key_exists($keys[23], $arr)) {
            $this->setClsId($arr[$keys[23]]);
        }
        if (array_key_exists($keys[24], $arr)) {
            $this->setFamId($arr[$keys[24]]);
        }
        if (array_key_exists($keys[25], $arr)) {
            $this->setEnvelope($arr[$keys[25]]);
        }
        if (array_key_exists($keys[26], $arr)) {
            $this->setDateLastEdited($arr[$keys[26]]);
        }
        if (array_key_exists($keys[27], $arr)) {
            $this->setDateEntered($arr[$keys[27]]);
        }
        if (array_key_exists($keys[28], $arr)) {
            $this->setEnteredBy($arr[$keys[28]]);
        }
        if (array_key_exists($keys[29], $arr)) {
            $this->setEditedBy($arr[$keys[29]]);
        }
        if (array_key_exists($keys[30], $arr)) {
            $this->setFriendDate($arr[$keys[30]]);
        }
        if (array_key_exists($keys[31], $arr)) {
            $this->setFlags($arr[$keys[31]]);
        }
        if (array_key_exists($keys[32], $arr)) {
            $this->setFacebook($arr[$keys[32]]);
        }
        if (array_key_exists($keys[33], $arr)) {
            $this->setTwitter($arr[$keys[33]]);
        }
        if (array_key_exists($keys[34], $arr)) {
            $this->setLinkedIn($arr[$keys[34]]);
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
        $tableMap = PersonTableMap::getTableMap();
        $criteria = new Criteria(PersonTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PersonTableMap::COL_PER_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_ID'), $this->per_id);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_TITLE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Title'), $this->per_title);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FIRSTNAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_FirstName'), $this->per_firstname);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_MIDDLENAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_MiddleName'), $this->per_middlename);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_LASTNAME)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_LastName'), $this->per_lastname);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_SUFFIX)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Suffix'), $this->per_suffix);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ADDRESS1)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Address1'), $this->per_address1);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ADDRESS2)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Address2'), $this->per_address2);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_CITY)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_City'), $this->per_city);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_STATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_State'), $this->per_state);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ZIP)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Zip'), $this->per_zip);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_COUNTRY)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Country'), $this->per_country);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_HOMEPHONE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_HomePhone'), $this->per_homephone);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_WORKPHONE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_WorkPhone'), $this->per_workphone);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_CELLPHONE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_CellPhone'), $this->per_cellphone);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_EMAIL)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Email'), $this->per_email);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_WORKEMAIL)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_WorkEmail'), $this->per_workemail);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_BIRTHMONTH)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_BirthMonth'), $this->per_birthmonth);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_BIRTHDAY)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_BirthDay'), $this->per_birthday);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_BIRTHYEAR)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_BirthYear'), $this->per_birthyear);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_MEMBERSHIPDATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_MembershipDate'), $this->per_membershipdate);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_GENDER)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Gender'), $this->per_gender);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FMR_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_fmr_ID'), $this->per_fmr_id);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_CLS_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_cls_ID'), $this->per_cls_id);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FAM_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_fam_ID'), $this->per_fam_id);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ENVELOPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Envelope'), $this->per_envelope);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_DATELASTEDITED)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_DateLastEdited'), $this->per_datelastedited);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_DATEENTERED)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_DateEntered'), $this->per_dateentered);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_ENTEREDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_EnteredBy'), $this->per_enteredby);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_EDITEDBY)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_EditedBy'), $this->per_editedby);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FRIENDDATE)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_FriendDate'), $this->per_frienddate);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FLAGS)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Flags'), $this->per_flags);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_FACEBOOK)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Facebook'), $this->per_facebook);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_TWITTER)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_Twitter'), $this->per_twitter);
        }
        if ($this->isColumnModified(PersonTableMap::COL_PER_LINKEDIN)) {
            $criteria->setUpdateValue($tableMap->getColumn('per_LinkedIn'), $this->per_linkedin);
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
        $tableMap = PersonTableMap::getTableMap();
        $query = ChildPersonQuery::create();
        $per_IDColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('per_ID'));
        $query->addAnd($per_IDColumn, $this->per_id);

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
     * Generic method to set the primary key (per_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Person (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setMiddleName($this->getMiddleName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setSuffix($this->getSuffix());
        $copyObj->setAddress1($this->getAddress1());
        $copyObj->setAddress2($this->getAddress2());
        $copyObj->setCity($this->getCity());
        $copyObj->setState($this->getState());
        $copyObj->setZip($this->getZip());
        $copyObj->setCountry($this->getCountry());
        $copyObj->setHomePhone($this->getHomePhone());
        $copyObj->setWorkPhone($this->getWorkPhone());
        $copyObj->setCellPhone($this->getCellPhone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setWorkEmail($this->getWorkEmail());
        $copyObj->setBirthMonth($this->getBirthMonth());
        $copyObj->setBirthDay($this->getBirthDay());
        $copyObj->setBirthYear($this->getBirthYear());
        $copyObj->setMembershipDate($this->getMembershipDate());
        $copyObj->setGender($this->getGender());
        $copyObj->setFmrId($this->getFmrId());
        $copyObj->setClsId($this->getClsId());
        $copyObj->setFamId($this->getFamId());
        $copyObj->setEnvelope($this->getEnvelope());
        $copyObj->setDateLastEdited($this->getDateLastEdited());
        $copyObj->setDateEntered($this->getDateEntered());
        $copyObj->setEnteredBy($this->getEnteredBy());
        $copyObj->setEditedBy($this->getEditedBy());
        $copyObj->setFriendDate($this->getFriendDate());
        $copyObj->setFlags($this->getFlags());
        $copyObj->setFacebook($this->getFacebook());
        $copyObj->setTwitter($this->getTwitter());
        $copyObj->setLinkedIn($this->getLinkedIn());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getWhyCames() as $relObj) {
                $copyObj->addWhyCame($relObj->copy($deepCopy));
            }
            $relObj = $this->getPersonCustom();
            if ($relObj) {
                $copyObj->setPersonCustom($relObj->copy($deepCopy));
            }
            foreach ($this->getNotes() as $relObj) {
                $copyObj->addNote($relObj->copy($deepCopy));
            }
            foreach ($this->getPerson2group2roleP2g2rs() as $relObj) {
                $copyObj->addPerson2group2roleP2g2r($relObj->copy($deepCopy));
            }
            foreach ($this->getEventAttends() as $relObj) {
                $copyObj->addEventAttend($relObj->copy($deepCopy));
            }
            foreach ($this->getPrimaryContactpeople() as $relObj) {
                $copyObj->addPrimaryContactPerson($relObj->copy($deepCopy));
            }
            foreach ($this->getSecondaryContactpeople() as $relObj) {
                $copyObj->addSecondaryContactPerson($relObj->copy($deepCopy));
            }
            foreach ($this->getPledges() as $relObj) {
                $copyObj->addPledge($relObj->copy($deepCopy));
            }
            $relObj = $this->getUser();
            if ($relObj) {
                $copyObj->setUser($relObj->copy($deepCopy));
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
        $family?->addPerson($this);

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
        if ($this->aFamily === null && ($this->per_fam_id !== null && $this->per_fam_id !== 0)) {
            $this->aFamily = ChildFamilyQuery::create()->findPk($this->per_fam_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFamily->addPeople($this);
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
        match ($relationName) {
            'WhyCame' => $this->initWhyCames(),
            'Note' => $this->initNotes(),
            'Person2group2roleP2g2r' => $this->initPerson2group2roleP2g2rs(),
            'EventAttend' => $this->initEventAttends(),
            'PrimaryContactPerson' => $this->initPrimaryContactpeople(),
            'SecondaryContactPerson' => $this->initSecondaryContactpeople(),
            'Pledge' => $this->initPledges(),
            default => null
        };
    }

    /**
     * Initializes the collWhyCames collection.
     *
     * By default this just sets the collWhyCames collection to an empty array (like clearcollWhyCames());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWhyCames(bool $overrideExisting = true): void
    {
        if ($this->collWhyCames !== null && !$overrideExisting) {
            return;
        }

        $this->collWhyCames = new WhyCameCollection();
        $this->collWhyCames->setModel('\ChurchCRM\model\ChurchCRM\WhyCame');
    }

    /**
     * Reset is the collWhyCames collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialWhyCames(bool $isPartial = true): void
    {
        $this->collWhyCamesPartial = $isPartial;
    }

    /**
     * Clears out the collWhyCames collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearWhyCames(): static
    {
        $this->collWhyCames = null;

        return $this;
    }

    /**
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\WhyCameCollection
     */
    public function getWhyCames(?Criteria $criteria = null, ?ConnectionInterface $con = null): WhyCameCollection
    {
        $partial = $this->collWhyCamesPartial && !$this->isNew();
        if ($this->collWhyCames && !$criteria && !$partial) {
            return $this->collWhyCames;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collWhyCames === null) {
                $this->initWhyCames();

                return $this->collWhyCames;
            }

            $collWhyCames = new WhyCameCollection();
            $collWhyCames->setModel('\ChurchCRM\model\ChurchCRM\Base\WhyCame');

            return $collWhyCames;
        }

        $collWhyCames = ChildWhyCameQuery::create(null, $criteria)
            ->filterByPerson($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collWhyCamesPartial !== false && count($collWhyCames)) {
                $this->initWhyCames(false);

                foreach ($collWhyCames as $obj) {
                    if (!$this->collWhyCames->contains($obj)) {
                        $this->collWhyCames->append($obj);
                    }
                }

                $this->collWhyCamesPartial = true;
            }

            return $collWhyCames;
        }

        if ($this->collWhyCamesPartial && $this->collWhyCames) {
            foreach ($this->collWhyCames as $obj) {
                if ($obj->isNew()) {
                    $collWhyCames[] = $obj;
                }
            }
        }

        $this->collWhyCames = $collWhyCames;
        $this->collWhyCamesPartial = false;

        return $this->collWhyCames;
    }

    /**
     * Sets a collection of person_per objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\WhyCame> $whyCames
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setWhyCames(Collection $whyCames, ?ConnectionInterface $con = null): static
    {
        $whyCamesToDelete = $this->getWhyCames(null, $con)->diff($whyCames);

        $this->whyCamesScheduledForDeletion = $whyCamesToDelete;

        foreach ($whyCamesToDelete as $whyCameRemoved) {
            $whyCameRemoved->setPerson(null);
        }

        $this->collWhyCames = null;
        foreach ($whyCames as $whyCame) {
            $this->addWhyCame($whyCame);
        }

        $this->collWhyCamesPartial = false;
        $this->collWhyCames = $whyCames instanceof WhyCameCollection
            ? $whyCames : new WhyCameCollection($whyCames->getData());

        return $this;
    }

    /**
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
     */
    public function countWhyCames(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collWhyCamesPartial && !$this->isNew();
        if ($this->collWhyCames === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collWhyCames === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWhyCames());
            }

            $query = ChildWhyCameQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collWhyCames);
    }

    /**
     * Method called to associate a WhyCame object to this object
     * through the WhyCame foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\WhyCame $whyCame
     *
     * @return $this
     */
    public function addWhyCame(WhyCame $whyCame)
    {
        if ($this->collWhyCames === null) {
            $this->initWhyCames();
            $this->collWhyCamesPartial = true;
        }

        if (!$this->collWhyCames->contains($whyCame)) {
            $this->doAddWhyCame($whyCame);

            if ($this->whyCamesScheduledForDeletion && $this->whyCamesScheduledForDeletion->contains($whyCame)) {
                $this->whyCamesScheduledForDeletion->remove($this->whyCamesScheduledForDeletion->search($whyCame));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\WhyCame $whyCame The WhyCame object to add.
     *
     * @return void
     */
    protected function doAddWhyCame(WhyCame $whyCame): void
    {
        $this->collWhyCames->append($whyCame);
        $whyCame->setPerson($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\WhyCame $whyCame The WhyCame object to remove.
     *
     * @return static
     */
    public function removeWhyCame(WhyCame $whyCame): static
    {
        if ($this->getWhyCames()->contains($whyCame)) {
            $pos = $this->collWhyCames->search($whyCame);
            $this->collWhyCames->remove($pos);
            if ($this->whyCamesScheduledForDeletion === null) {
                $this->whyCamesScheduledForDeletion = clone $this->collWhyCames;
                $this->whyCamesScheduledForDeletion->clear();
            }
            $this->whyCamesScheduledForDeletion->append(clone $whyCame);
            $whyCame->setPerson(null);
        }

        return $this;
    }

    /**
     * Gets a single PersonCustom object, which is related to this object by a one-to-one relationship.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\PersonCustom|null
     */
    public function getPersonCustom(?ConnectionInterface $con = null)
    {
        if ($this->singlePersonCustom === null && !$this->isNew()) {
            $this->singlePersonCustom = ChildPersonCustomQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singlePersonCustom;
    }

    /**
     * Sets a single PersonCustom object as related to this object by a one-to-one relationship.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\PersonCustom|null $v
     *
     * @return $this
     */
    public function setPersonCustom(?PersonCustom $v = null)
    {
        $this->singlePersonCustom = $v;

        // Make sure that that the passed-in PersonCustom isn't already associated with this object
        if ($v && $v->getPerson() === null) {
            $v->setPerson($this);
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
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
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
            ->filterByPerson($this)
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
     * Sets a collection of person_per objects related by a one-to-many relationship
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
            $noteRemoved->setPerson(null);
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
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
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
                ->filterByPerson($this)
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
        $note->setPerson($this);
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
            $note->setPerson(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related Notes from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection
     */
    public function getNotesJoinFamily(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): NoteCollection {
        $query = ChildNoteQuery::create(null, $criteria);
        $query->joinWith('Family', $joinBehavior);

        return $this->getNotes($query, $con);
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
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
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
            ->filterByPerson($this)
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
     * Sets a collection of person_per objects related by a one-to-many relationship
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
            $person2group2roleP2g2rRemoved->setPerson(null);
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
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
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
                ->filterByPerson($this)
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
        $person2group2roleP2g2r->setPerson($this);
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
            $person2group2roleP2g2r->setPerson(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related Person2group2roleP2g2rs from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection
     */
    public function getPerson2group2roleP2g2rsJoinGroup(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): Person2group2roleP2g2rCollection {
        $query = ChildPerson2group2roleP2g2rQuery::create(null, $criteria);
        $query->joinWith('Group', $joinBehavior);

        return $this->getPerson2group2roleP2g2rs($query, $con);
    }

    /**
     * Initializes the collEventAttends collection.
     *
     * By default this just sets the collEventAttends collection to an empty array (like clearcollEventAttends());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventAttends(bool $overrideExisting = true): void
    {
        if ($this->collEventAttends !== null && !$overrideExisting) {
            return;
        }

        $this->collEventAttends = new EventAttendCollection();
        $this->collEventAttends->setModel('\ChurchCRM\model\ChurchCRM\EventAttend');
    }

    /**
     * Reset is the collEventAttends collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialEventAttends(bool $isPartial = true): void
    {
        $this->collEventAttendsPartial = $isPartial;
    }

    /**
     * Clears out the collEventAttends collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearEventAttends(): static
    {
        $this->collEventAttends = null;

        return $this;
    }

    /**
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection
     */
    public function getEventAttends(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventAttendCollection
    {
        $partial = $this->collEventAttendsPartial && !$this->isNew();
        if ($this->collEventAttends && !$criteria && !$partial) {
            return $this->collEventAttends;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collEventAttends === null) {
                $this->initEventAttends();

                return $this->collEventAttends;
            }

            $collEventAttends = new EventAttendCollection();
            $collEventAttends->setModel('\ChurchCRM\model\ChurchCRM\Base\EventAttend');

            return $collEventAttends;
        }

        $collEventAttends = ChildEventAttendQuery::create(null, $criteria)
            ->filterByPerson($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collEventAttendsPartial !== false && count($collEventAttends)) {
                $this->initEventAttends(false);

                foreach ($collEventAttends as $obj) {
                    if (!$this->collEventAttends->contains($obj)) {
                        $this->collEventAttends->append($obj);
                    }
                }

                $this->collEventAttendsPartial = true;
            }

            return $collEventAttends;
        }

        if ($this->collEventAttendsPartial && $this->collEventAttends) {
            foreach ($this->collEventAttends as $obj) {
                if ($obj->isNew()) {
                    $collEventAttends[] = $obj;
                }
            }
        }

        $this->collEventAttends = $collEventAttends;
        $this->collEventAttendsPartial = false;

        return $this->collEventAttends;
    }

    /**
     * Sets a collection of person_per objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\EventAttend> $eventAttends
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setEventAttends(Collection $eventAttends, ?ConnectionInterface $con = null): static
    {
        $eventAttendsToDelete = $this->getEventAttends(null, $con)->diff($eventAttends);

        $this->eventAttendsScheduledForDeletion = $eventAttendsToDelete;

        foreach ($eventAttendsToDelete as $eventAttendRemoved) {
            $eventAttendRemoved->setPerson(null);
        }

        $this->collEventAttends = null;
        foreach ($eventAttends as $eventAttend) {
            $this->addEventAttend($eventAttend);
        }

        $this->collEventAttendsPartial = false;
        $this->collEventAttends = $eventAttends instanceof EventAttendCollection
            ? $eventAttends : new EventAttendCollection($eventAttends->getData());

        return $this;
    }

    /**
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
     */
    public function countEventAttends(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collEventAttendsPartial && !$this->isNew();
        if ($this->collEventAttends === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collEventAttends === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventAttends());
            }

            $query = ChildEventAttendQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPerson($this)
                ->count($con);
        }

        return count($this->collEventAttends);
    }

    /**
     * Method called to associate a EventAttend object to this object
     * through the EventAttend foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAttend $eventAttend
     *
     * @return $this
     */
    public function addEventAttend(EventAttend $eventAttend)
    {
        if ($this->collEventAttends === null) {
            $this->initEventAttends();
            $this->collEventAttendsPartial = true;
        }

        if (!$this->collEventAttends->contains($eventAttend)) {
            $this->doAddEventAttend($eventAttend);

            if ($this->eventAttendsScheduledForDeletion && $this->eventAttendsScheduledForDeletion->contains($eventAttend)) {
                $this->eventAttendsScheduledForDeletion->remove($this->eventAttendsScheduledForDeletion->search($eventAttend));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAttend $eventAttend The EventAttend object to add.
     *
     * @return void
     */
    protected function doAddEventAttend(EventAttend $eventAttend): void
    {
        $this->collEventAttends->append($eventAttend);
        $eventAttend->setPerson($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\EventAttend $eventAttend The EventAttend object to remove.
     *
     * @return static
     */
    public function removeEventAttend(EventAttend $eventAttend): static
    {
        if ($this->getEventAttends()->contains($eventAttend)) {
            $pos = $this->collEventAttends->search($eventAttend);
            $this->collEventAttends->remove($pos);
            if ($this->eventAttendsScheduledForDeletion === null) {
                $this->eventAttendsScheduledForDeletion = clone $this->collEventAttends;
                $this->eventAttendsScheduledForDeletion->clear();
            }
            $this->eventAttendsScheduledForDeletion->append(clone $eventAttend);
            $eventAttend->setPerson(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related EventAttends from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection
     */
    public function getEventAttendsJoinEvent(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventAttendCollection {
        $query = ChildEventAttendQuery::create(null, $criteria);
        $query->joinWith('Event', $joinBehavior);

        return $this->getEventAttends($query, $con);
    }

    /**
     * Initializes the collPrimaryContactpeople collection.
     *
     * By default this just sets the collPrimaryContactpeople collection to an empty array (like clearcollPrimaryContactpeople());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPrimaryContactpeople(bool $overrideExisting = true): void
    {
        if ($this->collPrimaryContactpeople !== null && !$overrideExisting) {
            return;
        }

        $this->collPrimaryContactpeople = new EventCollection();
        $this->collPrimaryContactpeople->setModel('\ChurchCRM\model\ChurchCRM\Event');
    }

    /**
     * Reset is the collPrimaryContactpeople collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialPrimaryContactpeople(bool $isPartial = true): void
    {
        $this->collPrimaryContactpeoplePartial = $isPartial;
    }

    /**
     * Clears out the collPrimaryContactpeople collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearPrimaryContactpeople(): static
    {
        $this->collPrimaryContactpeople = null;

        return $this;
    }

    /**
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getPrimaryContactpeople(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        $partial = $this->collPrimaryContactpeoplePartial && !$this->isNew();
        if ($this->collPrimaryContactpeople && !$criteria && !$partial) {
            return $this->collPrimaryContactpeople;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collPrimaryContactpeople === null) {
                $this->initPrimaryContactpeople();

                return $this->collPrimaryContactpeople;
            }

            $collPrimaryContactpeople = new EventCollection();
            $collPrimaryContactpeople->setModel('\ChurchCRM\model\ChurchCRM\Base\Event');

            return $collPrimaryContactpeople;
        }

        $collPrimaryContactpeople = ChildEventQuery::create(null, $criteria)
            ->filterByPersonRelatedByType($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collPrimaryContactpeoplePartial !== false && count($collPrimaryContactpeople)) {
                $this->initPrimaryContactpeople(false);

                foreach ($collPrimaryContactpeople as $obj) {
                    if (!$this->collPrimaryContactpeople->contains($obj)) {
                        $this->collPrimaryContactpeople->append($obj);
                    }
                }

                $this->collPrimaryContactpeoplePartial = true;
            }

            return $collPrimaryContactpeople;
        }

        if ($this->collPrimaryContactpeoplePartial && $this->collPrimaryContactpeople) {
            foreach ($this->collPrimaryContactpeople as $obj) {
                if ($obj->isNew()) {
                    $collPrimaryContactpeople[] = $obj;
                }
            }
        }

        $this->collPrimaryContactpeople = $collPrimaryContactpeople;
        $this->collPrimaryContactpeoplePartial = false;

        return $this->collPrimaryContactpeople;
    }

    /**
     * Sets a collection of person_per objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Event> $primaryContactpeople
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setPrimaryContactpeople(Collection $primaryContactpeople, ?ConnectionInterface $con = null): static
    {
        $primaryContactpeopleToDelete = $this->getPrimaryContactpeople(null, $con)->diff($primaryContactpeople);

        $this->primaryContactpeopleScheduledForDeletion = $primaryContactpeopleToDelete;

        foreach ($primaryContactpeopleToDelete as $primaryContactPersonRemoved) {
            $primaryContactPersonRemoved->setPersonRelatedByType(null);
        }

        $this->collPrimaryContactpeople = null;
        foreach ($primaryContactpeople as $primaryContactPerson) {
            $this->addPrimaryContactPerson($primaryContactPerson);
        }

        $this->collPrimaryContactpeoplePartial = false;
        $this->collPrimaryContactpeople = $primaryContactpeople instanceof EventCollection
            ? $primaryContactpeople : new EventCollection($primaryContactpeople->getData());

        return $this;
    }

    /**
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
     */
    public function countPrimaryContactpeople(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collPrimaryContactpeoplePartial && !$this->isNew();
        if ($this->collPrimaryContactpeople === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collPrimaryContactpeople === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPrimaryContactpeople());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPersonRelatedByType($this)
                ->count($con);
        }

        return count($this->collPrimaryContactpeople);
    }

    /**
     * Method called to associate a Event object to this object
     * through the Event foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return $this
     */
    public function addPrimaryContactPerson(Event $event)
    {
        if ($this->collPrimaryContactpeople === null) {
            $this->initPrimaryContactpeople();
            $this->collPrimaryContactpeoplePartial = true;
        }

        if (!$this->collPrimaryContactpeople->contains($event)) {
            $this->doAddPrimaryContactPerson($event);

            if ($this->primaryContactpeopleScheduledForDeletion && $this->primaryContactpeopleScheduledForDeletion->contains($event)) {
                $this->primaryContactpeopleScheduledForDeletion->remove($this->primaryContactpeopleScheduledForDeletion->search($event));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $primaryContactPerson The Event object to add.
     *
     * @return void
     */
    protected function doAddPrimaryContactPerson(Event $primaryContactPerson): void
    {
        $this->collPrimaryContactpeople->append($primaryContactPerson);
        $primaryContactPerson->setPersonRelatedByType($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $primaryContactPerson The Event object to remove.
     *
     * @return static
     */
    public function removePrimaryContactPerson(Event $primaryContactPerson): static
    {
        if ($this->getPrimaryContactpeople()->contains($primaryContactPerson)) {
            $pos = $this->collPrimaryContactpeople->search($primaryContactPerson);
            $this->collPrimaryContactpeople->remove($pos);
            if ($this->primaryContactpeopleScheduledForDeletion === null) {
                $this->primaryContactpeopleScheduledForDeletion = clone $this->collPrimaryContactpeople;
                $this->primaryContactpeopleScheduledForDeletion->clear();
            }
            $this->primaryContactpeopleScheduledForDeletion->append(clone $primaryContactPerson);
            $primaryContactPerson->setPersonRelatedByType(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related PrimaryContactpeople from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getPrimaryContactpeopleJoinEventType(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('EventType', $joinBehavior);

        return $this->getPrimaryContactpeople($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related PrimaryContactpeople from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getPrimaryContactpeopleJoinPersonRelatedBySecondaryContactPersonId(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('PersonRelatedBySecondaryContactPersonId', $joinBehavior);

        return $this->getPrimaryContactpeople($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related PrimaryContactpeople from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getPrimaryContactpeopleJoinLocation(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getPrimaryContactpeople($query, $con);
    }

    /**
     * Initializes the collSecondaryContactpeople collection.
     *
     * By default this just sets the collSecondaryContactpeople collection to an empty array (like clearcollSecondaryContactpeople());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSecondaryContactpeople(bool $overrideExisting = true): void
    {
        if ($this->collSecondaryContactpeople !== null && !$overrideExisting) {
            return;
        }

        $this->collSecondaryContactpeople = new EventCollection();
        $this->collSecondaryContactpeople->setModel('\ChurchCRM\model\ChurchCRM\Event');
    }

    /**
     * Reset is the collSecondaryContactpeople collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialSecondaryContactpeople(bool $isPartial = true): void
    {
        $this->collSecondaryContactpeoplePartial = $isPartial;
    }

    /**
     * Clears out the collSecondaryContactpeople collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearSecondaryContactpeople(): static
    {
        $this->collSecondaryContactpeople = null;

        return $this;
    }

    /**
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getSecondaryContactpeople(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        $partial = $this->collSecondaryContactpeoplePartial && !$this->isNew();
        if ($this->collSecondaryContactpeople && !$criteria && !$partial) {
            return $this->collSecondaryContactpeople;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collSecondaryContactpeople === null) {
                $this->initSecondaryContactpeople();

                return $this->collSecondaryContactpeople;
            }

            $collSecondaryContactpeople = new EventCollection();
            $collSecondaryContactpeople->setModel('\ChurchCRM\model\ChurchCRM\Base\Event');

            return $collSecondaryContactpeople;
        }

        $collSecondaryContactpeople = ChildEventQuery::create(null, $criteria)
            ->filterByPersonRelatedBySecondaryContactPersonId($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collSecondaryContactpeoplePartial !== false && count($collSecondaryContactpeople)) {
                $this->initSecondaryContactpeople(false);

                foreach ($collSecondaryContactpeople as $obj) {
                    if (!$this->collSecondaryContactpeople->contains($obj)) {
                        $this->collSecondaryContactpeople->append($obj);
                    }
                }

                $this->collSecondaryContactpeoplePartial = true;
            }

            return $collSecondaryContactpeople;
        }

        if ($this->collSecondaryContactpeoplePartial && $this->collSecondaryContactpeople) {
            foreach ($this->collSecondaryContactpeople as $obj) {
                if ($obj->isNew()) {
                    $collSecondaryContactpeople[] = $obj;
                }
            }
        }

        $this->collSecondaryContactpeople = $collSecondaryContactpeople;
        $this->collSecondaryContactpeoplePartial = false;

        return $this->collSecondaryContactpeople;
    }

    /**
     * Sets a collection of person_per objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Event> $secondaryContactpeople
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setSecondaryContactpeople(Collection $secondaryContactpeople, ?ConnectionInterface $con = null): static
    {
        $secondaryContactpeopleToDelete = $this->getSecondaryContactpeople(null, $con)->diff($secondaryContactpeople);

        $this->secondaryContactpeopleScheduledForDeletion = $secondaryContactpeopleToDelete;

        foreach ($secondaryContactpeopleToDelete as $secondaryContactPersonRemoved) {
            $secondaryContactPersonRemoved->setPersonRelatedBySecondaryContactPersonId(null);
        }

        $this->collSecondaryContactpeople = null;
        foreach ($secondaryContactpeople as $secondaryContactPerson) {
            $this->addSecondaryContactPerson($secondaryContactPerson);
        }

        $this->collSecondaryContactpeoplePartial = false;
        $this->collSecondaryContactpeople = $secondaryContactpeople instanceof EventCollection
            ? $secondaryContactpeople : new EventCollection($secondaryContactpeople->getData());

        return $this;
    }

    /**
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
     */
    public function countSecondaryContactpeople(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collSecondaryContactpeoplePartial && !$this->isNew();
        if ($this->collSecondaryContactpeople === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collSecondaryContactpeople === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSecondaryContactpeople());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPersonRelatedBySecondaryContactPersonId($this)
                ->count($con);
        }

        return count($this->collSecondaryContactpeople);
    }

    /**
     * Method called to associate a Event object to this object
     * through the Event foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $event
     *
     * @return $this
     */
    public function addSecondaryContactPerson(Event $event)
    {
        if ($this->collSecondaryContactpeople === null) {
            $this->initSecondaryContactpeople();
            $this->collSecondaryContactpeoplePartial = true;
        }

        if (!$this->collSecondaryContactpeople->contains($event)) {
            $this->doAddSecondaryContactPerson($event);

            if ($this->secondaryContactpeopleScheduledForDeletion && $this->secondaryContactpeopleScheduledForDeletion->contains($event)) {
                $this->secondaryContactpeopleScheduledForDeletion->remove($this->secondaryContactpeopleScheduledForDeletion->search($event));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $secondaryContactPerson The Event object to add.
     *
     * @return void
     */
    protected function doAddSecondaryContactPerson(Event $secondaryContactPerson): void
    {
        $this->collSecondaryContactpeople->append($secondaryContactPerson);
        $secondaryContactPerson->setPersonRelatedBySecondaryContactPersonId($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Event $secondaryContactPerson The Event object to remove.
     *
     * @return static
     */
    public function removeSecondaryContactPerson(Event $secondaryContactPerson): static
    {
        if ($this->getSecondaryContactpeople()->contains($secondaryContactPerson)) {
            $pos = $this->collSecondaryContactpeople->search($secondaryContactPerson);
            $this->collSecondaryContactpeople->remove($pos);
            if ($this->secondaryContactpeopleScheduledForDeletion === null) {
                $this->secondaryContactpeopleScheduledForDeletion = clone $this->collSecondaryContactpeople;
                $this->secondaryContactpeopleScheduledForDeletion->clear();
            }
            $this->secondaryContactpeopleScheduledForDeletion->append(clone $secondaryContactPerson);
            $secondaryContactPerson->setPersonRelatedBySecondaryContactPersonId(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related SecondaryContactpeople from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getSecondaryContactpeopleJoinEventType(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('EventType', $joinBehavior);

        return $this->getSecondaryContactpeople($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related SecondaryContactpeople from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getSecondaryContactpeopleJoinPersonRelatedByType(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('PersonRelatedByType', $joinBehavior);

        return $this->getSecondaryContactpeople($query, $con);
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related SecondaryContactpeople from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function getSecondaryContactpeopleJoinLocation(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventCollection {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getSecondaryContactpeople($query, $con);
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
     * Gets person_per objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Person is new, it will return
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
            ->filterByPerson($this)
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
     * Sets a collection of person_per objects related by a one-to-many relationship
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
            $pledgeRemoved->setPerson(null);
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
     * Returns the number of related person_per objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related person_per objects.
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
                ->filterByPerson($this)
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
        $pledge->setPerson($this);
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
            $this->pledgesScheduledForDeletion->append(clone $pledge);
            $pledge->setPerson(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
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
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
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
     * Otherwise if this person_per is new, it will return
     * an empty collection; or if this person_per has previously
     * been saved, it will retrieve related Pledges from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection
     */
    public function getPledgesJoinFamily(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): PledgeCollection {
        $query = ChildPledgeQuery::create(null, $criteria);
        $query->joinWith('Family', $joinBehavior);

        return $this->getPledges($query, $con);
    }

    /**
     * Gets a single User object, which is related to this object by a one-to-one relationship.
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\User|null
     */
    public function getUser(?ConnectionInterface $con = null)
    {
        if ($this->singleUser === null && !$this->isNew()) {
            $this->singleUser = ChildUserQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleUser;
    }

    /**
     * Sets a single User object as related to this object by a one-to-one relationship.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\User|null $v
     *
     * @return $this
     */
    public function setUser(?User $v = null)
    {
        $this->singleUser = $v;

        // Make sure that that the passed-in User isn't already associated with this object
        if ($v && $v->getPerson() === null) {
            $v->setPerson($this);
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
        if ($this->aFamily !== null) {
            $this->aFamily->removePerson($this);
        }
        $this->per_id = null;
        $this->per_title = null;
        $this->per_firstname = null;
        $this->per_middlename = null;
        $this->per_lastname = null;
        $this->per_suffix = null;
        $this->per_address1 = null;
        $this->per_address2 = null;
        $this->per_city = null;
        $this->per_state = null;
        $this->per_zip = null;
        $this->per_country = null;
        $this->per_homephone = null;
        $this->per_workphone = null;
        $this->per_cellphone = null;
        $this->per_email = null;
        $this->per_workemail = null;
        $this->per_birthmonth = null;
        $this->per_birthday = null;
        $this->per_birthyear = null;
        $this->per_membershipdate = null;
        $this->per_gender = null;
        $this->per_fmr_id = null;
        $this->per_cls_id = null;
        $this->per_fam_id = null;
        $this->per_envelope = null;
        $this->per_datelastedited = null;
        $this->per_dateentered = null;
        $this->per_enteredby = null;
        $this->per_editedby = null;
        $this->per_frienddate = null;
        $this->per_flags = null;
        $this->per_facebook = null;
        $this->per_twitter = null;
        $this->per_linkedin = null;
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
            if ($this->collWhyCames) {
                foreach ($this->collWhyCames as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singlePersonCustom) {
                $this->singlePersonCustom->clearAllReferences($deep);
            }
            if ($this->collNotes) {
                foreach ($this->collNotes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPerson2group2roleP2g2rs) {
                foreach ($this->collPerson2group2roleP2g2rs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventAttends) {
                foreach ($this->collEventAttends as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrimaryContactpeople) {
                foreach ($this->collPrimaryContactpeople as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSecondaryContactpeople) {
                foreach ($this->collSecondaryContactpeople as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPledges) {
                foreach ($this->collPledges as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleUser) {
                $this->singleUser->clearAllReferences($deep);
            }
        }

        $this->collWhyCames = null;
        $this->singlePersonCustom = null;
        $this->collNotes = null;
        $this->collPerson2group2roleP2g2rs = null;
        $this->collEventAttends = null;
        $this->collPrimaryContactpeople = null;
        $this->collSecondaryContactpeople = null;
        $this->collPledges = null;
        $this->singleUser = null;
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
        return (string)$this->exportTo(PersonTableMap::DEFAULT_STRING_FORMAT);
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
        $metadata->addPropertyConstraint('per_firstname', new NotNull());
        $metadata->addPropertyConstraint('per_firstname', new NotBlank());
        $metadata->addPropertyConstraint('per_firstname', new Length(array ('min' => 2,'max' => 50,)));
        $metadata->addPropertyConstraint('per_lastname', new NotNull());
        $metadata->addPropertyConstraint('per_lastname', new NotBlank());
        $metadata->addPropertyConstraint('per_lastname', new Length(array ('min' => 2,'max' => 50,)));
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

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (is_object($this->aFamily) and method_exists($this->aFamily, 'validate')) {
                if (!$this->aFamily->validate($validator)) {
                    $failureMap->addAll($this->aFamily->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collWhyCames) {
                foreach ($this->collWhyCames as $referrerFK) {
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
            if (null !== $this->collPerson2group2roleP2g2rs) {
                foreach ($this->collPerson2group2roleP2g2rs as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collEventAttends) {
                foreach ($this->collEventAttends as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collPrimaryContactpeople) {
                foreach ($this->collPrimaryContactpeople as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collSecondaryContactpeople) {
                foreach ($this->collSecondaryContactpeople as $referrerFK) {
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
