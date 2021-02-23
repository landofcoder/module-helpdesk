<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\QuickanswerInterfaceFactory;
use Lof\HelpDesk\Api\Data\QuickanswerSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\QuickanswerRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Quickanswer as ResourceQuickanswer;
use Lof\HelpDesk\Model\ResourceModel\Quickanswer\CollectionFactory as QuickanswerCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class QuickanswerRepository implements QuickanswerRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $QuickanswerFactory;

    protected $QuickanswerCollectionFactory;

    protected $resource;

    protected $dataQuickanswerFactory;

    protected $dataObjectHelper;


    /**
     * @param ResourceQuickanswer $resource
     * @param QuickanswerFactory $QuickanswerFactory
     * @param QuickanswerInterfaceFactory $dataQuickanswerFactory
     * @param QuickanswerCollectionFactory $QuickanswerCollectionFactory
     * @param QuickanswerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceQuickanswer $resource,
        QuickanswerFactory $QuickanswerFactory,
        QuickanswerInterfaceFactory $dataQuickanswerFactory,
        QuickanswerCollectionFactory $QuickanswerCollectionFactory,
        QuickanswerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->QuickanswerFactory = $QuickanswerFactory;
        $this->QuickanswerCollectionFactory = $QuickanswerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataQuickanswerFactory = $dataQuickanswerFactory;
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
        \Lof\HelpDesk\Api\Data\QuickanswerInterface $Quickanswer
    ) {
        /* if (empty($Quickanswer->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Quickanswer->setStoreId($storeId);
        } */

        $QuickanswerData = $this->extensibleDataObjectConverter->toNestedArray(
            $Quickanswer,
            [],
            \Lof\HelpDesk\Api\Data\QuickanswerInterface::class
        );

        $QuickanswerModel = $this->QuickanswerFactory->create()->setData($QuickanswerData);

        try {
            $this->resource->save($QuickanswerModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Quickanswer: %1',
                $exception->getMessage()
            ));
        }
        return $QuickanswerModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($QuickanswerId)
    {
        $Quickanswer = $this->QuickanswerFactory->create();
        $this->resource->load($Quickanswer, $QuickanswerId);
        if (!$Quickanswer->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_quickanswer with id "%1" does not exist.', $QuickanswerId));
        }
        return $Quickanswer->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->QuickanswerCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\QuickanswerInterface::class
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
        \Lof\HelpDesk\Api\Data\QuickanswerInterface $Quickanswer
    ) {
        try {
            $QuickanswerModel = $this->QuickanswerFactory->create();
            $this->resource->load($QuickanswerModel, $Quickanswer->getQuickanswerId());
            $this->resource->delete($QuickanswerModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_quickanswer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($QuickanswerId)
    {
        return $this->delete($this->get($QuickanswerId));
    }
}

