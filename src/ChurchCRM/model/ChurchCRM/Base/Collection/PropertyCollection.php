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
 * Custom collection for Property.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\Property>
 */
class PropertyCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\Property');
        $this->setFormatter(new ObjectFormatter());
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyTypeCollection
     */
    public function populatePropertyType(?Criteria $criteria = null, ?ConnectionInterface $con = null): PropertyTypeCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\PropertyTypeCollection $collection */
        $collection = $this->populateRelation('PropertyType', $criteria, $con);

        return $collection;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\Criteria|null $criteria
     * @param \Propel\Runtime\Connection\ConnectionInterface|null $con
     *
     * @return \ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection
     */
    public function populateRecordProperties(?Criteria $criteria = null, ?ConnectionInterface $con = null): RecordPropertyCollection
    {
        /** @var \ChurchCRM\model\ChurchCRM\Base\Collection\RecordPropertyCollection $collection */
        $collection = $this->populateRelation('RecordProperty', $criteria, $con);

        return $collection;
    }

}
