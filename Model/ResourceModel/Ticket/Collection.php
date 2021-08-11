<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2017 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Model\ResourceModel\Ticket;

class Collection extends \Lof\HelpDesk\Model\ResourceModel\AbstractReport\Ticketcollection
{
    protected $_date_column_filter = "main_table.created_at";
    protected $_period_type = "";
    protected $_idFieldName = 'ticket_id';
    /**
     * Define model & resource model
     */


    /**
     * Check range for live mode
     *
     * @param unknown_type $range
     * @return Mage_Reports_Model_Resource_Order_Collection
     */


    public function setDateColumnFilter($column_name = '')
    {
        if ($column_name) {
            $this->_date_column_filter = $column_name;
        }
        return $this;
    }

    public function getDateColumnFilter()
    {
        return $this->_date_column_filter;
    }

    /**
     * Set status filter
     *
     * @param string $orderStatus
     * @return Mage_Sales_Model_Resource_Report_Collection_Abstract
     */
    public function addDateFromFilter($from = null)
    {
        $this->_from_date_filter = $from;
        return $this;
    }

    /**
     * Set status filter
     *
     * @param string $orderStatus
     * @return Mage_Sales_Model_Resource_Report_Collection_Abstract
     */
    public function addDateToFilter($to = null)
    {
        $this->_to_date_filter = $to;
        return $this;
    }

    public function applyCustomFilter()
    {
        $this->_applyDateFilter();
        return $this;
    }

    protected function _applyDateFilter()
    {

        // sql theo filter date 
        if ($this->_to_date_filter && $this->_from_date_filter) {

            // kiem tra lai doan convert ngay thang nay ! 

            $dateStart = $this->_localeDate->convertConfigTimeToUtc($this->_from_date_filter, 'Y-m-d 00:00:00');
            $endStart = $this->_localeDate->convertConfigTimeToUtc($this->_to_date_filter, 'Y-m-d 23:59:59');
            $dateRange = ['from' => $dateStart, 'to' => $endStart, 'datetime' => true];

            $this->addFieldToFilter($this->getDateColumnFilter(), $dateRange);
        }


        return $this;
    }
}