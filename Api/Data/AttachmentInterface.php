<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface AttachmentInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const EXTERNAL_ID = 'external_id';
    const MESSAGE_ID = 'message_id';
    const STORAGE = 'storage';
    const EMAIL_ID = 'email_id';
    const TYPE = 'type';
    const NAME = 'name';
    const ATTACHMENT_ID = 'attachment_id';
    const SIZE = 'size';
    const BODY = 'body';

    /**
     * Get attachment_id
     * @return string|null
     */
    public function getAttachmentId();

    /**
     * Set attachment_id
     * @param string $attachmentId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setAttachmentId($attachmentId);

    /**
     * Get email_id
     * @return string|null
     */
    public function getEmailId();

    /**
     * Set email_id
     * @param string $emailId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setEmailId($emailId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\AttachmentExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\AttachmentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\AttachmentExtensionInterface $extensionAttributes
    );

    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set message_id
     * @param string $messageId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setMessageId($messageId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setName($name);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setType($type);

    /**
     * Get size
     * @return string|null
     */
    public function getSize();

    /**
     * Set size
     * @param string $size
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setSize($size);

    /**
     * Get body
     * @return string|null
     */
    public function getBody();

    /**
     * Set body
     * @param string $body
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setBody($body);

    /**
     * Get external_id
     * @return string|null
     */
    public function getExternalId();

    /**
     * Set external_id
     * @param string $externalId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setExternalId($externalId);

    /**
     * Get storage
     * @return string|null
     */
    public function getStorage();

    /**
     * Set storage
     * @param string $storage
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setStorage($storage);
}

