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
 * @package    Lof_FAQ
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Adminhtml\Ticket\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('ticket_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Ticket Information'));
    }

    /**
     * @return string
     *
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->addTab(
            'general',
            [
                'label' => __('General'),
                'content' => $this->getLayout()->createBlock('Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab\General')->toHtml()
            ]
        );
        $this->addTab(
            'message',
            [
                'label' => __('Message'),
                'content' => $this->getLayout()->createBlock('Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab\Message')->toHtml()
            ]
        );
        $this->addTab(
            'customer_information',
            [
                'label' => __('Customer Information'),
                'content' => $this->getLayout()->createBlock('Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab\Customer')->toHtml()
            ]
        );
        $this->addTab(
            'additional',
            [
                'label' => __('Additional'),
                'content' => $this->getLayout()->createBlock('Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab\Additional')->toHtml()
            ]
        );
        
        $this->addTab(
            'other_ticket',
            [
                'label' => __('Other ticket'),
                'content' => $this->getLayout()->createBlock('Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab\OtherTicket')->toHtml()
            ]
        );
    }

    /************************/
}
