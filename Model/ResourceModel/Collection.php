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

namespace Relieve\OutOfStock\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            "Relieve\OutOfStock\Model\DataOutStock",
            "Relieve\OutOfStock\Model\ResourceModel\DataOutStock");
    }

    /**
     * @return $this|Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        return $this;
    }
}