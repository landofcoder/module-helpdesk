<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface QuickanswerInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const UPDATED_AT = 'updated_at';
    const CONTENT = 'content';
    const TITLE = 'title';
    const LOF_HELPDESK_QUICKANSWER_ID = 'lof_helpdesk_quickanswer_id';
    const IS_ACTIVE = 'is_active';
    const CREATED_AT = 'created_at';

    /**
     * Get lof_helpdesk_quickanswer_id
     * @return string|null
     */
    public function getQuickanswerId();

    /**
     * Set lof_helpdesk_quickanswer_id
     * @param string $QuickanswerId
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     */
    public function setQuickanswerId($QuickanswerId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\QuickanswerExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\QuickanswerExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\QuickanswerExtensionInterface $extensionAttributes
    );

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     */
    public function setContent($content);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Lof\HelpDesk\Api\Data\QuickanswerInterface
     */
    public function setIsActive($isActive);
}

