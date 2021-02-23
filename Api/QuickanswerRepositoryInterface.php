<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface QuickanswerRepositoryInterface
{

    /**
     * Save lof_helpdesk_quickanswer
     * @param \Lof\HelpDesk\Api\Data\QuickanswerInterface $Quickanswer
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\QuickanswerInterface $Quickanswer
    );

    /**
     * Retrieve lof_helpdesk_quickanswer
     * @param string $QuickanswerId
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($QuickanswerId);

    /**
     * Retrieve lof_helpdesk_quickanswer matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\QuickanswerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_quickanswer
     * @param \Lof\HelpDesk\Api\Data\QuickanswerInterface $Quickanswer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\QuickanswerInterface $Quickanswer
    );

    /**
     * Delete lof_helpdesk_quickanswer by ID
     * @param string $QuickanswerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($QuickanswerId);
}

