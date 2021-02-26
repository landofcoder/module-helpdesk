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
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Controller\Adminhtml\Spam;

use Magento\Framework\Controller\ResultFactory;

class MassApprove extends \Lof\HelpDesk\Controller\Adminhtml\Spam
{
    /**
     *
     */
    public function execute()
    {
        //        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        //        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $ids = $this->getRequest()->getParam('spam_id');
        if (!is_array($ids)) {
            $this->messageManager->addError(__('Please select spam(s)'));
        } else {
            try {
                foreach ($ids as $id) {
                    $ticket = $this->ticketFactory->create()->load($id);
                    $ticket->markAsNotSpam();
                }
                $this->messageManager->addSuccess(
                    __(
                        'Total of %1 record(s) were successfully moved to the Tickets folder',
                        count($ids)
                    )
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}
