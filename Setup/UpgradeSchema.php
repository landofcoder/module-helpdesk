<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
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
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\HelpDesk\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * @codeCoverageIgnore
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getTable('lof_helpdesk_chat');
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $installer->getConnection()->addColumn(
                $table,
                'ip',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Ip'
                ]
            );

            $installer->getConnection()->addColumn(
                $table,
                'number_message',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'length' => 11,
                    'nullable' => true,
                    'comment' => 'Number Message'
                ]
            );
        }
        /**
         * Upgrade version 1.0.5
         */
        if (version_compare($context->getVersion(), '1.0.5', '<')) {
            /**
             * add new table lof_helpdesk_blacklist
             */
            $lof_helpdesk_blacklist = $installer->getConnection()->newTable(
                    $installer->getTable('lof_helpdesk_blacklist')
                )->addColumn(
                    'blacklist_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                    ],
                    'Blacklist ID'
                )->addColumn(
                    'customer_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => false, 'nullable' => true],
                    'Customer Id'
                )->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Email'
                )->addColumn(
                    'ip',
                    Table::TYPE_TEXT,
                    100,
                    ['nullable' => true],
                    'IP'
                )->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => 1],
                    'Status'
                )->addColumn(
                    'note',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => true],
                    'Note'
                )->addColumn(
                    'created_time',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created Time'
                )
                ->addColumn(
                    'updated_time',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Modification Time'
                );
                $installer->getConnection()->createTable($lof_helpdesk_blacklist);

                /**
                 * update table lof_helpdesk_chat
                 */
                $lof_helpdesk_chat = $installer->getTable('lof_helpdesk_chat');
                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'user_agent',
                    [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length'   => 255,
                        'nullable' => true,
                        'comment'  => 'User Agent'
                    ]
                );
    
                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'browser',
                    [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length'   => 100,
                        'nullable' => true,
                        'comment'  => 'Browser Info'
                    ]
                );
    
                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'os',
                    [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length'   => 255,
                        'nullable' => true,
                        'comment'  => 'Os Info'
                    ]
                );
    
                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'country',
                    [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length'   => 50,
                        'nullable' => true,
                        'comment'  => 'Country Info'
                    ]
                );
    
                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'phone_number',
                    [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length'   => 50,
                        'nullable' => true,
                        'comment'  => 'Phone Number Info'
                    ]
                );

    
                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'current_url',
                    [
                        'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'length'   => 255,
                        'nullable' => true,
                        'comment'  => 'Current Url'
                    ]
                );

                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'status',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '1',
                        'comment' => 'Status'
                    ]
                );

                $installer->getConnection()->addColumn(
                    $lof_helpdesk_chat,
                    'answered',
                [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '1',
                        'comment' => 'Answered'
                    ]
                );
        }

        /**
         * Upgrade version 1.0.6
         */
        if (version_compare($context->getVersion(), '1.0.6', '<')) {
            $lof_helpdesk_chat = $installer->getTable('lof_helpdesk_chat');
            $installer->getConnection()->addColumn(
                $lof_helpdesk_chat,
                'category_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Ticket Category Id'
                ]
            );
            $installer->getConnection()->addColumn(
                $lof_helpdesk_chat,
                'ticket_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Linked to Ticket Id'
                ]
            );
            $installer->getConnection()->addColumn(
                $lof_helpdesk_chat,
                'department_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'unsigned' => true,
                    'nullable' => true,
                    'default' => 0,
                    'comment' => 'Ticket Department Id'
                ]
            );
        }
        /**
         * Upgrade version 1.0.7
         */
        if (version_compare($context->getVersion(), '1.0.7', '<')) {
            $lof_helpdesk_ticket = $installer->getTable('lof_helpdesk_ticket');
            $installer->getConnection()->addColumn(
                $lof_helpdesk_ticket,
                'admin_note',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'length'   => "64k",
                    'default' => "",
                    'comment' => 'Ticket Admin Note'
                ]
            );
        }
        $installer->endSetup();
    }
}
