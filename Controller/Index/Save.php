<?php

namespace Plumrocket\OutOfStock\Controller\Index;

use Magento\Framework\Controller\Result\JsonFactory;

class Save extends \Magento\Framework\App\Action\Action
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    public function execute()
    {
        $request =  $this->getRequest()->isAjax();
        if (!$_POST['email']) {
            $result = 'Please enter email';
        } else {
            $result = 'Your email '.$_POST['email'].' has been saved for notification.';
        }
        echo json_encode(['result' => $result, 'request' => $request]);
    }
}