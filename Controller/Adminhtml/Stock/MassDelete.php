<?php

namespace Relieve\OutOfStock\Controller\Adminhtml\Stock;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Relieve\OutOfStock\Model\ResourceModel\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $collection = $this->collectionFactory->create();
        if ($deleteIds = $this->getRequest()->getParam('selected')
        ) {
            $collection->addFieldToFilter('product_id', ['in' => $deleteIds ]);
            $collectionSize = $collection->getSize();
            foreach ($collection as $item) {
                $item->delete();
            }
        } else {
            $collectionSize = $collection->getSize();
            foreach ($collection as $item) {
                $item->delete();
            }
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('outofstock/index/index');
    }
}