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

namespace Lof\HelpDesk\Block\Adminhtml\Permission\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    protected $pageLayoutBuilder;
    /**
     * @var \Magento\Authorization\Model\Role
     */
    protected $role;
    /**
     * @var \Lof\HelpDesk\Model\Department
     */
    protected $department;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Store\Model\System\Store $systemStore,
        \Lof\HelpDesk\Model\Category $category,
        \Lof\HelpDesk\Model\Department $department,
        \Magento\User\Model\User $user,
        \Magento\Authorization\Model\Role $role,
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        array $data = []
    )
    {
        $this->department = $department;
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_category = $category;
        $this->_user = $user;
        $this->role = $role;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('lofhelpdesk_permission');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Lof_HelpDesk::permission_edit')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('ticket_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getPermissionId()) {
            $fieldset->addField('permission_id', 'hidden', ['name' => 'permission_id']);
        }
        $roleCollection = $this->role->getCollection();
        $roles = [];

        foreach ($roleCollection as $key => $role) {
            if ($role->getParentId() == 0) {
                $roles[] = [
                    'label' => $role->getRoleName(),
                    'value' => $role->getRoleId()
                ];
            }
        }

        $fieldset->addField(
            'role_id',
            'select',
            ['name' => 'role_id',
                'label' => __('Role'),
                'title' => __('Role'),
                'values' => $roles,
                'disabled' => $isElementDisabled
            ]
        );

        $departmentCollection = $this->department->getCollection();
        $departments = [];
        foreach ($departmentCollection as $key => $department) {
            $departments[] = [
                'label' => $department->getTitle(),
                'value' => $department->getDepartmentId()
            ];
        }
        $field = $fieldset->addField(
            'department_id',
            'multiselect',
            [
                'name' => 'departments[]',
                'label' => __('Access to tickets of departments'),
                'title' => __('Access to tickets of departments'),
                'values' => $departments,
                'disabled' => $isElementDisabled]
        );

        $fieldset->addField(
            'is_ticket_remove_allowed',
            'select',
            [
                'label' => __('Can Delete Tickets'),
                'title' => __('Can Delete Tickets'),
                'name' => 'is_ticket_remove_allowed',
                'options' => $model->getAvailableStatuses(),
                'disabled' => $isElementDisabled
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('General');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('General');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
