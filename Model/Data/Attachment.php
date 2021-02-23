<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\AttachmentInterface;

class Attachment extends \Magento\Framework\Api\AbstractExtensibleObject implements AttachmentInterface
{

    /**
     * Get attachment_id
     * @return string|null
     */
    public function getAttachmentId()
    {
        return $this->_get(self::ATTACHMENT_ID);
    }

    /**
     * Set attachment_id
     * @param string $attachmentId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setAttachmentId($attachmentId)
    {
        return $this->setData(self::ATTACHMENT_ID, $attachmentId);
    }

    /**
     * Get email_id
     * @return string|null
     */
    public function getEmailId()
    {
        return $this->_get(self::EMAIL_ID);
    }

    /**
     * Set email_id
     * @param string $emailId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setEmailId($emailId)
    {
        return $this->setData(self::EMAIL_ID, $emailId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\AttachmentExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\AttachmentExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\AttachmentExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get message_id
     * @return string|null
     */
    public function getMessageId()
    {
        return $this->_get(self::MESSAGE_ID);
    }

    /**
     * Set message_id
     * @param string $messageId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setMessageId($messageId)
    {
        return $this->setData(self::MESSAGE_ID, $messageId);
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
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get type
     * @return string|null
     */
    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    /**
     * Set type
     * @param string $type
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get size
     * @return string|null
     */
    public function getSize()
    {
        return $this->_get(self::SIZE);
    }

    /**
     * Set size
     * @param string $size
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setSize($size)
    {
        return $this->setData(self::SIZE, $size);
    }

    /**
     * Get body
     * @return string|null
     */
    public function getBody()
    {
        return $this->_get(self::BODY);
    }

    /**
     * Set body
     * @param string $body
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setBody($body)
    {
        return $this->setData(self::BODY, $body);
    }

    /**
     * Get external_id
     * @return string|null
     */
    public function getExternalId()
    {
        return $this->_get(self::EXTERNAL_ID);
    }

    /**
     * Set external_id
     * @param string $externalId
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setExternalId($externalId)
    {
        return $this->setData(self::EXTERNAL_ID, $externalId);
    }

    /**
     * Get storage
     * @return string|null
     */
    public function getStorage()
    {
        return $this->_get(self::STORAGE);
    }

    /**
     * Set storage
     * @param string $storage
     * @return \Lof\HelpDesk\Api\Data\AttachmentInterface
     */
    public function setStorage($storage)
    {
        return $this->setData(self::STORAGE, $storage);
    }
}

