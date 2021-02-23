<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\PermissionInterface;

class Permission extends \Magento\Framework\Api\AbstractExtensibleObject implements PermissionInterface
{

    /**
     * Get lof_helpdesk_permission_id
     * @return string|null
     */
    public function getPermissionId()
    {
        return $this->_get(self::LOF_HELPDESK_PERMISSION_ID);
    }

    /**
     * Set lof_helpdesk_permission_id
     * @param string $PermissionId
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     */
    public function setPermissionId($PermissionId)
    {
        return $this->setData(self::LOF_HELPDESK_PERMISSION_ID, $PermissionId);
    }

    /**
     * Get role_id
     * @return string|null
     */
    public function getRoleId()
    {
        return $this->_get(self::ROLE_ID);
    }

    /**
     * Set role_id
     * @param string $roleId
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     */
    public function setRoleId($roleId)
    {
        return $this->setData(self::ROLE_ID, $roleId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\PermissionExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\PermissionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\PermissionExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get is_ticket_remove_allowed
     * @return string|null
     */
    public function getIsTicketRemoveAllowed()
    {
        return $this->_get(self::IS_TICKET_REMOVE_ALLOWED);
    }

    /**
     * Set is_ticket_remove_allowed
     * @param string $isTicketRemoveAllowed
     * @return \Lof\HelpDesk\Api\Data\PermissionInterface
     */
    public function setIsTicketRemoveAllowed($isTicketRemoveAllowed)
    {
        return $this->setData(self::IS_TICKET_REMOVE_ALLOWED, $isTicketRemoveAllowed);
    }
}

