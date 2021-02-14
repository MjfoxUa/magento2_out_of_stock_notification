<?php

namespace Relieve\OutOfStock\Helper;

use Magento\Framework\App\Helper;


class Cache extends Helper\AbstractHelper
{
    const CACHE_TAG = 'PLUMROCKET';
    const CACHE_ID = 'plumrocket';
    const CACHE_LIFETIME = 86400;

    /**
     * @var \Magento\Framework\App\Cache
     */
    private $cache;

    /**
     * @var \Magento\Framework\App\Cache\State
     */
    private $cacheState;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    private $storeId;

    public function __construct(
        Helper\Context $context,
        \Magento\Framework\App\Cache $cache,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->cache = $cache;
        $this->cacheState = $cacheState;
        $this->storeManager = $storeManager;
        $this->storeId = $storeManager->getStore()->getId();
        parent::__construct($context);
    }

    /**
     * @param $method
     * @param array $vars
     * @return string
     */
    public function getId($method, $vars = array())
    {
        return base64_encode($this->storeId . self::CACHE_ID . $method . implode('', $vars));
    }

    /**
     * @param $cacheId
     * @return bool|string
     */
    public function load($cacheId)
    {
        if ($this->cacheState->isEnabled(self::CACHE_ID)) {
            return $this->cache->load($cacheId);
        }
        return false;
    }

    /**
     * @param $data
     * @param $cacheId
     * @param int $cacheLifetime
     * @return bool
     */
    public function save($data, $cacheId, $cacheLifetime = self::CACHE_LIFETIME)
    {
        if ($this->cacheState->isEnabled(self::CACHE_ID)) {
            $this->cache->save($data, $cacheId, array(self::CACHE_TAG), $cacheLifetime);
            return true;
        }
        return false;
    }
}