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
 * @ticket   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab;

class General extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    /**
     * @var \Lof\HelpDesk\Model\Message
     */
    protected $message;
    /**
     * @var \Lof\HelpDesk\Model\Department
     */
    protected $department;
    /**
     * @var \Lof\HelpDesk\Model\Attachment
     */
    protected $attachment;
    /**
     * @var \Lof\HelpDesk\HelpDesk\Data
     */
    protected $helper;
    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    protected $pageLayoutBuilder;

    protected $authSession;

    protected $userFactory;

    protected $quickanswer;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder
     * @param \Lof\HelpDesk\Model\Message $message
     * @param \Lof\HelpDesk\Model\Category $category
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\Quickanswer $quickanswer
     * @param \Lof\HelpDesk\Model\Department $department
     * @param \Lof\HelpDesk\Model\Attachment $attachment
     * @param \Lof\HelpDesk\Model\TicketFactory $ticket
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param array $data = []
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        \Lof\HelpDesk\Model\Message $message,
        \Lof\HelpDesk\Model\Category $category,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Quickanswer $quickanswer,
        \Lof\HelpDesk\Model\Department $department,
        \Lof\HelpDesk\Model\Attachment $attachment,
        \Lof\HelpDesk\Model\TicketFactory $ticket,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\User\Model\UserFactory $userFactory,
        array $data = []
    )
    {
        $this->ticket = $ticket;
        $this->quickanswer = $quickanswer;
        $this->userFactory = $userFactory;
        $this->attachment = $attachment;
        $this->department = $department;
        $this->authSession = $authSession;
        $this->helper = $helper;
        $this->message = $message;
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_category = $category;
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
        $model = $this->_coreRegistry->registry('lofhelpdesk_ticket');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Lof_HelpDesk::ticket_edit')) {
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

        if ($model->getTicketId()) {
            $message = $this->message->getCollection()->addFieldToFilter('ticket_id', $model->getTicketId());
            foreach ($message as $key => $_message) {
                $_message->setData('is_read', 1)->save();
            }
            $ticket = $this->ticket->create()->load($model->getTicketId())->setData('is_read', 1);
            $ticket->save();
            $fieldset->addField('ticket_id', 'hidden', ['name' => 'ticket_id']);
        }


        $fieldset->addField(
            'customer_id',
            'text',
            ['name' => 'customer_id', 'label' => __('Customer Id'), 'title' => __('Customer Id'), 'required' => true]
        );
        $fieldset->addField(
            'customer_email',
            'text',
            ['name' => 'customer_email', 'label' => __('Customer Email'), 'title' => __('Customer Email'), 'required' => true]
        );
        $fieldset->addField(
            'customer_name',
            'text',
            ['name' => 'customer_name', 'label' => __('Customer Name'), 'title' => __('Customer Name'), 'required' => true]
        );
        $categoryCollection = $this->_category->getCollection();
        $categories = [];
        foreach ($categoryCollection as $k => $v) {
            $categories[] = [
                'label' => $v->getTitle(),
                'value' => $v->getCategoryId()
            ];
        }
        $field = $fieldset->addField(
            'category_id',
            'select',
            [
                'name' => 'category_id',
                'label' => __('Category'),
                'title' => __('Category'),
                'required' => true,
                'values' => $categories,
                'disabled' => $isElementDisabled]
        );
        $orders = $this->helper->getOrder($model->getCustomerEmail());
        $field = $fieldset->addField(
            'order_id',
            'select',
            [
                'name' => 'order_id',
                'label' => __('Order'),
                'title' => __('Order'),
                'values' => $orders,
                'disabled' => $isElementDisabled]
        );

        $products = $this->helper->getProductByOrder($model->getCustomerEmail());
        $field = $fieldset->addField(
            'product_id',
            'multiselect',
            [
                'name' => 'products[]',
                'label' => __('Product'),
                'title' => __('Product'),
                'values' => $products,
                'disabled' => $isElementDisabled
            ]
        );
        $field = $fieldset->addField(
            'qty_requested',
            'text',
            [
                'name' => 'qty_requested',
                'label' => __('QTY Requested'),
                'title' => __('QTY Requested'),
                'disabled' => $isElementDisabled
            ]
        );
        $field = $fieldset->addField(
            'qty_returned',
            'text',
            [
                'name' => 'qty_returned',
                'label' => __('QTY Returned'),
                'title' => __('QTY Returned'),
                'disabled' => $isElementDisabled
            ]
        );
        $department = $this->department->getCollection();
        $departments = [];
        foreach ($department as $k => $v) {
            $departments[] = [
                'label' => $v->getTitle(),
                'value' => $v->getDepartmentId()
            ];
        }


        $field = $fieldset->addField(
            'department_id',
            'select',
            [
                'name' => 'department_id',
                'label' => __('Department'),
                'title' => __('Department'),
                'required' => true,
                'values' => $departments,
                'disabled' => $isElementDisabled
            ]
        );

        $user = $this->authSession->getUser();
        $ticket_user_id = $model?$model->getUserId():$user->getUserId();
        if($model && $ticket_user_id !== $user->getUserId()){
            $newUser = $this->userFactory->create()->load($ticket_user_id);
            $user_name = $newUser->getFirstname() . ' ' . $newUser->getLastname();
            $user_email = $newUser->getEmail();
        }else {
            $user_name = $user->getFirstname() . ' ' . $user->getLastname();
            $user_email = $user->getEmail();
        }
        $fieldset->addField(
            'user_id',
            'hidden',
            ['name' => 'user_id', 'label' => __('User Id'), 'title' => __('User Id'), 'value' => $ticket_user_id]
        );

        $fieldset->addField(
            'user_name',
            'hidden',
            ['name' => 'user_name', 'label' => __('User Name'), 'title' => __('User Name'), 'value' => $user_name]
        );
        $fieldset->addField(
            'user_email',
            'hidden',
            ['name' => 'user_email', 'label' => __('User Email'), 'title' => __('User Email'), 'value' => $user_email]
        );

        // $model->setData('user_id', $ticket_user_id);
        $model->setData('user_name', $user_name);
        $model->setData('user_email', $user_email);

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
