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
 *
 * @copyright  Copyright (c) 2017 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Controller\Adminhtml\Chat;

class AddBlacklist extends \Magento\Backend\App\Action
{
    protected $chatFactory;
    protected $blacklistFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Lof\HelpDesk\Model\ChatFactory $chatFactory
     * @param \Lof\HelpDesk\Model\BlacklistFactory $blacklistFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context, 
        \Lof\HelpDesk\Model\ChatFactory $chatFactory,
        \Lof\HelpDesk\Model\BlacklistFactory $blacklistFactory
    )
    {
        $this->chatFactory = $chatFactory;
        $this->blacklistFactory = $blacklistFactory;
        parent::__construct($context);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('chat_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->chatFactory->create();
                $model->load($id);
                $blacklist = $this->blacklistFactory->create();
                $blacklist->addChatToBlacklist($model->getData());
                // display success message
                $this->messageManager->addSuccessMessage(__('You add user to blacklist.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['chat_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Chat to add to black list.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

