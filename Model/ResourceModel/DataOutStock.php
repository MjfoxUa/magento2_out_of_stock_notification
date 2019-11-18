<?php


namespace Plumrocket\OutOfStock\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\AbstractResource;

class DataOutStock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("plumrocket_outofstock_info", "id");
    }
}