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

class CategoryList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $_categoryFactory;

    /**
     * @param \Lof\HelpDesk\Model\Category
     */
    public function __construct(
        \Lof\HelpDesk\Model\Category $categoryFactory
    )
    {
        $this->_categoryFactory = $categoryFactory;
    }

    public function toOptionArray()
    {
        $options = [];
        $collection = $this->_categoryFactory->getCollection();
        foreach ($collection as $_cat) {
            $options[] = [
                'label' => $_cat->getTitle(),
                'value' => $_cat->getCategoryId()
            ];
        }
        return $options;
    }
}