<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface DepartmentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get lof_helpdesk_department list.
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface[]
     */
    public function getItems();

    /**
     * Set title list.
     * @param \Lof\HelpDesk\Api\Data\DepartmentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

