<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
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

class PageLayout implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'empty', 'label' => __('Empty')],
            ['value' => '1column', 'label' => __('1 column')],
            ['value' => '2columns-left', 'label' => __('2 columns with left bar')],
            ['value' => '2columns-right', 'label' => __('2 columns with right bar')],
            ['value' => '3columns', 'label' => __('3 columns')],
            ['value' => '2columns-right', 'label' => __('2 columns with right bar')],
        ];
    }
}
