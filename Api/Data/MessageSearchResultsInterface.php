<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface MessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get lof_helpdesk_message list.
     * @return \Lof\HelpDesk\Api\Data\MessageInterface[]
     */
    public function getItems();

    /**
     * Set ticket_id list.
     * @param \Lof\HelpDesk\Api\Data\MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

