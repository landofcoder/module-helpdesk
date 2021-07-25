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

    public function getChatId()
    {

        if ($this->isLogin()) {
            $chat = $this->chat->getCollection()->addFieldToFilter('customer_email', $this->getCustomer()->getData('email'));
            if (count($chat) > 0) {
                $chat_id = $chat->getFirstItem()->getData('chat_id');
            } else {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $chatModel = $objectManager->create('Lof\HelpDesk\Model\Chat');

                $chatModel->setCustomerId($this->getCustomerSession()->getCustomerId())->setCustomerName($this->getCustomer()->getData('firstname') . ' ' . $this->getCustomer()->getData('lastname'))->setCustomerEmail($this->getCustomer()->getData('email'));
                $chatModel->save();
                $chat_id = $chatModel->getData('chat_id');
            }
        } else {
            $chat = $this->chat->getCollection()->addFieldToFilter('ip', $this->helper->getIp());
            if (count($chat) > 0) {
                $chat_id = $chat->getFirstItem()->getData('chat_id');
            } else {
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $chatModel = $objectManager->create('Lof\HelpDesk\Model\Chat');
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
    public function getPostActionUrl()
    {
        return $this->_customerUrl->getLoginPostUrl();
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