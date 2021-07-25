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
namespace Lof\HelpDesk\Controller\Chat;

use Magento\Framework\App\Action\Context;

/**
 * Display Hello on screen
 */
class Msglog extends \Magento\Framework\App\Action\Action
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
    protected $helper;

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
    protected $_chatFactory;

    protected $httpRequest;

    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress
     */
    protected $remoteAddress;

    /**
     * @var \Lof\HelpDesk\Model\BlacklistFactory
     */
    protected $blacklistFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\ChatMessageFactory $messageFactory
     * @param \Lof\HelpDesk\Model\ChatFactory $chatFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress
     * @param \Lof\HelpDesk\Model\BlacklistFactory $blacklistFactory         
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\ChatMessageFactory $messageFactory,
        \Lof\HelpDesk\Model\ChatFactory $chatFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, 
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress,
        \Lof\HelpDesk\Model\BlacklistFactory $blacklistFactory
        ) {
        $this->_chatFactory                 = $chatFactory;
        $this->resultPageFactory    = $resultPageFactory;
        $this->helper              = $helper;
        $this->_messageFactory             = $messageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry        = $registry;
        $this->_cacheTypeList       = $cacheTypeList;
        $this->_customerSession     = $customerSession;
        $this->_request             = $context->getRequest();
        $this->remoteAddress        = $remoteAddress;
        $this->blacklistFactory     = $blacklistFactory;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $enable_blacklist = $this->helper->getConfig('chat/enable_blacklist');
        $enabled = $this->helper->getConfig('chat/enable');
        $enable_guest = $this->helper->getConfig('chat/enable_guest');
        if(!$enabled){
            exit;
            return;
        }
        //check if enabled config blacklist, then check if ip in blacklist, then redirect it to home, else continue action
        if ($enable_blacklist) {
            $client_ip = $this->remoteAddress->getRemoteAddress();
            $blacklist_model = $this->blacklistFactory->create(); 
            if ($client_ip) {
                $blacklist_model->loadByIp($client_ip);
                if ((0 < $blacklist_model->getId()) && $blacklist_model->getStatus()) {
                    echo __('Your IP was blocked in our blacklist. So, you will not get any messages.');
                    exit;
                }
            }
            if($customer_email = $this->_customerSession->getCustomer()->getEmail()) {
                $customer_id = $this->_customerSession->getCustomerId();
                $blacklist_model->loadByCustomerId((int)$customer_id);
                if ((0 < $blacklist_model->getId()) && $blacklist_model->getStatus()) {
                    echo __('Your Account was blocked in our blacklist. So, you will not get any messages.');
                    exit;
                }
                $blacklist_model2 = $this->blacklistFactory->create();
                $blacklist_model2->loadByEmail($customer_email);
                if ((0 < $blacklist_model2->getId()) && $blacklist_model2->getStatus()) {
                    echo __('Your Email Address was blocked in our blacklist. So, you will not get any messages.');
                    exit;
                }
            }
        }
        $message = null;
        if($this->_customerSession->getCustomer()->getEmail()) {
            $message = $this->_messageFactory->create()
            ->getCollection()
            ->addFieldToFilter('customer_id',$this->_customerSession->getCustomerId());
        } elseif($enable_guest) {
            $chatCollection = $this->_chatFactory->create()->getCollection()
                                ->addFieldToFilter('ip', $this->helper->getIp())
                                ->addFieldToFilter('customer_id',
                                [
                                    ['null' => true],
                                    ['eq' => 0],
                                    ['eq' => '']
                                ]);
            if ($chatCollection->count() > 0) {
                $chat_id = $chatCollection->getFirstItem()->getData('chat_id');
                $message = $this->_messageFactory->create()
                            ->getCollection()
                            ->addFieldToFilter('chat_id',$chat_id)
                            ->addFieldToFilter('customer_id', 
                            [
                                ['null' => true],
                                ['eq' => 0],
                                ['eq' => '']
                            ]);
            }
        }
        if(!$message){
            exit;
            return;
        }
        $count = $message->count();
        $i=0;
        $auto_user_name = $this->helper->getConfig('chat/auto_user_name');
        $auto_message = $this->helper->getConfig('chat/auto_message');
        $welcome_message = $this->helper->getConfig('chat/welcome_message');
        $auto_user_name = $auto_user_name?$auto_user_name:__("Bot");
        $auto_message = trim($auto_message);
        $welcome_message = trim($welcome_message);
        $count_found_user_replied = 0;
        foreach ($message as $_message1) {
            if($_message1->getUserId()){
                $count_found_user_replied++;
                continue;
            }
        }
        foreach ($message as $key => $_message) {
            $i++;
            $date_sent = $_message->getCreatedAt();
            $day_sent = substr($date_sent, 8, 2); 
            $month_sent = substr($date_sent, 5, 2); 
            $year_sent = substr($date_sent, 0, 4); 
            $hour_sent = substr($date_sent, 11, 2); 
            $min_sent = substr($date_sent, 14, 2); 
            $body_msg = $this->helper->xss_clean($_message['body_msg']);
            
            if (!$_message['user_id'])
            {
                echo '<div class="msg-user">
                        <p>'.$body_msg.'</p>
                        <div class="info-msg-user">
                            '.__("You").'
                        </div>
                    </div> ';

            } else {
                echo '<div class="msg">
                    <p>'.$body_msg.'</p>
                    <div class="info-msg">
                        '.$_message['user_name'].'
                    </div>
                </div>';
                if($count == $i) {
                    echo "
                    <script>require(['jquery'],function($) { $('.chat-message-counter').css('display','inline'); });</script>
                    ";
                }
            }

            if($i == 1 && !$count_found_user_replied && $auto_message){
                echo '<div class="msg">
                    <p>'.$auto_message.'</p>
                    <div class="info-msg">
                        '.$auto_user_name.'
                    </div>
                </div>';
            }
        }
        if(!$count && $welcome_message) {
            echo '<div class="msg">
                    <p>'.$welcome_message.'</p>
                    <div class="info-msg">
                        '.$auto_user_name.'
                    </div>
                </div>';
        }
        exit;
    }
}