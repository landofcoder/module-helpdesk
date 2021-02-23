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

class Message extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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
     * @var \Lof\HelpDesk\Model\Attachment
     */
    protected $attachment;

    protected $quickanswer;

    protected $like;

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
        \Magento\Framework\View\Model\PageLayout\Config\BuilderInterface $pageLayoutBuilder,
        \Lof\HelpDesk\Model\Message $message,
        \Lof\HelpDesk\Model\Category $category,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Attachment $attachment,
        \Lof\HelpDesk\Model\Department $department,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Lof\HelpDesk\Model\Quickanswer $quickanswer,
        \Lof\HelpDesk\Model\Like $like,
        array $data = []
    )
    {
        $this->like = $like;
        $this->quickanswer = $quickanswer;
        $this->department = $department;
        $this->helper = $helper;
        $this->message = $message;
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_category = $category;
        $this->authSession = $authSession;
        $this->attachment = $attachment;
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
            ['legend' => __('Message Information'), 'class' => 'fieldset-wide']
        );
        if ($model->getTicketId()) {
            $fieldset->addField('ticket_id', 'hidden', ['name' => 'ticket_id']);
        }
        $fieldset->addField(
            'attachment',
            'file',
            ['name' => 'attachment', 'label' => __('Attachment'), 'title' => __('Attachment')]
        );
        $fieldset->addField(
            'message',
            'textarea',
            ['name' => 'message', 'label' => __('Message'), 'title' => __('Message'), 'required' => true,
                //'style' => 'height:10em;',
                'disabled' => $isElementDisabled,
                //'config' => $wysiwygConfig,
                'after_element_html' => $this->getQuickanswer() . ' ' . $this->_getTicketContentAfterHtml($model->getTicketId())
            ]
        );


        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getQuickanswer()
    {
        $data = '';
        $quickanswer = $this->quickanswer->getCollection()->addFieldToFilter('is_active', 1);
        $data .= '<select id="quickanswer">';
        $data .= '<option value="0">Quick Answer</option>';
        foreach ($quickanswer as $key => $_quickanswer) {
            $data .= '<option value=' . $_quickanswer->getQuickanswerId() . '>';
            $data .= $_quickanswer->getTitle();
            $data .= '</option>';
        }
        $data .= '</select>';
        return $data;
    }

    public function getSumLike($id, $customer_id)
    {
        $like = $this->like->getCollection()->addFieldToFilter($id, $customer_id);
        return count($like);
    }

    protected function _getTicketContentAfterHtml($ticket_id)
    {
        if ($ticket_id) {
            $message = $this->message->getCollection()->addFieldToFilter('ticket_id', $ticket_id);
            $data = '';
            $class = '';
            foreach ($message as $key => $_message) {
                if ($_message->getData('user_name')) {
                    $name = $_message->getData('user_name');
                    $class = 'user';
                    $countlike = $this->getSumLike('user_id', $_message->getData('user_id'));
                } else {
                    $name = $_message->getData('customer_name');
                    $class = '';
                    $countlike = $this->getSumLike('customer_id', $_message->getData('customer_id'));
                }
                $data .= '<div class="lof-ticket-history">';
                $data .= '<div class="lof-message">';
                $data .= '<div class="lof-message-header">';
                $data .= '<strong>' . $name . '</strong>';
                $data .= '<span class="minor">' . __('added %1 (%2)', $this->helper->nicetime($_message->getCreatedAt()), $_message->getCreatedAt()) . '</span>';
                $data .= '<span class="like"><i class="fa fa-thumbs-up like_id_' . $_message->getMessageId() . '" aria-hidden="true" data-countlike="' . $countlike . '">' . $countlike . '</i></span>';
                $data .= '</div>';
                $data .= '<div class="lof-message-body ' . $class . '">';
                $data .= $_message->getBody();
                foreach ($this->attachment->getCollection()->addFieldToFilter('message_id', $_message->getMessageId()) as $key => $attachment) {
                    $data .= '<div class="lof-message-attachments">';
                    $data .= '<a href="' . $attachment->getImageUrl() . '">' . $attachment->getName() . '</a>
                                            </div>';
                }

                $data .= '</div>';
                if ($_message->getData('customer_name')) {
                    $data .= '<div class="comment-buttons">';
                    $data .= '<span class="like-button">';
                    $data .= '<a  class="like-comment button tiny" data-customerid="' . $_message->getData('customer_id') . '" data-messageid="' . $_message->getData('message_id') . '">';
                    $data .= '<i class="fa fa-thumbs-up" aria-hidden="true"></i><span>' . __('Like') . '</span>';
                    $data .= '</a>';
                    $data .= '</span>';
                    $data .= '<div class="thank-like message_id_' . $_message->getMessageId() . '">';

                    $data .= '</div>';
                    $data .= '</div>';
                }
                $data .= '</div>';
                $data .= '</div>';
            }

            return $data;
        }

    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Message');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Message');
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