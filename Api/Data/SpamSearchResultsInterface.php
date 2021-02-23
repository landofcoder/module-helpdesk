<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface SpamSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get lof_helpdesk_spam list.
     * @return \Lof\HelpDesk\Api\Data\SpamInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Lof\HelpDesk\Api\Data\SpamInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

