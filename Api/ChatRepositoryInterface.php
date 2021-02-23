<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ChatRepositoryInterface
{

    /**
     * Save chat
     * @param \Lof\HelpDesk\Api\Data\ChatInterface $chat
     * @return \Lof\HelpDesk\Api\Data\ChatInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\ChatInterface $chat
    );

    /**
     * Retrieve chat
     * @param string $chatId
     * @return \Lof\HelpDesk\Api\Data\ChatInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($chatId);

    /**
     * Retrieve chat matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\ChatSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete chat
     * @param \Lof\HelpDesk\Api\Data\ChatInterface $chat
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\ChatInterface $chat
    );

    /**
     * Delete chat by ID
     * @param string $chatId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($chatId);
}

