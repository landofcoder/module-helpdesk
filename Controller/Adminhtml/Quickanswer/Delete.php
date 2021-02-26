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
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Controller\Adminhtml\Quickanswer;

class Delete extends \Lof\HelpDesk\Controller\Adminhtml\Quickanswer
{
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Lof_HelpDesk::quickanswer_delete');
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
        $id = $this->getRequest()->getParam('quickanswer_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Lof\HelpDesk\Model\Quickanswer');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the quickanswer.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['quickanswer_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a quickanswer to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
