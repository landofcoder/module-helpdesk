<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface LikeSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get like list.
     * @return \Lof\HelpDesk\Api\Data\LikeInterface[]
     */
    public function getItems();

    /**
     * Set user_id list.
     * @param \Lof\HelpDesk\Api\Data\LikeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

