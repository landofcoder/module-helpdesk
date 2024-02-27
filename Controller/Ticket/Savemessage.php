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

namespace Lof\HelpDesk\Controller\Ticket;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;

class Savemessage extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;

    protected $sender;

    protected $helper;

    protected $spam;
    protected $messageFactory;
    protected $departmentFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Lof\HelpDesk\Model\Sender $sender
     * @param \Lof\HelpDesk\Helper\Data $helper
     * @param \Lof\HelpDesk\Model\Spam $spam
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Lof\HelpDesk\Model\MessageFactory $messageFactory
     * @param \Lof\HelpDesk\Model\DepartmentFactory $departmentFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Filesystem $filesystem,
        \Lof\HelpDesk\Model\Sender $sender,
        \Lof\HelpDesk\Helper\Data $helper,
        \Lof\HelpDesk\Model\Spam $spam,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Lof\HelpDesk\Model\MessageFactory $messageFactory,
        \Lof\HelpDesk\Model\DepartmentFactory $departmentFactory
    ) {
        $this->spam = $spam;
        $this->sender = $sender;
        $this->resultPageFactory = $resultPageFactory;
        $this->_fileSystem = $filesystem;
        $this->session = $customerSession;
        $this->helper = $helper;
        $this->messageFactory = $messageFactory;
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $customerSession = $this->session;
        $customerId = $customerSession->getId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data['customer_id'] = $customerId;
            $data['customer_name'] = $customerSession->getCustomer()->getName();
            $data['customer_email'] = $customerSession->getCustomer()->getEmail();
            $data['email'] = $customerSession->getCustomer()->getEmail();
            $data['is_read'] = 0;
            //$data['department_id'] = $helper->getDepartmentByCategory($data['category_id']);
            $messageModel = $this->messageFactory->create();

            foreach ($this->spam->getCollection()->addFieldToFilter('is_active', 1) as $key => $spam) {
                if ($this->helper->checkSpam($spam, $data)) {
                    $this->messageManager->addError(__('You are spamer'));
                    $this->_redirect('lofhelpdesk/ticket/view/id/' . $data['ticket_id']);
                    return;
                }
            }
            $data["body"] = $this->helper->xss_clean($data["body"]);
            $messageModel->setData($data)->save();
            $this->messageManager->addSuccessMessage(__('Message was successfully sent'));
            $department = $this->departmentFactory->create();
            $store = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
            $user = $objectManager->create('\Magento\User\Model\User');
            $ticket = $objectManager->create('Lof\HelpDesk\Model\Ticket')->load($data['ticket_id']);
            $category = $objectManager->get('Lof\HelpDesk\Model\Category')->load($data['category_id'], 'category_id');
            $data['nameticket'] = $ticket->getSubject();
            $data['category'] = $category->getTile();
            $data['store_id'] = $store->getStore()->getId();
            $data['namestore'] = $this->helper->getStoreName();
            $data['urllogin'] = $this->helper->getCustomerLoginUrl();

            foreach ($department->getCollection() as $key => $_department) {
                $dataDepartment = $department->load($_department->getDepartmentId())->getData();

                if (in_array($data['category_id'], $dataDepartment['category_id']) && $dataDepartment['is_active'] == 1 && (in_array($data['store_id'], $dataDepartment['store_id']) || in_array(0, $dataDepartment['store_id']))) {
                    $userData = [];
                    $data['email_to'] = [];
                    foreach ($dataDepartment['users'] as $key => $_user) {
                        $user->load($_user, 'user_id');
                        $data['email_to'][] = $user->getEmail();
                    }
                }
            }

            if ($this->helper->getConfig('email_settings/enable_testmode')) {
                $this->sender->newMessage($data);
            }
            $ticket->setLastReplyName($data['customer_name'])->setUpdatedAt(date('Y-m-d H:i:s'))->setIsRead(0)->save();
            $attachmentModel = $objectManager->get('Lof\HelpDesk\Model\Attachment');

            $attachmentData = [];
            $attachmentData['message_id'] = $messageModel->getId();

            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/helpdesk/';
            $path = $mediaDirectory->getAbsolutePath($mediaFolder);

            // Delete, Upload Image
            $imagePath = $mediaDirectory->getAbsolutePath($mediaFolder);

            // foreach ($data['attachment'] as $key => $attachment) {
            if (isset($data['attachment']['delete']) && file_exists($imagePath)) {
                unlink($imagePath);
                $data['attachment'] = '';
            }
            if (isset($data['attachment']) && is_array($data['attachment'])) {
                unset($data['attachment']);
            }
            if ($image = $this->uploadImage('attachment')) {
                $data['attachment'] = $image['attachment'];
                $data['attachment_name'] = $image['attachment_name'];

                $attachmentData['body'] = $data['attachment'];
                $attachmentData['name'] = $data['attachment_name'];
                $attachmentModel->setData($attachmentData)->save();

            }
        }
        $this->_redirect('lofhelpdesk/ticket/view/ticket_id/' . $data['ticket_id']);

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath("lofhelpdesk/ticket/view/ticket_id/" . $data['ticket_id']);
        //}
    }

    public function uploadImage($fieldId = 'file')
    {

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if (isset($_FILES[$fieldId]) && $_FILES[$fieldId]['name'] != '') {
            $uploader = $this->_objectManager->create(
                'Magento\Framework\File\Uploader',
                ['fileId' => $fieldId]
            );
            $path = $this->_fileSystem->getDirectoryRead(
                DirectoryList::MEDIA
            )->getAbsolutePath(
                'catalog/category/'
            );

            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/helpdesk/';
            try {

                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save($mediaDirectory->getAbsolutePath($mediaFolder)
                );
                $image['attachment'] = $mediaFolder . str_replace(' ', '_', $result['name']);
                $image['attachment_name'] = str_replace(' ', '_', $result['name']);
                return $image;
            } catch (\Exception $e) {

                $this->_logger->critical($e);
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['ticket_id' => $this->getRequest()->getParam('ticket_id')]);
            }
        }
        return;
    }

}
