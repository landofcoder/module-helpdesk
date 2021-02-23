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

namespace Lof\HelpDesk\Controller\Customer;

use Magento\Customer\Model\CustomerFactory;

class Saveticket extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;
    /**
     * @var \Lof\HelpDesk\Model\Sender
     */
    protected $sender;
    /**
     * @var  \Lof\HelpDesk\Helper\Data
     */
    protected $helper;
    /**
     * @var  \Lof\HelpDesk\Model\Spam
     */
    protected $spam;
    /**
     * @var  CustomerFactory
     */
    protected $customerFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Model\Sender $sender,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Spam $spam,
        \Magento\Framework\Filesystem $filesystem,
        CustomerFactory $customerFactory
    )
    {
        $this->spam = $spam;
        $this->helper = $helper;
        $this->resultPageFactory = $resultPageFactory;
        $this->session = $customerSession;
        $this->_fileSystem = $filesystem;
        $this->sender = $sender;
        $this->customerFactory = $customerFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $customerSession = $this->session;
         $customerId = $customerSession->getId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
             $data['customer_id'] = $customerId;
            $data['customer_name'] = $customerSession->getCustomer()->getName();
            $data['customer_email'] = $customerSession->getCustomer()->getEmail();
            $data['customer_name'] = $data['name'];
            $data['customer_email'] = $data['email'];
            $ticketModel = $objectManager->get('Lof\HelpDesk\Model\Ticket');
            $category = $objectManager->get('Lof\HelpDesk\Model\Category')->load($data['category_id'], 'category_id');
            $department = $objectManager->create('Lof\HelpDesk\Model\Department');
            $user = $objectManager->create('\Magento\User\Model\User');
            $store = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            $customerObj = $this->customerFactory->create()->getCollection()->addFieldToFilter('email', $data['email']);
            if($customerObj->getSize()>0){
                foreach ($customerObj->getData() as $customer){
                    $data['customer_id'] =$customer['entity_id'];
                }
            }else{
                $data['customer_id'] = $customerId;
            }
            $data['store_id'] = $store->getStore()->getId();
            $data['status_id'] = 1;
            $data['last_reply_name'] = $data['customer_name'];
            $data['reply_cnt'] = 0;
            $data['category'] = $category->getTile();
            $data['namestore'] = $this->helper->getStoreName();
            $data['department_id'] = $this->helper->getDepartmentByCategory($data['category_id']);
            // $data['urllogin'] = $this->helper->getStoreUrl('/customer/account/login');

            foreach ($department->getCollection() as $key => $_department) {
                $dataDepartment = $department->load($_department->getDepartmentId())->getData();
                if (in_array($data['category_id'], $dataDepartment['category_id']) && $dataDepartment['is_active'] == 1 && (in_array($data['store_id'], $dataDepartment['store_id']) || in_array(0, $dataDepartment['store_id']))) {
                    $userData = [];
                    $data['email_to'] = [];
                    foreach ($dataDepartment['users'] as $key => $_user) {
                        $user->load($_user, 'user_id');
                        $data['email_to'][] = $user->getEmail();
                    }
                }
            }

            foreach ($this->spam->getCollection()->addFieldToFilter('is_active', 1) as $key => $spam) {

                if ($this->helper->checkSpam($spam, $data)) {
                    $this->messageManager->addError(__('You are spamer'));
                    $this->_redirect('lofhelpdesk/ticket');
                    return;
                }
            }
            $ticketModel->setData($data)->save();
            $this->sender->newTicket($data);
            $this->_redirect($data['url']);
        }
    }

}