<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\DepartmentInterfaceFactory;
use Lof\HelpDesk\Api\Data\DepartmentSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\DepartmentRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Department as ResourceDepartment;
use Lof\HelpDesk\Model\ResourceModel\Department\CollectionFactory as DepartmentCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $DepartmentFactory;

    protected $extensibleDataObjectConverter;
    protected $DepartmentCollectionFactory;

    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $dataObjectHelper;

    protected $dataDepartmentFactory;


    /**
     * @param ResourceDepartment $resource
     * @param DepartmentFactory $DepartmentFactory
     * @param DepartmentInterfaceFactory $dataDepartmentFactory
     * @param DepartmentCollectionFactory $DepartmentCollectionFactory
     * @param DepartmentSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceDepartment $resource,
        DepartmentFactory $DepartmentFactory,
        DepartmentInterfaceFactory $dataDepartmentFactory,
        DepartmentCollectionFactory $DepartmentCollectionFactory,
        DepartmentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->DepartmentFactory = $DepartmentFactory;
        $this->DepartmentCollectionFactory = $DepartmentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataDepartmentFactory = $dataDepartmentFactory;
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
        \Lof\HelpDesk\Api\Data\DepartmentInterface $Department
    ) {
        /* if (empty($Department->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Department->setStoreId($storeId);
        } */

        $DepartmentData = $this->extensibleDataObjectConverter->toNestedArray(
            $Department,
            [],
            \Lof\HelpDesk\Api\Data\DepartmentInterface::class
        );

        $DepartmentModel = $this->DepartmentFactory->create()->setData($DepartmentData);

        try {
            $this->resource->save($DepartmentModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Department: %1',
                $exception->getMessage()
            ));
        }
        return $DepartmentModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($DepartmentId)
    {
        $Department = $this->DepartmentFactory->create();
        $this->resource->load($Department, $DepartmentId);
        if (!$Department->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_department with id "%1" does not exist.', $DepartmentId));
        }
        return $Department->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->DepartmentCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\DepartmentInterface::class
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
        \Lof\HelpDesk\Api\Data\DepartmentInterface $Department
    ) {
        try {
            $DepartmentModel = $this->DepartmentFactory->create();
            $this->resource->load($DepartmentModel, $Department->getDepartmentId());
            $this->resource->delete($DepartmentModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_department: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($DepartmentId)
    {
        return $this->delete($this->get($DepartmentId));
    }
}

