<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2014 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Adminhtml;

class Menu extends \Magento\Backend\Block\Template
{
    /**
     * @var null|array
     */
    protected $items = null;

    /**
     * Block template filename
     *
     * @var string
     */
    protected $_template = 'Lof_HelpDesk::menu.phtml';

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function getMenuItems()
    {
        if ($this->items === null) {
            $items = [
                'ticket' => [
                    'title' => __('Ticket'),
                    'url' => $this->getUrl('*/ticket/index'),
                    'resource' => 'Lof_HelpDesk::ticket'
                ],
                'category' => [
                    'title' => __('Category'),
                    'url' => $this->getUrl('*/category/index'),
                    'resource' => 'Lof_HelpDesk::category'
                ],
                'department' => [
                    'title' => __('Department'),
                    'url' => $this->getUrl('*/department/index'),
                    'resource' => 'Lof_HelpDesk::department'
                ],
                'permission' => [
                    'title' => __('Permission'),
                    'url' => $this->getUrl('*/permission/index'),
                    'resource' => 'Lof_HelpDesk::permission'
                ],
                'spam' => [
                    'title' => __('Spam'),
                    'url' => $this->getUrl('*/spam/index'),
                    'resource' => 'Lof_HelpDesk::spam'
                ],
                'chat' => [
                    'title' => __('Chat'),
                    'url' => $this->getUrl('*/chat/index'),
                    'resource' => 'Lof_HelpDesk::chat'
                ],
                'quickanswer' => [
                    'title' => __('Quick Answer'),
                    'url' => $this->getUrl('*/quickanswer/index'),
                    'resource' => 'Lof_HelpDesk::quickanswer'
                ],
                'blacklist' => [
                    'title' => __('Manage Blacklist'),
                    'url' => $this->getUrl('*/blacklist/index'),
                    'resource' => 'Lof_HelpDesk::blacklist'
                ],
                'settings' => [
                    'title' => __('Settings'),
                    'url' => $this->getUrl('adminhtml/system_config/edit/section/lofhelpdesk'),
                    'resource' => 'Lof_HelpDesk::settings'
                ],
                'readme' => [
                    'title' => __('Guide'),
                    'url' => 'http://guide.landofcoder.com/help-desk/',
                    'attr' => [
                        'target' => '_blank'
                    ],
                    'separator' => true
                ],
                'support' => [
                    'title' => __('Get Support'),
                    'url' => 'https://landofcoder.ticksy.com',
                    'attr' => [
                        'target' => '_blank'
                    ]
                ]
            ];
            foreach ($items as $index => $item) {
                if (array_key_exists('resource', $item)) {
                    if (!$this->_authorization->isAllowed($item['resource'])) {
                        unset($items[$index]);
                    }
                }
            }
            $this->items = $items;
        }

        return $this->items;
    }

    /**
     * @return array
     */
    public function getCurrentItem()
    {

        $items = $this->getMenuItems();

        $controllerName = $this->getRequest()->getControllerName();

        if (array_key_exists($controllerName, $items)) {
            return $items[$controllerName];
        }

        return $items['page'];
    }

    /**
     * @param array $item
     * @return string
     */
    public function renderAttributes(array $item)
    {
        $result = '';
        if (isset($item['attr'])) {
            foreach ($item['attr'] as $attrName => $attrValue) {
                $result .= sprintf(' %s=\'%s\'', $attrName, $attrValue);
            }
        }
        return $result;
    }

    /**
     * @param $itemIndex
     * @return bool
     */
    public function isCurrent($itemIndex)
    {
        return $itemIndex == $this->getRequest()->getControllerName();
    }
}
