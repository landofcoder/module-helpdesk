<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface ChatMessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get chat_message list.
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface[]
     */
    public function getItems();

    /**
     * Set chat_id list.
     * @param \Lof\HelpDesk\Api\Data\ChatMessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

