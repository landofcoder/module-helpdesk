<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model;

use Lof\HelpDesk\Api\Data\TicketInterfaceFactory;
use Lof\HelpDesk\Api\Data\TicketSearchResultsInterfaceFactory;
use Lof\HelpDesk\Api\TicketRepositoryInterface;
use Lof\HelpDesk\Model\ResourceModel\Ticket as ResourceTicket;
use Lof\HelpDesk\Model\ResourceModel\Ticket\CollectionFactory as TicketCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class TicketRepository implements TicketRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $extensionAttributesJoinProcessor;

    protected $resource;

    protected $TicketFactory;

    protected $TicketCollectionFactory;

    protected $dataObjectHelper;

    protected $dataTicketFactory;


    /**
     * @param ResourceTicket $resource
     * @param TicketFactory $TicketFactory
     * @param TicketInterfaceFactory $dataTicketFactory
     * @param TicketCollectionFactory $TicketCollectionFactory
     * @param TicketSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceTicket $resource,
        TicketFactory $TicketFactory,
        TicketInterfaceFactory $dataTicketFactory,
        TicketCollectionFactory $TicketCollectionFactory,
        TicketSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->TicketFactory = $TicketFactory;
        $this->TicketCollectionFactory = $TicketCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTicketFactory = $dataTicketFactory;
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
        \Lof\HelpDesk\Api\Data\TicketInterface $Ticket
    ) {
        /* if (empty($Ticket->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $Ticket->setStoreId($storeId);
        } */

        $TicketData = $this->extensibleDataObjectConverter->toNestedArray(
            $Ticket,
            [],
            \Lof\HelpDesk\Api\Data\TicketInterface::class
        );

        $TicketModel = $this->TicketFactory->create()->setData($TicketData);

        try {
            $this->resource->save($TicketModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Ticket: %1',
                $exception->getMessage()
            ));
        }
        return $TicketModel;
    }

    /**
     * {@inheritdoc}
     */
    public function get($TicketId)
    {
        $Ticket = $this->TicketFactory->create();
        $this->resource->load($Ticket, $TicketId);
        if (!$Ticket->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_ticket with id "%1" does not exist.', $TicketId));
        }
        return $Ticket;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->TicketCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Lof\HelpDesk\Api\Data\TicketInterface::class
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
        \Lof\HelpDesk\Api\Data\TicketInterface $Ticket
    ) {
        try {
            $TicketModel = $this->TicketFactory->create();
            $this->resource->load($TicketModel, $Ticket->getTicketId());
            $this->resource->delete($TicketModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the lof_helpdesk_ticket: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($TicketId)
    {
        return $this->delete($this->get($TicketId));
    }
}

