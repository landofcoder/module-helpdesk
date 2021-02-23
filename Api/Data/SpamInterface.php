<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface SpamInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const SCOPE = 'scope';
    const LOF_HELPDESK_SPAM_ID = 'lof_helpdesk_spam_id';
    const IS_ACTIVE = 'is_active';
    const NAME = 'name';
    const PATTERN = 'pattern';

    /**
     * Get lof_helpdesk_spam_id
     * @return string|null
     */
    public function getSpamId();

    /**
     * Set lof_helpdesk_spam_id
     * @param string $SpamId
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setSpamId($SpamId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setName($name);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\SpamExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\SpamExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\SpamExtensionInterface $extensionAttributes
    );

    /**
     * Get pattern
     * @return string|null
     */
    public function getPattern();

    /**
     * Set pattern
     * @param string $pattern
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setPattern($pattern);

    /**
     * Get scope
     * @return string|null
     */
    public function getScope();

    /**
     * Set scope
     * @param string $scope
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setScope($scope);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Lof\HelpDesk\Api\Data\SpamInterface
     */
    public function setIsActive($isActive);
}

