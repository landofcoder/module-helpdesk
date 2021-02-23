<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\ChatMessageInterface;

class ChatMessage extends \Magento\Framework\Api\AbstractExtensibleObject implements ChatMessageInterface
{

    /**
     * Get chat_message_id
     * @return string|null
     */
    public function getChatMessageId()
    {
        return $this->_get(self::CHAT_MESSAGE_ID);
    }

    /**
     * Set chat_message_id
     * @param string $chatMessageId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setChatMessageId($chatMessageId)
    {
        return $this->setData(self::CHAT_MESSAGE_ID, $chatMessageId);
    }

    /**
     * Get chat_id
     * @return string|null
     */
    public function getChatId()
    {
        return $this->_get(self::CHAT_ID);
    }

    /**
     * Set chat_id
     * @param string $chatId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setChatId($chatId)
    {
        return $this->setData(self::CHAT_ID, $chatId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\ChatMessageExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\ChatMessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\ChatMessageExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId()
    {
        return $this->_get(self::USER_ID);
    }

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail()
    {
        return $this->_get(self::CUSTOMER_EMAIL);
    }

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * Get customer_name
     * @return string|null
     */
    public function getCustomerName()
    {
        return $this->_get(self::CUSTOMER_NAME);
    }

    /**
     * Set customer_name
     * @param string $customerName
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
    }

    /**
     * Get is_read
     * @return string|null
     */
    public function getIsRead()
    {
        return $this->_get(self::IS_READ);
    }

    /**
     * Set is_read
     * @param string $isRead
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setIsRead($isRead)
    {
        return $this->setData(self::IS_READ, $isRead);
    }

    /**
     * Get user_name
     * @return string|null
     */
    public function getUserName()
    {
        return $this->_get(self::USER_NAME);
    }

    /**
     * Set user_name
     * @param string $userName
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setUserName($userName)
    {
        return $this->setData(self::USER_NAME, $userName);
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
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get body_msgbody_msg
     * @return string|null
     */
    public function getBodyMsgbodyMsg()
    {
        return $this->_get(self::BODY_MSGBODY_MSG);
    }

    /**
     * Set body_msgbody_msg
     * @param string $bodyMsgbodyMsg
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setBodyMsgbodyMsg($bodyMsgbodyMsg)
    {
        return $this->setData(self::BODY_MSGBODY_MSG, $bodyMsgbodyMsg);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->_get(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}

