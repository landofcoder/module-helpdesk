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

namespace Lof\HelpDesk\Block\Ticket;

class View extends \Magento\Framework\View\Element\Template
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Lof\HelpDesk\Helper\Data
     */
    protected $helper;

    /**
     * @var \Lof\HelpDesk\Model\Ticket
     */
    protected $_ticketFactory;
    /**
     * @var \Lof\HelpDesk\Model\Message
     */
    protected $message;
    /**
     * @var \Lof\HelpDesk\Model\Attachment
     */
    protected $attachment;
    /**
     * @var \Lof\HelpDesk\Model\Like
     */
    protected $like;
    /**
     * @var \Lof\HelpDesk\Model\Category
     */
    protected $_categoryFactory;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $_resource;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;

    protected $_cacheTypeList;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Lof\HelpDesk\Model\Ticket $ticketFactory
     * @param \Lof\HelpDesk\Model\Message $message
     * @param \Lof\HelpDesk\Model\Attachment $attachment
     * @param \Lof\HelpDesk\Model\CategoryFactory $categoryFactory
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\Like $like
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param array
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\HelpDesk\Model\Ticket $ticketFactory,
        \Lof\HelpDesk\Model\Message $message,
        \Lof\HelpDesk\Model\Attachment $attachment,
        \Lof\HelpDesk\Model\CategoryFactory $categoryFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Like $like,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        array $data = []
    )
    {
        parent::__construct($context, $data);

        $this->like = $like;
        $this->attachment = $attachment;
        $this->session = $customerSession;
        $this->request = $context->getRequest();
        $this->helper = $helper;
        $this->_coreRegistry = $registry;
        $this->_ticketFactory = $ticketFactory;
        $this->message = $message;
        $this->_categoryFactory = $categoryFactory;
        $this->_resource = $resource;
        $this->_cacheTypeList = $cacheTypeList;

    }

    /**
     * @return void
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $ticket = $this->getTicket();
        $this->pageConfig->getTitle()->set(__("Ticket: ").$ticket->getSubject());
        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle(__("Ticket: ").$ticket->getSubject());
        }
    }

    public function isRead()
    {
        foreach ($this->message->getCollection()->addFieldToFilter('customer_email', '')->addFieldToFilter('ticket_id', $this->getId()) as $key => $message) {
            $message->setData('is_read', 1)->save();
            $this->_cacheTypeList->cleanType('full_page');
        }

        return;
    }

    public function getBaseMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getTicketCategory($catId)
    {
        $store = $this->_storeManager->getStore();
        $cat = $this->_categoryFactory->create()->getCollection()
            ->addFieldToFilter('is_active', ['eq' => 1])
            ->addFieldToFilter('main_table.category_id', ['eq' => $catId])
            ->addStoreFilter($store)->getFirstItem();
        return $cat;
    }

    /**
     * Get Current ticket id
     * @return int
     */
    public function getId()
    {
        if(!isset($this->_ticket_id)){
            $this->_ticket_id = $this->request->getParam("ticket_id");
        }
        return $this->_ticket_id;
    }

    public function getOrderTicket($orderid, $order_url = "")
    {
        return $this->helper->getOrderTicket($orderid, $order_url);
    }

    /**
     * @param int $id
     * @return object
     */
    public function getStatus($id)
    {
        $data = '';
        if ($id == 0) {
            $data = __('Close');
        } elseif ($id == 1) {
            $data = __('Open');
        } elseif ($id == 2) {
            $data = __('Processing');
        } elseif ($id == 3) {
            $data = __('Done');
        }

        return $data;
    }

    /**
     * @param int $id
     * @return object
     */
    public function getPriority($id)
    {
        $data = '';
        if ($id == 0) {
            $data = __('Low');
        } elseif ($id == 1) {
            $data = __('Medium');
        } elseif ($id == 2) {
            $data = __('Height');
        } elseif ($id == 3) {
            $data = __('Ugent');
        }

        return $data;
    }

    /**
     * @param int $catid
     * @return object
     */
    public function getCategoryName($catid)
    {
        $category = $this->_categoryFactory->create()->load($catid);
        $name = $category->getTitle();
        return $name;
    }

    /**
     * get current ticket
     * @return \Lof\HelpDesk\Model\Ticket|Object
     */
    public function getTicket()
    {
        $ticket = $this->_ticketFactory->getCollection()
            ->addFieldToFilter('main_table.ticket_id', $this->getId())
            ->getFirstItem();
        return $ticket;
    }

    /**
     * Get Message by Id
     * @param int $ticket_id
     * @return \Lof\HelpDesk\Model\Message[]
     */
    public function getMessage($ticket_id)
    {
        $message = $this->message->getCollection()->addFieldToFilter('ticket_id', $ticket_id);
        $message->setOrder('created_at','desc');
        return $message;
    }

    /**
     * Get Attachment by Id
     * @param int $message_id
     * @return \Lof\HelpDesk\Model\Attachment[]
     */
    public function getAttachment($message_id)
    {
        $attachment = $this->attachment->getCollection()
            ->addFieldToFilter('message_id', $message_id);
        return $attachment;
    }
    /**
     * @param string $id
     * @param int $message_id
     * @return int
     */
    public function getSumLike($id, $message_id)
    {
        $like = $this->like->getCollection()->addFieldToFilter($id, ['neq' => 'NULL']);
        $like->addFieldToFilter("message_id", $message_id);
        return $like->count();
    }

    /**
     * Retrive image URL
     * @param string $image
     * @return string
     */
    public function getAvatarUrl($image)
    {
        $url = false;
        if ($image) {
            $url = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $image;
        };
        return $url;
    }
}