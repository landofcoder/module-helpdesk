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

namespace Lof\HelpDesk\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Lof\HelpDesk\Controller\Adminhtml\Category
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    protected $jsHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Helper\Js $jsHelper
    )
    {
        $this->_coreRegistry = $coreRegistry;
        $this->jsHelper = $jsHelper;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if data sent
        $data = $this->getRequest()->getPostValue();

        if ($data) {

            $id = $this->getRequest()->getParam('category_id');
            $model = $this->_objectManager->create('Lof\HelpDesk\Model\Category')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This category no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/helpdesk/';
            $path = $mediaDirectory->getAbsolutePath($mediaFolder);
            // Delete, Upload Image
            $imagePath = $mediaDirectory->getAbsolutePath($model->getImage());
            if (isset($data['image']['delete']) && file_exists($imagePath)) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $data['image'] = '';
            }
            if (isset($data['image']) && is_array($data['image'])) {
                unset($data['image']);
            }
            if ($image = $this->uploadImage('image')) {
                $data['image'] = $image;
            }

            $links = $this->getRequest()->getPost('links');
            $links = is_array($links) ? $links : [];
            if (!empty($links) && isset($links['questions'])) {
                $questionProducts = $this->jsHelper->decodeGridSerializedInput($links['questions']);
                $data['questions'] = $questionProducts;
            }

            // init model and set data

            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                $this->messageManager->addSuccess(__('You saved the category.'));
                // clear previously saved data from session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['category_id' => $model->getId()]);
                }
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // save data in session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                // redirect to edit form
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $this->getRequest()->getParam('category_id')]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }

    public function uploadImage($fieldId = 'image')
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if (isset($_FILES[$fieldId]) && $_FILES[$fieldId]['name'] != '') {
            $uploader = $this->_objectManager->create(
                'Magento\Framework\File\Uploader',
                ['fileId' => $fieldId]
            );

            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
            $mediaFolder = 'lof/helpdesk/';
            try {
                $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);
                $result = $uploader->save($mediaDirectory->getAbsolutePath($mediaFolder)
                );
                return $mediaFolder . $result['name'];
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['category_id' => $this->getRequest()->getParam('category_id')]);
            }
        }
        return;
    }
}
