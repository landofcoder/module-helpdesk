<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface TicketInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const LAST_REPLY_NAME = 'last_reply_name';
    const FOLDER = 'folder';
    const CATEGORY_ID = 'category_id';
    const MERGED_TICKET_ID = 'merged_ticket_id';
    const DEPARTMENT_ID = 'department_id';
    const FP_PERIOD_VALUE = 'fp_period_value';
    const EMAIL_ID = 'email_id';
    const FP_EXECUTE_AT = 'fp_execute_at';
    const UPDATED_AT = 'updated_at';
    const CUSTOMER_EMAIL = 'customer_email';
    const PRODUCT_ID = 'product_id';
    const ORDER_ID = 'order_id';
    const CREATED_AT = 'created_at';
    const QUOTE_ADDRESS_ID = 'quote_address_id';
    const BCC = 'bcc';
    const FP_DEPARTMENT_ID = 'fp_department_id';
    const CUSTOMER_ID = 'customer_id';
    const FP_STATUS_ID = 'fp_status_id';
    const CUSTOMER_NAME = 'customer_name';
    const CC = 'cc';
    const FIRST_SOLVED_AT = 'first_solved_at';
    const DESCRIPTION = 'description';
    const RATING = 'rating';
    const LAST_REPLY_AT = 'last_reply_at';
    const FIRST_REPLY_AT = 'first_reply_at';
    const FP_IS_REMIND = 'fp_is_remind';
    const FP_USER_ID = 'fp_user_id';
    const THIRD_PARTY_EMAIL = 'third_party_email';
    const IS_READ = 'is_read';
    const CODE = 'code';
    const FP_REMIND_EMAIL = 'fp_remind_email';
    const CHANNEL_DATA = 'channel_data';
    const REPLY_CNT = 'reply_cnt';
    const STATUS_ID = 'status_id';
    const SEARCH_INDEX = 'search_index';
    const STORE_ID = 'store_id';
    const FP_PERIOD_UNIT = 'fp_period_unit';
    const PRIORITY_ID = 'priority_id';
    const SUBJECT = 'subject';
    const CHANNEL = 'channel';
    const USER_ID = 'user_id';
    const LOF_HELPDESK_TICKET_ID = 'lof_helpdesk_ticket_id';
    const FP_PRIORITY_ID = 'fp_priority_id';
    const ADMIN_NOTE = 'admin_note';
    const QTY_REQUESTED = 'qty_requested';
    const QTY_RETURNED = 'qty_returned';

    /**
     * Get lof_helpdesk_ticket_id
     * @return string|null
     */
    public function getTicketId();

    /**
     * Set lof_helpdesk_ticket_id
     * @param string $TicketId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setTicketId($TicketId);

    /**
     * Get code
     * @return string|null
     */
    public function getCode();

    /**
     * Set code
     * @param string $code
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCode($code);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\TicketExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\TicketExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\TicketExtensionInterface $extensionAttributes
    );

    /**
     * Get category_id
     * @return string|null
     */
    public function getCategoryId();

    /**
     * Set category_id
     * @param string $categoryId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCategoryId($categoryId);

    /**
     * Get product_id
     * @return string|null
     */
    public function getProductId();

    /**
     * Set product_id
     * @param string $productId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setProductId($productId);

    /**
     * Get user_id
     * @return string|null
     */
    public function getUserId();

    /**
     * Set user_id
     * @param string $userId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setUserId($userId);

    /**
     * Get subject
     * @return string|null
     */
    public function getSubject();

    /**
     * Set subject
     * @param string $subject
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setSubject($subject);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setDescription($description);

    /**
     * Get priority_id
     * @return string|null
     */
    public function getPriorityId();

    /**
     * Set priority_id
     * @param string $priorityId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setPriorityId($priorityId);

    /**
     * Get status_id
     * @return string|null
     */
    public function getStatusId();

    /**
     * Set status_id
     * @param string $statusId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setStatusId($statusId);

    /**
     * Get department_id
     * @return string|null
     */
    public function getDepartmentId();

    /**
     * Set department_id
     * @param string $departmentId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setDepartmentId($departmentId);

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get quote_address_id
     * @return string|null
     */
    public function getQuoteAddressId();

    /**
     * Set quote_address_id
     * @param string $quoteAddressId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setQuoteAddressId($quoteAddressId);

    /**
     * Get customer_email
     * @return string|null
     */
    public function getCustomerEmail();

    /**
     * Set customer_email
     * @param string $customerEmail
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCustomerName($customerName);

    /**
     * Get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $orderId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setOrderId($orderId);

    /**
     * Get last_reply_name
     * @return string|null
     */
    public function getLastReplyName();

    /**
     * Set last_reply_name
     * @param string $lastReplyName
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setLastReplyName($lastReplyName);

    /**
     * Get last_reply_at
     * @return string|null
     */
    public function getLastReplyAt();

    /**
     * Set last_reply_at
     * @param string $lastReplyAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setLastReplyAt($lastReplyAt);

    /**
     * Get reply_cnt
     * @return string|null
     */
    public function getReplyCnt();

    /**
     * Set reply_cnt
     * @param string $replyCnt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setReplyCnt($replyCnt);

    /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId();

    /**
     * Set store_id
     * @param string $storeId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setStoreId($storeId);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
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
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get folder
     * @return string|null
     */
    public function getFolder();

    /**
     * Set folder
     * @param string $folder
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFolder($folder);

    /**
     * Get email_id
     * @return string|null
     */
    public function getEmailId();

    /**
     * Set email_id
     * @param string $emailId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setEmailId($emailId);

    /**
     * Get rating
     * @return string|null
     */
    public function getRating();

    /**
     * Set rating
     * @param string $rating
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setRating($rating);

    /**
     * Get first_reply_at
     * @return string|null
     */
    public function getFirstReplyAt();

    /**
     * Set first_reply_at
     * @param string $firstReplyAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFirstReplyAt($firstReplyAt);

    /**
     * Get first_solved_at
     * @return string|null
     */
    public function getFirstSolvedAt();

    /**
     * Set first_solved_at
     * @param string $firstSolvedAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFirstSolvedAt($firstSolvedAt);

    /**
     * Get fp_period_unit
     * @return string|null
     */
    public function getFpPeriodUnit();

    /**
     * Set fp_period_unit
     * @param string $fpPeriodUnit
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpPeriodUnit($fpPeriodUnit);

    /**
     * Get fp_period_value
     * @return string|null
     */
    public function getFpPeriodValue();

    /**
     * Set fp_period_value
     * @param string $fpPeriodValue
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpPeriodValue($fpPeriodValue);

    /**
     * Get fp_execute_at
     * @return string|null
     */
    public function getFpExecuteAt();

    /**
     * Set fp_execute_at
     * @param string $fpExecuteAt
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpExecuteAt($fpExecuteAt);

    /**
     * Get fp_is_remind
     * @return string|null
     */
    public function getFpIsRemind();

    /**
     * Set fp_is_remind
     * @param string $fpIsRemind
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpIsRemind($fpIsRemind);

    /**
     * Get fp_remind_email
     * @return string|null
     */
    public function getFpRemindEmail();

    /**
     * Set fp_remind_email
     * @param string $fpRemindEmail
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpRemindEmail($fpRemindEmail);

    /**
     * Get fp_priority_id
     * @return string|null
     */
    public function getFpPriorityId();

    /**
     * Set fp_priority_id
     * @param string $fpPriorityId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpPriorityId($fpPriorityId);

    /**
     * Get fp_status_id
     * @return string|null
     */
    public function getFpStatusId();

    /**
     * Set fp_status_id
     * @param string $fpStatusId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpStatusId($fpStatusId);

    /**
     * Get fp_department_id
     * @return string|null
     */
    public function getFpDepartmentId();

    /**
     * Set fp_department_id
     * @param string $fpDepartmentId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpDepartmentId($fpDepartmentId);

    /**
     * Get fp_user_id
     * @return string|null
     */
    public function getFpUserId();

    /**
     * Set fp_user_id
     * @param string $fpUserId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setFpUserId($fpUserId);

    /**
     * Get channel
     * @return string|null
     */
    public function getChannel();

    /**
     * Set channel
     * @param string $channel
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setChannel($channel);

    /**
     * Get channel_data
     * @return string|null
     */
    public function getChannelData();

    /**
     * Set channel_data
     * @param string $channelData
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setChannelData($channelData);

    /**
     * Get third_party_email
     * @return string|null
     */
    public function getThirdPartyEmail();

    /**
     * Set third_party_email
     * @param string $thirdPartyEmail
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setThirdPartyEmail($thirdPartyEmail);

    /**
     * Get search_index
     * @return string|null
     */
    public function getSearchIndex();

    /**
     * Set search_index
     * @param string $searchIndex
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setSearchIndex($searchIndex);

    /**
     * Get cc
     * @return string|null
     */
    public function getCc();

    /**
     * Set cc
     * @param string $cc
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setCc($cc);

    /**
     * Get bcc
     * @return string|null
     */
    public function getBcc();

    /**
     * Set bcc
     * @param string $bcc
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setBcc($bcc);

    /**
     * Get is_read
     * @return string|null
     */
    public function getIsRead();

    /**
     * Set is_read
     * @param string $isRead
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setIsRead($isRead);

    /**
     * Get merged_ticket_id
     * @return string|null
     */
    public function getMergedTicketId();

    /**
     * Set merged_ticket_id
     * @param string $mergedTicketId
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setMergedTicketId($mergedTicketId);

    /**
     * Get admin_note
     * @return string|null
     */
    public function getAdminNote();

    /**
     * Set admin_note
     * @param string $adminNote
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setAdminNote($adminNote);

    /**
     * Get qty_requested
     * @return float|int|null
     */
    public function getQtyRequested();

    /**
     * Set qty_requested
     * @param float|int|null $qtyRequested
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setQtyRequested($qtyRequested);

    /**
     * Get qty_returned
     * @return float|int|null
     */
    public function getQtyReturned();

    /**
     * Set qty_returned
     * @param float|int|null $qtyReturned
     * @return \Lof\HelpDesk\Api\Data\TicketInterface
     */
    public function setQtyReturned($qtyReturned);
}

