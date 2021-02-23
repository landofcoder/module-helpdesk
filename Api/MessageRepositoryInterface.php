<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface MessageRepositoryInterface
{

    /**
     * Save lof_helpdesk_message
     * @param \Lof\HelpDesk\Api\Data\MessageInterface $Message
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\MessageInterface $Message
    );

    /**
     * Retrieve lof_helpdesk_message
     * @param string $MessageId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($MessageId);

    /**
     * Retrieve lof_helpdesk_message matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\MessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_message
     * @param \Lof\HelpDesk\Api\Data\MessageInterface $Message
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\MessageInterface $Message
    );

    /**
     * Delete lof_helpdesk_message by ID
     * @param string $MessageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($MessageId);
}

