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

class OtherTicket extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
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

    protected $ticket;

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
        \Lof\HelpDesk\Model\Department $department,
        \Lof\HelpDesk\Model\Ticket $ticket,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
    )
    {
        $this->ticket = $ticket;
        $this->department = $department;
        $this->helper = $helper;
        $this->message = $message;
        $this->pageLayoutBuilder = $pageLayoutBuilder;
        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_category = $category;
        $this->authSession = $authSession;
        parent::__construct($context, $registry, $formFactory, $data);
    }


    /**
     * @return string
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _toHtml()
    {
        $model = $this->_coreRegistry->registry('lofhelpdesk_ticket');

        $ticket = $this->ticket->getCollection()->addFieldToFilter('customer_email', $model->getCustomerEmail());

        $data = '';
        $data .= '<div class="lof_helpdesk_grid" data="lof_helpdesk_grid"';
        $data .= '<div class="admin__data-grid-wrap" data-role="grid-wrapper">';
        $data .= '<table class="data-grid data-grid-draggable" data-role="grid">
                    <thead>
                         <tr>
                            <th data-sort="code" data-direction="asc" class="data-grid-th _sortable not-sort  col-code"><span>ID</span></th>                                                                                   
                            <th data-sort="subject" data-direction="asc" class="data-grid-th _sortable not-sort  col-subject"><span>Subject</span></th>                                            
                            <th data-sort="status_id" data-direction="asc" class="data-grid-th _sortable not-sort  col-status_id"><span>Status</span></th>                                                          
                            <th data-sort="priority_id" data-direction="asc" class="data-grid-th _sortable not-sort  col-priority_id"><span>Priority</span></th>                                                      
                            <th class="data-grid-th  no-link col-action"><span>Action</span></th>                                                                        
                        </tr>
                     </thead>
                <tbody>';
        foreach ($ticket as $key => $_ticket) {
            if ($_ticket->getData('ticket_id') != $model->getTicketId()) {
                $data .= '<tr>';
                $data .= '<td>';
                $data .= $_ticket->getData('ticket_id');
                $data .= '</td>';
                $data .= '<td>';
                $data .= $_ticket->getData('subject');
                $data .= '</td>';

                $data .= '<td>';
                $data .= $this->helper->getStatus($_ticket->getData('status_id'));
                $data .= '</td>';

                $data .= '<td>';
                $data .= $this->helper->getPriority($_ticket->getData('priority_id'));
                $data .= '</td>';

                $data .= '<td>';
                $data .= '<a href="' . $this->getUrl('lofhelpdesk/ticket/edit', ['ticket_id' => $_ticket->getData('ticket_id')]) . '">View</a>';
                $data .= '</td>';
                $data .= '</tr>';
            }
        }

        $data .= '</tbody>
            </table>';
        $data .= '</div>';
        $data .= '</div>';
        return $data;
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