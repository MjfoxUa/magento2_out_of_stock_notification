<?php


namespace Plumrocket\OutOfStock\Model\ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            "Plumrocket\OutOfStock\Model\DataOutStock",
            "Plumrocket\OutOfStock\Model\ResourceModel\DataOutStock");
    }
    protected function _initSelect()
    {
        parent::_initSelect();
        return $this;
    }
}