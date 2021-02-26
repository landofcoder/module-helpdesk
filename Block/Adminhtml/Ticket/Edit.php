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

namespace Lof\HelpDesk\Block\Adminhtml\Ticket;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    protected $quickanswer;

    protected $authSession;

    protected $_storeManager;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\HelpDesk\Model\Quickanswer $quickanswer,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_storeManager = $context->getStoreManager();
        $this->quickanswer = $quickanswer;
        $this->authSession = $authSession;
        $this->_coreRegistry = $registry;

    }

    /**
     * Initialize cms page edit block
     *
     * @return void
     */
    protected function _construct()
    {

        $this->_objectId = 'ticket_id';
        $this->_blockGroup = 'Lof_HelpDesk';
        $this->_controller = 'adminhtml_ticket';

        parent::_construct();

        if ($this->_isAllowedAction('Lof_HelpDesk::ticket_save')) {
            $this->buttonList->update('save', 'label', __('Save Ticket'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );

        } else {
            $this->buttonList->remove('save');
        }
        if ($this->_isAllowedAction('Lof_HelpDesk::ticket_delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Ticket'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('lofhelpdesk_ticket')->getId()) {
            return __("View Ticket '%1'", $this->escapeHtml($this->_coreRegistry->registry('lofhelpdesk_ticket')->getTitle()));
        } else {
            return __('New Ticket');
        }
    }

    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */

    protected function _afterToHtml($html)
    {


        return parent::_afterToHtml($html . $this->_getJsInitScripts());
    }

    protected function _getJsInitScripts()
    {
        $data = '';
        $user = $this->authSession->getUser();
        $model = $this->_coreRegistry->registry('lofhelpdesk_ticket');
        $dataModel = $model->getData();

        $quickanswer = $this->quickanswer->getCollection()->addFieldToFilter('is_active', 1);
        $data .= '<script>
            require(["jquery"], function(jQuery){
                jQuery(document).ready(function() {
                    jQuery("#quickanswer").change(function() {';
        foreach ($quickanswer as $key => $_quickanswer) {
            $content = $_quickanswer->getContent();
            $content = str_replace('[ticket_customer_name]', $dataModel['customer_name'], $content);
            $content = str_replace('[ticket_customer_email]', $dataModel['customer_email'], $content);
            $content = str_replace('[ticket_code]', $dataModel['ticket_id'], $content);
            $content = str_replace('[user_firstname]', $user->getFirstname(), $content);
            $content = str_replace('[user_lastname]', $user->getLastname(), $content);
            $content = str_replace('[user_email]', $user->getEmail(), $content);
            $data .= '
                        if(jQuery(this).val() == ' . $_quickanswer->getQuickanswerId() . ') {
                            jQuery("#ticket_message").val("' . $content . '");
                        }
                        ';
        }
        $data .= "});
                    jQuery('.like-button .like-comment').click(function() {
                        var customerid = jQuery(this).data('customerid');
                        var messageid = jQuery(this).data('messageid');
                        var countlike = jQuery(this).closest('.lof-message').find('.fa-thumbs-up').data('countlike');
                        
                        jQuery.ajax({
                            url: '" . $this->getUrl('lofhelpdesk/ticket/like') . "',
                            type: 'post',
                            data: {  messageid: messageid, countlike: countlike, customerid: customerid},
                            dataType: 'json', 
                            success: function(result) {
                                jQuery(result.id).html(result.message);
                                jQuery(result.like_id).html(result.like );
                            }
                        });
                        return false;
                        
                    });
                });
            });
       </script>";

        return $data;

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

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('lofhelpdesk/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '{{tab_id}}']);
    }

    /**
     * Prepare layout
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            };
        ";
        return parent::_prepareLayout();
    }
}
