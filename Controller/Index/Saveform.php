<?php

namespace Plumrocket\OutOfStock\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

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
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->customerSession = $customerSession;
        $this->request = $request;
        $this->dataOutStock = $dataOutStock;
        $this->resultFactory = $resultFactory;
        return parent::__construct($context);
    }
    public function execute()
    {

        if (!$this->customerSession->isLoggedIn()) {
            $customerId = 'guest';
        } else {
            $customerId = $this->customerSession->getCustomer()->getId();
        }

        $data = $this->request->getPost();
        if (!$data['email']) {
            $status = false;
            $messagee = (__('Please enter email'));
        } else {
            $model = $this->dataOutStock->create();
            $model->addData([
                'website_id' => $data['storeId'],
                'product_id' => $data['productId'],
                'customer_id' => $customerId,
                'customer_email' => $data['email'],
            ]);
            $model->save();
            $status = true;
            $messagee = (__('Your email '.$data['email'].'has been saved for notification.'));
        }
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(['result' => $messagee, 'status' => $status]);
        return $resultJson;
    }
}