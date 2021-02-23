<?php
/**
 * Copyright © Landofcoder All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Lof\HelpDesk\Model\Data;

use Lof\HelpDesk\Api\Data\CategoryInterface;

class Category extends \Magento\Framework\Api\AbstractExtensibleObject implements CategoryInterface
{

    /**
     * Get lof_helpdesk_category_id
     * @return string|null
     */
    public function getCategoryId()
    {
        return $this->_get(self::LOF_HELPDESK_CATEGORY_ID);
    }

    /**
     * Set lof_helpdesk_category_id
     * @param string $CategoryId
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setCategoryId($CategoryId)
    {
        return $this->setData(self::LOF_HELPDESK_CATEGORY_ID, $CategoryId);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->_get(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Lof\HelpDesk\Api\Data\CategoryExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Lof\HelpDesk\Api\Data\CategoryExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Lof\HelpDesk\Api\Data\CategoryExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get cat_icon
     * @return string|null
     */
    public function getCatIcon()
    {
        return $this->_get(self::CAT_ICON);
    }

    /**
     * Set cat_icon
     * @param string $catIcon
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setCatIcon($catIcon)
    {
        return $this->setData(self::CAT_ICON, $catIcon);
    }

    /**
     * Get page_title
     * @return string|null
     */
    public function getPageTitle()
    {
        return $this->_get(self::PAGE_TITLE);
    }

    /**
     * Set page_title
     * @param string $pageTitle
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setPageTitle($pageTitle)
    {
        return $this->setData(self::PAGE_TITLE, $pageTitle);
    }

    /**
     * Get identifier
     * @return string|null
     */
    public function getIdentifier()
    {
        return $this->_get(self::IDENTIFIER);
    }

    /**
     * Set identifier
     * @param string $identifier
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
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
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get grid_column
     * @return string|null
     */
    public function getGridColumn()
    {
        return $this->_get(self::GRID_COLUMN);
    }

    /**
     * Set grid_column
     * @param string $gridColumn
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setGridColumn($gridColumn)
    {
        return $this->setData(self::GRID_COLUMN, $gridColumn);
    }

    /**
     * Get layout_type
     * @return string|null
     */
    public function getLayoutType()
    {
        return $this->_get(self::LAYOUT_TYPE);
    }

    /**
     * Set layout_type
     * @param string $layoutType
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setLayoutType($layoutType)
    {
        return $this->setData(self::LAYOUT_TYPE, $layoutType);
    }

    /**
     * Get page_layout
     * @return string|null
     */
    public function getPageLayout()
    {
        return $this->_get(self::PAGE_LAYOUT);
    }

    /**
     * Set page_layout
     * @param string $pageLayout
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setPageLayout($pageLayout)
    {
        return $this->setData(self::PAGE_LAYOUT, $pageLayout);
    }

    /**
     * Get meta_keywords
     * @return string|null
     */
    public function getMetaKeywords()
    {
        return $this->_get(self::META_KEYWORDS);
    }

    /**
     * Set meta_keywords
     * @param string $metaKeywords
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setMetaKeywords($metaKeywords)
    {
        return $this->setData(self::META_KEYWORDS, $metaKeywords);
    }

    /**
     * Get meta_description
     * @return string|null
     */
    public function getMetaDescription()
    {
        return $this->_get(self::META_DESCRIPTION);
    }

    /**
     * Set meta_description
     * @param string $metaDescription
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setMetaDescription($metaDescription)
    {
        return $this->setData(self::META_DESCRIPTION, $metaDescription);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->_get(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->_get(self::CREATION_TIME);
    }

    /**
     * Set creation_time
     * @param string $creationTime
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->_get(self::UPDATE_TIME);
    }

    /**
     * Set update_time
     * @param string $updateTime
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Get position
     * @return string|null
     */
    public function getPosition()
    {
        return $this->_get(self::POSITION);
    }

    /**
     * Set position
     * @param string $position
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get include_in_sidebar
     * @return string|null
     */
    public function getIncludeInSidebar()
    {
        return $this->_get(self::INCLUDE_IN_SIDEBAR);
    }

    /**
     * Set include_in_sidebar
     * @param string $includeInSidebar
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setIncludeInSidebar($includeInSidebar)
    {
        return $this->setData(self::INCLUDE_IN_SIDEBAR, $includeInSidebar);
    }

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive()
    {
        return $this->_get(self::IS_ACTIVE);
    }

    /**
     * Set is_active
     * @param string $isActive
     * @return \Lof\HelpDesk\Api\Data\CategoryInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}

