<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\MessageInterface;

class Message extends \Magento\Framework\Api\AbstractExtensibleObject implements MessageInterface
{

    /**
     * Get lof_helpdesk_message_id
     * @return string|null
     */
    public function getMessageId()
    {
        return $this->_get(self::LOF_HELPDESK_MESSAGE_ID);
    }

    /**
     * Set lof_helpdesk_message_id
     * @param string $MessageId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setMessageId($MessageId)
    {
        return $this->setData(self::LOF_HELPDESK_MESSAGE_ID, $MessageId);
    }

    /**
     * Get ticket_id
     * @return string|null
     */
    public function getTicketId()
    {
        return $this->_get(self::TICKET_ID);
    }

    /**
     * Set ticket_id
     * @param string $ticketId
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setTicketId($ticketId)
    {
        return $this->setData(self::TICKET_ID, $ticketId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\MessageExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\MessageExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\MessageExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setEmailId($emailId)
    {
        return $this->setData(self::EMAIL_ID, $emailId);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Get user_email
     * @return string|null
     */
    public function getUserEmail()
    {
        return $this->_get(self::USER_EMAIL);
    }

    /**
     * Set user_email
     * @param string $userEmail
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUserEmail($userEmail)
    {
        return $this->setData(self::USER_EMAIL, $userEmail);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUserName($userName)
    {
        return $this->setData(self::USER_NAME, $userName);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setBody($body)
    {
        return $this->setData(self::BODY, $body);
    }

    /**
     * Get body_format
     * @return string|null
     */
    public function getBodyFormat()
    {
        return $this->_get(self::BODY_FORMAT);
    }

    /**
     * Set body_format
     * @param string $bodyFormat
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setBodyFormat($bodyFormat)
    {
        return $this->setData(self::BODY_FORMAT, $bodyFormat);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get uid
     * @return string|null
     */
    public function getUid()
    {
        return $this->_get(self::UID);
    }

    /**
     * Set uid
     * @param string $uid
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setUid($uid)
    {
        return $this->setData(self::UID, $uid);
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
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }

    /**
     * Get third_party_email
     * @return string|null
     */
    public function getThirdPartyEmail()
    {
        return $this->_get(self::THIRD_PARTY_EMAIL);
    }

    /**
     * Set third_party_email
     * @param string $thirdPartyEmail
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setThirdPartyEmail($thirdPartyEmail)
    {
        return $this->setData(self::THIRD_PARTY_EMAIL, $thirdPartyEmail);
    }

    /**
     * Get third_party_name
     * @return string|null
     */
    public function getThirdPartyName()
    {
        return $this->_get(self::THIRD_PARTY_NAME);
    }

    /**
     * Set third_party_name
     * @param string $thirdPartyName
     * @return \Lof\HelpDesk\Api\Data\MessageInterface
     */
    public function setThirdPartyName($thirdPartyName)
    {
        return $this->setData(self::THIRD_PARTY_NAME, $thirdPartyName);
    }
}

