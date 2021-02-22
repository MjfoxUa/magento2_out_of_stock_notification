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

namespace Relieve\OutOfStock\Controller\Adminhtml\Stock;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Relieve\OutOfStock\Model\ResourceModel\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
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