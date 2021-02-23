<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface CategorySearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get lof_helpdesk_category list.
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Lof\HelpDesk\Api\Data\CategoryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

