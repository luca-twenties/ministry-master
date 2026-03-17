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
 * Custom collection for EventAttend.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\EventAttend>
 */
class EventAttendCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\EventAttend');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection
     */
    public function populateEvent(?Criteria $criteria = null, ?ConnectionInterface $con = null): EventCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\EventCollection $collection */
        $collection = $this->populateRelation('Event', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection
     */
    public function populatePerson(?Criteria $criteria = null, ?ConnectionInterface $con = null): PersonCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection $collection */
        $collection = $this->populateRelation('Person', $criteria, $con);

        return $collection;
    }

}
