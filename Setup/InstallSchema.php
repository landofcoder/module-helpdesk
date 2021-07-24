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
namespace Lof\HelpDesk\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'lof_helpdesk_ticket'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('lof_helpdesk_ticket'))
            ->addColumn(
                'ticket_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Ticket Id'
            )
            ->addColumn(
                'code',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Code'
            )
            ->addColumn(
                'category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => false, 'nullable' => false],
                'Product Id'
            )
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                ['unsigned' => false, 'nullable' => false],
                'Product Id'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'User Id'
            )
            ->addColumn(
                'subject',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Subject'
            )
            ->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Description'
            )
            ->addColumn(
                'priority_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Priority Id'
            )
            ->addColumn(
                'status_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Status Id'
            )
            ->addColumn(
                'department_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Department Id'
            )
            ->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Customer Id'
            )
            ->addColumn(
                'quote_address_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Quote Address Id'
            )
            ->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Customer Email'
            )
            ->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Customer Name'
            )
            ->addColumn(
                'order_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Order Id'
            )
            ->addColumn(
                'last_reply_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Last Reply Name'
            )
            ->addColumn(
                'last_reply_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['unsigned' => false, 'nullable' => false],
                'Last Reply At'
            )
            ->addColumn(
                'reply_cnt',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Reply Cnt'
            )
            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true, 'nullable' => true],
                'Store Id'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            )
            ->addColumn(
                'folder',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 1],
                'Folder'
            )
            ->addColumn(
                'email_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Email Id'
            )
            ->addColumn(
                'rating',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => false, 'nullable' => false],
                'rating'
            )
            ->addColumn(
                'first_reply_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['unsigned' => false, 'nullable' => true],
                'First Reply At'
            )
            ->addColumn(
                'first_solved_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['unsigned' => false, 'nullable' => true],
                'First Solved At'
            )
            ->addColumn(
                'fp_period_unit',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Fp Period Unit'
            )
            ->addColumn(
                'fp_period_value',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Fp Period Value'
            )
            ->addColumn(
                'fp_execute_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Fp Execute At'
            )
            ->addColumn(
                'fp_is_remind',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Fp Is Remind'
            )
            ->addColumn(
                'fp_remind_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Fp Remind Email'
            )
            ->addColumn(
                'fp_priority_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Fp Priority Id'
            )
            ->addColumn(
                'fp_status_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Fp Status Id'
            )
            ->addColumn(
                'fp_department_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Fp Department Id'
            )
            ->addColumn(
                'fp_user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Fp User Id'
            )
            ->addColumn(
                'channel',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Channel'
            )
            ->addColumn(
                'channel_data',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Channel Data'
            )
            ->addColumn(
                'third_party_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Third Party Email'
            )
            ->addColumn(
                'search_index',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Search Index'
            )
            ->addColumn(
                'cc',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Cc'
            )
            ->addColumn(
                'bcc',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Bcc'
            )
            ->addColumn(
                'is_read',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Read'
            )
            ->addColumn(
                'merged_ticket_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Merged Ticket Id'
            );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_category'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_category')
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Category ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Category Title'
        )->addColumn(
            'cat_icon',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Category Icon'
        )->addColumn(
            'page_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Page Title'
        )->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Identifier'
        )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Description'
        )->addColumn(
            'grid_column',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Grid Column'
        )->addColumn(
            'layout_type',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Layout Type'
        )->addColumn(
            'page_layout',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Page Layout'
        )->addColumn(
            'meta_keywords',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Page Meta Keywords'
        )->addColumn(
            'meta_description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Page Meta Description'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Category Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Category Modification Time'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => true],
            'Position'
        )->addColumn(
            'include_in_sidebar',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Include the block HelpDesk Category on Sidebar'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Is Category Active'
        )->addIndex(
            $setup->getIdxName(
                $installer->getTable('lof_helpdesk_category'),
                ['title'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'LOF HelpDesk Category Table'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_category_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_category_store')
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Category ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName('lof_helpdesk_category_store', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName('lof_helpdesk_category_store', 'category_id', 'lof_helpdesk_category', 'category_id'),
            'category_id',
            $installer->getTable('lof_helpdesk_category'),
            'category_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_helpdesk_category_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Lof HelpDesk Category To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_ticket_product'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_ticket_product')
        )->addColumn(
            'ticket_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Ticket ID'
        )->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Product ID'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => true],
            'Position'
        )->addIndex(
            $installer->getIdxName('lof_helpdesk_ticket_product', ['product_id']),
            ['product_id']
        )->setComment(
            'Lof HelpDesk Ticket To Product Linkage Table'
        );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_department'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_department')
        )->addColumn(
            'department_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Ticket ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Title'
        )->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Identifier'
        )->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Category Creation Time'
        )->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'Category Modification Time'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => true],
            'Position'
        )->addColumn(
            'is_active',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Is Category Active'
        )->setComment(
            'Lof HelpDesk Ticket To Category Linkage Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_department_store'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_department_store')
        )->addColumn(
            'department_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Department ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $installer->getIdxName('lof_helpdesk_department_store', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $installer->getFkName('lof_helpdesk_department_store', 'department_id', 'lof_helpdesk_department', 'department_id'),
            'department_id',
            $installer->getTable('lof_helpdesk_department'),
            'department_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $installer->getFkName('lof_helpdesk_department_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Lof HelpDesk Department To Store Linkage Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_quickanswer'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_quickanswer')
        )
            ->addColumn(
                'quickanswer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Spam Id'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Title'
            )
            ->addColumn(
                'content',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Content'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            )
            ->addColumn(
                'is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Active'
            );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_spam'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_spam')
        )
            ->addColumn(
                'spam_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Spam Id'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Name'
            )
            ->addColumn(
                'pattern',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Pattern'
            )
            ->addColumn(
                'scope',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Scope'
            )
            ->addColumn(
                'is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Active'
            );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_permission'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_permission')
        )
            ->addColumn(
                'permission_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Permission Id'
            )
            ->addColumn(
                'role_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Role Id'
            )
            ->addColumn(
                'is_ticket_remove_allowed',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Ticket Remove Allowed'
            )
            ->addIndex(
                $installer->getIdxName('lof_helpdesk_permission', ['role_id']),
                ['role_id']
            );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_permission_department'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_permission_department')
        )
            ->addColumn(
                'permission_department_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Permission Department Id'
            )
            ->addColumn(
                'permission_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false],
                'Permission Id'
            )
            ->addColumn(
                'department_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Department Id'
            )
            ->addIndex(
                $installer->getIdxName('lof_helpdesk_permission_department', ['permission_id']),
                ['permission_id']
            )
            ->addIndex(
                $installer->getIdxName('lof_helpdesk_permission_department', ['department_id']),
                ['department_id']
            );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_department_category'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_department_category')
        )->addColumn(
            'department_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Department ID'
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Category ID'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => true],
            'Position'
        )->addIndex(
            $installer->getIdxName('lof_helpdesk_department_category', ['category_id']),
            ['category_id']
        )->setComment(
            'Lof HelpDesk Ticket To Category Linkage Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_department_user'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_department_user')
        )->addColumn(
            'department_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'primary' => true],
            'Department ID'
        )->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'User ID'
        )->addIndex(
            $installer->getIdxName('lof_helpdesk_department_user', ['user_id']),
            ['user_id']
        )->setComment(
            'Lof HelpDesk Ticket To User Linkage Table'
        );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_department_category'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_message')
        )
            ->addColumn(
                'message_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Message Id'
            )
            ->addColumn(
                'ticket_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false],
                'Ticket Id'
            )
            ->addColumn(
                'email_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Email Id'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'User Id'
            )
            ->addColumn(
                'user_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'User Email'
            )
            ->addColumn(
                'user_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'User Name'
            )
            ->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Customer Id'
            )
            ->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Customer Email'
            )
            ->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Customer Name'
            )
            ->addColumn(
                'body',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Body'
            )
            ->addColumn(
                'body_format',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                5,
                ['unsigned' => false, 'nullable' => false],
                'Body Format'
            )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            )
            ->addColumn(
                'uid',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Uid'
            )
            ->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Type'
            )
            ->addColumn(
                'third_party_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Third Party Email'
            )
            ->addColumn(
                'third_party_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Third Party Name'
            )
            ->addColumn(
                'triggered_by',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Triggered By'
            )
            ->addColumn(
                'is_read',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Read'
            )
            ->addIndex(
                $installer->getIdxName('lof_helpdesk_message', ['ticket_id']),
                ['ticket_id']
            );

        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_attachment'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_attachment')
        )
            ->addColumn(
                'attachment_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Attachment Id'
            )
            ->addColumn(
                'email_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Email Id'
            )
            ->addColumn(
                'message_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Message Id'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Name'
            )
            ->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'Type'
            )
            ->addColumn(
                'size',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Size'
            )
            ->addColumn(
                'body',
                \Magento\Framework\DB\Ddl\Table::TYPE_BLOB,
                '4G',
                ['unsigned' => false, 'nullable' => true],
                'Body'
            )
            ->addColumn(
                'external_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => false],
                'External Id'
            )
            ->addColumn(
                'storage',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                'Storage'
            );
        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_user_like'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_user_like')
        )
            ->addColumn(
                'like_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Like Id'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'User Id'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Customer Id'
            )->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Email'
            )->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Name'
            )->addColumn(
                'message_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Message Id'
            );

        $installer->getConnection()->createTable($table);

        /**
         * Create table 'lof_helpdesk_chat'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_chat')
        )
            ->addColumn(
                'chat_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Chat Id'
            )
            ->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'User Id'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Customer Id'
            )->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Email'
            )->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Name'
            )->addColumn(
                'user_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'User Name'
            )->addColumn(
                'is_read',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Read'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            );
        $installer->getConnection()->createTable($table);
        /**
         * Create table 'lof_helpdesk_chat_message'
         */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('lof_helpdesk_chat_message')
        )
            ->addColumn(
                'message_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'identity' => true, 'primary' => true],
                'Chat Id'
            )
            ->addColumn(
                'chat_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Chat Id'
            )->addColumn(
                'user_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'User Id'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => true],
                'Customer Id'
            )->addColumn(
                'customer_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Email'
            )->addColumn(
                'customer_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Customer Name'
            )
            ->addColumn(
                'is_read',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => false, 'nullable' => false, 'default' => 0],
                'Is Read'
            )
            ->addColumn(
                'user_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'User Name'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )->addColumn(
                'body_msg',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64K',
                ['unsigned' => false, 'nullable' => true],
                'Body'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
