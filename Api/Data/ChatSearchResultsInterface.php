<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface ChatSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get chat list.
     * @return \Lof\HelpDesk\Api\Data\ChatInterface[]
     */
    public function getItems();

    /**
     * Set user_id list.
     * @param \Lof\HelpDesk\Api\Data\ChatInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

