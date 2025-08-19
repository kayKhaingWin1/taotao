<?php
include_once __DIR__ . '/../model/Product.php';

class ProductController {
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function getProducts()
    {
        return $this->product->getProducts();
    }

    public function addProduct($name, $price, $description, $image, $brand_id, $sub_id)
    {
        return $this->product->addProduct($name, $price, $description, $image, $brand_id, $sub_id);
    }

    public function getProduct($id)
    {
        return $this->product->getProduct($id);
    }

    public function editProduct($id, $name, $price, $description, $image, $brand_id, $sub_id)
    {
        return $this->product->editProduct($id, $name, $price, $description, $image, $brand_id, $sub_id);
    }

    public function deleteProduct($id)
    {
        return $this->product->deleteProduct($id);
    }

    public function getColorSizes($product_id)
    {
        return $this->product->getColorSizesByProduct($product_id);
    }

    public function addProductColorSize($product_id, $color_id, $size_id)
    {
        return $this->product->addProductColorSize($product_id, $color_id, $size_id);
    }

    public function deleteProductColorSize($product_id)
    {
        return $this->product->deleteProductColorSize($product_id);
    }

    public function getDiscountByProductId($product_id)
    {
        return $this->product->getDiscountByProductId($product_id);
    }

    public function addDiscountToProduct($product_id, $discount_id)
    {
        return $this->product->addDiscountToProduct($product_id, $discount_id);
    }

    public function deleteDiscountFromProduct($product_id)
    {
        return $this->product->deleteDiscountFromProduct($product_id);
    }

    public function getLastInsertedProductId()
    {
        return $this->product->getLastInsertedId();
    }
}
