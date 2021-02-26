<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/license-1-0
 */

namespace Lof\HelpDesk\Model\Config\Source;

class Category implements \Magento\Framework\Option\ArrayInterface
{
    protected $_category;

    public function __construct(\Lof\HelpDesk\Model\Category $category)
    {
        $this->_category = $category;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->_category->getCollection();
        $categorys = [];
        foreach ($collection as $_category) {
            $categorys[] = [
                'value' => $_category->getCategoryId(),
                'label' => $_category->getTitle()
            ];
        }
        return $categorys;
    }
}
