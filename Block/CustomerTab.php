<?php


namespace Plumrocket\OutOfStock\Block;

class CustomerTab extends \Magento\Framework\View\Element\Template
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
    /**
     * @var \Plumrocket\OutOfStock\Model\ResourceModel\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    private $productRepository;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    private $productloader;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ProductFactory $productloader,
        \Plumrocket\OutOfStock\Model\ResourceModel\CollectionFactory $collectionFactory,
        \Plumrocket\OutOfStock\Controller\Index\Config $config,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
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
        return $outOfStock->getData();
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
