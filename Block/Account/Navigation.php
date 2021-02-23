<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_HelpDesk
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Account;

class Navigation extends \Magento\Framework\View\Element\Html\Link
{
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;

    /**
     *
     * @var Lof\HelpDesk\Model\CategoryFactory
     */
    protected $category;

    /**
     *
     * @var Lof\HelpDesk\Model\Ticket
     */
    protected $ticket;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Lof\HelpDesk\Model\Ticket $ticket,
        \Lof\HelpDesk\Model\Category $category,
        array $data = []
    )
    {
        $this->ticket = $ticket;
        $this->session = $customerSession;
        $this->category = $category;
        parent::__construct($context, $data);
    }

    public function isLogin()
    {
        if ($session->isLoggedIn()) {
            return true;
        }
        return false;
    }

    public function getCurrentUrl()
    {
        return $this->_urlBuilder->getCurrentUrl();
    }

    public function getCategory()
    {
        return $this->category->getCollection();
    }

    public function getTicket()
    {
        return $this->ticket->getCollection();
    }

    /**
     * Retrive image URL
     *
     * @return string
     */
    public function getAvatarUrl($image)
    {
        $url = false;
        if ($image) {
            $url = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $image;
        };
        return $url;
    }
}