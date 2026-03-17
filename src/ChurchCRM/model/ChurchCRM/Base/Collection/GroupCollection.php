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
 * Custom collection for Group.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Group>
 */
class GroupCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\Group');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\ListOptionCollection
     */
    public function populateListOption(?Criteria $criteria = null, ?ConnectionInterface $con = null): ListOptionCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\ListOptionCollection $collection */
        $collection = $this->populateRelation('ListOption', $criteria, $con);

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
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection
     */
    public function populateEventTypes(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventTypeCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventTypeCollection $collection */
        $collection = $this->populateRelation('EventType', $criteria, $con);

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
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function populateEvents(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection $collection */
        $collection = $this->populateRelation('Event', $criteria, $con);

        return $collection;
    }

}
