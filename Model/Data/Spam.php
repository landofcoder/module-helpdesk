<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\SpamInterface;

class Spam extends \Magento\Framework\Api\AbstractExtensibleObject implements SpamInterface
{

    /**
     * Get lof_helpdesk_spam_id
     * @return string|null
     */
    public function getSpamId()
    {
        return $this->_get(self::LOF_HELPDESK_SPAM_ID);
    }

    /**
     * Set lof_helpdesk_spam_id
     * @param string $SpamId
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setSpamId($SpamId)
    {
        return $this->setData(self::LOF_HELPDESK_SPAM_ID, $SpamId);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\SpamExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\SpamExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\SpamExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get pattern
     * @return string|null
     */
    public function getPattern()
    {
        return $this->_get(self::PATTERN);
    }

    /**
     * Set pattern
     * @param string $pattern
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setPattern($pattern)
    {
        return $this->setData(self::PATTERN, $pattern);
    }

    /**
     * Get scope
     * @return string|null
     */
    public function getScope()
    {
        return $this->_get(self::SCOPE);
    }

    /**
     * Set scope
     * @param string $scope
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setScope($scope)
    {
        return $this->setData(self::SCOPE, $scope);
    }

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->_get(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $isActive
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}

