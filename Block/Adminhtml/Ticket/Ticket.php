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

namespace Lof\HelpDesk\Block\Adminhtml;

class Ticket extends \Magento\Backend\Block\Widget\Container
{
    public function _construct()
    {
        $this->_blockGroup = 'Lof_HelpDesk';
        $this->_controller = 'adminhtml_ticket';
        $this->_headerText = __('Tickets');
        $this->_addButtonLabel = __('Add New Ticket');
        parent::_construct();
    }
}
