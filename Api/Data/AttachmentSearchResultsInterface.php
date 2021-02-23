<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface AttachmentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get attachment list.
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface[]
     */
    public function getItems();

    /**
     * Set email_id list.
     * @param \Lof\HelpDesk\Api\Data\AttachmentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

