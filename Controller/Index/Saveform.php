<?php

namespace Plumrocket\OutOfStock\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
use Plumrocket\OutOfStock\Model\DataOutStock;

class Saveform extends \Magento\Framework\App\Action\Action
{
    /**
     * @var
     */
    private $dataOutStock;

    public function __construct(
        \Plumrocket\OutOfStock\Model\DataOutStockFactory $dataOutStock,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->dataOutStock = $dataOutStock;
        $this->resultFactory = $resultFactory;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        $model = $this->dataOutStock->create();
        $model->addData([
            "website" => 'test',
            "product_name" => 'test_product',
            "product_url" => 'test_product_url',
            "customer_name" => 'test_customer_name',
            "customer_email" => 'test_customer_email',
            "sku" => 'test_sku'
        ]);
        $saveData = $model->save();
        if($saveData )
        {
            $this->messageManager->addSuccess( __('Insert Record Successfully !') );
        }
        return $resultRedirect;
    }
}