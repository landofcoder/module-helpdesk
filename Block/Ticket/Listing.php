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

use Lof\HelpDesk\Model\Config as Config;

class Listing extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Lof\HelpDesk\Model\DepartmentFactory
     */
    protected $departmentFactory;
    /**
     * @var \Lof\HelpDesk\Model\Config
     */
    protected $config;

    /**
     * @var \Lof\HelpDesk\Model\ResourceModel\Ticket\CollectionFactory
     */
    protected $ticketCollectionFactory;

    /**
     *
     * @var Lof\HelpDesk\Model\CategoryFactory
     */
    protected $category;

    /**
     * @var \Lof\HelpDesk\Helper\Field
     */
    protected $helpdeskField;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\View\Element\Template\Context
     */
    protected $context;

    protected $helper;

    protected $_unreadMessageCollection;

    protected $_message;
    /**
     * @var \Lof\HelpDesk\Model\ResourceModel\Ticket\CollectionFactory
     */
    protected $_collection;

    /**
     * @param \Lof\HelpDesk\Model\PriorityFactory $priorityFactory
     * @param \Lof\HelpDesk\Model\DepartmentFactory $departmentFactory
     * @param \Lof\HelpDesk\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Lof\HelpDesk\Model\ResourceModel\Field\CollectionFactory $fieldCollectionFactory
     * @param \Lof\HelpDesk\Model\Config $config
     * @param \Lof\HelpDesk\Helper\Field $helpdeskField
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Lof\HelpDesk\Helper\Order $helpdeskOrder
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Lof\HelpDesk\Model\DepartmentFactory $departmentFactory,
        \Lof\HelpDesk\Model\ResourceModel\Ticket\CollectionFactory $ticketCollectionFactory,
        \Lof\HelpDesk\Model\Config $config,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\HelpDesk\Model\Category $category,
        \Lof\HelpDesk\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Lof\HelpDesk\Model\Message $message,
        array $data = []
    )
    {
        $this->helper = $helper;
        $this->category = $category;
        $this->config = $config;
        $this->departmentFactory = $departmentFactory;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->context = $context;
        $this->_message = $message;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('My Tickets'));
        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle(__('My Tickets'));
        }
    }

    /**
     * @return $this
     */
    protected function getCustomer()
    {
        return $this->customerFactory->create()->load($this->customerSession->getCustomerId());
    }

    /**
     * @return object
     */
    public function getTicketCollection()
    {
        $collection = $this->ticketCollectionFactory->create()
            ->addFieldToFilter('customer_id', $this->getCustomer()->getId());

        return $collection;
    }

    /**
     * @return object
     */
    public function getCategoryName($catid)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $category = $objectManager->get('Lof\HelpDesk\Model\Category')->load($catid);
        $name = $category->getTitle();

        return $name;
    }

    /**
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
     * @return object
     */
    public function getDepartmentCollection()
    {
        return $this->departmentFactory->create()->getPreparedCollection($this->context->getStoreManager()->getStore())
            ->addFieldToFilter('is_show_in_frontend', true);
    }


    public function getCategory()
    {
        return $this->category->getCollection();
    }

    public function getOrder()
    {
        return $this->helper->getOrder($this->helper->getCustomerEmail());
    }

    public function getProduct()
    {
        return $this->helper->getProduct($this->helper->getCustomerEmail());
    }

    public function getPriority()
    {

        $data = [];
        $data [] = [];
        $data[0]['id'] = 0;
        $data[0]['title'] = __('Low');
        $data[1]['id'] = 1;
        $data[1]['title'] = __('Medium');
        $data[2]['id'] = 2;
        $data[2]['title'] = __('Height');
        $data[3]['id'] = 3;
        $data[3]['title'] = __('Ugent');

        return $data;
    }

    /**
     * Get Unread Message Collection
     *
     * @return \Lof\HelpDesk\Model\ResourceModel\Message\Collection
     */
    public function getUnreadMessageCollection($ticket_id)
    {


        $message = $this->_message->getCollection()->addFieldToFilter('ticket_id', $ticket_id)->addFieldToFilter('customer_name', '')
            ->addFieldToFilter('is_read', 0)
            ->setOrder('message_id', 'DESC')
            ->setPageSize(5);

        return $message;
    }


    /**
     * Get Unread Message Count
     *
     * @return int
     */
    public function getUnreadMessageCount($ticket_id)
    {
        return $this->getUnreadMessageCollection($ticket_id)->getSize();
    }

    /**
     * @param\Lof\HelpDesk\Model\ResourceModel\Ticket\Collection
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;
        return $this;
    }

    /**
     * @return \Lof\HelpDesk\Model\ResourceModel\Ticket\Collection
     */
    public function getCollection()
    {
        return $this->_collection;
    }

    protected function _beforeToHtml()
    {
        $toolbar = $this->getLayout()->getBlock('lhd_toolbar');
        $collection = $this->getTicket();
        $limit = $this->getLimit();

        if (!$limit) {
            $limit = 5;
        }
        if ($toolbar) {

            $toolbar->setData('_current_limit', $limit)->setCollection($collection);
            $this->setChild('toolbar', $toolbar);
        }
        return $this;
    }

    public function getLimitPage()
    {
        $size = $this->getCollection()->getSize();
        $limit = ceil($size / $this->getLimit());
        return $limit;
    }

    public function getCurrentPage()
    {
        $p = (int)$this->getRequest()->getParam('p');
        $limit = (int)$this->getLimitPage();
        if ($p > $limit) {
            $p = $limit;
        }
        if (!$p) {
            $p = 1;
        }
        return $p;
    }

    public function getTicket()
    {
        if (!$this->_collection) {
            $limit = $this->getLimit();
            if (!$limit) {
                $limit = 5;
            }
            $collection = $this->ticketCollectionFactory->create()
                ->addFieldToFilter('customer_id', $this->getCustomer()->getId());
            $collection->setPageSize($limit)->setOrder('ticket_id', 'desc');
            $this->setCollection($collection);
        }
        return $this->getCollection();
    }


}
