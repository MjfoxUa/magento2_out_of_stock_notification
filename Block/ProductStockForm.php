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

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_registry = $registry;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }

    public function getEmailData()
    {
        return $this->getEmail();
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