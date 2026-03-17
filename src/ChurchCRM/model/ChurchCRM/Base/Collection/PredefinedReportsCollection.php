<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChurchCRM\model\ChurchCRM\Base\Collection;

use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Formatter\ObjectFormatter;

/**
 * Custom collection for PredefinedReports.
 *
 * @extends \Propel\Runtime\Collection\ObjectCollection<\ChurchCRM\model\ChurchCRM\Base\PredefinedReports>
 */
class PredefinedReportsCollection extends ObjectCollection
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->setModel('\ChurchCRM\model\ChurchCRM\PredefinedReports');
        $this->setFormatter(new ObjectFormatter());
    }

}
