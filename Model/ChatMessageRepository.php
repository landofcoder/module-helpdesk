<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\ChatMessageRepositoryInterface;
use Lof\HelpDesk\Api\Data\ChatMessageInterfaceFactory;
use Lof\HelpDesk\Api\Data\ChatMessageSearchResultsInterfaceFactory;
use Lof\HelpDesk\Model\ResourceModel\ChatMessage as ResourceChatMessage;
use Lof\HelpDesk\Model\ResourceModel\ChatMessage\CollectionFactory as ChatMessageCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class ChatMessageRepository implements ChatMessageRepositoryInterface
{

    protected $chatMessageFactory;

    protected $dataChatMessageFactory;

    private $storeManager;

    protected $chatMessageCollectionFactory;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $dataObjectHelper;


    /**
     * @param ResourceChatMessage $resource
     * @param ChatMessageFactory $chatMessageFactory
     * @param ChatMessageInterfaceFactory $dataChatMessageFactory
     * @param ChatMessageCollectionFactory $chatMessageCollectionFactory
     * @param ChatMessageSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceChatMessage $resource,
        ChatMessageFactory $chatMessageFactory,
        ChatMessageInterfaceFactory $dataChatMessageFactory,
        ChatMessageCollectionFactory $chatMessageCollectionFactory,
        ChatMessageSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->chatMessageFactory = $chatMessageFactory;
        $this->chatMessageCollectionFactory = $chatMessageCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataChatMessageFactory = $dataChatMessageFactory;
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
        \Lof\HelpDesk\Api\Data\ChatMessageInterface $chatMessage
    ) {
        /* if (empty($chatMessage->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $chatMessage->setStoreId($storeId);
        } */

        $chatMessageData = $this->extensibleDataObjectConverter->toNestedArray(
            $chatMessage,
            [],
            \Lof\HelpDesk\Api\Data\ChatMessageInterface::class
        );

        $chatMessageModel = $this->chatMessageFactory->create()->setData($chatMessageData);

        try {
            $this->resource->save($chatMessageModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the chatMessage: %1',
                $exception->getMessage()
            ));
        }
        return $chatMessageModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($chatMessageId)
    {
        $chatMessage = $this->chatMessageFactory->create();
        $this->resource->load($chatMessage, $chatMessageId);
        if (!$chatMessage->getId()) {
            throw new NoSuchEntityException(__('chat_message with id "%1" does not exist.', $chatMessageId));
        }
        return $chatMessage->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->chatMessageCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\ChatMessageInterface::class
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
        \Lof\HelpDesk\Api\Data\ChatMessageInterface $chatMessage
    ) {
        try {
            $chatMessageModel = $this->chatMessageFactory->create();
            $this->resource->load($chatMessageModel, $chatMessage->getChatMessageId());
            $this->resource->delete($chatMessageModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the chat_message: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($chatMessageId)
    {
        return $this->delete($this->get($chatMessageId));
    }
}

