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

namespace Lof\HelpDesk\Controller\Adminhtml\Chat;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Display Hello on screen
 */
class Sendmsg extends \Magento\Framework\App\Action\Action
{
    protected $_cacheTypeList;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_response;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;

    /**
     * @var \Lof\HelpDesk\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Lof\HelpDesk\Model\ChatMessageFactory
     */
    protected $_messageFactory;

    /**
     * @var \Lof\HelpDesk\Model\ChatFactory
     */
    protected $chatFactory;

    /**
     * @param Context $context
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\ChatMessageFactory $messageFactory
     * @param \Lof\HelpDesk\Model\ChatFactory $chatFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\ChatMessageFactory $messageFactory,
        \Lof\HelpDesk\Model\ChatFactory $chatFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $helper;
        $this->_messageFactory = $messageFactory;
        $this->_chatFactory = $chatFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry = $registry;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_customerSession = $customerSession;
        $this->_request = $context->getRequest();
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $data = $this->_request->getPostValue();
        if (!empty($data)) {
            $data['is_read'] =1;
            $data['current_time'] = $this->_helper->getCurrentTime();
            if($customer_email = $this->_customerSession->getCustomer()->getEmail()) {
                $customer_id = $this->_customerSession->getCustomerId();
                if(!isset($data["customer_id"]) || (empty($data["customer_id"]))){
                    $data["customer_id"] = (int)$customer_id;
                }
                if(!isset($data["customer_email"]) || ($data["customer_email"] != $customer_email)){
                    $data["customer_email"] = $customer_email;
                }
                if(!isset($data["customer_name"]) || (empty($data["customer_name"]))){
                    $data["customer_name"] =  $this->_customerSession->getCustomer()->getData("firstname").' '. $this->_customerSession->getCustomer()->getData("lastname");
                }
            }
            if(empty($data['customer_name'])) {
                $data['customer_name'] = __('Guest');
            }
            $data = $this->_helper->xss_clean_array($data);
            $responseData = [];
            $message = $this->_messageFactory->create();

            if(!empty($data) && !empty($data['body_msg'])){
                try {
                    $client_ip = $this->remoteAddress->getRemoteAddress();
                    $data['chat_id'] = isset($data['chat_id'])?$data['chat_id']:null;
                    $message->setData($data)->save();
                    $chat = $this->_chatFactory->create()->load($data['chat_id']);
                    $enable_auto_assign_user = $this->_helper->getConfig('automation/enable_auto_assign_user');
                    $admin_user_id = $this->_helper->getConfig('automation/admin_user_id');
                    if($enable_auto_assign_user && $admin_user_id){
                        $data["user_id"] = (int)$admin_user_id;
                    }else {
                        $data["user_id"] = 0;
                    }
                    $number_message = $chat->getData('number_message') + 1;
                    $chat
                        ->setData('user_id', (int)$data["user_id"])
                        ->setData('is_read',3)
                        ->setData('answered',1)
                        ->setData('status',1)
                        ->setData('number_message',$number_message)
                        ->setData('current_url',$data['current_url'])
                        ->setData('ip', $this->_helper->getIp())
                        ->save();
                    $this->_cacheTypeList->cleanType('full_page');
                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                    $this->messageManager->addError($e->getMessage());
                    return;
                }
            }
            return;
        }
    }
}