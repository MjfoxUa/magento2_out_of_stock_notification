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

namespace Relieve\OutOfStock\Controller\Index;

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
    /**
     * @var
     */
    private $collectionFactory;
    /**
     * @var
     */
    private $logger;

    public function __construct(
        \Relieve\OutOfStock\Model\DataOutStockFactory $dataOutStock,
        \Relieve\OutOfStock\Model\ResourceModel\CollectionFactory $collectionFactory,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
        $this->request = $request;
        $this->dataOutStock = $dataOutStock;
        $this->resultFactory = $resultFactory;
        $this->logger = $logger;
        return parent::__construct($context);
    }
    public function execute()
    {
        try{
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
                $dataOutOfStock = $this->collectionFactory->create();
                $dataOutOfStock->addFieldToFilter('product_id', $data['productId']);
                $dataOutOfStock->addFieldToFilter('customer_email', $data['email']);
                $dataOutOfStock->load();
                if (isset($dataOutOfStock
                        ->getFirstItem()
                        ->getData()['customer_email'])) {
                    $status = true;
                    $messagee = (__('This email is already registered.'));
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

                    $messagee = (__('Your email %1 has been saved for out of stock notification.', $data['email'] ));
                }
            }
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData(['result' => $messagee, 'status' => $status]);
            return $resultJson;
        } catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
        }
    }
}

