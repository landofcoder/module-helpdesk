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
use Lof\HelpDesk\Helper\Data;
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

    protected $ticketFactory;

    protected $ticketCollectionFactory;

    protected $dataObjectHelper;

    protected $dataTicketFactory;

    /**
     * @var Data
     */
    protected $helperData;


    /**
     * @param ResourceTicket $resource
     * @param TicketFactory $ticketFactory
     * @param TicketInterfaceFactory $dataTicketFactory
     * @param TicketCollectionFactory $ticketCollectionFactory
     * @param TicketSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param Data $helperData
     */
    public function __construct(
        ResourceTicket $resource,
        TicketFactory $ticketFactory,
        TicketInterfaceFactory $dataTicketFactory,
        TicketCollectionFactory $ticketCollectionFactory,
        TicketSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        Data $helperData
    ) {
        $this->resource = $resource;
        $this->ticketFactory = $ticketFactory;
        $this->ticketCollectionFactory = $ticketCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataTicketFactory = $dataTicketFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->helperData = $helperData;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Lof\HelpDesk\Api\Data\TicketInterface $ticket
    ) {
        /* if (empty($ticket->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $ticket->setStoreId($storeId);
        } */

        $ticketData = $this->extensibleDataObjectConverter->toNestedArray(
            $ticket,
            [],
            \Lof\HelpDesk\Api\Data\TicketInterface::class
        );
        $ticketCode = "";
        if($ticket->getTicketId()){
            $oldTicketModel = $this->get((int)$ticket->getTicketId());
            $ticketCode = $oldTicketModel->getCode();
        }
        $ticketModel = $this->ticketFactory->create()->setData($ticketData);

        try {
            if(!$ticketModel->getId()){
                $ticketCode = $this->helperData->generateTicketCode();
            }
            $ticketModel->setData("code", $ticketCode);
            $this->resource->save($ticketModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the Ticket: %1',
                $exception->getMessage()
            ));
        }
        return $ticketModel;
    }

    /**
     * {@inheritdoc}
     */
    public function get($ticketId)
    {
        $ticket = $this->ticketFactory->create();
        $this->resource->load($ticket, $ticketId);
        if (!$ticket->getId()) {
            throw new NoSuchEntityException(__('lof_helpdesk_ticket with id "%1" does not exist.', $ticketId));
        }
        return $ticket;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->ticketCollectionFactory->create();

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
        \Lof\HelpDesk\Api\Data\TicketInterface $ticket
    ) {
        try {
            $ticketModel = $this->ticketFactory->create();
            $this->resource->load($ticketModel, $ticket->getTicketId());
            $this->resource->delete($ticketModel);
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
    public function deleteById($ticketId)
    {
        return $this->delete($this->get($ticketId));
    }
}

