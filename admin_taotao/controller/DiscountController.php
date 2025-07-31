<?php
include_once __DIR__ . '/../model/Discount.php';

class DiscountController {
    private $discount;

    public function __construct()
    {
        $this->discount = new Discount();
    }

    public function getDiscounts()
    {
        return $this->discount->getDiscounts();
    }

    public function getDiscount($id)
    {
        return $this->discount->getDiscount($id);
    }

    public function addDiscount($discount, $voucher_code)
    {
        return $this->discount->addDiscount($discount, $voucher_code);
    }

    public function editDiscount($id, $discount, $voucher_code)
    {
        return $this->discount->editDiscount($id, $discount, $voucher_code);
    }

    public function deleteDiscount($id)
    {
        return $this->discount->deleteDiscount($id);
    }

    public function getLastInsertedDiscountId()
    {
        return $this->discount->getLastInsertedId();
    }
}
