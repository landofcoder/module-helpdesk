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
 * @department   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Model\ResourceModel;

class Department extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
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
        $this->_init('lof_helpdesk_department', 'department_id');
    }

    /**
     * Process block data before deleting
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Cms\Model\ResourceModel\Page
     */
    protected function _beforeDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $condition = ['department_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('lof_helpdesk_department_store'), $condition);

        $condition = ['department_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('lof_helpdesk_department_category'), $condition);

        $condition = ['department_id = ?' => (int)$object->getId()];
        $this->getConnection()->delete($this->getTable('lof_helpdesk_department_user'), $condition);

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
        $oldStores = $this->lookupStoreIds($object->getId());
        $oldCategories = $this->lookupCategoryIds($object->getId());
        $oldUsers = $this->lookupUserIds($object->getId());

        $newStores = (array)$object->getStores();
        $newCategories = (array)$object->getCategories();
        $newUsers = (array)$object->getUsers();

        $table = $this->getTable('lof_helpdesk_department_store');
        $table1 = $this->getTable('lof_helpdesk_department_category');
        $table2 = $this->getTable('lof_helpdesk_department_user');

        $insert = array_diff($newStores, $oldStores);
        $insert1 = array_diff($newCategories, $oldCategories);
        $insert2 = array_diff($newUsers, $oldUsers);

        $delete = array_diff($oldStores, $newStores);
        $delete1 = array_diff($oldCategories, $newCategories);
        $delete2 = array_diff($oldUsers, $newUsers);

        if ($delete) {
            $where = ['department_id = ?' => (int)$object->getId(), 'store_id IN (?)' => $delete];
            $this->getConnection()->delete($table, $where);
        }
        if ($delete1) {
            $where = ['department_id = ?' => (int)$object->getId(), 'category_id IN (?)' => $delete1];
            $this->getConnection()->delete($table1, $where);
        }
        if ($delete2) {
            $where = ['department_id = ?' => (int)$object->getId(), 'user_id IN (?)' => $delete2];
            $this->getConnection()->delete($table2, $where);
        }
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = ['department_id' => (int)$object->getId(), 'store_id' => (int)$storeId];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }
        if ($insert1) {
            $data = [];
            foreach ($insert1 as $categoryId) {
                $data[] = ['department_id' => (int)$object->getId(), 'category_id' => (int)$categoryId];
            }
            $this->getConnection()->insertMultiple($table1, $data);
        }
        if ($insert2) {
            $data = [];
            foreach ($insert2 as $userId) {
                $data[] = ['department_id' => (int)$object->getId(), 'user_id' => (int)$userId];
            }
            $this->getConnection()->insertMultiple($table2, $data);
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
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
            $object->setData('stores', $stores);
            $categories = $this->lookupCategoryIds($object->getId());
            $object->setData('category_id', $categories);
            $object->setData('categories', $categories);
            $users = $this->lookupUserIds($object->getId());
            $object->setData('user_id', $users);
            $object->setData('users', $users);
        }

        // if ($id = $object->getId()) {
        //     $connection = $this->getConnection();
        //     $select = $connection->select()
        //     ->from($this->getTable('lof_helpdesk_department_category'))
        //     ->where(
        //         'department_id = '.(int)$id
        //         );
        //     $products = $connection->fetchAll($select);
        //     $object->setData('categories', $products);
        // } 

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param \Lof\HelpDesk\Model\Question $object
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $stores = [(int)$object->getStoreId(), \Magento\Store\Model\Store::DEFAULT_STORE_ID];

            $select->join(
                ['cbs' => $this->getTable('lof_helpdesk_department_store')],
                $this->getMainTable() . '.department_id = cbs.department_id',
                ['store_id']
            )->where(
                'is_active = ?',
                1
            )->where(
                'cbs.store_id in (?)',
                $stores
            )->order(
                'store_id DESC'
            )->limit(
                1
            );
        }


        return $select;
    }

    /**
     * Check for unique of identifier of block to selected store(s).
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return bool
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getIsUniqueBlockToStores(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($this->_storeManager->hasSingleStore()) {
            $stores = [\Magento\Store\Model\Store::DEFAULT_STORE_ID];
        } else {
            $stores = (array)$object->getData('stores');
        }

        $select = $this->getConnection()->select()->from(
            ['cb' => $this->getMainTable()]
        )->join(
            ['cbs' => $this->getTable('lof_helpdesk_department_store')],
            'cb.department_id = cbs.department_id',
            []
        )->where(
            'cbs.store_id IN (?)',
            $stores
        );

        if ($object->getId()) {
            $select->where('cb.department_id <> ?', $object->getId());
        }

        if ($this->getConnection()->fetchRow($select)) {
            return false;
        }

        return true;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('lof_helpdesk_department_store'),
            'store_id'
        )->where(
            'department_id = :department_id'
        );

        $binds = [':department_id' => (int)$id];

        return $connection->fetchCol($select, $binds);
    }

    /**
     * Get category ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupCategoryIds($id)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('lof_helpdesk_department_category'),
            'category_id'
        )->where(
            'department_id = :department_id'
        );

        $binds = [':department_id' => (int)$id];

        return $connection->fetchCol($select, $binds);
    }

    /**
     * Get category ids to which specified item is assigned
     *
     * @param int $id
     * @return array
     */
    public function lookupUserIds($id)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('lof_helpdesk_department_user'),
            'user_id'
        )->where(
            'department_id = :department_id'
        );

        $binds = [':department_id' => (int)$id];

        return $connection->fetchCol($select, $binds);
    }

    /**
     * Perform operations before object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        // if (!$this->getIsUniqueBlockToStores($object)) {
        //     throw new \Magento\Framework\Exception\LocalizedException(
        //         __('A department identifier with the same properties already exists in the selected store.')
        //         );
        // }
        return $this;
    }
}
