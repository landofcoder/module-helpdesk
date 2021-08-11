<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
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
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Model\ResourceModel\Department;

use \Lof\HelpDesk\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'department_id';

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->performAfterLoad('lof_helpdesk_department_store', 'department_id');
        $this->performAfterLoadUser('lof_helpdesk_department_user', 'department_id');
        $this->performAfterLoadCategory('lof_helpdesk_department_category', 'department_id');
        return parent::_afterLoad();
    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Lof\HelpDesk\Model\Department', 'Lof\HelpDesk\Model\ResourceModel\Department');
        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields']['user'] = 'user_table.user_id';
    }

    /**
     * Returns pairs department_id - title
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->_toOptionArray('department_id', 'title');
    }

    /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        $this->performAddStoreFilter($store, $withAdmin);
        return $this;
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $this->joinStoreRelationTable('lof_helpdesk_department_store', 'department_id');
    }
}