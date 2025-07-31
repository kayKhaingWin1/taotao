<?php
include_once __DIR__ . '/../model/OrderItem.php';

class OrderItemController
{
    private $orderItem;

    public function __construct()
    {
        $this->orderItem = new OrderItem();
    }

    public function createOrderItem($quantity, $price, $product_id, $order_id)
    {
        return $this->orderItem->createOrderItem($quantity, $price, $product_id, $order_id);
    }

    public function getItemsByOrderId($order_id)
    {
        return $this->orderItem->getItemsByOrderId($order_id);
    }
}
