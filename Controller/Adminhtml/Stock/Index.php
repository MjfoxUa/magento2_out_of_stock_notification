<?php

namespace Plumrocket\OutOfStock\Controller\Adminhtml\Stock;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->_view->loadLayout();
                       $resultPage = $this->resultPageFactory->create();
                        $resultPage->getConfig()->getTitle()->prepend(__('Manage Out Of Stock'));
                        $this->_addContent($this->_view->getLayout()->createBlock('Plumrocket\OutOfStock\Block\Adminhtml\Stock\Grid'));
                        $this->_view->renderLayout();
    }
}