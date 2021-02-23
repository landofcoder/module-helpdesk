<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\AttachmentRepositoryInterface;
use Lof\HelpDesk\Api\Data\AttachmentInterfaceFactory;
use Lof\HelpDesk\Api\Data\AttachmentSearchResultsInterfaceFactory;
use Lof\HelpDesk\Model\ResourceModel\Attachment as ResourceAttachment;
use Lof\HelpDesk\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class AttachmentRepository implements AttachmentRepositoryInterface
{

    protected $attachmentFactory;

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $dataAttachmentFactory;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $attachmentCollectionFactory;

    protected $dataObjectHelper;


    /**
     * @param ResourceAttachment $resource
     * @param AttachmentFactory $attachmentFactory
     * @param AttachmentInterfaceFactory $dataAttachmentFactory
     * @param AttachmentCollectionFactory $attachmentCollectionFactory
     * @param AttachmentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceAttachment $resource,
        AttachmentFactory $attachmentFactory,
        AttachmentInterfaceFactory $dataAttachmentFactory,
        AttachmentCollectionFactory $attachmentCollectionFactory,
        AttachmentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->attachmentFactory = $attachmentFactory;
        $this->attachmentCollectionFactory = $attachmentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAttachmentFactory = $dataAttachmentFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Lof\HelpDesk\Api\Data\AttachmentInterface $attachment
    ) {
        /* if (empty($attachment->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $attachment->setStoreId($storeId);
        } */

        $attachmentData = $this->extensibleDataObjectConverter->toNestedArray(
            $attachment,
            [],
            \Lof\HelpDesk\Api\Data\AttachmentInterface::class
        );

        $attachmentModel = $this->attachmentFactory->create()->setData($attachmentData);

        try {
            $this->resource->save($attachmentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the attachment: %1',
                $exception->getMessage()
            ));
        }
        return $attachmentModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($attachmentId)
    {
        $attachment = $this->attachmentFactory->create();
        $this->resource->load($attachment, $attachmentId);
        if (!$attachment->getId()) {
            throw new NoSuchEntityException(__('attachment with id "%1" does not exist.', $attachmentId));
        }
        return $attachment->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->attachmentCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\AttachmentInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getData();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\AttachmentInterface $attachment
    ) {
        try {
            $attachmentModel = $this->attachmentFactory->create();
            $this->resource->load($attachmentModel, $attachment->getAttachmentId());
            $this->resource->delete($attachmentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the attachment: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($attachmentId)
    {
        return $this->delete($this->get($attachmentId));
    }
}

