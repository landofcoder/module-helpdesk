<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
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
 *
 * @copyright  Copyright (c) 2016 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Block\Adminhtml\Ticket\Grid\Renderer\Action;

class UrlBuilder
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $frontendUrlBuilder;

    /**
     * @param \Magento\Framework\UrlInterface $frontendUrlBuilder
     */
    public function __construct(\Magento\Framework\UrlInterface $frontendUrlBuilder)
    {
        $this->frontendUrlBuilder = $frontendUrlBuilder;
    }

    /**
     * Get action url
     *
     * @param string $routePath
     * @param string $scope
     * @param string $store
     * @return string
     */
    public function getUrl($routePath, $scope, $store)
    {
        $this->frontendUrlBuilder->setScope($scope);
        $href = $this->frontendUrlBuilder->getUrl(
            $routePath,
            ['_current' => false, '_query' => '___store=' . $store]
        );
        return $href;
    }
}


