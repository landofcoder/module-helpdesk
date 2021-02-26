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

namespace Lof\HelpDesk\Controller\Adminhtml\Ticket;

class Delete extends \Lof\HelpDesk\Controller\Adminhtml\Ticket
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $authSession;

    protected $permission;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Lof\HelpDesk\Model\ResourceModel\Permission\CollectionFactory $permission,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->permission = $permission;
        $this->authSession = $authSession;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    protected function _isAllowed()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $user = $this->authSession->getUser();
        $role = $user->getRole();
        $model = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket');

        if ($id) {
            $model->load($id);

            $category = $model->getCategoryId();
            $store = $model->getStoreId();
            $department = $this->_objectManager->create('Lof\HelpDesk\Model\Department');
            $permission = $this->_objectManager->create('Lof\HelpDesk\Model\Permission')->load($role->getRoleId(), 'role_id');
            foreach ($department->getCollection() as $key => $_department) {
                $data = $department->load($_department->getDepartmentId())->getData();
                if (in_array($category, $data['category_id']) && $data['is_active'] == 1 && (in_array($store, $data['store_id']) || in_array(0, $data['store_id']))) {

                    foreach ($permission->getCollection() as $key => $_permission) {

                        if (is_array($_permission->getDepartmentId())) {
                            if (in_array($_department->getDepartmentId(), $_permission->getDepartmentId()) && $_permission->getData('is_ticket_remove_allowed')) {
                                return 1;
                            } else {
                                return 0;
                            }
                        }

                    }

                    return 1;
                } else {
                    return 0;
                }
            }
        }

        return $this->_authorization->isAllowed('Lof_HelpDesk::ticket_delete');
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
        $id = $this->getRequest()->getParam('ticket_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the ticket.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['ticket_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a ticket to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
