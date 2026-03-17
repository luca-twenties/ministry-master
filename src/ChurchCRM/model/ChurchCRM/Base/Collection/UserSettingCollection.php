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
 * Custom collection for UserSetting.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\UserSetting>
 */
class UserSettingCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\UserSetting');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection
     */
    public function populateUser(?Criteria $criteria = null, ?ConnectionInterface $con = null): UserCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\UserCollection $collection */
        $collection = $this->populateRelation('User', $criteria, $con);

        return $collection;
    }

}
