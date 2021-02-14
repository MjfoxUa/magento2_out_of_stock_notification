<?php


namespace Relieve\OutOfStock\Ui\Component\Listing\Column;


class RowUrlAction extends \Magento\Ui\Component\Listing\Columns\Column
{
    const URL_PATH_EDIT = 'Relieve/RowUrl/edit';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * constructor
     *
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }


    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $storeId = $this->context->getFilterParam('store_id');
            if (isset($dataSource['data']['items'])) {
                foreach ($dataSource['data']['items'] as &$item) {
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            'catalog/product/edit',
                            ['id' => $item['entity_id'], 'store' => $storeId]
                        ),
                        'label' => __('Edit Product'),
                        'hidden' => false,
                        '__disableTmpl' => true
                    ];
                }
            }
            return $dataSource;
        }
    }
}