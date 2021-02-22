<?php
/**
 * Relieve Inc.
 * NOTICE OF LICENSE
 *
 * @package     Relieve_OutOfStock
 * @copyright   Copyright (c) 2021 Relieve Inc.
 * @license     End-user License Agreement
 */

namespace Relieve\OutOfStock\Controller\Index;

use Magento\Framework\App\Action\Context;
use \Magento\Framework\App\ActionInterface;
use Relieve\OutOfStock\Helper\Data;

class Config implements ActionInterface
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Relieve\OutOfStock\Helper\Data       $helperData
     */
    public function __construct(
        Context $context,
        Data $helperData
    ) {
        $this->helperData = $helperData;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|mixed
     */
    public function execute()
    {
        return $this->helperData->getGeneralConfig('enable');
    }
}