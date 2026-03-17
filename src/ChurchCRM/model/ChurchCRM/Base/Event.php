<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base;

use ChurchCRM\model\ChurchCRM\Base\Collection\CalendarCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\GroupCollection;
use ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection;
use ChurchCRM\model\ChurchCRM\CalendarEvent as ChildCalendarEvent;
use ChurchCRM\model\ChurchCRM\CalendarEventQuery as ChildCalendarEventQuery;
use ChurchCRM\model\ChurchCRM\CalendarQuery as ChildCalendarQuery;
use ChurchCRM\model\ChurchCRM\EventAttendQuery as ChildEventAttendQuery;
use ChurchCRM\model\ChurchCRM\EventAudience as ChildEventAudience;
use ChurchCRM\model\ChurchCRM\EventAudienceQuery as ChildEventAudienceQuery;
use ChurchCRM\model\ChurchCRM\EventQuery as ChildEventQuery;
use ChurchCRM\model\ChurchCRM\EventTypeQuery as ChildEventTypeQuery;
use ChurchCRM\model\ChurchCRM\GroupQuery as ChildGroupQuery;
use ChurchCRM\model\ChurchCRM\KioskAssignmentQuery as ChildKioskAssignmentQuery;
use ChurchCRM\model\ChurchCRM\LocationQuery as ChildLocationQuery;
use ChurchCRM\model\ChurchCRM\Map\EventTableMap;
use ChurchCRM\model\ChurchCRM\PersonQuery as ChildPersonQuery;
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
 * Base class that represents a row from the 'events_event' table.
 *
 * This contains events
 *
 * @package propel.generator.ChurchCRM.model.ChurchCRM.Base
 */
abstract class Event implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\ChurchCRM\\model\\ChurchCRM\\Map\\EventTableMap';

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
     * The value for the event_id field.
     */
    protected int|null $event_id = null;

    /**
     * The value for the event_type field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $event_type = null;

    /**
     * The value for the event_title field.
     *
     * Note: this column has a database default value of: ''
     */
    protected string|null $event_title = null;

    /**
     * The value for the event_desc field.
     */
    protected string|null $event_desc = null;

    /**
     * The value for the event_text field.
     */
    protected string|null $event_text = null;

    /**
     * The value for the event_start field.
     */
    protected DateTimeInterface|null $event_start = null;

    /**
     * The value for the event_end field.
     */
    protected DateTimeInterface|null $event_end = null;

    /**
     * The value for the inactive field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $inactive = null;

    /**
     * The value for the location_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $location_id = null;

    /**
     * The value for the primary_contact_person_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $primary_contact_person_id = null;

    /**
     * The value for the secondary_contact_person_id field.
     *
     * Note: this column has a database default value of: 0
     */
    protected int|null $secondary_contact_person_id = null;

    /**
     * The value for the event_url field.
     */
    protected string|null $event_url = null;

    /**
     * EventType associated via EventType relation (n:1).
     */
    protected EventType|null $aEventType = null;

    /**
     * Person associated via PersonRelatedByType relation (n:1).
     */
    protected Person|null $aPersonRelatedByType = null;

    /**
     * Person associated via PersonRelatedBySecondaryContactPersonId relation (n:1).
     */
    protected Person|null $aPersonRelatedBySecondaryContactPersonId = null;

    /**
     * Location associated via Location relation (n:1).
     */
    protected Location|null $aLocation = null;

    /**
     * Objects associated via EventAttend relation (1:n).
     */
    protected EventAttendCollection|null $collEventAttends = null;

    /**
     * If $collEventAttends contains all objects in EventAttend relation.
     */
    protected bool $collEventAttendsPartial = false;

    /**
     * Objects associated via KioskAssignment relation (1:n).
     */
    protected KioskAssignmentCollection|null $collKioskAssignments = null;

    /**
     * If $collKioskAssignments contains all objects in KioskAssignment relation.
     */
    protected bool $collKioskAssignmentsPartial = false;

    /**
     * Objects associated via EventAudience relation (1:n).
     */
    protected EventAudienceCollection|null $collEventAudiences = null;

    /**
     * If $collEventAudiences contains all objects in EventAudience relation.
     */
    protected bool $collEventAudiencesPartial = false;

    /**
     * Objects associated via CalendarEvent relation (1:n).
     */
    protected CalendarEventCollection|null $collCalendarEvents = null;

    /**
     * If $collCalendarEvents contains all objects in CalendarEvent relation.
     */
    protected bool $collCalendarEventsPartial = false;

    /**
     * Objects associated via Group relation (n:m).
     */
    protected GroupCollection|null $collGroups = null;

    /**
     * If $collGroups contains all objects in Group relation.
     */
    protected bool $collGroupsIsPartial = false;

    /**
     * Objects associated via Calendar relation (n:m).
     */
    protected CalendarCollection|null $collCalendars = null;

    /**
     * If $collCalendars contains all objects in Calendar relation.
     */
    protected bool $collCalendarsIsPartial = false;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     */
    protected bool $alreadyInSave = false;

    /**
     * Items of Group relation marked for deletion.
     */
    protected GroupCollection|null $groupsScheduledForDeletion = null;

    /**
     * Items of Calendar relation marked for deletion.
     */
    protected CalendarCollection|null $calendarsScheduledForDeletion = null;

    /**
     * Items of EventAttends relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAttend>|null
     */
    protected ObjectCollection|null $eventAttendsScheduledForDeletion = null;

    /**
     * Items of KioskAssignments relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\KioskAssignment>|null
     */
    protected ObjectCollection|null $kioskAssignmentsScheduledForDeletion = null;

    /**
     * Items of EventAudiences relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAudience>|null
     */
    protected ObjectCollection|null $eventAudiencesScheduledForDeletion = null;

    /**
     * Items of CalendarEvents relation marked for deletion.
     *
     * @var \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\CalendarEvent>|null
     */
    protected ObjectCollection|null $calendarEventsScheduledForDeletion = null;

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
        $this->event_type = 0;
        $this->event_title = '';
        $this->inactive = 0;
        $this->location_id = 0;
        $this->primary_contact_person_id = 0;
        $this->secondary_contact_person_id = 0;
    }

    /**
     * Initializes internal state of ChurchCRM\model\ChurchCRM\Base\Event object.
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
     * Compares this with another <code>Event</code> instance. If
     * <code>obj</code> is an instance of <code>Event</code>, delegates to
     * <code>equals(Event)</code>. Otherwise, returns <code>false</code>.
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
     * Get the [event_id] column value.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->event_id;
    }

    /**
     * Get the [event_type] column value.
     *
     * @return int|null
     */
    public function getType()
    {
        return $this->event_type;
    }

    /**
     * Get the [event_title] column value.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->event_title;
    }

    /**
     * Get the [event_desc] column value.
     *
     * @return string|null
     */
    public function getDesc()
    {
        return $this->event_desc;
    }

    /**
     * Get the [event_text] column value.
     *
     * @return string|null
     */
    public function getText()
    {
        return $this->event_text;
    }

    /**
     * Get the [optionally formatted] temporal [event_start] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getStart($format = null)
    {
        if ($format === null) {
            return $this->event_start;
        } else {
            return $this->event_start instanceof DateTimeInterface ? $this->event_start->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [event_end] column value.
     *
     * @psalm-return ($format is null ? \DateTime|\DateTimeInterface|null : string|null)
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw \DateTime object will be returned.
     *
     * @return \DateTime|\DateTimeInterface|string|null Formatted date/time value as string or \DateTime object (if format is NULL), and 0 if column value is 0000-00-00 00:00:00.
     */
    public function getEnd($format = null)
    {
        if ($format === null) {
            return $this->event_end;
        } else {
            return $this->event_end instanceof DateTimeInterface ? $this->event_end->format($format) : null;
        }
    }

    /**
     * Get the [inactive] column value.
     *
     * @return int|null
     */
    public function getInActive()
    {
        return $this->inactive;
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
     * Get the [primary_contact_person_id] column value.
     *
     * @return int|null
     */
    public function getPrimaryContactPersonId()
    {
        return $this->primary_contact_person_id;
    }

    /**
     * Get the [secondary_contact_person_id] column value.
     *
     * @return int|null
     */
    public function getSecondaryContactPersonId()
    {
        return $this->secondary_contact_person_id;
    }

    /**
     * Get the [event_url] column value.
     *
     * @return string|null
     */
    public function getURL()
    {
        return $this->event_url;
    }

    /**
     * Set the value of [event_id] column.
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

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [event_type] column.
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

        if ($this->event_type !== $v) {
            $this->event_type = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_TYPE] = true;
        }

        if ($this->aEventType !== null && $this->aEventType->getId() !== $v) {
            $this->aEventType = null;
        }

        if ($this->aPersonRelatedByType !== null && $this->aPersonRelatedByType->getId() !== $v) {
            $this->aPersonRelatedByType = null;
        }

        return $this;
    }

    /**
     * Set the value of [event_title] column.
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

        if ($this->event_title !== $v) {
            $this->event_title = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [event_desc] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setDesc($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->event_desc !== $v) {
            $this->event_desc = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_DESC] = true;
        }

        return $this;
    }

    /**
     * Set the value of [event_text] column.
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

        if ($this->event_text !== $v) {
            $this->event_text = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_TEXT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [event_start] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->event_start !== null || $dt !== null) {
            if ($this->event_start === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->event_start->format('Y-m-d H:i:s.u')) {
                $this->event_start = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_EVENT_START] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Sets the value of [event_end] column to a normalized version of the date/time value specified.
     *
     * @param \DateTimeInterface|string|int $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     *
     * @return $this
     */
    public function setEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, '\DateTime');
        if ($this->event_end !== null || $dt !== null) {
            if ($this->event_end === null || $dt === null || $dt->format('Y-m-d H:i:s.u') !== $this->event_end->format('Y-m-d H:i:s.u')) {
                $this->event_end = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_EVENT_END] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [inactive] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setInActive($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->inactive !== $v) {
            $this->inactive = $v;
            $this->modifiedColumns[EventTableMap::COL_INACTIVE] = true;
        }

        return $this;
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
            $this->modifiedColumns[EventTableMap::COL_LOCATION_ID] = true;
        }

        if ($this->aLocation !== null && $this->aLocation->getLocationId() !== $v) {
            $this->aLocation = null;
        }

        return $this;
    }

    /**
     * Set the value of [primary_contact_person_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setPrimaryContactPersonId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->primary_contact_person_id !== $v) {
            $this->primary_contact_person_id = $v;
            $this->modifiedColumns[EventTableMap::COL_PRIMARY_CONTACT_PERSON_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [secondary_contact_person_id] column.
     *
     * @param int|null $v New value
     *
     * @return $this
     */
    public function setSecondaryContactPersonId($v)
    {
        if ($v !== null) {
            $v = (int)$v;
        }

        if ($this->secondary_contact_person_id !== $v) {
            $this->secondary_contact_person_id = $v;
            $this->modifiedColumns[EventTableMap::COL_SECONDARY_CONTACT_PERSON_ID] = true;
        }

        if ($this->aPersonRelatedBySecondaryContactPersonId !== null && $this->aPersonRelatedBySecondaryContactPersonId->getId() !== $v) {
            $this->aPersonRelatedBySecondaryContactPersonId = null;
        }

        return $this;
    }

    /**
     * Set the value of [event_url] column.
     *
     * @param string|null $v New value
     *
     * @return $this
     */
    public function setURL($v)
    {
        if ($v !== null) {
            $v = (string)$v;
        }

        if ($this->event_url !== $v) {
            $this->event_url = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_URL] = true;
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
        if ($this->event_type !== 0) {
            return false;
        }

        if ($this->event_title !== '') {
            return false;
        }

        if ($this->inactive !== 0) {
            return false;
        }

        if ($this->location_id !== 0) {
            return false;
        }

        if ($this->primary_contact_person_id !== 0) {
            return false;
        }

        if ($this->secondary_contact_person_id !== 0) {
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

            $rowIndex = $useNumericIndex ? $startcol + 0 : EventTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 1 : EventTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_type = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 2 : EventTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_title = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 3 : EventTableMap::translateFieldName('Desc', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_desc = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 4 : EventTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_text = $columnValue !== null ? (string)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 5 : EventTableMap::translateFieldName('Start', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->event_start = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 6 : EventTableMap::translateFieldName('End', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            if ($columnValue === '0000-00-00 00:00:00') {
                $columnValue = null;
            }
            $this->event_end = ($columnValue !== null) ? PropelDateTime::newInstance($columnValue, null, '\DateTime') : null;

            $rowIndex = $useNumericIndex ? $startcol + 7 : EventTableMap::translateFieldName('InActive', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->inactive = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 8 : EventTableMap::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->location_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 9 : EventTableMap::translateFieldName('PrimaryContactPersonId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->primary_contact_person_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 10 : EventTableMap::translateFieldName('SecondaryContactPersonId', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->secondary_contact_person_id = $columnValue !== null ? (int)$columnValue : null;

            $rowIndex = $useNumericIndex ? $startcol + 11 : EventTableMap::translateFieldName('URL', TableMap::TYPE_PHPNAME, $indexType);
            $columnValue = $row[$rowIndex];
            $this->event_url = $columnValue !== null ? (string)$columnValue : null;

            $this->resetModified();
            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12;
        } catch (Exception $e) {
            throw new PropelException('Error populating \ChurchCRM\model\ChurchCRM\Event object', 0, $e);
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
        if ($this->aEventType !== null && $this->event_type !== $this->aEventType->getId()) {
            $this->aEventType = null;
        }
        if ($this->aPersonRelatedByType !== null && $this->event_type !== $this->aPersonRelatedByType->getId()) {
            $this->aPersonRelatedByType = null;
        }
        if ($this->aLocation !== null && $this->location_id !== $this->aLocation->getLocationId()) {
            $this->aLocation = null;
        }
        if ($this->aPersonRelatedBySecondaryContactPersonId !== null && $this->secondary_contact_person_id !== $this->aPersonRelatedBySecondaryContactPersonId->getId()) {
            $this->aPersonRelatedBySecondaryContactPersonId = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventQuery::create(null, $this->buildPkeyCriteria())->fetch($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row || $row === true) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) { // also de-associate any related objects?
            $this->aEventType = null;
            $this->aPersonRelatedByType = null;
            $this->aPersonRelatedBySecondaryContactPersonId = null;
            $this->aLocation = null;
            $this->collEventAttends = null;
            $this->collKioskAssignments = null;
            $this->collEventAudiences = null;
            $this->collCalendarEvents = null;
            $this->collGroups = null;
            $this->collCalendars = null;
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @see Event::setDeleted()
     * @see Event::isDeleted()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
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
                EventTableMap::addInstanceToPool($this);
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

        if ($this->aEventType !== null) {
            if ($this->aEventType->isModified() || $this->aEventType->isNew()) {
                $affectedRows += $this->aEventType->save($con);
            }
            $this->setEventType($this->aEventType);
        }

        if ($this->aPersonRelatedByType !== null) {
            if ($this->aPersonRelatedByType->isModified() || $this->aPersonRelatedByType->isNew()) {
                $affectedRows += $this->aPersonRelatedByType->save($con);
            }
            $this->setPersonRelatedByType($this->aPersonRelatedByType);
        }

        if ($this->aPersonRelatedBySecondaryContactPersonId !== null) {
            if ($this->aPersonRelatedBySecondaryContactPersonId->isModified() || $this->aPersonRelatedBySecondaryContactPersonId->isNew()) {
                $affectedRows += $this->aPersonRelatedBySecondaryContactPersonId->save($con);
            }
            $this->setPersonRelatedBySecondaryContactPersonId($this->aPersonRelatedBySecondaryContactPersonId);
        }

        if ($this->aLocation !== null) {
            if ($this->aLocation->isModified() || $this->aLocation->isNew()) {
                $affectedRows += $this->aLocation->save($con);
            }
            $this->setLocation($this->aLocation);
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

        if ($this->groupsScheduledForDeletion !== null && !$this->groupsScheduledForDeletion->isEmpty()) {
            $pks = [];
            foreach ($this->groupsScheduledForDeletion as $entry) {
                $entryPk = [];

                $entryPk[0] = $this->getId();
                $entryPk[1] = $entry->getId();
                $pks[] = $entryPk;
            }

            ChildEventAudienceQuery::create()
                ->filterByPrimaryKeys($pks)
                ->delete($con);

            $this->groupsScheduledForDeletion = null;
        }

        if ($this->collGroups) {
            foreach ($this->collGroups as $group) {
                if (!$group->isDeleted() && ($group->isNew() || $group->isModified())) {
                    $group->save($con);
                }
            }
        }

        if ($this->calendarsScheduledForDeletion !== null && !$this->calendarsScheduledForDeletion->isEmpty()) {
            $pks = [];
            foreach ($this->calendarsScheduledForDeletion as $entry) {
                $entryPk = [];

                $entryPk[1] = $this->getId();
                $entryPk[0] = $entry->getId();
                $pks[] = $entryPk;
            }

            ChildCalendarEventQuery::create()
                ->filterByPrimaryKeys($pks)
                ->delete($con);

            $this->calendarsScheduledForDeletion = null;
        }

        if ($this->collCalendars) {
            foreach ($this->collCalendars as $calendar) {
                if (!$calendar->isDeleted() && ($calendar->isNew() || $calendar->isModified())) {
                    $calendar->save($con);
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

        if ($this->calendarEventsScheduledForDeletion !== null) {
            if (!$this->calendarEventsScheduledForDeletion->isEmpty()) {
                ChildCalendarEventQuery::create()
                    ->filterByPrimaryKeys($this->calendarEventsScheduledForDeletion->getPrimaryKeys(false))
                    ->delete($con);
                $this->calendarEventsScheduledForDeletion = null;
            }
        }

        if ($this->collCalendarEvents !== null) {
            foreach ($this->collCalendarEvents as $referrerFK) {
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
        $this->modifiedColumns[EventTableMap::COL_EVENT_ID] = true;
        if ($this->event_id !== null) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventTableMap::COL_EVENT_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++] = 'event_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TYPE)) {
            $modifiedColumns[':p' . $index++] = 'event_type';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TITLE)) {
            $modifiedColumns[':p' . $index++] = 'event_title';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_DESC)) {
            $modifiedColumns[':p' . $index++] = 'event_desc';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TEXT)) {
            $modifiedColumns[':p' . $index++] = 'event_text';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_START)) {
            $modifiedColumns[':p' . $index++] = 'event_start';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_END)) {
            $modifiedColumns[':p' . $index++] = 'event_end';
        }
        if ($this->isColumnModified(EventTableMap::COL_INACTIVE)) {
            $modifiedColumns[':p' . $index++] = 'inactive';
        }
        if ($this->isColumnModified(EventTableMap::COL_LOCATION_ID)) {
            $modifiedColumns[':p' . $index++] = 'location_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_PRIMARY_CONTACT_PERSON_ID)) {
            $modifiedColumns[':p' . $index++] = 'primary_contact_person_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_SECONDARY_CONTACT_PERSON_ID)) {
            $modifiedColumns[':p' . $index++] = 'secondary_contact_person_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_URL)) {
            $modifiedColumns[':p' . $index++] = 'event_url';
        }

        $sql = sprintf(
            'INSERT INTO events_event (%s) VALUES (%s)',
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
                    case 'event_id':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);

                        break;
                    case 'event_type':
                        $stmt->bindValue($identifier, $this->event_type, PDO::PARAM_INT);

                        break;
                    case 'event_title':
                        $stmt->bindValue($identifier, $this->event_title, PDO::PARAM_STR);

                        break;
                    case 'event_desc':
                        $stmt->bindValue($identifier, $this->event_desc, PDO::PARAM_STR);

                        break;
                    case 'event_text':
                        $stmt->bindValue($identifier, $this->event_text, PDO::PARAM_STR);

                        break;
                    case 'event_start':
                        $stmt->bindValue($identifier, $this->event_start ? $this->event_start->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'event_end':
                        $stmt->bindValue($identifier, $this->event_end ? $this->event_end->format('Y-m-d H:i:s.u') : null, PDO::PARAM_STR);

                        break;
                    case 'inactive':
                        $stmt->bindValue($identifier, $this->inactive, PDO::PARAM_INT);

                        break;
                    case 'location_id':
                        $stmt->bindValue($identifier, $this->location_id, PDO::PARAM_INT);

                        break;
                    case 'primary_contact_person_id':
                        $stmt->bindValue($identifier, $this->primary_contact_person_id, PDO::PARAM_INT);

                        break;
                    case 'secondary_contact_person_id':
                        $stmt->bindValue($identifier, $this->secondary_contact_person_id, PDO::PARAM_INT);

                        break;
                    case 'event_url':
                        $stmt->bindValue($identifier, $this->event_url, PDO::PARAM_STR);

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
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
            2 => $this->getTitle(),
            3 => $this->getDesc(),
            4 => $this->getText(),
            5 => $this->getStart(),
            6 => $this->getEnd(),
            7 => $this->getInActive(),
            8 => $this->getLocationId(),
            9 => $this->getPrimaryContactPersonId(),
            10 => $this->getSecondaryContactPersonId(),
            11 => $this->getURL(),
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
        if (isset($alreadyDumpedObjects['Event'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Event'][$this->hashCode()] = true;
        $keys = EventTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getType(),
            $keys[2] => $this->getTitle(),
            $keys[3] => $this->getDesc(),
            $keys[4] => $this->getText(),
            $keys[5] => $this->getStart(),
            $keys[6] => $this->getEnd(),
            $keys[7] => $this->getInActive(),
            $keys[8] => $this->getLocationId(),
            $keys[9] => $this->getPrimaryContactPersonId(),
            $keys[10] => $this->getSecondaryContactPersonId(),
            $keys[11] => $this->getURL(),
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
            if ($this->aEventType !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'eventType',
                     TableMap::TYPE_FIELDNAME => 'event_types',
                     default => 'EventType',
                };
                $result[$key] = $this->aEventType->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aPersonRelatedByType !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'person',
                     TableMap::TYPE_FIELDNAME => 'person_per',
                     default => 'Person',
                };
                $result[$key] = $this->aPersonRelatedByType->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aPersonRelatedBySecondaryContactPersonId !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'person',
                     TableMap::TYPE_FIELDNAME => 'person_per',
                     default => 'Person',
                };
                $result[$key] = $this->aPersonRelatedBySecondaryContactPersonId->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->aLocation !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'location',
                     TableMap::TYPE_FIELDNAME => 'locations',
                     default => 'Location',
                };
                $result[$key] = $this->aLocation->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
            }
            if ($this->collEventAttends !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'eventAttends',
                     TableMap::TYPE_FIELDNAME => 'event_attends',
                     default => 'EventAttends',
                };
                $result[$key] = $this->collEventAttends->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collKioskAssignments !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'kioskAssignments',
                     TableMap::TYPE_FIELDNAME => 'kioskassginment_kasms',
                     default => 'KioskAssignments',
                };
                $result[$key] = $this->collKioskAssignments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collEventAudiences !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'eventAudiences',
                     TableMap::TYPE_FIELDNAME => 'event_audiences',
                     default => 'EventAudiences',
                };
                $result[$key] = $this->collEventAudiences->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if ($this->collCalendarEvents !== null) {
                $key = match ($keyType) {
                     TableMap::TYPE_CAMELNAME => 'calendarEvents',
                     TableMap::TYPE_FIELDNAME => 'calendar_eventss',
                     default => 'CalendarEvents',
                };
                $result[$key] = $this->collCalendarEvents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setTitle($value);

                break;
            case 3:
                $this->setDesc($value);

                break;
            case 4:
                $this->setText($value);

                break;
            case 5:
                $this->setStart($value);

                break;
            case 6:
                $this->setEnd($value);

                break;
            case 7:
                $this->setInActive($value);

                break;
            case 8:
                $this->setLocationId($value);

                break;
            case 9:
                $this->setPrimaryContactPersonId($value);

                break;
            case 10:
                $this->setSecondaryContactPersonId($value);

                break;
            case 11:
                $this->setURL($value);

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
        $keys = EventTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setType($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTitle($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDesc($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setText($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setStart($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEnd($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setInActive($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLocationId($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPrimaryContactPersonId($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSecondaryContactPersonId($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setURL($arr[$keys[11]]);
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
        $tableMap = EventTableMap::getTableMap();
        $criteria = new Criteria(EventTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventTableMap::COL_EVENT_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_id'), $this->event_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TYPE)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_type'), $this->event_type);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TITLE)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_title'), $this->event_title);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_DESC)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_desc'), $this->event_desc);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_TEXT)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_text'), $this->event_text);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_START)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_start'), $this->event_start);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_END)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_end'), $this->event_end);
        }
        if ($this->isColumnModified(EventTableMap::COL_INACTIVE)) {
            $criteria->setUpdateValue($tableMap->getColumn('inactive'), $this->inactive);
        }
        if ($this->isColumnModified(EventTableMap::COL_LOCATION_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('location_id'), $this->location_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_PRIMARY_CONTACT_PERSON_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('primary_contact_person_id'), $this->primary_contact_person_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_SECONDARY_CONTACT_PERSON_ID)) {
            $criteria->setUpdateValue($tableMap->getColumn('secondary_contact_person_id'), $this->secondary_contact_person_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_EVENT_URL)) {
            $criteria->setUpdateValue($tableMap->getColumn('event_url'), $this->event_url);
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
        $tableMap = EventTableMap::getTableMap();
        $query = ChildEventQuery::create();
        $event_idColumn = new LocalColumnExpression($query, $tableMap->getName(), $tableMap->getColumn('event_id'));
        $query->addAnd($event_idColumn, $this->event_id);

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
     * Generic method to set the primary key (event_id column).
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
     * @param object $copyObj An object of \ChurchCRM\model\ChurchCRM\Event (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     *
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setType($this->getType());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDesc($this->getDesc());
        $copyObj->setText($this->getText());
        $copyObj->setStart($this->getStart());
        $copyObj->setEnd($this->getEnd());
        $copyObj->setInActive($this->getInActive());
        $copyObj->setLocationId($this->getLocationId());
        $copyObj->setPrimaryContactPersonId($this->getPrimaryContactPersonId());
        $copyObj->setSecondaryContactPersonId($this->getSecondaryContactPersonId());
        $copyObj->setURL($this->getURL());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEventAttends() as $relObj) {
                $copyObj->addEventAttend($relObj->copy($deepCopy));
            }
            foreach ($this->getKioskAssignments() as $relObj) {
                $copyObj->addKioskAssignment($relObj->copy($deepCopy));
            }
            foreach ($this->getEventAudiences() as $relObj) {
                $copyObj->addEventAudience($relObj->copy($deepCopy));
            }
            foreach ($this->getCalendarEvents() as $relObj) {
                $copyObj->addCalendarEvent($relObj->copy($deepCopy));
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
     * Declares an association between this object and a EventType object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\EventType|null $eventType
     *
     * @return $this
     */
    public function setEventType(?EventType $eventType = null)
    {
        $type = $eventType ? $eventType->getId() : 0;
        $this->setType($type);

        $this->aEventType = $eventType;
        $eventType?->addEventType($this);

        return $this;
    }

    /**
     * Get the associated EventType object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\EventType|null
     */
    public function getEventType(?ConnectionInterface $con = null)
    {
        if ($this->aEventType === null && ($this->event_type !== null && $this->event_type !== 0)) {
            $this->aEventType = ChildEventTypeQuery::create()->findPk($this->event_type, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEventType->addEventTypes($this);
             */
        }

        return $this->aEventType;
    }

    /**
     * Declares an association between this object and a Person object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|null $personRelatedByType
     *
     * @return $this
     */
    public function setPersonRelatedByType(?Person $personRelatedByType = null)
    {
        $type = $personRelatedByType ? $personRelatedByType->getId() : 0;
        $this->setType($type);

        $this->aPersonRelatedByType = $personRelatedByType;
        $personRelatedByType?->addPrimaryContactPerson($this);

        return $this;
    }

    /**
     * Get the associated PersonRelatedByType object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Person|null
     */
    public function getPersonRelatedByType(?ConnectionInterface $con = null)
    {
        if ($this->aPersonRelatedByType === null && ($this->event_type !== null && $this->event_type !== 0)) {
            $this->aPersonRelatedByType = ChildPersonQuery::create()->findPk($this->event_type, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPersonRelatedByType->addPrimaryContactpeople($this);
             */
        }

        return $this->aPersonRelatedByType;
    }

    /**
     * Declares an association between this object and a Person object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Person|null $personRelatedBySecondaryContactPersonId
     *
     * @return $this
     */
    public function setPersonRelatedBySecondaryContactPersonId(?Person $personRelatedBySecondaryContactPersonId = null)
    {
        $secondaryContactPersonId = $personRelatedBySecondaryContactPersonId ? $personRelatedBySecondaryContactPersonId->getId() : 0;
        $this->setSecondaryContactPersonId($secondaryContactPersonId);

        $this->aPersonRelatedBySecondaryContactPersonId = $personRelatedBySecondaryContactPersonId;
        $personRelatedBySecondaryContactPersonId?->addSecondaryContactPerson($this);

        return $this;
    }

    /**
     * Get the associated PersonRelatedBySecondaryContactPersonId object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Person|null
     */
    public function getPersonRelatedBySecondaryContactPersonId(?ConnectionInterface $con = null)
    {
        if ($this->aPersonRelatedBySecondaryContactPersonId === null && ($this->secondary_contact_person_id !== null && $this->secondary_contact_person_id !== 0)) {
            $this->aPersonRelatedBySecondaryContactPersonId = ChildPersonQuery::create()->findPk($this->secondary_contact_person_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPersonRelatedBySecondaryContactPersonId->addSecondaryContactpeople($this);
             */
        }

        return $this->aPersonRelatedBySecondaryContactPersonId;
    }

    /**
     * Declares an association between this object and a Location object.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Location|null $location
     *
     * @return $this
     */
    public function setLocation(?Location $location = null)
    {
        $locationId = $location ? $location->getLocationId() : 0;
        $this->setLocationId($locationId);

        $this->aLocation = $location;
        $location?->addEvent($this);

        return $this;
    }

    /**
     * Get the associated Location object
     *
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional Connection object.
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Location|null
     */
    public function getLocation(?ConnectionInterface $con = null)
    {
        if ($this->aLocation === null && ($this->location_id !== null && $this->location_id !== 0)) {
            $this->aLocation = ChildLocationQuery::create()->findPk($this->location_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLocation->addEvents($this);
             */
        }

        return $this->aLocation;
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
            'EventAttend' => $this->initEventAttends(),
            'KioskAssignment' => $this->initKioskAssignments(),
            'EventAudience' => $this->initEventAudiences(),
            'CalendarEvent' => $this->initCalendarEvents(),
            default => null
        };
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
     * Gets events_event objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Event is new, it will return
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
            ->filterByEvent($this)
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
     * Sets a collection of events_event objects related by a one-to-many relationship
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
            $eventAttendRemoved->setEvent(null);
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
     * Returns the number of related events_event objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related events_event objects.
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
                ->filterByEvent($this)
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
        $eventAttend->setEvent($this);
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
            $eventAttend->setEvent(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this events_event is new, it will return
     * an empty collection; or if this events_event has previously
     * been saved, it will retrieve related EventAttends from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection
     */
    public function getEventAttendsJoinPerson(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventAttendCollection {
        $query = ChildEventAttendQuery::create(null, $criteria);
        $query->joinWith('Person', $joinBehavior);

        return $this->getEventAttends($query, $con);
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
     * Gets events_event objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Event is new, it will return
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
            ->filterByEvent($this)
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
     * Sets a collection of events_event objects related by a one-to-many relationship
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
            $kioskAssignmentRemoved->setEvent(null);
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
     * Returns the number of related events_event objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related events_event objects.
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
                ->filterByEvent($this)
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
        $kioskAssignment->setEvent($this);
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
            $kioskAssignment->setEvent(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this events_event is new, it will return
     * an empty collection; or if this events_event has previously
     * been saved, it will retrieve related KioskAssignments from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection
     */
    public function getKioskAssignmentsJoinKioskDevice(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): KioskAssignmentCollection {
        $query = ChildKioskAssignmentQuery::create(null, $criteria);
        $query->joinWith('KioskDevice', $joinBehavior);

        return $this->getKioskAssignments($query, $con);
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
     * Gets events_event objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Event is new, it will return
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
            ->filterByEvent($this)
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
     * Sets a collection of events_event objects related by a one-to-many relationship
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
            $eventAudienceRemoved->setEvent(null);
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
     * Returns the number of related events_event objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related events_event objects.
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
                ->filterByEvent($this)
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
        $eventAudience->setEvent($this);
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
            $eventAudience->setEvent(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this events_event is new, it will return
     * an empty collection; or if this events_event has previously
     * been saved, it will retrieve related EventAudiences from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection
     */
    public function getEventAudiencesJoinGroup(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): EventAudienceCollection {
        $query = ChildEventAudienceQuery::create(null, $criteria);
        $query->joinWith('Group', $joinBehavior);

        return $this->getEventAudiences($query, $con);
    }

    /**
     * Initializes the collCalendarEvents collection.
     *
     * By default this just sets the collCalendarEvents collection to an empty array (like clearcollCalendarEvents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCalendarEvents(bool $overrideExisting = true): void
    {
        if ($this->collCalendarEvents !== null && !$overrideExisting) {
            return;
        }

        $this->collCalendarEvents = new CalendarEventCollection();
        $this->collCalendarEvents->setModel('\ChurchCRM\model\ChurchCRM\CalendarEvent');
    }

    /**
     * Reset is the collCalendarEvents collection loaded partially.
     *
     * @param bool $isPartial
     *
     * @return void
     */
    public function resetPartialCalendarEvents(bool $isPartial = true): void
    {
        $this->collCalendarEventsPartial = $isPartial;
    }

    /**
     * Clears out the collCalendarEvents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return static
     */
    public function clearCalendarEvents(): static
    {
        $this->collCalendarEvents = null;

        return $this;
    }

    /**
     * Gets events_event objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Event is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection
     */
    public function getCalendarEvents(?Criteria $criteria = null, ?ConnectionInterface $con = null): CalendarEventCollection
    {
        $partial = $this->collCalendarEventsPartial && !$this->isNew();
        if ($this->collCalendarEvents && !$criteria && !$partial) {
            return $this->collCalendarEvents;
        }

        if ($this->isNew()) {
            // return empty collection
            if ($this->collCalendarEvents === null) {
                $this->initCalendarEvents();

                return $this->collCalendarEvents;
            }

            $collCalendarEvents = new CalendarEventCollection();
            $collCalendarEvents->setModel('\ChurchCRM\model\ChurchCRM\Base\CalendarEvent');

            return $collCalendarEvents;
        }

        $collCalendarEvents = ChildCalendarEventQuery::create(null, $criteria)
            ->filterByEvent($this)
            ->findObjects($con);

        if ($criteria) {
            if ($this->collCalendarEventsPartial !== false && count($collCalendarEvents)) {
                $this->initCalendarEvents(false);

                foreach ($collCalendarEvents as $obj) {
                    if (!$this->collCalendarEvents->contains($obj)) {
                        $this->collCalendarEvents->append($obj);
                    }
                }

                $this->collCalendarEventsPartial = true;
            }

            return $collCalendarEvents;
        }

        if ($this->collCalendarEventsPartial && $this->collCalendarEvents) {
            foreach ($this->collCalendarEvents as $obj) {
                if ($obj->isNew()) {
                    $collCalendarEvents[] = $obj;
                }
            }
        }

        $this->collCalendarEvents = $collCalendarEvents;
        $this->collCalendarEventsPartial = false;

        return $this->collCalendarEvents;
    }

    /**
     * Sets a collection of events_event objects related by a one-to-many relationship
     * to the current object.
     *
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\CalendarEvent> $calendarEvents
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return static
     */
    public function setCalendarEvents(Collection $calendarEvents, ?ConnectionInterface $con = null): static
    {
        $calendarEventsToDelete = $this->getCalendarEvents(null, $con)->diff($calendarEvents);

        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->calendarEventsScheduledForDeletion = clone $calendarEventsToDelete;

        foreach ($calendarEventsToDelete as $calendarEventRemoved) {
            $calendarEventRemoved->setEvent(null);
        }

        $this->collCalendarEvents = null;
        foreach ($calendarEvents as $calendarEvent) {
            $this->addCalendarEvent($calendarEvent);
        }

        $this->collCalendarEventsPartial = false;
        $this->collCalendarEvents = $calendarEvents instanceof CalendarEventCollection
            ? $calendarEvents : new CalendarEventCollection($calendarEvents->getData());

        return $this;
    }

    /**
     * Returns the number of related events_event objects.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param bool $distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return int Count of related events_event objects.
     */
    public function countCalendarEvents(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collCalendarEventsPartial && !$this->isNew();
        if ($this->collCalendarEvents === null || $criteria !== null || $partial) {
            if ($this->isNew() && $this->collCalendarEvents === null) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCalendarEvents());
            }

            $query = ChildCalendarEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collCalendarEvents);
    }

    /**
     * Method called to associate a CalendarEvent object to this object
     * through the CalendarEvent foreign key attribute.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\CalendarEvent $calendarEvent
     *
     * @return $this
     */
    public function addCalendarEvent(CalendarEvent $calendarEvent)
    {
        if ($this->collCalendarEvents === null) {
            $this->initCalendarEvents();
            $this->collCalendarEventsPartial = true;
        }

        if (!$this->collCalendarEvents->contains($calendarEvent)) {
            $this->doAddCalendarEvent($calendarEvent);

            if ($this->calendarEventsScheduledForDeletion && $this->calendarEventsScheduledForDeletion->contains($calendarEvent)) {
                $this->calendarEventsScheduledForDeletion->remove($this->calendarEventsScheduledForDeletion->search($calendarEvent));
            }
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\CalendarEvent $calendarEvent The CalendarEvent object to add.
     *
     * @return void
     */
    protected function doAddCalendarEvent(CalendarEvent $calendarEvent): void
    {
        $this->collCalendarEvents->append($calendarEvent);
        $calendarEvent->setEvent($this);
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\CalendarEvent $calendarEvent The CalendarEvent object to remove.
     *
     * @return static
     */
    public function removeCalendarEvent(CalendarEvent $calendarEvent): static
    {
        if ($this->getCalendarEvents()->contains($calendarEvent)) {
            $pos = $this->collCalendarEvents->search($calendarEvent);
            $this->collCalendarEvents->remove($pos);
            if ($this->calendarEventsScheduledForDeletion === null) {
                $this->calendarEventsScheduledForDeletion = clone $this->collCalendarEvents;
                $this->calendarEventsScheduledForDeletion->clear();
            }
            $this->calendarEventsScheduledForDeletion->append(clone $calendarEvent);
            $calendarEvent->setEvent(null);
        }

        return $this;
    }

    /**
     * @deprecated do join yourself if you need it.
     *
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this events_event is new, it will return
     * an empty collection; or if this events_event has previously
     * been saved, it will retrieve related CalendarEvents from storage.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection
     */
    public function getCalendarEventsJoinCalendar(
        ?Criteria $criteria = null,
        ?ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    ): CalendarEventCollection {
        $query = ChildCalendarEventQuery::create(null, $criteria);
        $query->joinWith('Calendar', $joinBehavior);

        return $this->getCalendarEvents($query, $con);
    }

    /**
     * Clears out the collGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     */
    public function clearGroups(): void
    {
        $this->collGroups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collGroups crossRef collection.
     *
     * By default this just sets the collGroups collection to an empty collection (like clearGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initGroups(): void
    {
        $this->collGroups = new GroupCollection();
        $this->collGroupsIsPartial = true;
        $this->collGroups->setModel('\ChurchCRM\model\ChurchCRM\Group');
    }

    /**
     * Checks if the collGroups collection is loaded.
     *
     * @return bool
     */
    public function isGroupsLoaded(): bool
    {
        return $this->collGroups !== null;
    }

    /**
     * Gets a collection of Group objects related by a many-to-many relationship
     * to the current object by way of the event_audience cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Event is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional query object to filter the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\GroupCollection
     */
    public function getGroups(?Criteria $criteria = null, ?ConnectionInterface $con = null): GroupCollection
    {
        $partial = $this->collGroupsIsPartial && !$this->isNew();
        if ($this->collGroups === null || $criteria !== null || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if ($this->collGroups === null) {
                    $this->initGroups();
                }
            } else {
                $query = ChildGroupQuery::create(null, $criteria)
                    ->filterByEvent($this);
                $collGroups = $query->findObjects($con);
                if ($criteria !== null) {
                    return $collGroups;
                }

                if ($partial && $this->collGroups) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collGroups as $obj) {
                        if (!$collGroups->contains($obj)) {
                            $collGroups[] = $obj;
                        }
                    }
                }

                $this->collGroups = $collGroups;
                $this->collGroupsIsPartial = false;
            }
        }

        return $this->collGroups;
    }

    /**
     * Sets a collection of Group objects related by a many-to-many relationship
     * to the current object by way of the event_audience cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Group> $groups A Propel collection.
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return static
     */
    public function setGroups(Collection $groups, ?ConnectionInterface $con = null): static
    {
        $this->clearGroups();
        $currentGroups = $this->getGroups();

        $groupsScheduledForDeletion = $currentGroups->diff($groups);

        foreach ($groupsScheduledForDeletion as $toDelete) {
            $this->removeGroup($toDelete);
        }

        foreach ($groups as $group) {
            if (!$currentGroups->contains($group)) {
                $this->doAddGroup($group);
            }
        }

        $this->collGroupsIsPartial = false;
        $this->collGroups = $groups instanceof GroupCollection
            ? $groups : new GroupCollection($groups->getData());

        return $this;
    }

    /**
     * Gets the number of Group objects related by a many-to-many relationship
     * to the current object by way of the event_audience cross-reference table.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return int The number of related Group objects
     */
    public function countGroups(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collGroupsIsPartial && !$this->isNew();
        if ($this->collGroups && !$criteria && !$partial) {
            return count($this->collGroups);
        }

        if ($this->isNew() && $this->collGroups === null) {
            return 0;
        }

        if ($partial && !$criteria) {
            return count($this->getGroups());
        }

        $query = ChildGroupQuery::create(null, $criteria);
        if ($distinct) {
            $query->distinct();
        }

        return $query
            ->filterByEvent($this)
            ->count($con);
    }

    /**
     * Associate a Group with this object through the event_audience cross reference table.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Group $group
     *
     * @return static
     */
    public function addGroup(Group $group): static
    {
        if ($this->collGroups === null) {
            $this->initGroups();
        }

        if (!$this->getGroups()->contains($group)) {
            // only add it if the **same** object is not already associated
            $this->collGroups->push($group);
            $this->doAddGroup($group);
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Group $group
     *
     * @return void
     */
    protected function doAddGroup(Group $group): void
    {
        $eventAudience = new ChildEventAudience();
        $eventAudience->setGroup($group);
        $eventAudience->setEvent($this);

        $this->addEventAudience($eventAudience);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$group->isEventsLoaded()) {
            $group->initEvents();
            $group->getEvents()->push($this);
        } elseif (!$group->getEvents()->contains($this)) {
            $group->getEvents()->push($this);
        }
    }

    /**
     * Remove group of this object through the event_audience cross reference table.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Group $group
     *
     * @return static
     */
    public function removeGroup(Group $group): static
    {
        if (!$this->getGroups()->contains($group)) {
            return $this;
        }

        $eventAudience = new ChildEventAudience();
        $eventAudience->setGroup($group);
        if ($group->isEventsLoaded()) {
            //remove the back reference if available
            $group->getEvents()->removeObject($this);
        }

        $eventAudience->setEvent($this);
        $this->removeEventAudience(clone $eventAudience);
        $eventAudience->clear();

        $this->collGroups->remove($this->collGroups->search($group));

        if ($this->groupsScheduledForDeletion === null) {
            $this->groupsScheduledForDeletion = clone $this->collGroups;
            $this->groupsScheduledForDeletion->clear();
        }

        $this->groupsScheduledForDeletion->push($group);

        return $this;
    }

    /**
     * Clears out the collCalendars collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     */
    public function clearCalendars(): void
    {
        $this->collCalendars = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collCalendars crossRef collection.
     *
     * By default this just sets the collCalendars collection to an empty collection (like clearCalendars());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initCalendars(): void
    {
        $this->collCalendars = new CalendarCollection();
        $this->collCalendarsIsPartial = true;
        $this->collCalendars->setModel('\ChurchCRM\model\ChurchCRM\Calendar');
    }

    /**
     * Checks if the collCalendars collection is loaded.
     *
     * @return bool
     */
    public function isCalendarsLoaded(): bool
    {
        return $this->collCalendars !== null;
    }

    /**
     * Gets a collection of Calendar objects related by a many-to-many relationship
     * to the current object by way of the calendar_events cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Event is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional query object to filter the query
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarCollection
     */
    public function getCalendars(?Criteria $criteria = null, ?ConnectionInterface $con = null): CalendarCollection
    {
        $partial = $this->collCalendarsIsPartial && !$this->isNew();
        if ($this->collCalendars === null || $criteria !== null || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if ($this->collCalendars === null) {
                    $this->initCalendars();
                }
            } else {
                $query = ChildCalendarQuery::create(null, $criteria)
                    ->filterByEvent($this);
                $collCalendars = $query->findObjects($con);
                if ($criteria !== null) {
                    return $collCalendars;
                }

                if ($partial && $this->collCalendars) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collCalendars as $obj) {
                        if (!$collCalendars->contains($obj)) {
                            $collCalendars[] = $obj;
                        }
                    }
                }

                $this->collCalendars = $collCalendars;
                $this->collCalendarsIsPartial = false;
            }
        }

        return $this->collCalendars;
    }

    /**
     * Sets a collection of Calendar objects related by a many-to-many relationship
     * to the current object by way of the calendar_events cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param \Propel\Runtime\Collection\Collection<\ChurchCRM\model\ChurchCRM\Base\Calendar> $calendars A Propel collection.
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return static
     */
    public function setCalendars(Collection $calendars, ?ConnectionInterface $con = null): static
    {
        $this->clearCalendars();
        $currentCalendars = $this->getCalendars();

        $calendarsScheduledForDeletion = $currentCalendars->diff($calendars);

        foreach ($calendarsScheduledForDeletion as $toDelete) {
            $this->removeCalendar($toDelete);
        }

        foreach ($calendars as $calendar) {
            if (!$currentCalendars->contains($calendar)) {
                $this->doAddCalendar($calendar);
            }
        }

        $this->collCalendarsIsPartial = false;
        $this->collCalendars = $calendars instanceof CalendarCollection
            ? $calendars : new CalendarCollection($calendars->getData());

        return $this;
    }

    /**
     * Gets the number of Calendar objects related by a many-to-many relationship
     * to the current object by way of the calendar_events cross-reference table.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria Optional query object to filter the query
     * @param bool $distinct Set to true to force count distinct
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con Optional connection object
     *
     * @return int The number of related Calendar objects
     */
    public function countCalendars(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collCalendarsIsPartial && !$this->isNew();
        if ($this->collCalendars && !$criteria && !$partial) {
            return count($this->collCalendars);
        }

        if ($this->isNew() && $this->collCalendars === null) {
            return 0;
        }

        if ($partial && !$criteria) {
            return count($this->getCalendars());
        }

        $query = ChildCalendarQuery::create(null, $criteria);
        if ($distinct) {
            $query->distinct();
        }

        return $query
            ->filterByEvent($this)
            ->count($con);
    }

    /**
     * Associate a Calendar with this object through the calendar_events cross reference table.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Calendar $calendar
     *
     * @return static
     */
    public function addCalendar(Calendar $calendar): static
    {
        if ($this->collCalendars === null) {
            $this->initCalendars();
        }

        if (!$this->getCalendars()->contains($calendar)) {
            // only add it if the **same** object is not already associated
            $this->collCalendars->push($calendar);
            $this->doAddCalendar($calendar);
        }

        return $this;
    }

    /**
     * @param \ChurchCRM\model\ChurchCRM\Base\Calendar $calendar
     *
     * @return void
     */
    protected function doAddCalendar(Calendar $calendar): void
    {
        $calendarEvent = new ChildCalendarEvent();
        $calendarEvent->setCalendar($calendar);
        $calendarEvent->setEvent($this);

        $this->addCalendarEvent($calendarEvent);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$calendar->isEventsLoaded()) {
            $calendar->initEvents();
            $calendar->getEvents()->push($this);
        } elseif (!$calendar->getEvents()->contains($this)) {
            $calendar->getEvents()->push($this);
        }
    }

    /**
     * Remove calendar of this object through the calendar_events cross reference table.
     *
     * @param \ChurchCRM\model\ChurchCRM\Base\Calendar $calendar
     *
     * @return static
     */
    public function removeCalendar(Calendar $calendar): static
    {
        if (!$this->getCalendars()->contains($calendar)) {
            return $this;
        }

        $calendarEvent = new ChildCalendarEvent();
        $calendarEvent->setCalendar($calendar);
        if ($calendar->isEventsLoaded()) {
            //remove the back reference if available
            $calendar->getEvents()->removeObject($this);
        }

        $calendarEvent->setEvent($this);
        $this->removeCalendarEvent(clone $calendarEvent);
        $calendarEvent->clear();

        $this->collCalendars->remove($this->collCalendars->search($calendar));

        if ($this->calendarsScheduledForDeletion === null) {
            $this->calendarsScheduledForDeletion = clone $this->collCalendars;
            $this->calendarsScheduledForDeletion->clear();
        }

        $this->calendarsScheduledForDeletion->push($calendar);

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
        if ($this->aEventType !== null) {
            $this->aEventType->removeEventType($this);
        }
        if ($this->aPersonRelatedByType !== null) {
            $this->aPersonRelatedByType->removePrimaryContactPerson($this);
        }
        if ($this->aPersonRelatedBySecondaryContactPersonId !== null) {
            $this->aPersonRelatedBySecondaryContactPersonId->removeSecondaryContactPerson($this);
        }
        if ($this->aLocation !== null) {
            $this->aLocation->removeEvent($this);
        }
        $this->event_id = null;
        $this->event_type = null;
        $this->event_title = null;
        $this->event_desc = null;
        $this->event_text = null;
        $this->event_start = null;
        $this->event_end = null;
        $this->inactive = null;
        $this->location_id = null;
        $this->primary_contact_person_id = null;
        $this->secondary_contact_person_id = null;
        $this->event_url = null;
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
            if ($this->collEventAttends) {
                foreach ($this->collEventAttends as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collKioskAssignments) {
                foreach ($this->collKioskAssignments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventAudiences) {
                foreach ($this->collEventAudiences as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCalendarEvents) {
                foreach ($this->collCalendarEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroups) {
                foreach ($this->collGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCalendars) {
                foreach ($this->collCalendars as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        }

        $this->collEventAttends = null;
        $this->collKioskAssignments = null;
        $this->collEventAudiences = null;
        $this->collCalendarEvents = null;
        $this->collGroups = null;
        $this->collCalendars = null;
        $this->aEventType = null;
        $this->aPersonRelatedByType = null;
        $this->aPersonRelatedBySecondaryContactPersonId = null;
        $this->aLocation = null;

        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->exportTo(EventTableMap::DEFAULT_STRING_FORMAT);
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
