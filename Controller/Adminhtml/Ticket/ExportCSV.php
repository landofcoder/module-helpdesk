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
namespace Lof\HelpDesk\Controller\Adminhtml\Ticket;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutInterface;

/**
 * Class ExportCSV
 * @package Lof\HelpDesk\Controller\Adminhtml\Ticket
 */
class ExportCSV extends Action
{
    /**
     * @var LayoutInterface
     */
    protected $_layout;
    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $directory;

    /**
     * ExportCSV constructor.
     * @param Context $context
     * @param LayoutInterface $layout
     * @param Filesystem $filesystem
     * @param FileFactory $fileFactory
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Context $context,
        LayoutInterface $layout,
        Filesystem $filesystem,
        FileFactory $fileFactory
    )
    {
        $this->_layout = $layout;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->fileFactory = $fileFactory;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            // init model and delete
            $collection = $this->_objectManager->create('Lof\HelpDesk\Model\Ticket')->getCollection();
            $params = [];
            foreach ($collection as $key => $model) {
                $params[] = $model->getData();
            }
            $name = 'lofhelpdesk';
            $file = 'export/helpdesk/'. $name . '.csv';

            $this->directory->create('export');
            $stream = $this->directory->openFile($file, 'w+');
            $stream->lock();
            $headers = $fields = [];
            $headers = array('ticket_id','subject','content','customer_name','last_reply_name','created_at','updated_at','status_id','priority_id','is_read','qty_requested','qty_returned');
            $stream->writeCsv($headers);
            foreach ($params as $row) {
                $rowData = $fields;
                foreach($row as $v){
                    $rowData['ticket_id'] = $row['ticket_id'];
                    $rowData['subject'] = $row['subject'];
                    $rowData['description'] = $row['description'];
                    $rowData['customer_name'] = $row['customer_name'];
                    $rowData['last_reply_name'] = $row['last_reply_name'];
                    $rowData['created_at'] = $row['created_at'];
                    $rowData['updated_at'] = $row['updated_at'];
                    $rowData['status_id'] = $row['status_id'];
                    $rowData['priority_id'] = $row['priority_id'];
                    $rowData['qty_requested'] = $row['qty_requested'];
                    $rowData['qty_returned'] = $row['qty_returned'];
                }
                $stream->writeCsv($rowData);
            }
            $stream->unlock();
            $stream->close();
            $file = [
                'type' => 'filename',
                'value' => $file,
                'rm' => true  // can delete file after use
            ];
            // display success message
            $this->messageManager->addSuccess(__('You export ticket to csv successfully.'));
            return $this->fileFactory->create($name . '.csv', $file, 'var');

        } catch (\Exception $e) {
            // display error message
            $this->messageManager->addError($e->getMessage());
            // go back to edit form
            return $resultRedirect->setPath('*/*/index');
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a ticket to exportcsv.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

}
