<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\TicketInterface;

class Ticket extends \Magento\Framework\Api\AbstractExtensibleObject implements TicketInterface
{

    /**
     * Get lof_helpdesk_ticket_id
     * @return string|null
     */
    public function getTicketId()
    {
        return $this->_get(self::LOF_HELPDESK_TICKET_ID);
    }

    /**
     * Set lof_helpdesk_ticket_id
     * @param string $TicketId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setTicketId($TicketId)
    {
        return $this->setData(self::LOF_HELPDESK_TICKET_ID, $TicketId);
    }

    /**
     * Get code
     * @return string|null
     */
    public function getTicketCode()
    {
        return $this->_get(self::CODE);
    }

    /**
     * Set code
     * @param string $code
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setTicketCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * {@inheritdoc}
     * 
     */
    public function getCode()
    {
        return $this->_get(self::CODE);
    }

    /**
     * {@inheritdoc}
     * 
     */
    public function setCode($code)
    {
        return $this->setData(self::CODE, $code);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\TicketExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\TicketExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\TicketExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get category_id
     * @return string|null
     */
    public function getCategoryId()
    {
        return $this->_get(self::CATEGORY_ID);
    }

    /**
     * Set category_id
     * @param string $categoryId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * Get product_id
     * @return string|null
     */
    public function getProductId()
    {
        return $this->_get(self::PRODUCT_ID);
    }

    /**
     * Set product_id
     * @param string $productId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setUserId($userId)
    {
        return $this->setData(self::USER_ID, $userId);
    }

    /**
     * Get subject
     * @return string|null
     */
    public function getSubject()
    {
        return $this->_get(self::SUBJECT);
    }

    /**
     * Set subject
     * @param string $subject
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setSubject($subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    /**
     * Get description
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_get(self::DESCRIPTION);
    }

    /**
     * Set description
     * @param string $description
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get priority_id
     * @return string|null
     */
    public function getPriorityId()
    {
        return $this->_get(self::PRIORITY_ID);
    }

    /**
     * Set priority_id
     * @param string $priorityId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setPriorityId($priorityId)
    {
        return $this->setData(self::PRIORITY_ID, $priorityId);
    }

    /**
     * Get status_id
     * @return string|null
     */
    public function getStatusId()
    {
        return $this->_get(self::STATUS_ID);
    }

    /**
     * Set status_id
     * @param string $statusId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setStatusId($statusId)
    {
        return $this->setData(self::STATUS_ID, $statusId);
    }

    /**
     * Get department_id
     * @return string|null
     */
    public function getDepartmentId()
    {
        return $this->_get(self::DEPARTMENT_ID);
    }

    /**
     * Set department_id
     * @param string $departmentId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setDepartmentId($departmentId)
    {
        return $this->setData(self::DEPARTMENT_ID, $departmentId);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get quote_address_id
     * @return string|null
     */
    public function getQuoteAddressId()
    {
        return $this->_get(self::QUOTE_ADDRESS_ID);
    }

    /**
     * Set quote_address_id
     * @param string $quoteAddressId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setQuoteAddressId($quoteAddressId)
    {
        return $this->setData(self::QUOTE_ADDRESS_ID, $quoteAddressId);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCustomerName($customerName)
    {
        return $this->setData(self::CUSTOMER_NAME, $customerName);
    }

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Set order_id
     * @param string $orderId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get last_reply_name
     * @return string|null
     */
    public function getLastReplyName()
    {
        return $this->_get(self::LAST_REPLY_NAME);
    }

    /**
     * Set last_reply_name
     * @param string $lastReplyName
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setLastReplyName($lastReplyName)
    {
        return $this->setData(self::LAST_REPLY_NAME, $lastReplyName);
    }

    /**
     * Get last_reply_at
     * @return string|null
     */
    public function getLastReplyAt()
    {
        return $this->_get(self::LAST_REPLY_AT);
    }

    /**
     * Set last_reply_at
     * @param string $lastReplyAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setLastReplyAt($lastReplyAt)
    {
        return $this->setData(self::LAST_REPLY_AT, $lastReplyAt);
    }

    /**
     * Get reply_cnt
     * @return string|null
     */
    public function getReplyCnt()
    {
        return $this->_get(self::REPLY_CNT);
    }

    /**
     * Set reply_cnt
     * @param string $replyCnt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setReplyCnt($replyCnt)
    {
        return $this->setData(self::REPLY_CNT, $replyCnt);
    }

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * Set store_id
     * @param string $storeId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * Get folder
     * @return string|null
     */
    public function getFolder()
    {
        return $this->_get(self::FOLDER);
    }

    /**
     * Set folder
     * @param string $folder
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFolder($folder)
    {
        return $this->setData(self::FOLDER, $folder);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setEmailId($emailId)
    {
        return $this->setData(self::EMAIL_ID, $emailId);
    }

    /**
     * Get rating
     * @return string|null
     */
    public function getRating()
    {
        return $this->_get(self::RATING);
    }

    /**
     * Set rating
     * @param string $rating
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setRating($rating)
    {
        return $this->setData(self::RATING, $rating);
    }

    /**
     * Get first_reply_at
     * @return string|null
     */
    public function getFirstReplyAt()
    {
        return $this->_get(self::FIRST_REPLY_AT);
    }

    /**
     * Set first_reply_at
     * @param string $firstReplyAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFirstReplyAt($firstReplyAt)
    {
        return $this->setData(self::FIRST_REPLY_AT, $firstReplyAt);
    }

    /**
     * Get first_solved_at
     * @return string|null
     */
    public function getFirstSolvedAt()
    {
        return $this->_get(self::FIRST_SOLVED_AT);
    }

    /**
     * Set first_solved_at
     * @param string $firstSolvedAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFirstSolvedAt($firstSolvedAt)
    {
        return $this->setData(self::FIRST_SOLVED_AT, $firstSolvedAt);
    }

    /**
     * Get fp_period_unit
     * @return string|null
     */
    public function getFpPeriodUnit()
    {
        return $this->_get(self::FP_PERIOD_UNIT);
    }

    /**
     * Set fp_period_unit
     * @param string $fpPeriodUnit
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpPeriodUnit($fpPeriodUnit)
    {
        return $this->setData(self::FP_PERIOD_UNIT, $fpPeriodUnit);
    }

    /**
     * Get fp_period_value
     * @return string|null
     */
    public function getFpPeriodValue()
    {
        return $this->_get(self::FP_PERIOD_VALUE);
    }

    /**
     * Set fp_period_value
     * @param string $fpPeriodValue
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpPeriodValue($fpPeriodValue)
    {
        return $this->setData(self::FP_PERIOD_VALUE, $fpPeriodValue);
    }

    /**
     * Get fp_execute_at
     * @return string|null
     */
    public function getFpExecuteAt()
    {
        return $this->_get(self::FP_EXECUTE_AT);
    }

    /**
     * Set fp_execute_at
     * @param string $fpExecuteAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpExecuteAt($fpExecuteAt)
    {
        return $this->setData(self::FP_EXECUTE_AT, $fpExecuteAt);
    }

    /**
     * Get fp_is_remind
     * @return string|null
     */
    public function getFpIsRemind()
    {
        return $this->_get(self::FP_IS_REMIND);
    }

    /**
     * Set fp_is_remind
     * @param string $fpIsRemind
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpIsRemind($fpIsRemind)
    {
        return $this->setData(self::FP_IS_REMIND, $fpIsRemind);
    }

    /**
     * Get fp_remind_email
     * @return string|null
     */
    public function getFpRemindEmail()
    {
        return $this->_get(self::FP_REMIND_EMAIL);
    }

    /**
     * Set fp_remind_email
     * @param string $fpRemindEmail
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpRemindEmail($fpRemindEmail)
    {
        return $this->setData(self::FP_REMIND_EMAIL, $fpRemindEmail);
    }

    /**
     * Get fp_priority_id
     * @return string|null
     */
    public function getFpPriorityId()
    {
        return $this->_get(self::FP_PRIORITY_ID);
    }

    /**
     * Set fp_priority_id
     * @param string $fpPriorityId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpPriorityId($fpPriorityId)
    {
        return $this->setData(self::FP_PRIORITY_ID, $fpPriorityId);
    }

    /**
     * Get fp_status_id
     * @return string|null
     */
    public function getFpStatusId()
    {
        return $this->_get(self::FP_STATUS_ID);
    }

    /**
     * Set fp_status_id
     * @param string $fpStatusId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpStatusId($fpStatusId)
    {
        return $this->setData(self::FP_STATUS_ID, $fpStatusId);
    }

    /**
     * Get fp_department_id
     * @return string|null
     */
    public function getFpDepartmentId()
    {
        return $this->_get(self::FP_DEPARTMENT_ID);
    }

    /**
     * Set fp_department_id
     * @param string $fpDepartmentId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpDepartmentId($fpDepartmentId)
    {
        return $this->setData(self::FP_DEPARTMENT_ID, $fpDepartmentId);
    }

    /**
     * Get fp_user_id
     * @return string|null
     */
    public function getFpUserId()
    {
        return $this->_get(self::FP_USER_ID);
    }

    /**
     * Set fp_user_id
     * @param string $fpUserId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpUserId($fpUserId)
    {
        return $this->setData(self::FP_USER_ID, $fpUserId);
    }

    /**
     * Get channel
     * @return string|null
     */
    public function getChannel()
    {
        return $this->_get(self::CHANNEL);
    }

    /**
     * Set channel
     * @param string $channel
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setChannel($channel)
    {
        return $this->setData(self::CHANNEL, $channel);
    }

    /**
     * Get channel_data
     * @return string|null
     */
    public function getChannelData()
    {
        return $this->_get(self::CHANNEL_DATA);
    }

    /**
     * Set channel_data
     * @param string $channelData
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setChannelData($channelData)
    {
        return $this->setData(self::CHANNEL_DATA, $channelData);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setThirdPartyEmail($thirdPartyEmail)
    {
        return $this->setData(self::THIRD_PARTY_EMAIL, $thirdPartyEmail);
    }

    /**
     * Get search_index
     * @return string|null
     */
    public function getSearchIndex()
    {
        return $this->_get(self::SEARCH_INDEX);
    }

    /**
     * Set search_index
     * @param string $searchIndex
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setSearchIndex($searchIndex)
    {
        return $this->setData(self::SEARCH_INDEX, $searchIndex);
    }

    /**
     * Get cc
     * @return string|null
     */
    public function getCc()
    {
        return $this->_get(self::CC);
    }

    /**
     * Set cc
     * @param string $cc
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCc($cc)
    {
        return $this->setData(self::CC, $cc);
    }

    /**
     * Get bcc
     * @return string|null
     */
    public function getBcc()
    {
        return $this->_get(self::BCC);
    }

    /**
     * Set bcc
     * @param string $bcc
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setBcc($bcc)
    {
        return $this->setData(self::BCC, $bcc);
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setIsRead($isRead)
    {
        return $this->setData(self::IS_READ, $isRead);
    }

    /**
     * Get merged_ticket_id
     * @return string|null
     */
    public function getMergedTicketId()
    {
        return $this->_get(self::MERGED_TICKET_ID);
    }

    /**
     * Set merged_ticket_id
     * @param string $mergedTicketId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setMergedTicketId($mergedTicketId)
    {
        return $this->setData(self::MERGED_TICKET_ID, $mergedTicketId);
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminNote()
    {
        return $this->_get(self::ADMIN_NOTE);
    }

    /**
     * {@inheritdoc}
     */
    public function setAdminNote($adminNote)
    {
        return $this->setData(self::ADMIN_NOTE, $adminNote);
    }

    /**
     * {@inheritdoc}
     */
    public function getQtyRequested()
    {
        return $this->_get(self::QTY_REQUESTED);
    }

    /**
     * {@inheritdoc}
     */
    public function setQtyRequested($qtyRequested)
    {
        return $this->setData(self::QTY_REQUESTED, $qtyRequested);
    }

    /**
     * {@inheritdoc}
     */
    public function getQtyReturned()
    {
        return $this->_get(self::QTY_RETURNED);
    }

    /**
     * {@inheritdoc}
     */
    public function setQtyReturned($qtyReturned)
    {
        return $this->setData(self::QTY_RETURNED, $qtyReturned);
    }
}

