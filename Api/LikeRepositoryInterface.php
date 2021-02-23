<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface LikeRepositoryInterface
{

    /**
     * Save like
     * @param \Lof\HelpDesk\Api\Data\LikeInterface $like
     * @return \Lof\HelpDesk\Api\Data\LikeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\LikeInterface $like
    );

    /**
     * Retrieve like
     * @param string $likeId
     * @return \Lof\HelpDesk\Api\Data\LikeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($likeId);

    /**
     * Retrieve like matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\LikeSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete like
     * @param \Lof\HelpDesk\Api\Data\LikeInterface $like
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\LikeInterface $like
    );

    /**
     * Delete like by ID
     * @param string $likeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($likeId);
}

