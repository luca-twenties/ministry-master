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
 * Custom collection for Pledge.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Pledge>
 */
class PledgeCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\Pledge');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\DepositCollection
     */
    public function populateDeposit(?Criteria $criteria = null, ?ConnectionInterface $con = null): DepositCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\DepositCollection $collection */
        $collection = $this->populateRelation('Deposit', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\DonationFundCollection
     */
    public function populateDonationFund(?Criteria $criteria = null, ?ConnectionInterface $con = null): DonationFundCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\DonationFundCollection $collection */
        $collection = $this->populateRelation('DonationFund', $criteria, $con);

        return $collection;
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
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection
     */
    public function populatePerson(?Criteria $criteria = null, ?ConnectionInterface $con = null): PersonCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PersonCollection $collection */
        $collection = $this->populateRelation('Person', $criteria, $con);

        return $collection;
    }

}
