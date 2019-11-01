<?php


namespace Plumrocket\OutOfStock\Plugins;


class Outofstock
{
    public function aftergetName( \Magento\Catalog\Model\Product  $product, $name)
    {
        $price = $product->getData('price');
        if($price < 40){
            $name .= " Salable";
        } else {
            $name .= " No salable";
        }
        return $name;
    }
}