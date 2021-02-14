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

namespace Relieve\OutOfStock\Model\ResourceModel\ManageStock\Grid;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;
use Relieve\OutOfStock\Model\ResourceModel\Collection as GridCollection;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Relieve\OutOfStock\Model\ResourceModel\DataOutStock;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ResourceConnection;


class Collection extends GridCollection implements SearchResultInterface
{
    /**
     * @var \Magento\Framework\Api\Search\AggregationInterface
     */
    protected $aggregations;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null          $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null    $resource
     * @param \Magento\Framework\App\ResourceConnection                    $resourceConnection                                           $resourceConnection
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null,
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     *
     */
    public function _construct()
    {
        $this->_init(Document::class, DataOutStock::class);
    }

    /**
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @param AggregationInterface $aggregations
     * @return AggregationInterface|Collection
     */
    public function setAggregations($aggregations)
    {
        return $this->aggregations = $aggregations;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol(
            $this->_getAllIdsSelect($limit, $offset),
            $this->_bindParams);
    }

    /**
     * @return null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return $this|Collection
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @param int $totalCount
     * @return $this|Collection
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @param array|null $items
     * @return $this|Collection
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * Count customer awaiting notification for each product.
     *
     * @return $this|GridCollection|Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $catalogProductEntity = $this->resourceConnection->getTableName('catalog_product_entity');
        $storeGroup = $this->resourceConnection->getTableName('store_group');
        $catalogProductEntityVarchar = $this->resourceConnection->getTableName('catalog_product_entity_varchar');

        $this->getSelect()
            ->columns(['awaiting' => 'COUNT(*)'])
            ->columns(['max_crate_time' => new \Zend_Db_Expr('MAX(main_table.created_at)')])
            ->columns(['min_crate_time' => new \Zend_Db_Expr('MIN(main_table.created_at)')])
            ->joinLeft(
                $catalogProductEntity,
                'main_table.product_id = ' . $catalogProductEntity . '.entity_id'
            )
            ->joinLeft(
                $storeGroup,
                'main_table.website_id = ' . $storeGroup . '.website_id'
            )
            ->joinLeft(
                $catalogProductEntityVarchar,
                'main_table.product_id = ' . $catalogProductEntityVarchar . '.entity_id
                        AND attribute_id = 73'
            )
            ->group('product_id')
            ->order('product_id');

        return $this;
    }
}
