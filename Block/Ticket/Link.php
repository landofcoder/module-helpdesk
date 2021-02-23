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

namespace Lof\HelpDesk\Block\Ticket;

/**
 * Customer account dropdown link
 */
class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var string
     */
    // protected $_template = 'Lof_HelpDesk::link.phtml';
    protected $_unreadMessageCollection;

    protected $_messageFactory;

    protected $helper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\HelpDesk\Model\MessageFactory $messageFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_customerSession = $customerSession;
        $this->_messageFactory = $messageFactory;
        $this->helper = $helper;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->getUrl('lofhelpdesk/ticket');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Helpdesk');
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
            $this->_unreadMessageCollection->addFieldToFilter('customer_email', '')->addFieldToFilter('customer_id', $this->helper->getCustomerId())
                ->addFieldToFilter('is_read', 0)
                ->setOrder('message_id', 'DESC')
                ->setPageSize(5);
        }

        return $this->_unreadMessageCollection;
    }

    /**
     * @return string
     */
    public function getMessageUrl()
    {
        return $this->getUrl('lofhelpdesk/ticket');
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

    public function toHtml()
    {
        if (!$this->_customerSession->isLoggedIn()) return '';
        return parent::toHtml();
    }
}

?>
