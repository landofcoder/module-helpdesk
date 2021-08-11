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
 *
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Adminhtml\Report;

use Lof\HelpDesk\Model\Config;

class Report extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Lof\HelpDesk\Model\Ticket
     */
    protected $_ticket;

    protected $_columnDate = 'main_table.created_at';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Lof\HelpDesk\Model\Ticket $ticketCollection
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Lof\HelpDesk\Model\Ticket $ticketCollection
    )
    {
        $this->_ticket = $ticketCollection;
        parent::__construct($context);
    }

    /**
     * @return Lof\HelpDesk\Model\ResourceModel\Ticket\Collecion
     */
    public function getSumTicket()
    {
        $ticket = $this->_ticket->getCollection();
        return $ticket;
    }

    public function getTicketsReport()
    {
        $data = [];
        $dates = [];
        // for each day in the month
        for ($i = 1; $i <= date('t'); $i++) {
            // add the date to the dates array
            $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        $data[] = [];
        foreach ($dates as $key => $date) {
            $ticket = $this->_ticket->getCollection()->setDateColumnFilter($this->_columnDate)
                ->addDateFromFilter($date, null)->addDateToFilter($date, null);
            $ticket->applyCustomFilter();

            $data[$key]['tickets'] = count($ticket);
            $data[$key]['period'] = substr($date, 5);
        }
        return json_encode($data);
    }

    public function daysInMonth($month)
    {
        return $this->getDaysInMonth($month, date("Y"));
    }

    public function getDaysInMonth($month, $year)
    {
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
    }

    public function getTicketsReportMonth()
    {
        $data = [];
        $dates = [];
        // for each day in the month
        for ($i = 1; $i <= 12; $i++) {
            // add the date to the dates array
            $dates[] = date('Y') . "-" . $i;
        }
        $data[] = [];

        foreach ($dates as $key => $date) {
            $ticket = $this->_ticket->getCollection()->setDateColumnFilter($this->_columnDate)
                ->addDateFromFilter($date, null)->addDateToFilter($date . "-" . $this->daysInMonth($i), null);
            $ticket->applyCustomFilter();
            $data[$key]['tickets'] = count($ticket);
            $data[$key]['period'] = $date;
        }

        return json_encode($data);
    }

    /**
     * @return array
     */
    public function getlistTicket()
    {
        return [
            0 => 'Close',
            1 => 'Open',
            2 => 'Processing',
            3 => 'Done'
        ];
    }

}
