<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\CategoryInterfaceFactory;
use Lof\HelpDesk\Api\Data\CategorySearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\CategoryRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Category as ResourceCategory;
use Lof\HelpDesk\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CategoryRepository
 * @package Lof\HelpDesk\Model
 */
class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CategoryFactory
     */
    protected $CategoryFactory;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @var CategorySearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CategoryCollectionFactory
     */
    protected $CategoryCollectionFactory;

    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var ResourceCategory
     */
    protected $resource;

    /**
     * @var CategoryInterfaceFactory
     */
    protected $dataCategoryFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;


    /**
     * @param ResourceCategory $resource
     * @param CategoryFactory $CategoryFactory
     * @param CategoryInterfaceFactory $dataCategoryFactory
     * @param CategoryCollectionFactory $CategoryCollectionFactory
     * @param CategorySearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceCategory $resource,
        CategoryFactory $CategoryFactory,
        CategoryInterfaceFactory $dataCategoryFactory,
        CategoryCollectionFactory $CategoryCollectionFactory,
        CategorySearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->CategoryFactory = $CategoryFactory;
        $this->CategoryCollectionFactory = $CategoryCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCategoryFactory = $dataCategoryFactory;
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
        \Lof\HelpDesk\Api\Data\CategoryInterface $Category
    ) {
        /* if (empty($Category->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Category->setStoreId($storeId);
        } */

        $CategoryData = $this->extensibleDataObjectConverter->toNestedArray(
            $Category,
            [],
            \Lof\HelpDesk\Api\Data\CategoryInterface::class
        );

        $CategoryModel = $this->CategoryFactory->create()->setData($CategoryData);

        try {
            $this->resource->save($CategoryModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Category: %1',
                $exception->getMessage()
            ));
        }
        return $CategoryModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($CategoryId)
    {
        $Category = $this->CategoryFactory->create();
        $this->resource->load($Category, $CategoryId);
        if (!$Category->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_category with id "%1" does not exist.', $CategoryId));
        }
        return $Category->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->CategoryCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\CategoryInterface::class
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
        \Lof\HelpDesk\Api\Data\CategoryInterface $Category
    ) {
        try {
            $CategoryModel = $this->CategoryFactory->create();
            $this->resource->load($CategoryModel, $Category->getCategoryId());
            $this->resource->delete($CategoryModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_category: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($CategoryId)
    {
        return $this->delete($this->get($CategoryId));
    }
}

