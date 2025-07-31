<?php
include_once __DIR__ . '/../model/Discount.php';

class DiscountController {
    private $discount;

    public function __construct() {
        $this->discount = new Discount();
    }

    public function getDiscountsByProductId($productId) {
        return $this->discount->getDiscountsByProductId($productId);
    }
}
