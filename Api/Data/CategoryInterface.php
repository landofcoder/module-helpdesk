<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Api\Data;

interface CategoryInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const POSITION = 'position';
    const CAT_ICON = 'cat_icon';
    const INCLUDE_IN_SIDEBAR = 'include_in_sidebar';
    const PAGE_LAYOUT = 'page_layout';
    const IDENTIFIER = 'identifier';
    const GRID_COLUMN = 'grid_column';
    const LAYOUT_TYPE = 'layout_type';
    const TITLE = 'title';
    const META_DESCRIPTION = 'meta_description';
    const PAGE_TITLE = 'page_title';
    const LOF_HELPDESK_CATEGORY_ID = 'lof_helpdesk_category_id';
    const IMAGE = 'image';
    const CREATION_TIME = 'creation_time';
    const META_KEYWORDS = 'meta_keywords';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';
    const DESCRIPTION = 'description';

    /**
     * Get lof_helpdesk_category_id
     * @return string|null
     */
    public function getCategoryId();

    /**
     * Set lof_helpdesk_category_id
     * @param string $CategoryId
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setCategoryId($CategoryId);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setTitle($title);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\CategoryExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\CategoryExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\CategoryExtensionInterface $extensionAttributes
    );

    /**
     * Get cat_icon
     * @return string|null
     */
    public function getCatIcon();

    /**
     * Set cat_icon
     * @param string $catIcon
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setCatIcon($catIcon);

    /**
     * Get page_title
     * @return string|null
     */
    public function getPageTitle();

    /**
     * Set page_title
     * @param string $pageTitle
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setPageTitle($pageTitle);

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setIdentifier($identifier);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setDescription($description);

    /**
     * Get grid_column
     * @return string|null
     */
    public function getGridColumn();

    /**
     * Set grid_column
     * @param string $gridColumn
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setGridColumn($gridColumn);

    /**
     * Get layout_type
     * @return string|null
     */
    public function getLayoutType();

    /**
     * Set layout_type
     * @param string $layoutType
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setLayoutType($layoutType);

    /**
     * Get page_layout
     * @return string|null
     */
    public function getPageLayout();

    /**
     * Set page_layout
     * @param string $pageLayout
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setPageLayout($pageLayout);

    /**
     * Get meta_keywords
     * @return string|null
     */
    public function getMetaKeywords();

    /**
     * Set meta_keywords
     * @param string $metaKeywords
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * Get meta_description
     * @return string|null
     */
    public function getMetaDescription();

    /**
     * Set meta_description
     * @param string $metaDescription
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setMetaDescription($metaDescription);

    /**
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setImage($image);

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set creation_time
     * @param string $creationTime
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set update_time
     * @param string $updateTime
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Get position
     * @return string|null
     */
    public function getPosition();

    /**
     * Set position
     * @param string $position
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setPosition($position);

    /**
     * Get include_in_sidebar
     * @return string|null
     */
    public function getIncludeInSidebar();

    /**
     * Set include_in_sidebar
     * @param string $includeInSidebar
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setIncludeInSidebar($includeInSidebar);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setIsActive($isActive);
}

