<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PermissionRepositoryInterface
{

    /**
     * Save lof_helpdesk_permission
     * @param \Lof\HelpDesk\Api\Data\PermissionInterface $Permission
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Lof\HelpDesk\Api\Data\PermissionInterface $Permission
    );

    /**
     * Retrieve lof_helpdesk_permission
     * @param string $PermissionId
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($PermissionId);

    /**
     * Retrieve lof_helpdesk_permission matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\HelpDesk\Api\Data\PermissionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete lof_helpdesk_permission
     * @param \Lof\HelpDesk\Api\Data\PermissionInterface $Permission
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Lof\HelpDesk\Api\Data\PermissionInterface $Permission
    );

    /**
     * Delete lof_helpdesk_permission by ID
     * @param string $PermissionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($PermissionId);
}

