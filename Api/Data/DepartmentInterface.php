<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface DepartmentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const POSITION = 'position';
    const IDENTIFIER = 'identifier';
    const TITLE = 'title';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const LOF_HELPDESK_DEPARTMENT_ID = 'lof_helpdesk_department_id';
    const IS_ACTIVE = 'is_active';

    /**
     * Get lof_helpdesk_department_id
     * @return string|null
     */
    public function getDepartmentId();

    /**
     * Set lof_helpdesk_department_id
     * @param string $DepartmentId
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setDepartmentId($DepartmentId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\DepartmentExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\DepartmentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\DepartmentExtensionInterface $extensionAttributes
    );

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set creation_time
     * @param string $creationTime
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set update_time
     * @param string $updateTime
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Get position
     * @return string|null
     */
    public function getPosition();

    /**
     * Set position
     * @param string $position
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setPosition($position);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Lof\HelpDesk\Api\Data\DepartmentInterface
     */
    public function setIsActive($isActive);
}

