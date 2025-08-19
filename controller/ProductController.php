<?php
include_once __DIR__ . '/../model/Product.php';

class ProductController
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function getProducts()
    {
        return $this->product->getProducts();
    }

    public function getProduct($id)
{
    return $this->product->getProduct($id);
}


    public function getFilteredProducts($keyword = null, $filters = [], $sort = null,$categoryId=null)
    {
        return $this->product->getFilteredProducts($keyword, $filters, $sort,$categoryId);
    }
}
