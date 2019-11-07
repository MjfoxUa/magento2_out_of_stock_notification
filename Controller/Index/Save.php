<?php

namespace Plumrocket\OutOfStock\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Framework\App\Action\Action
{

    /**
     * @var
     */
    private $request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->request = $request;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }
    public function execute()
    {
        $data =  $this->request->getPost();
        if (!$data['email']) {
            $result = 'Please enter email';
            $this->messageManager->addError('Please enter email');
        } else {
            $result = 'Your email '.$data['email'].' has been saved for notification.';
            $this->messageManager->addSuccess('Your email '.$data['email'].' has been saved for notification.');
        }

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(['result' => $result]);
        return $resultJson;
    }
}