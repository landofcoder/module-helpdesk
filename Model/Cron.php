<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
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

namespace Lof\HelpDesk\Model;

use Magento\Cron\Model\Schedule;

class Cron
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    protected $helper;

    protected $ticket;

    public function __construct(
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Ticket $ticket,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->ticket = $ticket;
        $this->logger = $logger;
        $this->helper = $helper;
    }

    /**
     * Clean expired quotes (cron process)
     *
     * @return void
     */
    public function execute()
    {
        $this->closeTicket();
    }

    public function closeTicket()
    {
        $data_time = time() - ($this->helper->getConfig('automation/auto_close_ticket') * 24 * 60 * 60);
        $time = date(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT, $data_time);
        $ticket = $this->ticket->getCollection()->addFieldToFilter('last_reply_at', ['gteq' => $time]);
        foreach ($ticket as $key => $_ticket) {
            $_ticket->setData('status_id', 0)->save();
        }
    }

    public function autoReminderTicket()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $data_time = time() - ($this->helper->getConfig('automation/auto_reminder_ticket') * 24 * 60 * 60);
        $time = date(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT, $data_time);
        $ticket = $this->ticket->getCollection()->addFieldToFilter('last_reply_at', ['gteq' => $time])->addFieldToFilter('reply_cnt', 1);
        $user = $objectManager->create('\Magento\User\Model\User');
        foreach ($ticket as $key => $_ticket) {
            $department = $objectManager->create('Lof\HelpDesk\Model\Department')->load($_ticket->getData('department_id'));
            $data = $_ticket->getData();
            $data['email_to'] = [];
            if (count($department->getData()) > 0) {
                foreach ($department->getData('users') as $key => $_user) {
                    $user->load($_user, 'user_id');
                    $data['email_to'][] = $user->getEmail();
                }
            }
            if (count($data['email_to'])) {
                $this->sender->reminderTicket($data);
            }
        }
    }
}
