<?php

namespace Plumrocket\OutOfStock\Block\Adminhtml;

class Stock extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_stock';
        $this->_blockGroup = 'Plumrocket_OutOfStock';
        $this->_headerText = __('PlumrocketAalerts');
        $this->_addButtonLabel = __('Save Changes');
        parent::_construct();
    }
}