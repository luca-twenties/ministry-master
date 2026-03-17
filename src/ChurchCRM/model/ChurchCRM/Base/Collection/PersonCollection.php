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
 * Custom collection for Person.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Person>
 */
class PersonCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\Person');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCollection
     */
    public function populateFamily(?Criteria $criteria = null, ?ConnectionInterface $con = null): FamilyCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\FamilyCollection $collection */
        $collection = $this->populateRelation('Family', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\WhyCameCollection
     */
    public function populateWhyCames(?Criteria $criteria = null, ?ConnectionInterface $con = null): WhyCameCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\WhyCameCollection $collection */
        $collection = $this->populateRelation('WhyCame', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCustomCollection
     */
    public function populatePersonCustoms(?Criteria $criteria = null, ?ConnectionInterface $con = null): PersonCustomCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCustomCollection $collection */
        $collection = $this->populateRelation('PersonCustom', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection
     */
    public function populateNotes(?Criteria $criteria = null, ?ConnectionInterface $con = null): NoteCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\NoteCollection $collection */
        $collection = $this->populateRelation('Note', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection
     */
    public function populatePerson2group2roleP2g2rs(?Criteria $criteria = null, ?ConnectionInterface $con = null): Person2group2roleP2g2rCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\Person2group2roleP2g2rCollection $collection */
        $collection = $this->populateRelation('Person2group2roleP2g2r', $criteria, $con);

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
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function populatePrimaryContactpeople(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection $collection */
        $collection = $this->populateRelation('PrimaryContactPerson', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function populateSecondaryContactpeople(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection $collection */
        $collection = $this->populateRelation('SecondaryContactPerson', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection
     */
    public function populatePledges(?Criteria $criteria = null, ?ConnectionInterface $con = null): PledgeCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PledgeCollection $collection */
        $collection = $this->populateRelation('Pledge', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection
     */
    public function populateUsers(?Criteria $criteria = null, ?ConnectionInterface $con = null): UserCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection $collection */
        $collection = $this->populateRelation('User', $criteria, $con);

        return $collection;
    }

}
