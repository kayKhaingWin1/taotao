<?php
include_once __DIR__ . '/../model/Order.php';

class OrderController {
    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function getOrders()
    {
        return $this->order->getOrdersWithStatus();
    }

    public function getOrder($id)
    {
        return $this->order->getOrder($id);
    }

    public function getOrderTotal($id)
    {
        return $this->order->getOrderTotal($id);
    }
}


?>