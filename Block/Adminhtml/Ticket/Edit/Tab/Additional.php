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
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Adminhtml\Ticket\Edit\Tab;

class Additional extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
     * @var \Lof\HelpDesk\HelpDesk\Data
     */
    protected $helper;
    /**
     * @var \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface
     */
    protected $pageLayoutBuilder;

    protected $authSession;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;

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
     * @param \Lof\HelpDesk\Model\Department $department
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param   array $data = []
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
        \Lof\HelpDesk\Model\Department $department,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\User\Model\UserFactory $userFactory,
        array $data = []
    )
    {
        $this->department = $department;
        $this->helper = $helper;
        $this->message = $message;
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_category = $category;
        $this->authSession = $authSession;
        $this->userFactory = $userFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function getUserList() {
        $model = $this->_coreRegistry->registry('lofhelpdesk_ticket');
        $user_id = $model?$model->getUserId():0;
        $collection = $this->userFactory->create()->getCollection();
        $collection->addFieldToFilter("main_table.is_active", 1);
        if($user_id){
            $collection->addFieldToFilter("main_table.user_id", ["neq" => $user_id]);
        }
        $options = [];
        $options[0] = __("--- Choose an User ---");
        if($collection->count()){
            foreach($collection as $user){
                $options[$user->getUserId()] = $user->getFirstname()." ".$user->getLastname()." <".$user->getEmail().">";
            }
        }
        return $options;
    }
    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        if ($this->_isAllowedAction('Lof_HelpDesk::ticket_edit')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('ticket_');

        $model = $this->_coreRegistry->registry('lofhelpdesk_ticket');

        $fieldset = $form->addFieldset(
            'meta_fieldset',
            ['legend' => __('Additional Information'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField(
            'subject',
            'text',
            ['name' => 'subject', 'label' => __('Subject'), 'title' => __('Subject'), 'required' => true]
        );

//        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId() . time()]);
        if ($model->getDescription()) {
            $fieldset->addField(
                'description',
                'note',
                [
                    'name' => ' description',
                    'label' => __('Description'),
                    'text' => $model->getDescription()
                ]
            );
        } else {
            $fieldset->addField(
                'description',
                'textarea',
                [
                    'name' => ' description',
                    'label' => __('Description'),
                    //'style' => 'height:10em;',
                    'disabled' => $isElementDisabled,
                    //'config' => $wysiwygConfig
                    //'after_element_html' => $this->_getTicketContentAfterHtml($model->getTicketId())
                ]
            );
        }

        $fieldset->addField(
            'store_id',
            'select',
            [
                'name' => 'store_id',
                'label' => __('Store'),
                'title' => __('Store'),
                'readonly' => 'false',
                'disabled' => $isElementDisabled,
                'values' => $this->_systemStore->getStoreValuesForForm(false, true)
            ]
        );

        $user = $this->authSession->getUser();
        $ticket_user_id = $model?$model->getUserId():$user->getUserId();
        if($model && $ticket_user_id !== $user->getUserId()){
            $newUser = $this->userFactory->create()->load($ticket_user_id);
            $user_name = $newUser->getFirstname() . ' ' . $newUser->getLastname();
            $user_email = $newUser->getEmail();
        }else {
            $user_name = $model?$model->getUserName():($user->getFirstname() . ' ' . $user->getLastname());
            $user_email = $model?$model->getUserEmail():$user->getEmail();
        }

        $fieldset->addField(
            'user_id',
            'note',
            ['name' => 'user_id', 'label' => __('User Id'), 'title' => __('User Id'), 'text' => $ticket_user_id]
        );
        $fieldset->addField(
            'user_name',
            'note',
            ['name' => 'user_name', 'label' => __('User Name'), 'title' => __('User Name'), 'text' => $user_name]
        );
        $fieldset->addField(
            'user_email',
            'note',
            ['name' => 'user_email', 'label' => __('User Email'), 'title' => __('User Email'), 'text' => $user_email]
        );

        $fieldset->addField(
            'status_id',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status_id',
                'options' => [
                    '1' => __('Open'),
                    '0' => __('Close'),
                    '2' => __('Processing'),
                    '3' => __('Done')
                ]
            ]
        );

        $fieldset->addField(
            'fp_user_id',
            'select',
            [
                'label' => __('Assign to Other User'),
                'title' => __('Assign to Other User'),
                'name' => 'fp_user_id',
                'options' => $this->getUserList()
            ]
        );

        $fieldset->addField(
            'admin_note',
            'textarea',
            [
                'name' => 'admin_note',
                'label' => __('Admin Note'),
                'title' => __('Admin Note'),
                'note' => __('Admin Note for this ticket.'),
                'required' => false
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }
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
        return __('Additional');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Additional');
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
