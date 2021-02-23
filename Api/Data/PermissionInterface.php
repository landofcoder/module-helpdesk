<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface PermissionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const IS_TICKET_REMOVE_ALLOWED = 'is_ticket_remove_allowed';
    const ROLE_ID = 'role_id';
    const LOF_HELPDESK_PERMISSION_ID = 'lof_helpdesk_permission_id';

    /**
     * Get lof_helpdesk_permission_id
     * @return string|null
     */
    public function getPermissionId();

    /**
     * Set lof_helpdesk_permission_id
     * @param string $PermissionId
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     */
    public function setPermissionId($PermissionId);

    /**
     * Get role_id
     * @return string|null
     */
    public function getRoleId();

    /**
     * Set role_id
     * @param string $roleId
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     */
    public function setRoleId($roleId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\PermissionExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\PermissionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\PermissionExtensionInterface $extensionAttributes
    );

    /**
     * Get is_ticket_remove_allowed
     * @return string|null
     */
    public function getIsTicketRemoveAllowed();

    /**
     * Set is_ticket_remove_allowed
     * @param string $isTicketRemoveAllowed
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     */
    public function setIsTicketRemoveAllowed($isTicketRemoveAllowed);
}

