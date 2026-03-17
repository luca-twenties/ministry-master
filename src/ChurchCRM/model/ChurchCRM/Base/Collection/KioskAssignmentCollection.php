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
 * Custom collection for KioskAssignment.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\KioskAssignment>
 */
class KioskAssignmentCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\KioskAssignment');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\KioskDeviceCollection
     */
    public function populateKioskDevice(?Criteria $criteria = null, ?ConnectionInterface $con = null): KioskDeviceCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\KioskDeviceCollection $collection */
        $collection = $this->populateRelation('KioskDevice', $criteria, $con);

        return $collection;
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

}
