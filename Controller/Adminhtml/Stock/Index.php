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
//        $resultPage = $this->resultPageFactory->create();
//        $resultPage->getConfig()->getTitle()->prepend((__('Out of Stock')));
//        return $resultPage;
        $this->_view->loadLayout();
                       $resultPage = $this->resultPageFactory->create();
                        $resultPage->getConfig()->getTitle()->prepend(__('Manage Out Of Stock'));
                        //$resultPage->setActiveMenu('Plumrocket_OutOfStock::Grid');
                        //$resultPage->addBreadcrumb(__('Grid Name Process'), __('Grid Name List'));
                        $this->_addContent($this->_view->getLayout()->createBlock('Plumrocket\OutOfStock\Block\Adminhtml\Stock\Grid'));
                        $this->_view->renderLayout();
    }
}