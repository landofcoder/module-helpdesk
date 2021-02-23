<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\SpamInterfaceFactory;
use Lof\HelpDesk\Api\Data\SpamSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\SpamRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Spam as ResourceSpam;
use Lof\HelpDesk\Model\ResourceModel\Spam\CollectionFactory as SpamCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class SpamRepository implements SpamRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $SpamFactory;

    protected $SpamCollectionFactory;

    protected $dataSpamFactory;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $dataObjectHelper;


    /**
     * @param ResourceSpam $resource
     * @param SpamFactory $SpamFactory
     * @param SpamInterfaceFactory $dataSpamFactory
     * @param SpamCollectionFactory $SpamCollectionFactory
     * @param SpamSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSpam $resource,
        SpamFactory $SpamFactory,
        SpamInterfaceFactory $dataSpamFactory,
        SpamCollectionFactory $SpamCollectionFactory,
        SpamSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->SpamFactory = $SpamFactory;
        $this->SpamCollectionFactory = $SpamCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSpamFactory = $dataSpamFactory;
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
        \Lof\HelpDesk\Api\Data\SpamInterface $Spam
    ) {
        /* if (empty($Spam->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Spam->setStoreId($storeId);
        } */

        $SpamData = $this->extensibleDataObjectConverter->toNestedArray(
            $Spam,
            [],
            \Lof\HelpDesk\Api\Data\SpamInterface::class
        );

        $SpamModel = $this->SpamFactory->create()->setData($SpamData);

        try {
            $this->resource->save($SpamModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Spam: %1',
                $exception->getMessage()
            ));
        }
        return $SpamModel->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function get($SpamId)
    {
        $Spam = $this->SpamFactory->create();
        $this->resource->load($Spam, $SpamId);
        if (!$Spam->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_spam with id "%1" does not exist.', $SpamId));
        }
        return $Spam->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->SpamCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\SpamInterface::class
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
        \Lof\HelpDesk\Api\Data\SpamInterface $Spam
    ) {
        try {
            $SpamModel = $this->SpamFactory->create();
            $this->resource->load($SpamModel, $Spam->getSpamId());
            $this->resource->delete($SpamModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_spam: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($SpamId)
    {
        return $this->delete($this->get($SpamId));
    }
}

