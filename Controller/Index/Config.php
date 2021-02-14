<?php

namespace Relieve\OutOfStock\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Relieve\OutOfStock\Helper\Data $helperData
    ) {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function execute()
    {
        return $this->helperData->getGeneralConfig('enable');
    }
}