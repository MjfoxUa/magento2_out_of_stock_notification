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
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Relieve\OutOfStock\Controller\Index\Config;

class ProductStockForm extends Template
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
     * @param \Magento\Backend\Block\Template\Context     $context
     * @param \Magento\Customer\Model\Session             $customerSession
     * @param \Magento\Framework\Registry                 $registry
     * @param \Relieve\OutOfStock\Controller\Index\Config $config
     * @param \Magento\Store\Model\StoreManagerInterface  $storeManager
     * @param array                                       $data
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        Registry $registry,
        Config $config,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->config = $config;
        $this->customerSession = $customerSession;
        $this->_registry = $registry;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
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
