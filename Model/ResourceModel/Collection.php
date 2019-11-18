<?php


namespace Plumrocket\OutOfStock\Model\ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            "Plumrocket\OutOfStock\Model\DataOutStock",
            "Plumrocket\OutOfStock\Model\ResourceModel\DataOutStock");

    }
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->columns(['awaiting' => 'COUNT(*)'])
            ->columns(['max_crate_time' => new \Zend_Db_Expr('MAX(main_table.created_at)')])
            ->columns(['min_crate_time' => new \Zend_Db_Expr('MIN(main_table.created_at)')])
            ->joinLeft(
                'catalog_product_entity',
                'main_table.product_id = catalog_product_entity.entity_id'
            )
            ->joinLeft(
                'store_group',
                'main_table.website_id = store_group.website_id'
            )
            ->joinLeft(
                'catalog_product_entity_varchar',
                'main_table.product_id = catalog_product_entity_varchar.entity_id
                        AND attribute_id = 73'
            )
            ->group('product_id')
            ->order('product_id');
        return $this;
    }
}