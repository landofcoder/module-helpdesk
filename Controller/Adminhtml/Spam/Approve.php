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


namespace Lof\Helpdesk\Controller\Adminhtml\Spam;

use Magento\Framework\Controller\ResultFactory;

class Approve extends \Lof\Helpdesk\Controller\Adminhtml\Spam
{
    /**
     *
     */
    public function execute()
    {
        //        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        //        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $ticket = $this->ticketFactory->create()->load($id);
                $ticket->markAsNotSpam();

                $this->messageManager->addSuccess(
                    __('Ticket was successfully moved to the Tickets folder')
                );
                $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()
                    ->getParam('id'),]);
            }
        }
        $this->_redirect('*/*/');
    }
}
