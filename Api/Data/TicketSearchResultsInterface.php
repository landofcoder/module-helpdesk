<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface TicketSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get lof_helpdesk_ticket list.
     * @return \Lof\HelpDesk\Api\Data\TicketInterface[]
     */
    public function getItems();

    /**
     * Set code list.
     * @param \Lof\HelpDesk\Api\Data\TicketInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

