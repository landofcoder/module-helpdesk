<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Model\Config\Source;

class Position implements \Magento\Framework\Option\ArrayInterface
{


    public function toOptionArray()
    {
        $data = [];
        $data[] = [
            'value' => 'left',
            'label' => __('Left'),
        ];
        $data[] = [
            'value' => 'right',
            'label' => __('Right'),
        ];
        return $data;
    }
}