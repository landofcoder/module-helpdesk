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

namespace Lof\HelpDesk\Block\Widget;

class Form extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Contact\Helper\Data
     */
    protected $contactHelper;
    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    protected $currentCustomer;

    /**
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $customerSessionFactory;

    /**
     * @var int
     */
    private $_username = -1;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Contact\Helper\Data $contactHelper,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory,
        array $data = []
    )
    {
        $this->currentCustomer = $currentCustomer;
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->contactHelper = $contactHelper;
        $this->customerSessionFactory = $customerSessionFactory;
        parent::__construct($context, $data);
    }

    public function getCustomerId()
    {
        return $this->currentCustomer->getCustomerId();
    }

    public function getCustomerSession(){
        return $this->customerSessionFactory->create();
    }

    public function _toHtml()
    {
        $template = 'Lof_HelpDesk::widget/form.phtml';
        $this->setTemplate($template);
        return parent::_toHtml();
    }

    public function getConfig($key, $default = '')
    {
        if ($this->hasData($key)) {
            return $this->getData($key);
        }
        return $default;
    }

    /**
     * @return $this|bool
     */
    public function getCustomer()
    {
        $customer = $this->customerFactory->create()->load($this->customerSession->getCustomerId());
        if ($customer->getId() > 0) {
            return $customer;
        }

        return false;
    }

    /**
     * Retrieve username for form field
     *
     * @return string
     */
    public function getUsername()
    {
        if (-1 === $this->_username) {
            $this->_username = $this->customerSession->getUsername(true);
        }
        return $this->_username;
    }

    /**
     * @return string
     */
    public function getUserEmail()
    {
        return $this->contactHelper->getUserEmail();
    }

    public function getFormAction()
    {
        return $this->getUrl('lofhelpdesk/customer/saveticket');
    }
}