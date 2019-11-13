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
          public function __construct(
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
              $demo = $this->demoFactory->create()
                  ->addFieldToSelect('*');
              $demo->addFieldToFilter('id', array('neq' => ''));
              $this->setCollection($demo);
              return parent::_prepareCollection();
          }
          protected function _prepareColumns()
          {
              $this->addColumn(
                  'id',
                  ['header' => __('ID'),
                    'type' => 'checkbox',
                    'name' => 'id',
                    'align' => 'center',
                    'index' => 'id',
                  ]
                );
              $this->addColumn(
                  'website',
                  ['header' => __('Website'),
                      'type' => 'text',
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'website',
                  ]
              );
              $this->addColumn(
                  'name',
                  ['header' => __('Product Name'),
                      'type' => 'text',
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'product_name',
                  ]
              );
              $this->addColumn(
                  'sku',
                  ['header' => __('SKU'),
                      'type' => 'text',
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'sku',
                  ]
              );
              $this->addColumn(
                  'create_at',
                  ['header' => __('Create at'),
                      'type' => 'text',
                      'name' => 'id',
                      'align' => 'center',
                      'index' => 'created_at',
                  ]
              );
              $this->addColumn(
                  'edit',
                  [
                      'header' => __('Edit'),
                      'type' => 'action',
                      'getter' => 'getId',
                      'actions' => [
                          [
                              'caption' => __('Edit'),
                              'url' => [
                                  'base' => '*/*/edit',
                                  'params' => ['store' => $this->getRequest()->getParam('store')]
                              ],
                              'field' => 'id'
                          ]
                      ],
                      'filter' => false,
                      'sortable' => false,
                      'index' => 'stores',
                      'header_css_class' => 'col-action',
                      'column_css_class' => 'col-action'
                  ]
              );
              return parent::_prepareColumns();
          }
}