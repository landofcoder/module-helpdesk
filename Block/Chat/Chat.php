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
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Chat;

class Chat extends \Magento\Framework\View\Element\Template
{
    /**
     *
     * @var int
     */
    private $_username = -1;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $_customerSession;

    /**
     *
     * @var Lof\HelpDesk\Model\CategoryFactory
     */
    protected $category;
    /**
     *
     * @var \Lof\HelpDesk\Model\ChatFactory
     */
    protected $chatFactory;
    /**
     *
     * @var \Lof\HelpDesk\Helper\Data
     */
    protected $helper;
    /**
     *
     * @var \Magento\Customer\Model\Url
     */
    protected $_customerUrl;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Lof\HelpDesk\Model\Category $category
     * @param \Lof\HelpDesk\Helper\Url $customerUrl
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\ChatFactory $chatFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\HelpDesk\Model\Category $category,
        \Lof\HelpDesk\Helper\Url $customerUrl,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\ChatFactory $chatFactory,
        array $data = []
    )
    {
        $this->helper = $helper;
        $this->chatFactory = $chatFactory;
        $this->_customerSession = $customerSession;
        $this->category = $category;
        $this->_customerUrl = $customerUrl;
        parent::__construct($context, $data);
    }

    public function isLogin()
    {
        if ($this->_customerSession->isLoggedIn()) {
            return true;
        }
        return false;
    }

    public function getChatModel(){
        return $this->chatFactory->create();
    }

    public function _toHtml()
	{
        $module_enable = $this->helper->getConfig("general_settings/enable");
        $enable_chat = $this->helper->getConfig("chat/enable");
        $enable_guest = $this->helper->getConfig("chat/enable_guest");
        if(!$enable_guest && !$this->isLogin()){
            $enable_chat = false;
        }
        if($module_enable && $enable_chat){
            return parent::_toHtml();
        }
        return;
    }

    public function getChatId()
    {
        if ($this->isLogin()) {
            $chat = $this->getChatModel()->getCollection()->addFieldToFilter('customer_id', $this->getCustomerSession()->getCustomerId());
            if ($chat->count() > 0) {
                $chat_id = $chat->getFirstItem()->getData('chat_id');
            } else {
                $chatModel = $this->getChatModel();
                $chatModel
                    ->setCustomerId($this->getCustomerSession()->getCustomerId())
                    ->setCustomerName($this->getCustomer()->getData('firstname').' '.$this->getCustomer()->getData('lastname'))
                    ->setCustomerEmail($this->getCustomer()->getData('email'));
                $chatModel->save();
                $chat_id = $chatModel->getData('chat_id');
            }
        } else {
            $chat = $this->getChatModel()
                                ->getCollection()
                                ->addFieldToFilter('ip', $this->helper->getIp())
                                ->addFieldToFilter('customer_id',
                                [
                                    ['null' => true],
                                    ['eq' => 0],
                                    ['eq' => '']
                                ]);
            if ($chat->count() > 0) {
                $chat_id = $chat->getFirstItem()->getData('chat_id');
            } else {
                $chatModel = $this->getChatModel();
                $chatModel->setIp($this->helper->getIp());
                $chatModel->save();
                $chat_id = $chatModel->getData('chat_id');
            }
        }
        return $chat_id;
    }

    public function getCurrentUrl()
    {
        return $this->_urlBuilder->getCurrentUrl();
    }

    public function getCategory()
    {
        return $this->category->getCollection();
    }

    public function getCustomerSession()
    {
        return $this->_customerSession;
    }

    public function getCustomer()
    {
        return $this->getCustomerSession()->getCustomer();
    }

    /**
     * Retrieve form posting url
     *
     * @return string
     */
    public function getPostActionUrl() {
        $post_action_url = $this->_customerUrl->getLoginPostUrl ();
        return $post_action_url;
    }

    /**
     * Retrieve password forgotten url
     *
     * @return string
     */
    public function getForgotPasswordUrl()
    {
        return $this->_customerUrl->getForgotPasswordUrl();
    }


    public function getRegisterUrl()
    {
        return $this->_customerUrl->getRegisterUrl();
    }

    /**
     * Retrieve username for form field
     *
     * @return string
     */
    public function getUsername()
    {
        if (-1 === $this->_username) {
            $this->_username = $this->_customerSession->getUsername(true);
        }
        return $this->_username;
    }

    /**
     * Check if autocomplete is disabled on storefront
     *
     * @return bool
     */
    public function isAutocompleteDisabled()
    {
        return ( bool )!$this->_scopeConfig->getValue(\Magento\Customer\Model\Form::XML_PATH_ENABLE_AUTOCOMPLETE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}