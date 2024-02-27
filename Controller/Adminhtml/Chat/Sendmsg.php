<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @chat   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Controller\Adminhtml\Chat;

use Magento\Framework\App\Action\Context;

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

    protected $_message;

    protected $sender;

    protected $_chatModelFactory;

    protected $authSession;

    protected $resultPageFactory;
    protected $_coreRegistry;
    protected $_customerSession;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\ChatMessage $message,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Lof\HelpDesk\Model\Sender $sender,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\HelpDesk\Model\ChatFactory $chatModelFactory,
        \Magento\Backend\Model\Auth\Session $authSession
        ) {
        $this->resultPageFactory    = $resultPageFactory;
        $this->_helper              = $helper;
        $this->_message             = $message;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry        = $registry;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_customerSession     = $customerSession;
        $this->_request             = $context->getRequest();
        $this->sender = $sender;
        $this->_chatModelFactory = $chatModelFactory;
        $this->authSession  = $authSession;
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
        $data['current_time'] = $this->_helper->getCurrentTime();
        $data = $this->_helper->xss_clean_array($data);
        if(!empty($data)){
            $responseData = [];
            $message = $this->_message;

            try{
                $user_id = $this->getUser()->getData('user_id');
                $user_name = $this->getUser()->getData('firstname').' '.$this->getUser()->getData('lastname');
                if(!isset($data['user_name']) || ($data['user_name'] != $user_name)){
                    $data['user_name'] = $user_name;
                }
                if(!isset($data['user_id']) || ($data['user_id'] != $user_id)){
                    $data['user_id'] = $user_id;
                }
                $message->setData($data)->save();
                $chat = $this->_chatModelFactory->create()->load($data['chat_id']);
                $number_message = $chat->getData('number_message') + 1;
                $chat
                    ->setUserName($data['user_name'])
                    ->setData("user_id", (int)$data['user_id'])
                    ->setData('is_read',3)
                    ->setData('answered',0)
                    ->setData('number_message',$number_message)
                    ->save();
                //$this->_cacheTypeList->cleanType('full_page');
                if($data['customer_name'] && $this->_helper->getConfig('email_settings/enable_email_customer_chat')) {
                    $data['url'] = $this->_helper->getUrl();
                    $this->sender->sendAdminChat($data);
                }
            }catch(\Exception $e){
                $this->messageManager->addError(
                    __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                return;
            }
        }
    }
    protected function getUser() {
        $user = $this->authSession->getUser();
        return $user;
    }
}
