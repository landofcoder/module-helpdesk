<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\ChatRepositoryInterface;
use Lof\HelpDesk\Api\Data\ChatInterfaceFactory;
use Lof\HelpDesk\Api\Data\ChatSearchResultsInterfaceFactory;
use Lof\HelpDesk\Model\ResourceModel\Chat as ResourceChat;
use Lof\HelpDesk\Model\ResourceModel\Chat\CollectionFactory as ChatCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class ChatRepository implements ChatRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $chatCollectionFactory;

    protected $extensibleDataObjectConverter;
    protected $chatFactory;

    protected $searchResultsFactory;

    protected $dataChatFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $dataObjectHelper;


    /**
     * @param ResourceChat $resource
     * @param ChatFactory $chatFactory
     * @param ChatInterfaceFactory $dataChatFactory
     * @param ChatCollectionFactory $chatCollectionFactory
     * @param ChatSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceChat $resource,
        ChatFactory $chatFactory,
        ChatInterfaceFactory $dataChatFactory,
        ChatCollectionFactory $chatCollectionFactory,
        ChatSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->chatFactory = $chatFactory;
        $this->chatCollectionFactory = $chatCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataChatFactory = $dataChatFactory;
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
        \Lof\HelpDesk\Api\Data\ChatInterface $chat
    ) {
        /* if (empty($chat->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $chat->setStoreId($storeId);
        } */

        $chatData = $this->extensibleDataObjectConverter->toNestedArray(
            $chat,
            [],
            \Lof\HelpDesk\Api\Data\ChatInterface::class
        );

        $chatModel = $this->chatFactory->create()->setData($chatData);

        try {
            $this->resource->save($chatModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the chat: %1',
                $exception->getMessage()
            ));
        }
        return $chatModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($chatId)
    {
        $chat = $this->chatFactory->create();
        $this->resource->load($chat, $chatId);
        if (!$chat->getId()) {
            throw new NoSuchEntityException(__('chat with id "%1" does not exist.', $chatId));
        }
        return $chat->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->chatCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\ChatInterface::class
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
        \Lof\HelpDesk\Api\Data\ChatInterface $chat
    ) {
        try {
            $chatModel = $this->chatFactory->create();
            $this->resource->load($chatModel, $chat->getChatId());
            $this->resource->delete($chatModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the chat: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($chatId)
    {
        return $this->delete($this->get($chatId));
    }
}

