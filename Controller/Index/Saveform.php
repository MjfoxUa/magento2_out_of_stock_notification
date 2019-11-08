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
    /**
     * @var
     */
    private $request;
    /**
     * @var
     */
    private $customerSession;

    public function __construct(
        \Plumrocket\OutOfStock\Model\DataOutStockFactory $dataOutStock,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->customerSession = $customerSession;
        $this->request = $request;
        $this->dataOutStock = $dataOutStock;
        $this->resultFactory = $resultFactory;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    public function execute()
    {
        if (!$this->customerSession->isLoggedIn()) {
            $customerName = 'guest';
        } else {
            $customerName = $this->customerSession->getCustomer()->getName();
        }

        $data = $this->request->getPost();
        if (!$data['email']) {
            $status = false;
            $messagee = 'Please enter email';
        } else {
            $model = $this->dataOutStock->create();
            $model->addData([
                "website" => $data['storeName'],
                "product_name" => $data['productName'],
                "product_url" => $data['productUrl'],
                "customer_name" => $customerName,
                "customer_email" => $data['email'],
                "sku" => $data['productSku']
            ]);
            $model->save();
            $status = true;
            $messagee = "Your email ".$data['email']."has been saved for notification.";

        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(['result' => $messagee, 'status' => $status]);
        return $resultJson;
    }
}