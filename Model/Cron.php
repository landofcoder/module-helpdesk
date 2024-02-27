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

namespace Lof\HelpDesk\Model;

class Cron
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Lof\HelpDesk\Model\Ticket
     */
    protected $helper;

    protected $ticket;

    /**
     * @var \Lof\HelpDesk\Model\Sender
     */
    protected $sender;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;

    /**
     * @var \Lof\HelpDesk\Model\DepartmentFactory
     */
    protected $departmentFactory;

    public function __construct(
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Ticket $ticket,
        \Psr\Log\LoggerInterface $logger,
        \Lof\HelpDesk\Model\Sender $sender,
        \Magento\User\Model\UserFactory $userFactory,
        \Lof\HelpDesk\Model\DepartmentFactory $departmentFactory
    ) {
        $this->ticket = $ticket;
        $this->logger = $logger;
        $this->helper = $helper;
        $this->sender = $sender;
        $this->userFactory = $userFactory;
        $this->departmentFactory = $departmentFactory;
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

    /**
     * close ticket
     */
    public function closeTicket()
    {
        $data_time = time() - ($this->helper->getConfig('automation/auto_close_ticket') * 24 * 60 * 60);
        $time = date(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT, $data_time);
        $ticket = $this->ticket->getCollection()->addFieldToFilter('last_reply_at', ['gteq' => $time]);
        foreach ($ticket as $key => $_ticket) {
            $_ticket->setData('status_id', 0)->save();
        }
    }

    /**
     * auto reminder ticket
     *
     * @return void
     */
    public function autoReminderTicket()
    {
        $data_time = time() - ($this->helper->getConfig('automation/auto_reminder_ticket') * 24 * 60 * 60);
        $time = date(\Magento\Framework\Stdlib\DateTime::DATETIME_PHP_FORMAT, $data_time);
        $ticket = $this->ticket->getCollection()->addFieldToFilter('last_reply_at', ['gteq' => $time])->addFieldToFilter('reply_cnt', 1);

        foreach ($ticket as  $_ticket) {
            if (!$_ticket->getData('department_id')) {
                continue;
            }
            $department = $this->departmentFactory->create()->load((int)$_ticket->getData('department_id'));
            $data = $_ticket->getData();
            $data['email_to'] = [];
            if ($department->getId() && count($department->getData()) > 0) {
                foreach ($department->getData('users') as $key => $_user) {
                    $user = $this->userFactory->create();
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
