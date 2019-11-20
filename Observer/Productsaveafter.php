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
    /**
     * @var \Plumrocket\OutOfStock\Controller\Index\Config
     */
    private $config;
    /**
     * @var \Magento\Framework\App\Action\Context
     */
    private $context;
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    private $inlineTranslation;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\Escaper
     */
    private $escaper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\Registry $registry,
        \Plumrocket\OutOfStock\Model\ResourceModel\CollectionFactory $collectionFactory,
        \Plumrocket\OutOfStock\Controller\Index\Config $config

    ) {

        $this->registry = $registry;
        $this->collectionFactory = $collectionFactory;
        $this->config = $config;
        $this->context = $context;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->config->execute()){
        /**
         * @var Product $product
         */
        if($product->isAvailable()){

        }
        $product = $observer->getProduct();
        $productId = $product->getId();
        $dataStock = $this->collectionFactory->create();
        $dataFiltered = $dataStock->addFieldToFilter('product_id', $productId);
        $dataMail['product_name'] = $product->getName();

        var_dump();
        exit;

        foreach ($dataFiltered->getData() as $data){
            $emailData[] = $data['customer_email'];
        }
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($dataMail);
        $sender = [
            'name' => $this->escaper->escapeHtml('Out Of Stock Notification'),
            'email' => $this->escaper->escapeHtml('cookies.lana@gmail.com'),
        ];
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $transport = $this->transportBuilder
            ->setTemplateIdentifier('outofstock_alert_email_template')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
           ->setTemplateVars([ 'data' => $postObject ])
            ->setFrom($sender)
            ->addTo($emailData)
            ->getTransport();
            $transport->sendMessage();
            return;
        }
    }
}
