<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ChatMessageRepositoryInterface
{

    /**
     * Save chat_message
     * @param \Lof\HelpDesk\Api\Data\ChatMessageInterface $chatMessage
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\ChatMessageInterface $chatMessage
    );

    /**
     * Retrieve chat_message
     * @param string $chatMessageId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($chatMessageId);

    /**
     * Retrieve chat_message matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\ChatMessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete chat_message
     * @param \Lof\HelpDesk\Api\Data\ChatMessageInterface $chatMessage
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\ChatMessageInterface $chatMessage
    );

    /**
     * Delete chat_message by ID
     * @param string $chatMessageId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($chatMessageId);
}

