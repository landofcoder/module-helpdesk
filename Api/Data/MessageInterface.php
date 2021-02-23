<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface MessageInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const THIRD_PARTY_EMAIL = 'third_party_email';
    const USER_EMAIL = 'user_email';
    const CUSTOMER_ID = 'customer_id';
    const CUSTOMER_NAME = 'customer_name';
    const EMAIL_ID = 'email_id';
    const TYPE = 'type';
    const USER_ID = 'user_id';
    const UPDATED_AT = 'updated_at';
    const USER_NAME = 'user_name';
    const LOF_HELPDESK_MESSAGE_ID = 'lof_helpdesk_message_id';
    const CUSTOMER_EMAIL = 'customer_email';
    const BODY_FORMAT = 'body_format';
    const UID = 'uid';
    const TICKET_ID = 'ticket_id';
    const THIRD_PARTY_NAME = 'third_party_name';
    const BODY = 'body';
    const CREATED_AT = 'created_at';

    /**
     * Get lof_helpdesk_message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set lof_helpdesk_message_id
     * @param string $MessageId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setMessageId($MessageId);

    /**
     * Get ticket_id
     * @return string|null
     */
    public function getTicketId();

    /**
     * Set ticket_id
     * @param string $ticketId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setTicketId($ticketId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\MessageExtensionInterface $extensionAttributes
    );

    /**
     * Get email_id
     * @return string|null
     */
    public function getEmailId();

    /**
     * Set email_id
     * @param string $emailId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setEmailId($emailId);

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId();

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUserId($userId);

    /**
     * Get user_email
     * @return string|null
     */
    public function getUserEmail();

    /**
     * Set user_email
     * @param string $userEmail
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUserEmail($userEmail);

    /**
     * Get user_name
     * @return string|null
     */
    public function getUserName();

    /**
     * Set user_name
     * @param string $userName
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUserName($userName);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setCustomerName($customerName);

    /**
     * Get body
     * @return string|null
     */
    public function getBody();

    /**
     * Set body
     * @param string $body
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setBody($body);

    /**
     * Get body_format
     * @return string|null
     */
    public function getBodyFormat();

    /**
     * Set body_format
     * @param string $bodyFormat
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setBodyFormat($bodyFormat);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get uid
     * @return string|null
     */
    public function getUid();

    /**
     * Set uid
     * @param string $uid
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUid($uid);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setType($type);

    /**
     * Get third_party_email
     * @return string|null
     */
    public function getThirdPartyEmail();

    /**
     * Set third_party_email
     * @param string $thirdPartyEmail
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setThirdPartyEmail($thirdPartyEmail);

    /**
     * Get third_party_name
     * @return string|null
     */
    public function getThirdPartyName();

    /**
     * Set third_party_name
     * @param string $thirdPartyName
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setThirdPartyName($thirdPartyName);
}

