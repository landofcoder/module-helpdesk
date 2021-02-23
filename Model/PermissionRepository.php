<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\PermissionInterfaceFactory;
use Lof\HelpDesk\Api\Data\PermissionSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\PermissionRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Permission as ResourcePermission;
use Lof\HelpDesk\Model\ResourceModel\Permission\CollectionFactory as PermissionCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class PermissionRepository implements PermissionRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $PermissionFactory;

    protected $searchResultsFactory;

    protected $dataPermissionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $PermissionCollectionFactory;

    protected $dataObjectHelper;


    /**
     * @param ResourcePermission $resource
     * @param PermissionFactory $PermissionFactory
     * @param PermissionInterfaceFactory $dataPermissionFactory
     * @param PermissionCollectionFactory $PermissionCollectionFactory
     * @param PermissionSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourcePermission $resource,
        PermissionFactory $PermissionFactory,
        PermissionInterfaceFactory $dataPermissionFactory,
        PermissionCollectionFactory $PermissionCollectionFactory,
        PermissionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->PermissionFactory = $PermissionFactory;
        $this->PermissionCollectionFactory = $PermissionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataPermissionFactory = $dataPermissionFactory;
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
        \Lof\HelpDesk\Api\Data\PermissionInterface $Permission
    ) {
        /* if (empty($Permission->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Permission->setStoreId($storeId);
        } */

        $PermissionData = $this->extensibleDataObjectConverter->toNestedArray(
            $Permission,
            [],
            \Lof\HelpDesk\Api\Data\PermissionInterface::class
        );

        $PermissionModel = $this->PermissionFactory->create()->setData($PermissionData);

        try {
            $this->resource->save($PermissionModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Permission: %1',
                $exception->getMessage()
            ));
        }
        return $PermissionModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($PermissionId)
    {
        $Permission = $this->PermissionFactory->create();
        $this->resource->load($Permission, $PermissionId);
        if (!$Permission->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_permission with id "%1" does not exist.', $PermissionId));
        }
        return $Permission->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->PermissionCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\PermissionInterface::class
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
        \Lof\HelpDesk\Api\Data\PermissionInterface $Permission
    ) {
        try {
            $PermissionModel = $this->PermissionFactory->create();
            $this->resource->load($PermissionModel, $Permission->getPermissionId());
            $this->resource->delete($PermissionModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_permission: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($PermissionId)
    {
        return $this->delete($this->get($PermissionId));
    }
}

