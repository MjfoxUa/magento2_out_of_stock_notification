<?php

namespace Plumrocket\OutOfStock\Model;

use \Magento\Framework\Model\AbstractModel;

class DataOutStock extends AbstractModel
{
    public function _construct()
    {
        $this->_init("Plumrocket\OutOfStock\Model\ResourceModel\DataOutStock");
    }
}