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

namespace Lof\HelpDesk\Block\Account\Dashboard\Link;

class Ticket extends \Magento\Framework\View\Element\Html\Link\Current
{

    /**
     * @var \Lof\HelpDesk\Helper\Data
     */
    protected $ticketData;

    protected $_unreadMessageCollection;

    protected $_messageFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\DefaultPathInterface $defaultPath
     * @param \Lof\HelpDesk\Helper\Data $ticketData
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\DefaultPathInterface $defaultPath,
        \Lof\HelpDesk\Helper\Data $ticketData,
        \Lof\HelpDesk\Model\MessageFactory $messageFactory,
        array $data = []
    )
    {
        parent::__construct($context, $defaultPath);
        $this->ticketData = $ticketData;
        $this->_messageFactory = $messageFactory;
    }

    /**
     * Get Unread Message Collection
     *
     * @return \Lof\HelpDesk\Model\ResourceModel\Message\Collection
     */
    public function getUnreadMessageCollection()
    {
        if (!$this->_unreadMessageCollection) {
            $this->_unreadMessageCollection = $this->_messageFactory->create()->getCollection();
            $this->_unreadMessageCollection->addFieldToFilter('customer_email', '')->addFieldToFilter('customer_id', $this->ticketData->getCustomerId())
                ->addFieldToFilter('is_read', 0)
                ->setOrder('message_id', 'DESC')
                ->setPageSize(5);
        }

        return $this->_unreadMessageCollection;
    }

    /**
     * Get Unread Message Count
     *
     * @return int
     */
    public function getUnreadMessageCount()
    {
        return $this->getUnreadMessageCollection()->getSize();
    }

    /**
     * Retrieve the Customer Data using the customer Id from the customer session.
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer()
    {
        $customer = $this->ticketData->getCustomer();
        return $customer;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        $html = '';
        $customer = $this->getCustomer();

        if (!$customer) {
            return;
        }
        $message = '';
        if ($this->getUnreadMessageCount() > 0) {
            if ($this->getUnreadMessageCount() == 1) {
                $message = '(' . $this->getUnreadMessageCount() . ' message)';
            } else {
                $message = '(' . $this->getUnreadMessageCount() . ' messages)';
            }
        }
        $highlight = '';
        //var_dump($this->getHref()); die();
        if ($this->getIsHighlighted()) {
            $highlight = ' current';
        }

        if ($this->isCurrent()) {
            $html = '<li class="lof_helpdesk nav item current lrw-nav-item">';
            $html .= '<strong>'
                . '<span>' . $this->escapeHtml((string)new \Magento\Framework\Phrase($this->getLabel())) . $message . '</span>';
            $html .= '</strong>';
            $html .= '</li>';
        } else {
            $html = '<li class="lof_helpdesk nav item' . $highlight . ' lrw-nav-item"><a href="' . $this->escapeHtml($this->getHref()) . '"';
            $html .= $this->getTitle()
                ? ' title="' . $this->escapeHtml((string)new \Magento\Framework\Phrase($this->getTitle())) . '"'
                : '';
            $html .= $this->getAttributesHtml() . '>';

            if ($this->getIsHighlighted()) {
                $html .= '<strong>';
            }

            $html .= '<span>' . $this->escapeHtml((string)new \Magento\Framework\Phrase($this->getLabel())) . $message . '</span>';

            if ($this->getIsHighlighted()) {
                $html .= '</strong>';
            }
            $html .= '</a></li>';
        }

        return $html;
    }
}