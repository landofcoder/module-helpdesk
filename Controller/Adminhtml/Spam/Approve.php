<?php
/**
 * Lof
 *
 * This source file is subject to the Lof Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Lof
 * @package   mirasvit/module-helpdesk
 * @version   1.1.16
 * @copyright Copyright (C) 2016 Lof (https://mirasvit.com/)
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
