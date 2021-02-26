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

namespace Lof\HelpDesk\Model\ResourceModel;

/**
 * CMS block model
 */
class Ticket extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

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
        \Magento\Backend\Model\Auth\Session $authSession,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
        $this->_storeManager = $storeManager;
        $this->authSession = $authSession;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('lof_helpdesk_ticket', 'ticket_id');
    }

    /**
     * Perform operations after object save
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $insert = $delete = '';
        $oldProducts = $this->lookupProductIds($object->getId());
        $newProducts = (array)$object->getProducts();
        $table = $this->getTable('lof_helpdesk_ticket_product');
        $insert = array_diff($newProducts, $oldProducts);

        $delete = array_diff($oldProducts, $newProducts);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        if ($delete) {
            $where = ['product_id = ?' => $delete, 'ticket_id IN (?)' => (int)$object->getId()];
            $this->getConnection()->delete($table, $where);
        }
        if ($insert) {
            $data = [];
            foreach ($insert as $productId) {
                $data[] = [
                    'ticket_id' => (int)$object->getId(),
                    'product_id' => (int)$productId];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }


        $table = $this->getTable('lof_helpdesk_message');
        if ($object->getDescription() && isset($object->getData()['email_to'])) {

            $data_message = [];
            $data_message = [
                'ticket_id' => (int)$object->getId(),
                'body' => $object->getDescription(),
                'customer_id' => $object->getCustomerId(),
                'customer_email' => $object->getCustomerEmail(),
                'customer_name' => $object->getCustomerName()
            ];

            $messageModel = $objectManager->get('Lof\HelpDesk\Model\Message');
            $attachmentModel = $objectManager->get('Lof\HelpDesk\Model\Attachment');

            $messageModel->setData($data_message)->save();
            $attachmentData = [];
            $attachmentData['message_id'] = $messageModel->getId();
            $attachmentData['body'] = $object->getAttachment();
            $attachmentData['name'] = $object->getAttachmentName();
            $attachmentModel->setData($attachmentData)->save();
        }

        if ($object->getMessage()) {

            $user = $this->authSession->getUser();
            $data_message = [];
            $data_message = [
                'ticket_id' => (int)$object->getId(),
                'body' => $object->getMessage(),
                'user_id' => $user->getId(),
                'customer_id' => $object->getCustomerId(),
                'user_name' => $user->getFirstname() . ' ' . $user->getLastname(),
            ];

            $messageModel = $objectManager->get('Lof\HelpDesk\Model\Message');
            $attachmentModel = $objectManager->get('Lof\HelpDesk\Model\Attachment');

            $messageModel->setData($data_message)->save();
            $attachmentData = [];
            $attachmentData['message_id'] = $messageModel->getId();
            $attachmentData['body'] = $object->getAttachment();
            $attachmentData['name'] = $object->getAttachmentName();
            $attachmentModel->setData($attachmentData)->save();
        }
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
            $products = $this->lookupProductIds($object->getId());
            $object->setData('product_id', $products);
            $object->setData('products', $products);
            $object->setData('status',$this->getStatus($object->getStatusId()));
            if($this->lookupDepartment($object->getDepartmentId()) && isset($this->lookupDepartment($object->getDepartmentId())['0'])) {
                $object->setData('department', $this->lookupDepartment($object->getDepartmentId())['0']);
            }
        }
        return parent::_afterLoad($object);
    }

    /**
     * @param $status_id
     * @return \Magento\Framework\Phrase|string
     */
    protected function getStatus($status_id){
        $data = '';
        if ($status_id == 0) {
            $data = 'Close';
        } elseif ($status_id == 1) {
            $data = 'Open';
        } elseif ($status_id == 2) {
            $data = 'Processing';
        } elseif ($status_id == 3) {
            $data = 'Done';
        }
        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function lookupDepartment($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('lof_helpdesk_department'),
            'title'
        )->where(
            'department_id = :department_id'
        );
        $binds = [':department_id' => (int)$id];
        return $connection->fetchCol($select, $binds);
    }

    /**
     * @param $id
     * @return array
     */
    public function lookupProductIds($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            $this->getTable('lof_helpdesk_ticket_product'),
            'product_id'
        )->where(
            'ticket_id = :ticket_id'
        );
        $binds = [':ticket_id' => (int)$id];
        return $connection->fetchCol($select, $binds);
    }

}
