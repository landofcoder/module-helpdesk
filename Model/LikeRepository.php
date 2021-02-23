<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\LikeInterfaceFactory;
use Lof\HelpDesk\Api\Data\LikeSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\LikeRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Like as ResourceLike;
use Lof\HelpDesk\Model\ResourceModel\Like\CollectionFactory as LikeCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class LikeRepository implements LikeRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $dataLikeFactory;

    protected $extensibleDataObjectConverter;
    protected $likeCollectionFactory;

    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $likeFactory;

    protected $dataObjectHelper;


    /**
     * @param ResourceLike $resource
     * @param LikeFactory $likeFactory
     * @param LikeInterfaceFactory $dataLikeFactory
     * @param LikeCollectionFactory $likeCollectionFactory
     * @param LikeSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceLike $resource,
        LikeFactory $likeFactory,
        LikeInterfaceFactory $dataLikeFactory,
        LikeCollectionFactory $likeCollectionFactory,
        LikeSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->likeFactory = $likeFactory;
        $this->likeCollectionFactory = $likeCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataLikeFactory = $dataLikeFactory;
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
        \Lof\HelpDesk\Api\Data\LikeInterface $like
    ) {
        /* if (empty($like->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $like->setStoreId($storeId);
        } */

        $likeData = $this->extensibleDataObjectConverter->toNestedArray(
            $like,
            [],
            \Lof\HelpDesk\Api\Data\LikeInterface::class
        );

        $likeModel = $this->likeFactory->create()->setData($likeData);

        try {
            $this->resource->save($likeModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the like: %1',
                $exception->getMessage()
            ));
        }
        return $likeModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($likeId)
    {
        $like = $this->likeFactory->create();
        $this->resource->load($like, $likeId);
        if (!$like->getId()) {
            throw new NoSuchEntityException(__('like with id "%1" does not exist.', $likeId));
        }
        return $like->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->likeCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\LikeInterface::class
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
        \Lof\HelpDesk\Api\Data\LikeInterface $like
    ) {
        try {
            $likeModel = $this->likeFactory->create();
            $this->resource->load($likeModel, $like->getLikeId());
            $this->resource->delete($likeModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the like: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($likeId)
    {
        return $this->delete($this->get($likeId));
    }
}

