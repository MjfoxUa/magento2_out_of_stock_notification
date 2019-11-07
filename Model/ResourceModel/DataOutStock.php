<?php


namespace Plumrocket\OutOfStock\Model\ResourceModel;


class DataOutStock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
    $this->_init("plumrocket_outofstock_info","id");
    }
}