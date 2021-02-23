<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface PermissionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get lof_helpdesk_permission list.
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface[]
     */
    public function getItems();

    /**
     * Set role_id list.
     * @param \Lof\HelpDesk\Api\Data\PermissionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

