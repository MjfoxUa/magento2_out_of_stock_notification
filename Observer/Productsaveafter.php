<?php

namespace Plumrocket\OutOfStock\Observer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\ObserverInterface;

class Productsaveafter implements ObserverInterface
{

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;
    /**
     * @var Plumrocket\OutOfStock\Model\ResourceModel\CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        \Magento\Framework\Registry $registry,
        \Plumrocket\OutOfStock\Model\ResourceModel\CollectionFactory $collectionFactory
    ) {

        $this->registry = $registry;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /**
         * @var Product $product
         */
        $product = $observer->getProduct();
        $productId = $product->getId();
        $dataStock = $this->collectionFactory->create();
        $dataFiltered = $dataStock->addFieldToFilter('product_id', ['in' => $productId ]);

    //    foreach ($dataFiltered as $item){
        echo '<pre>';
            var_dump($dataFiltered->getData());
        echo '</pre>';
    //    }
            exit;
    }
}
