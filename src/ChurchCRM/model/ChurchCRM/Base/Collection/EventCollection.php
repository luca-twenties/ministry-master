<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base\Collection;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Formatter\ObjectFormatter;

/**
 * Custom collection for Event.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Event>
 */
class EventCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\Event');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection
     */
    public function populateEventType(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventTypeCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection $collection */
        $collection = $this->populateRelation('EventType', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection
     */
    public function populatePersonRelatedByType(?Criteria $criteria = null, ?ConnectionInterface $con = null): PersonCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection $collection */
        $collection = $this->populateRelation('PersonRelatedByType', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection
     */
    public function populatePersonRelatedBySecondaryContactPersonId(?Criteria $criteria = null, ?ConnectionInterface $con = null): PersonCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection $collection */
        $collection = $this->populateRelation('PersonRelatedBySecondaryContactPersonId', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\LocationCollection
     */
    public function populateLocation(?Criteria $criteria = null, ?ConnectionInterface $con = null): LocationCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\LocationCollection $collection */
        $collection = $this->populateRelation('Location', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection
     */
    public function populateEventAttends(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventAttendCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventAttendCollection $collection */
        $collection = $this->populateRelation('EventAttend', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection
     */
    public function populateKioskAssignments(?Criteria $criteria = null, ?ConnectionInterface $con = null): KioskAssignmentCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\KioskAssignmentCollection $collection */
        $collection = $this->populateRelation('KioskAssignment', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection
     */
    public function populateEventAudiences(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventAudienceCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventAudienceCollection $collection */
        $collection = $this->populateRelation('EventAudience', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection
     */
    public function populateCalendarEvents(?Criteria $criteria = null, ?ConnectionInterface $con = null): CalendarEventCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarEventCollection $collection */
        $collection = $this->populateRelation('CalendarEvent', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\GroupCollection
     */
    public function populateGroups(?Criteria $criteria = null, ?ConnectionInterface $con = null): GroupCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\GroupCollection $collection */
        $collection = $this->populateRelation('Group', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarCollection
     */
    public function populateCalendars(?Criteria $criteria = null, ?ConnectionInterface $con = null): CalendarCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\CalendarCollection $collection */
        $collection = $this->populateRelation('Calendar', $criteria, $con);

        return $collection;
    }

}
