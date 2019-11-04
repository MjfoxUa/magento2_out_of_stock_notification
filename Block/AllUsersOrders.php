<?php


namespace Plumrocket\OutOfStock\Block;


use Magento\Framework\View\Element\Template;

class AllUsersOrders extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\Collection
     */
    private $customerCollection;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    private $orderCollectionFactory;

    public function __construct(Template\Context $context,
                                \Magento\Customer\Model\ResourceModel\Customer\Collection $customerCollection,
                                \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
                                array $data = [])
    {
        parent::__construct($context, $data);
        $this->customerCollection = $customerCollection;
        $this->orderCollectionFactory = $orderCollectionFactory;

    }

    /**
     * @return \Magento\Framework\DataObject[]
     */
    public function getAllCustomers()
    {
        return $this->customerCollection->getItems();
    }

    /**
     * @param $customerId
     * @return \Magento\Sales\Model\ResourceModel\Order\Collection
     */
    public function getOrders($customerId)
    {
        $orders = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_id', [
                'eq' => $customerId
            ])
            ->setOrder('created_at', 'desc');
        return $orders;
    }

}