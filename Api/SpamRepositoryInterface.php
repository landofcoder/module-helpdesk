<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SpamRepositoryInterface
{

    /**
     * Save lof_helpdesk_spam
     * @param \Lof\HelpDesk\Api\Data\SpamInterface $Spam
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\SpamInterface $Spam
    );

    /**
     * Retrieve lof_helpdesk_spam
     * @param string $SpamId
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($SpamId);

    /**
     * Retrieve lof_helpdesk_spam matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\SpamSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_spam
     * @param \Lof\HelpDesk\Api\Data\SpamInterface $Spam
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\SpamInterface $Spam
    );

    /**
     * Delete lof_helpdesk_spam by ID
     * @param string $SpamId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($SpamId);
}

