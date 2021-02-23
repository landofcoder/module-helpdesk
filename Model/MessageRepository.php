<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\MessageInterfaceFactory;
use Lof\HelpDesk\Api\Data\MessageSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\MessageRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Message as ResourceMessage;
use Lof\HelpDesk\Model\ResourceModel\Message\CollectionFactory as MessageCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class MessageRepository implements MessageRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $MessageCollectionFactory;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $MessageFactory;

    protected $dataObjectHelper;

    protected $dataMessageFactory;


    /**
     * @param ResourceMessage $resource
     * @param MessageFactory $MessageFactory
     * @param MessageInterfaceFactory $dataMessageFactory
     * @param MessageCollectionFactory $MessageCollectionFactory
     * @param MessageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceMessage $resource,
        MessageFactory $MessageFactory,
        MessageInterfaceFactory $dataMessageFactory,
        MessageCollectionFactory $MessageCollectionFactory,
        MessageSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->MessageFactory = $MessageFactory;
        $this->MessageCollectionFactory = $MessageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataMessageFactory = $dataMessageFactory;
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
        \Lof\HelpDesk\Api\Data\MessageInterface $Message
    ) {
        /* if (empty($Message->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Message->setStoreId($storeId);
        } */

        $MessageData = $this->extensibleDataObjectConverter->toNestedArray(
            $Message,
            [],
            \Lof\HelpDesk\Api\Data\MessageInterface::class
        );

        $MessageModel = $this->MessageFactory->create()->setData($MessageData);

        try {
            $this->resource->save($MessageModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Message: %1',
                $exception->getMessage()
            ));
        }
        return $MessageModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($MessageId)
    {
        $Message = $this->MessageFactory->create();
        $this->resource->load($Message, $MessageId);
        if (!$Message->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_message with id "%1" does not exist.', $MessageId));
        }
        return $Message->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->MessageCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\MessageInterface::class
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
        \Lof\HelpDesk\Api\Data\MessageInterface $Message
    ) {
        try {
            $MessageModel = $this->MessageFactory->create();
            $this->resource->load($MessageModel, $Message->getMessageId());
            $this->resource->delete($MessageModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_message: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($MessageId)
    {
        return $this->delete($this->get($MessageId));
    }
}

