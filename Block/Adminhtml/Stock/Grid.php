<?php

namespace Plumrocket\OutOfStock\Block\Adminhtml\Stock;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Magento\Framework\ObjectManagerInterface;
use Plumrocket\OutOfStock\Model\ResourceModel\CollectionFactory as DemoCollection;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $registry;
    protected $_objectManager = null;
    protected $demoFactory;

    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;
    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    private $websiteFactory;

    public function __construct(
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Store\Model\WebsiteFactory $websiteFactory,
        Context $context,
        Data $backendHelper,
        Registry $registry,
        ObjectManagerInterface $objectManager,
        DemoCollection $demoFactory,
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        $this -> demoFactory = $demoFactory;
        $this->productRepository = $productRepository;
        $this->websiteFactory = $websiteFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    protected function _construct()
    {
              parent::_construct();
              $this->setId('index');
              $this->setDefaultSort('created_at');
              $this->setDefaultDir('DESC');
              $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
              $demo = $this->demoFactory->create();
              $this->setCollection($demo);
              return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
              $this->addColumn(
                  'website',
                  ['header' => __('Website'),
                      'type' => 'skip-list',
                      'sortable' => false,
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'name',
                      //'options' => [ '1' => 'website_name' ]
                  ]
              );
              $this->addColumn(
                  'name',
                  ['header' => __('Name'),
                      'type' => 'skip-list',
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'value',
                  ]
              );
                $this->addColumn(
                    'sku',
                    ['header' => __('SKU'),
                        'type' => 'skip-list',
                        'name' => 'id',
                        'align' => 'center',
                        'index' => 'sku',
                    ]
                );
        $this->addColumn(
            'max_crate_time',
            ['header' => __('Last Subscription'),
                'type' => 'skip-list',
                'name' => 'id',
                'align' => 'center',
                'index' => 'max_crate_time',
            ]
        );
              $this->addColumn(
                  'min_crate_time',
                  ['header' => __('First Subscription'),
                      'type' => 'skip-list',
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'min_crate_time',
                  ]
              );
                $this->addColumn(
                    'awaiting',
                    ['header' => __('Customer Awaiting Notification'),
                        'type' => 'skip-list',
                        'name' => 'id',
                        'align' => 'center',
                        'index' => 'awaiting',
                    ]
                );
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('product_id');
        $this->getMassactionBlock()->setUseAjax(true);
        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('sales_rule/*/couponsMassDelete', ['_current' => true]),
                'confirm' => __('Are you sure you want to delete the selected coupon(s)?'),
                'complete' => 'refreshCouponCodesGrid'
            ]
        );
        return $this;
    }

    /**
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('catalog/product/edit', ['id' => $row->getData('product_id')]);
    }
}
