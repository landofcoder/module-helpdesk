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

namespace Lof\HelpDesk\Controller\Adminhtml\Spam;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Lof\HelpDesk\Controller\Adminhtml\Spam
{
    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Helper\Js $jsHelper,
        \Magento\Framework\Filesystem $filesystem
    )
    {
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

        //check format Pattern
        try {
            preg_match($data['pattern'], 'this-is-string-to-check-the-format-pattern');
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Format incorrect pattern. E.g correct format: /special proposal/i'));
            return $resultRedirect->setPath('*/*/edit', ['spam_id' => $this->getRequest()->getParam('spam_id')]);
        }

        if ($data) {
            $id = $this->getRequest()->getParam('spam_id');
            $model = $this->_objectManager->create('Lof\HelpDesk\Model\Spam')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This spam no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            // init model and set data
            $model->setData($data);
            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                $this->messageManager->addSuccess(__('You saved the spam.'));
                // clear previously saved data from session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                if ($this->getRequest()->getParam("duplicate")) {
                    unset($data['spam_id']);

                    $spam = $this->_objectManager->create('Lof\HelpDesk\Model\Spam');
                    $spam->setData($data);
                    try {
                        $spam->save();
                        $this->messageManager->addSuccess(__('You duplicated this spam.'));
                    } catch (\Magento\Framework\Exception\LocalizedException $e) {
                        $this->messageManager->addError($e->getMessage());
                    } catch (\RuntimeException $e) {
                        $this->messageManager->addError($e->getMessage());
                    } catch (\Exception $e) {
                        $this->messageManager->addException($e, __('Something went wrong while duplicating the spam.'));
                    }
                }


                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['spam_id' => $model->getId()]);
                }
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // save data in session
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData($data);
                // redirect to edit form
                return $resultRedirect->setPath('*/*/edit', ['spam_id' => $this->getRequest()->getParam('spam_id')]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
