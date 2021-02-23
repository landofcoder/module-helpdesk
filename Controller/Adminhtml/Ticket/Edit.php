<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
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

class Edit extends \Lof\HelpDesk\Controller\Adminhtml\Ticket
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $authSession;

    protected $permission;

    protected $helper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Lof\HelpDesk\Model\ResourceModel\Permission\CollectionFactory $permission,
        \Lof\HelpDesk\Helper\Data $helper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->helper = $helper;
        $this->permission = $permission;
        $this->authSession = $authSession;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        $id = $this->getRequest()->getParam('ticket_id');
        $user = $this->authSession->getUser();
        $role = $user->getRole();
        $model = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket');

        if ($id) {
            $model->load($id);
            $department_id = $model->getDepartmentId();
            $department = $this->_objectManager->create('Lof\HelpDesk\Model\Department')->load($department_id);
            $permission = $this->_objectManager->create('Lof\HelpDesk\Model\Permission')->load($role->getRoleId(), 'role_id');

            if (is_array($department->getData('user_id'))) {
                if (in_array($user->getUserId(), $department->getData('user_id'))) {
                    return 1;
                } else {
                    if (count($permission->getData())) {
                        if (in_array($department_id, $permission->getData('department_id'))) {
                            return 1;
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                }
            } else {
                return 0;
            }

        } else {
            return $this->_authorization->isAllowed('Lof_HelpDesk::spam_edit');
        }
    }

    /**
     * Edit HelpDesk Form
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('ticket_id');
        $model = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Ticket no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        // 3. Set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in forms
        $this->_coreRegistry->register('lofhelpdesk_ticket', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        // 5. Build edit form
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Ticket') : __('New Ticket'),
            $id ? __('Edit Ticket') : __('New Ticket')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Tickets'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Ticket'));
        return $resultPage;
    }
}
