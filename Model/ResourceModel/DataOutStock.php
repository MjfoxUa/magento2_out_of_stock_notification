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

use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DataOutStock extends AbstractDb
{
    /**
     * Resource model initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init("relieve_outofstock_info", "id");
    }
}

