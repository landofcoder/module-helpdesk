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

namespace Lof\HelpDesk\Controller\Adminhtml\Ticket;

use Lof\HelpDesk\Model\ResourceModel\Ticket\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 */
class MassDelete extends \Magento\Backend\App\Action
{
    protected $authSession;
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->authSession = $authSession;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $model) {
            $model->delete();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        $user = $this->authSession->getUser();
        $role = $user->getRole();
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $model) {
            $category = $model->getCategoryId();
            $store = $model->getStoreId();
            $department_id = $model->getDepartmentId();
            $department = $this->_objectManager->create('Lof\HelpDesk\Model\Department')->load($department_id);
            $permission = $this->_objectManager->create('Lof\HelpDesk\Model\Permission')->load($role->getRoleId(), 'role_id');
            if ($department->getData('user_id')) {
                if (in_array($user->getUserId(), $department->getData('user_id'))) {
                    return 1;
                } else {
                    if (count($permission->getData())) {
                        if (in_array($department_id, $permission->getData('department_id')) && $permission->getData('ticket_is_ticket_remove_allowed')) {
                            return 1;
                        } else {
                            return 0;
                        }
                    } else {
                        return 0;
                    }
                }

            }
        }
    }
}
