<?php

namespace Plumrocket\OutOfStock\Model\ResourceModel\ManageStock\Grid;

use Plumrocket\OutOfStock\Model\ResourceModel\Collection as GridCollection;
use Magento\Framework\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Plumrocket\OutOfStock\Model\ResourceModel\DataOutStock;
use Magento\Framework\Api\SearchCriteriaInterface;

class Collection extends GridCollection implements \Magento\Framework\Api\Search\SearchResultInterface
{
    protected $aggregations;

    public function _construct()
    {
        $this->_init(Document::class, DataOutStock::class);
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
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