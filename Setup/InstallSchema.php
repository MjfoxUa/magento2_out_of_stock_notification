<?php
/**
 * Relieve Inc.
 * NOTICE OF LICENSE
 *
 * @package     Relieve_OutOfStock
 * @copyright   Copyright (c) 2021 Relieve Inc.
 * @license     End-user License Agreement
 */

declare(strict_types=1);

namespace Relieve\OutOfStock\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface   $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('relieve_outofstock_info')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('relieve_outofstock_info')
            )
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                255,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'auto_increment' => true,
                ],
                'ID'
            )
                ->addColumn(
                    'website_id',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Website ID'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Product ID'
                )
                ->addColumn(
                    'customer_id',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Customer ID'
                )
                ->addColumn(
                    'customer_email',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable => false'],
                    'Customer Email'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                );
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('relieve_outofstock_info'),
                $setup->getIdxName(
                    $installer->getTable('relieve_outofstock_info'),
                    ['website_id', 'product_name', 'product_url', 'customer_name', 'customer_email','sku' ],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['website_id', 'product_name', 'product_url', 'customer_name', 'customer_email','sku'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }

        $installer->endSetup();
    }
}
