<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface TicketRepositoryInterface
{

    /**
     * Save lof_helpdesk_ticket
     * @param \Lof\HelpDesk\Api\Data\TicketInterface $Ticket
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\TicketInterface $Ticket
    );

    /**
     * Retrieve lof_helpdesk_ticket
     * @param string $TicketId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($TicketId);

    /**
     * Retrieve lof_helpdesk_ticket matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\TicketSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_ticket
     * @param \Lof\HelpDesk\Api\Data\TicketInterface $Ticket
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\TicketInterface $Ticket
    );

    /**
     * Delete lof_helpdesk_ticket by ID
     * @param string $TicketId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($TicketId);
}

