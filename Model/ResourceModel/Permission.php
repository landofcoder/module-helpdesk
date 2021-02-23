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

namespace Lof\HelpDesk\Model\ResourceModel;

/**
 * CMS block model
 */
class Permission extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lof_helpdesk_permission', 'permission_id');
    }

    /**
     * Process block data before deleting
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Cms\Model\ResourceModel\Page
     */
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $condition = ['permission_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('lof_helpdesk_permission_department'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     * Perform operations after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $oldDepartments = $this->lookupDepartmentIds($object->getId());

        $newDepartments = (array)$object->getDepartments();


        $table = $this->getTable('lof_helpdesk_permission_department');

        $insert = array_diff($newDepartments, $oldDepartments);

        $delete = array_diff($oldDepartments, $newDepartments);

        if ($delete) {
            $where = ['permission_id = ?' => (int)$object->getId(), 'department_id IN (?)' => $delete];
            $this->getConnection()->delete($table, $where);
        }

        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = ['permission_id' => (int)$object->getId(), 'department_id' => (int)$storeId];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }


    /**
     * Perform operations after object load
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId()) {
            $users = $this->lookupDepartmentIds($object->getId());
            $object->setData('department_id', $users);
            $object->setData('departments', $users);
        }

        return parent::_afterLoad($object);
    }

    /**
     * Get category ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupDepartmentIds($id)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('lof_helpdesk_permission_department'),
            'department_id'
        )->where(
            'permission_id = :permission_id'
        );

        $binds = [':permission_id' => (int)$id];

        return $connection->fetchCol($select, $binds);
    }
}
