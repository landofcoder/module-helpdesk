<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    protected $_config = [];

    /**
     * Template filter factory
     *
     * @var \Magento\Catalog\Model\Template\Filter\Factory
     */
    protected $_templateFilterFactory;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $localeDate;

    /**
     * @var \Lof\HelpDesk\Model\Department
     */
    protected $department;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $_customerUrl;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $_urlInterface;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var Trackcode
     */
    protected $trackcode;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    protected $_localeDate;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Lof\HelpDesk\Model\Department $department
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\UrlInterface $urlInterface
     * @param Trackcode $trackcode
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Lof\HelpDesk\Model\Department $department,
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\UrlInterface $urlInterface,
        Trackcode $trackcode
    ) {
        parent::__construct($context);
        $this->department = $department;
        $this->_storeManager = $storeManager;
        $this->orderFactory = $orderFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->_filterProvider = $filterProvider;
        $this->_localeDate = $localeDate;
        $this->_coreRegistry = $registry;
        $this->customerSession = $customerSession;
        $this->_customerUrl = $customerUrl;
        $this->_urlInterface = $urlInterface;
        $this->date = $date;
        $this->trackcode = $trackcode;

        $chunks = $this->getConfig("advanced_settings/chunks", null, 1);
        $letters = $this->getConfig("advanced_settings/letters", null, 9);
        $separate_text = $this->getConfig("advanced_settings/separate_text", null, "-");

        $this->trackcode->numberChunks = (int)$chunks;
        $this->trackcode->numberLettersPerChunk = (int)$letters;
        $this->trackcode->separateChunkText = (int)$separate_text;
    }

    /**
     * @return string
     */
    public function generateTicketCode() {
        if($this->enableTicketCode()){
            return $this->trackcode->generate();
        }
        return "";
    }
    /**
     * @return int|null
     */
    public function enableTicketCode() {
        return $this->getConfig("advanced_settings/enabled_ticket_code");
    }
    /**
     * @return string
     */
    public function getCurrentTime() {
        return $date = $this->date->gmtDate();
    }

    public function getTimezoneDateTime($dateTime = "today"){
        if($dateTime === "today" || !$dateTime){
            $dateTime = $this->date->gmtDate();
        }

        $today = $this->_localeDate
            ->date(
                new \DateTime($dateTime)
            )->format('Y-m-d H:i:s');
        return $today;
    }

    public function getTimezoneName(){
        return $this->_localeDate->getConfigTimezone(\Magento\Store\Model\ScopeInterface::SCOPE_STORES);
    }

    /**
     * @return string
     */
    public function getUrl() {
        return  $this->_storeManager->getStore()->getBaseUrl();
    }
    /**
     * @return string
     */
    public function getCurrentUrl() {
       return $this->_urlInterface -> getCurrentUrl();
    }
    /**
     * @return string
     */
    public function getIp()
    {
        return $this->_remoteAddress->getRemoteAddress();
    }
    /**
     * @return string
     */
    public function getCustomerLoginUrl()
    {
        return $this->_customerUrl->getLoginUrl();
    }
    /**
     * @param int $category_id
     * @return int|null
     */
    public function getDepartmentByCategory($category_id)
    {
        $department = $this->department;

        foreach ($department->getCollection() as $key => $_department) {
            if (is_array($_department->getCategoryId()) && in_array($category_id, $_department->getCategoryId())) {
                return $_department->getDepartmentId();
            }
        }
        return null;
    }

    public function getDepartmentById($department_id)
    {
        $department = $this->department->getCollection()->addFieldToFilter('department_id', $department_id)->getFirstItem();
        return $department;
    }

    public function getCustomer()
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        return $customerId;
    }

    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        return $customerId;
    }

    public function getCustomerEmail()
    {
        $customer = $this->customerSession->getCustomer()->getEmail();
        return $customer;
    }

    public function getCustomerName()
    {
        $customer = $this->customerSession->getCustomer()->getFirstname() . ' ' . $this->customerSession->getCustomer()->getLastname();
        return $customer;
    }

//    public function filter($str)
//    {
//        $html = $this->_filterProvider->getPageFilter()->filter($str);
//        return $html;
//    }

    public function isLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function getCoreRegistry()
    {
        return $this->_coreRegistry;
    }

    /**
     * Returns array of orders for customer
     * by customer email or id.
     *
     * @param string $customerEmail
     * @param string $order_url
     * @param bool $customerId
     *
     * @return array
     */
    public function getOrderTicket($orderid, $order_url = "")
    {
        $order = $this->orderCollectionFactory->create()->addFieldToFilter('entity_id', $orderid)->getFirstItem();
        if (!is_object($order)) {
            $order = $this->orderFactory->create()->load($order);
        }
        $res = "#{$order->getRealOrderId()}";
        if($order_url){
            $res = '<a href="'.$order_url.'" target="_BLANK">'.$res.'</a>';
        }
        $res .= __(
            ' at %1 (%2) - %3',
            $this->formatDate($order->getCreatedAt(), \IntlDateFormatter::MEDIUM),
            strip_tags($order->formatPrice($order->getGrandTotal())),
            __(ucwords($order->getStatus()))
        );

        return $res;
    }

    /**
     * @return object
     */
    public function getStatus($id)
    {
        $data = '';
        if ($id == 0) {
            $data = __('Close');
        } elseif ($id == 1) {
            $data = __('Open');
        } elseif ($id == 2) {
            $data = __('Processing');
        } elseif ($id == 3) {
            $data = __('Done');
        }

        return $data;
    }

    /**
     * @return object
     */
    public function getPriority($id)
    {
        $data = '';
        if ($id == 0) {
            $data = __('Low');
        } elseif ($id == 1) {
            $data = __('Medium');
        } elseif ($id == 2) {
            $data = __('Height');
        } elseif ($id == 3) {
            $data = __('Ugent');
        }

        return $data;
    }

    public function getOrder($customerEmail, $customerId = false)
    {
        $orders = [];
        $collection = $this->orderCollectionFactory->create();
        $collection
            ->addAttributeToSelect('*')
            ->setOrder('created_at', 'desc');
        if ($customerId) {
            $collection->addFieldToFilter(
                ['customer_email', 'customer_id'],
                [$customerEmail, $customerId]
            );
        } else {
            $collection->addFieldToFilter('customer_email', $customerEmail);
        }
        /** @var \Magento\Sales\Model\Order $order */
        foreach ($collection as $order) {
            if (!is_object($order)) {
                $order = $this->orderFactory->create()->load($order);
            }
            $res = "#{$order->getRealOrderId()}";
            $res .= __(
                ' at %1 (%2) - %3',
                $this->formatDate($order->getCreatedAt(), \IntlDateFormatter::MEDIUM),
                strip_tags($order->formatPrice($order->getGrandTotal())),
                __(ucwords($order->getStatus()))
            );

            $orders[] = [
                'id' => $order->getId(),
                'value' => $order->getId(),
                'name' => $res,
                'label' => $res,
            ];
        }
        return $orders;
    }

    public function getProductByOrder($customerEmail, $customerId = false)
    {
        $products = [];
        $collection = $this->orderCollectionFactory->create();
        $collection
            ->addAttributeToSelect('*')
            ->setOrder('created_at', 'desc');
        if ($customerId) {
            $collection->addFieldToFilter(
                ['customer_email', 'customer_id'],
                [$customerEmail, $customerId]
            );
        } else {
            $collection->addFieldToFilter('customer_email', $customerEmail);
        }
        /** @var \Magento\Sales\Model\Order $order */
        foreach ($collection as $order) {
            foreach ($order->getAllItems() as $key => $item) {
                $products[] = [
                    'value' => $item->getProductId(),
                    'name'  => $item->getName(),
                    'label' => $item->getName().__(" - SKU: %1 (Ordered QTY: %2 items)", $item->getSku(), (int)$item->getQtyOrdered())
                ];
            }
        }

        return array_unique($products, SORT_REGULAR);
    }

    public function getProduct($customerEmail, $customerId = false)
    {
        $products = [];
        $collection = $this->orderCollectionFactory->create();
        $collection
            ->addAttributeToSelect('*')
            ->setOrder('created_at', 'desc');
        if ($customerId) {
            $collection->addFieldToFilter(
                ['customer_email', 'customer_id'],
                [$customerEmail, $customerId]
            );
        } else {
            $collection->addFieldToFilter('customer_email', $customerEmail);
        }
        /** @var \Magento\Sales\Model\Order $order */
        foreach ($collection as $order) {
            foreach ($order->getAllItems() as $key => $item) {
                $products[] = [
                    'value' => $item->getProductId(),
                    'sku'   => $item->getSku(),
                    'label' => $item->getName(),
                    'qty'   => ((int)$item->getQtyOrdered() - (int)$item->getQtyRefunded()),
                    'order_id' => $order->getId()
                ];
            }
        }

        //return array_unique($products, SORT_REGULAR);
        return $products;
    }

    /**
     * @param $key
     * @param null $store
     * @param null $default
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig($key, $store = null, $default = null)
    {
        $store = $this->_storeManager->getStore($store);

        $result = $this->scopeConfig->getValue(
            'lofhelpdesk/' . $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        if ($default != null) {
            return $result ? $result : $default;
        } else {
            return $result;
        }
    }

    public function getConfigs($key, $store = null)
    {
        $store = $this->_storeManager->getStore($store);
        $websiteId = $store->getWebsiteId();

        $result = $this->scopeConfig->getValue(
            $key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        return $result;
    }

    public function getFormatDate($date, $type = 'full')
    {
        $result = '';
        switch ($type) {
            case 'full':
                $result = $this->formatDate($date, \IntlDateFormatter::FULL);
                break;
            case 'long':
                $result = $this->formatDate($date, \IntlDateFormatter::LONG);
                break;
            case 'medium':
                $result = $this->formatDate($date, \IntlDateFormatter::MEDIUM);
                break;
            case 'short':
                $result = $this->formatDate($date, \IntlDateFormatter::SHORT);
                break;
        }
        return $result;
    }

    public function formatDate(
        $date = null,
        $format = \IntlDateFormatter::SHORT,
        $showTime = false,
        $timezone = null
    ) {
        $date = $date instanceof \DateTimeInterface ? $date : new \DateTime($date);
        return $this->_localeDate->formatDateTime(
            $date,
            $format,
            $showTime ? $format : \IntlDateFormatter::NONE,
            null,
            $timezone
        );
    }

    public function subString($text, $length = 100, $replacer = '...', $is_striped = true)
    {
        if ($length == 0) {
            return $text;
        }
        $text = ($is_striped == true) ? strip_tags($text) : $text;
        if (strlen($text) <= $length) {
            return $text;
        }
        $text = substr($text, 0, $length);
        $pos_space = strrpos($text, ' ');
        return substr($text, 0, $pos_space) . $replacer;
    }

    public function getCategoryUrl($cat)
    {
        $link = '';
        $route = $this->getConfig('general_settings/route');
        if ($route) {
            $link = $route . '/';
        }
        if (is_array($cat)) {
            $link .= $cat['identifier'];
        } else {
            $link .= $cat->getIdentifier();
        }
        return $this->_getUrl('', ['_direct' => $link]);
    }

    public function getQuestionUrl($_question)
    {
        $link = '';
        $route = $this->getConfig('general_settings/route');
        if ($route) {
            $link = $route . '/';
        }
        $link .= 'question/id';
        return $this->_getUrl($link) . $_question->getId();
    }

    public function getTagUrl($alias)
    {
        $url = $this->_storeManager->getStore()->getBaseUrl();
        $url_prefix = $this->getConfig('general_settings/route');
        $urlPrefix = '';
        if ($url_prefix) {
            $urlPrefix = $url_prefix . '/';
        }
        return $url . $urlPrefix . 'tag/' . $alias;
    }

    public function nicetime($timestamp, $detailLevel = 1)
    {
        $periods = ['sec', 'min', 'hour', 'day', 'week', 'month', 'year', 'decade'];
        $lengths = ['60', '60', '24', '7', '4.35', '12', '10'];

        $now = time();
        $timestamp = strtotime($timestamp);
        // check validity of date
        if (empty($timestamp)) {
            return 'Unknown time';
        }

        // is it future date or past date
        if ($now > $timestamp) {
            $difference = $now - $timestamp;
            $tense = 'ago';
        } else {
            $difference = $timestamp - $now;
            $tense = 'from now';
        }

        if ($difference == 0) {
            return '1 sec ago';
        }

        $remainders = [];

        for ($j = 0; $j < count($lengths); ++$j) {
            $remainders[$j] = floor(fmod($difference, $lengths[$j]));
            $difference = floor($difference / $lengths[$j]);
        }

        $difference = round($difference);

        $remainders[] = $difference;

        $string = '';

        for ($i = count($remainders) - 1; $i >= 0; --$i) {
            if ($remainders[$i]) {
                // on last detail level get next period and round current
                if ($detailLevel == 1 && isset($remainders[$i - 1]) && $remainders[$i - 1] > $lengths[$i - 1] / 2) {
                    $remainders[$i]++;
                }
                $string .= $remainders[$i] . ' ' . $periods[$i];

                if ($remainders[$i] != 1) {
                    $string .= 's';
                }

                $string .= ' ';

                --$detailLevel;

                if ($detailLevel <= 0) {
                    break;
                }
            }
        }

        return $string . $tense;
    }

    /**
     * @param string $time
     *
     * @return string
     */
    public function formatDateTime($time)
    {
        return $this->formatDate(
            $time,
            \IntlDateFormatter::MEDIUM
        ) . ' ' . $this->formatTime(
                $time,
                \IntlDateFormatter::SHORT
            );
    }

    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Get website identifier
     *
     * @return string|int|null
     */
    public function getWebsiteId()
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }

    /**
     * Get Store code
     *
     * @return string
     */
    public function getStoreCode()
    {
        return $this->_storeManager->getStore()->getCode();
    }

    /**
     * Get Store name
     *
     * @return string
     */
    public function getStoreName()
    {
        return $this->_storeManager->getStore()->getName();
    }

    /**
     * Get current url for store
     *
     * @param bool|string $fromStore Include/Exclude from_store parameter from URL
     * @return string
     */
    public function getStoreUrl($fromStore = true)
    {
        return $this->_storeManager->getStore()->getCurrentUrl($fromStore);
    }

    /**
     * Check if store is active
     *
     * @return boolean
     */
    public function isStoreActive()
    {
        return $this->_storeManager->getStore()->isActive();
    }

    public function checkSpam($email, $data)
    {
        $subject = '';
        switch ($email->getData('scope')) {
            case 'headers':
                $subject = $data['customer_email'];
                break;
            case 'subject':
                if ($data['subject']) {
                    $subject = $data['subject'];
                } else {
                    $subject = '';
                }
                break;
            case 'body':
                if (isset($data['description'])) {
                    $subject = $data['description'];
                } elseif ($data['body']) {
                    $subject = $data['body'];
                }
                break;
        }

        $matches = [];
        preg_match($email->getPattern(), $subject, $matches);

        if (count($matches) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function xss_clean_array($data_array){
        $result = [];
        if(is_array($data_array)){
            foreach($data_array as $key=>$val){
                $val = $this->xss_clean($val);
                $result[$key] = $val;
            }
        }
        return $result;
    }
    public function xss_clean($data)
    {
        if(!is_string($data))
            return $data;
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
    }
}
