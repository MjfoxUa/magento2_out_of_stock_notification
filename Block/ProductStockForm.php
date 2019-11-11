<?php

namespace Plumrocket\OutOfStock\Block;

class ProductStockForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Plumrocket\OutOfStock\Controller\Index\Config
     */
    private $config;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Registry $registry,
        \Plumrocket\OutOfStock\Controller\Index\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->config = $config;
        $this->customerSession = $customerSession;
        $this->_registry = $registry;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getEnableModul()
    {
        return $this->config->execute();
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    public function getCustomerName()
    {
        return $this->customerSession->getCustomer()->getName();
    }

    public function getStoreName()
    {
        return $this->storeManager->getStore()->getName();
    }

    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category');
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }

}