<?php
include_once __DIR__ . '/../model/OrderItem.php';

class OrderItemController {
    private $orderItem;

    function __construct()
    {
        $this->orderItem = new OrderItem();
    }

    public function getItemsByOrderId($order_id)
    {
        return $this->orderItem->getItemsByOrderId($order_id);
    }

    public function getOrderItem($id)
    {
        return $this->orderItem->getOrderItem($id);
    }
}