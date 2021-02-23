<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CategoryRepositoryInterface
{

    /**
     * Save lof_helpdesk_category
     * @param \Lof\HelpDesk\Api\Data\CategoryInterface $Category
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\CategoryInterface $Category
    );

    /**
     * Retrieve lof_helpdesk_category
     * @param string $CategoryId
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($CategoryId);

    /**
     * Retrieve lof_helpdesk_category matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\CategorySearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_category
     * @param \Lof\HelpDesk\Api\Data\CategoryInterface $Category
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\CategoryInterface $Category
    );

    /**
     * Delete lof_helpdesk_category by ID
     * @param string $CategoryId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($CategoryId);
}

