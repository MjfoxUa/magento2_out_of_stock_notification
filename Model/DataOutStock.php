<?php

namespace Relieve\OutOfStock\Model;

use \Magento\Framework\Model\AbstractModel;

class DataOutStock extends AbstractModel
{
    public function _construct()
    {
        $this->_init("Relieve\OutOfStock\Model\ResourceModel\DataOutStock");
    }
}
