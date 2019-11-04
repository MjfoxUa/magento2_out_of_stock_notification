<?php


namespace Plumrocket\OutOfStock\Controller\Result;


use Magento\Framework\Controller\Result\JsonFactory;

class Result extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    /**
     * @var
     */
    private $jsonFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
        )
    {
        $this->pageFactory = $pageFactory;
        $this->jsonFactory = $jsonFactory;
        return parent::__construct($context);
    }
    public function execute()
    {
        $email = $this->getRequest()->getParam('email');
        $output = $email.' result';
        $result = $this->jsonFactory->create();
        $resultPage = $this->pageFactory->create();

        $block = $resultPage->getLayout()
            ->createBlock('Plumrocket\OutOfStock\Block\ProductStockForm')
            ->setTemplate('Plumrocket_OutOfStock::result.phtml')
            ->setData('email',$email)
            ->toHtml();
        $result->setData(['output'=> $output]);
        return $result;
    }
}