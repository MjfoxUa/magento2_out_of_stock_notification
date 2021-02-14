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

namespace Relieve\OutOfStock\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Relieve\OutOfStock\Controller\Index\Config;
use Relieve\OutOfStock\Helper\Cache;
use Relieve\OutOfStock\Model\ResourceModel\CollectionFactory;

class CustomerTab extends Template
{
    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ProductFactory
     */
    private $productloader;
    /**
     * @var Cache
     */
    private $cacheHelper;

    /**
     * @param \Magento\Backend\Block\Template\Context                   $context
     * @param \Magento\Customer\Model\Session                           $customerSession
     * @param \Magento\Framework\Registry                               $registry
     * @param \Magento\Catalog\Model\ProductRepository                  $productRepository
     * @param \Magento\Catalog\Model\ProductFactory                     $productloader
     * @param \Relieve\OutOfStock\Model\ResourceModel\CollectionFactory $collectionFactory
     * @param \Relieve\OutOfStock\Controller\Index\Config               $config
     * @param \Magento\Store\Model\StoreManagerInterface                $storeManager
     * @param \Relieve\OutOfStock\Helper\Cache                          $cacheHelper
     * @param array                                                     $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Registry $registry,
        ProductRepository $productRepository,
        ProductFactory $productloader,
        CollectionFactory $collectionFactory,
        Config $config,
        StoreManagerInterface $storeManager,
        Cache $cacheHelper,
        array $data = []
    ) {
        $this->cacheHelper = $cacheHelper;
        $this->productloader = $productloader;
        $this->productRepository = $productRepository;
        $this->collectionFactory = $collectionFactory;
        $this->config = $config;
        $this->customerSession = $customerSession;
        $this->_registry = $registry;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getCurrentCustomer()
    {
         return $this->customerSession->getCustomer()->getId();
    }
    
    public function getStockData($id)
    {
        $outOfStock = $this->collectionFactory->create();
        $outOfStock->addFieldToFilter('customer_id',$id);
        $cacheId =$this->cacheHelper->getId('data_outofstock');
        if($cache = $this->cacheHelper->load($cacheId)){
            $cache = json_decode($cache, true);
            return $cache;
        }
        $outOfStockData = $outOfStock->getData();
        $this->cacheHelper->save(json_encode($outOfStockData),$cacheId);
        return $outOfStockData;
    }

    public function getProductNameById($id)
    {
         $product = $this->productRepository->getById($id);
         return  $product->getName();
    }

    public function getStoreNameById($id)
    {
        return $this->storeManager->getStore($id)->getName();
    }

    public function getProductUrl($id)
    {
        $product = $this->productloader->create()->load($id);
        return  $product->getProductUrl();
    }
}

