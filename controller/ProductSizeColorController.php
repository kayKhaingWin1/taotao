<?php
include_once __DIR__ . '/../model/ProductSizeColor.php';

class ProductSizeColorController
{
    private $psc;

    public function __construct()
    {
        $this->psc = new ProductSizeColor();
    }


    public function getByProductId($productId)
    {
        return $this->psc->getByProductId($productId);
    }
}
