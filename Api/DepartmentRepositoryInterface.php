<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface DepartmentRepositoryInterface
{

    /**
     * Save lof_helpdesk_department
     * @param \Lof\HelpDesk\Api\Data\DepartmentInterface $Department
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\DepartmentInterface $Department
    );

    /**
     * Retrieve lof_helpdesk_department
     * @param string $DepartmentId
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($DepartmentId);

    /**
     * Retrieve lof_helpdesk_department matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\DepartmentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_department
     * @param \Lof\HelpDesk\Api\Data\DepartmentInterface $Department
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\DepartmentInterface $Department
    );

    /**
     * Delete lof_helpdesk_department by ID
     * @param string $DepartmentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($DepartmentId);
}

