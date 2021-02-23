<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface ChatMessageInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CUSTOMER_ID = 'customer_id';
    const CHAT_ID = 'chat_id';
    const USER_ID = 'user_id';
    const CUSTOMER_NAME = 'customer_name';
    const CHAT_MESSAGE_ID = 'chat_message_id';
    const UPDATED_AT = 'updated_at';
    const CUSTOMER_EMAIL = 'customer_email';
    const USER_NAME = 'user_name';
    const NAME = 'name';
    const BODY_MSGBODY_MSG = 'body_msgbody_msg';
    const CREATED_AT = 'created_at';
    const IS_READ = 'is_read';

    /**
     * Get chat_message_id
     * @return string|null
     */
    public function getChatMessageId();

    /**
     * Set chat_message_id
     * @param string $chatMessageId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setChatMessageId($chatMessageId);

    /**
     * Get chat_id
     * @return string|null
     */
    public function getChatId();

    /**
     * Set chat_id
     * @param string $chatId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setChatId($chatId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\ChatMessageExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\ChatMessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\ChatMessageExtensionInterface $extensionAttributes
    );

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId();

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setUserId($userId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get customer_name
     * @return string|null
     */
    public function getCustomerName();

    /**
     * Set customer_name
     * @param string $customerName
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setCustomerName($customerName);

    /**
     * Get is_read
     * @return string|null
     */
    public function getIsRead();

    /**
     * Set is_read
     * @param string $isRead
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setIsRead($isRead);

    /**
     * Get user_name
     * @return string|null
     */
    public function getUserName();

    /**
     * Set user_name
     * @param string $userName
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setUserName($userName);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setName($name);

    /**
     * Get body_msgbody_msg
     * @return string|null
     */
    public function getBodyMsgbodyMsg();

    /**
     * Set body_msgbody_msg
     * @param string $bodyMsgbodyMsg
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setBodyMsgbodyMsg($bodyMsgbodyMsg);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\ChatMessageInterface
     */
    public function setUpdatedAt($updatedAt);
}

