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

namespace Lof\HelpDesk\Controller\Ticket;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class View extends \Magento\Framework\App\Action\Action
{
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
    protected $_helpdeskHelper;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;

    protected $resultPageFactory;

    /**
     * @param Context
     * @param \Magento\Store\Model\StoreManager
     * @param \Magento\Framework\View\Result\PageFactory
     * @param \Lof\HelpDesk\Helper\Data
     * @param \Magento\Framework\Controller\Result\ForwardFactory
     * @param \Magento\Framework\Registry
     */
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Helper\Data $helpdeskHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helpdeskHelper = $helpdeskHelper;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->_coreRegistry = $registry;
        $this->session = $customerSession;
        parent::__construct($context);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $customerSession = $this->session;
        $page = $this->resultPageFactory->create();
        if ($customerSession->isLoggedIn()) {
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        } else {
            $this->_redirect('customer/account/login');
        }
        // return $page;
    }
}
