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

namespace Lof\HelpDesk\Controller\Adminhtml\Ticket;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Display Hello on screen
 */
class Like extends \Magento\Framework\App\Action\Action
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

    protected $_likeFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\LikeFactory $likeFactory
     * @param \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\LikeFactory $likeFactory,
        \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helper = $helper;
        $this->_likeFactory = $likeFactory;
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
            $responseData = [];
            $count = $data['countlike'];
            $collection = $this->_likeFactory->create()->getCollection();
            $collection->addFieldToFilter("message_id", (int)$data['messageid']);
            $collection->addFieldToFilter("customer_id", (int)$data['customerid']);
            if ($collection->count() == 0) {
                try {
                    $message = __('Thanks for your like!');
                    $count = $data['countlike'] + 1;
                    $like = $this->_likeFactory->create();
                    $like->setData('customer_id', $data['customerid'])->setData('message_id', $data['messageid'])->save();
                    $this->_cacheTypeList->cleanType('full_page');
                } catch (\Exception $e) {
                    $this->messageManager->addError(
                        __('We can\'t process your request right now. Sorry, that\'s all we know.')
                    );
                    return;
                }
            } else {
                $message = __('Already liked!');
            }
            $responseData['message'] = $message;
            $responseData['like'] = $count;
            $responseData['id'] = '.message_id_' . $data['messageid'];
            $responseData['like_id'] = '.like_id_' . $data['messageid'];
            $this->getResponse()->representJson(
                $this->_objectManager->get('Magento\Framework\Json\Helper\Data')->jsonEncode($responseData)
            );
            return;
        }
    }
}