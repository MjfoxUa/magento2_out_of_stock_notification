<?php

namespace Plumrocket\OutOfStock\Model;

class DataOutStock extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init("Plumrocket\OutOfStock\Model\ResourceModel\DataOutStock");
    }
}