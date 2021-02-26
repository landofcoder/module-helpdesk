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

namespace Lof\HelpDesk\Controller\Adminhtml\Ticket;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Lof\HelpDesk\Controller\Adminhtml\Ticket
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;

    protected $helper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Helper\Js $jsHelper,
        \Lof\HelpDesk\Helper\Data $helper,
        \Magento\Framework\Filesystem $filesystem
    )
    {
        $this->helper = $helper;
        $this->_fileSystem = $filesystem;
        $this->jsHelper = $jsHelper;
        parent::__construct($context, $coreRegistry);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if data sent
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $data['last_reply_name'] = $data['user_name'];
            $data['reply_cnt'] = 1;
            $sender = $this->_objectManager->create('Lof\HelpDesk\Model\Sender');

            if ($data['message']) {
                $sender->sendEmailTicket($data);
            }
            if ($data['ticket_id']) {
                $model = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket')->load($data['ticket_id']);
                if ($data['status_id'] != $model->getStatusId()) {
                    $data['status'] = $this->helper->getStatus($data['status_id'])->getText();
                    $data['urllogin'] = $this->helper->getStoreUrl('/customer/account/login');
                    $sender->statusTicket($data);
                }
                if ($data['department_id'] != $model->getDepartmentId()) {
                    $sender->assignTicket($data);
                }
            }

            $id = $this->getRequest()->getParam('ticket_id');
            $model = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This ticket no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/helpdesk/';
            $path = $mediaDirectory->getAbsolutePath($mediaFolder);

            // Delete, Upload Image

            $imagePath = $mediaDirectory->getAbsolutePath($model->getImage());
            if (isset($data['attachment']['delete']) && file_exists($imagePath . $mediaFolder)) {
                //unlink($imagePath.$mediaFolder);
                $data['attachment'] = '';
            }
            if (isset($data['attachment']) && is_array($data['attachment'])) {
                unset($data['attachment']);
            }
            if ($image = $this->uploadImage('attachment')) {

                $data['attachment'] = $image['attachment'];
                $data['attachment_name'] = $image['attachment_name'];
            }

            // init model and set data
            $model->setData($data);
            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                $this->messageManager->addSuccess(__('You saved the ticket.'));
                // clear previously saved data from session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                if ($this->getRequest()->getParam("duplicate")) {
                    unset($data['ticket_id']);
                    $data['identifier'] = $data['identifier'] . time();

                    $ticket = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket');
                    $ticket->setData($data);
                    try {
                        $ticket->save();
                        $this->messageManager->addSuccess(__('You duplicated this ticket.'));
                    } catch (\Magento\Framework\Exception\LocalizedException $e) {
                        $this->messageManager->addError($e->getMessage());
                    } catch (\RuntimeException $e) {
                        $this->messageManager->addError($e->getMessage());
                    } catch (\Exception $e) {
                        $this->messageManager->addException($e, __('Something went wrong while duplicating the ticket.'));
                    }
                }


                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['ticket_id' => $model->getId()]);
                }
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // save data in session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                // redirect to edit form
                return $resultRedirect->setPath('*/*/edit', ['ticket_id' => $this->getRequest()->getParam('ticket_id')]);
            }
        }
        return $resultRedirect->setPath('*/*/');
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
