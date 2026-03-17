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
 * Custom collection for User.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\User>
 */
class UserCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\User');
        $this->setFormatter(new ObjectFormatter());
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

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\UserConfigCollection
     */
    public function populateUserConfigs(?Criteria $criteria = null, ?ConnectionInterface $con = null): UserConfigCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\UserConfigCollection $collection */
        $collection = $this->populateRelation('UserConfig', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection
     */
    public function populateUserSettings(?Criteria $criteria = null, ?ConnectionInterface $con = null): UserSettingCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\UserSettingCollection $collection */
        $collection = $this->populateRelation('UserSetting', $criteria, $con);

        return $collection;
    }

}
