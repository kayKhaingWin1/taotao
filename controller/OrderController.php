<?php
include_once __DIR__ . '/../model/Order.php';

class OrderController
{
    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function createOrder($orderCode, $total, $date, $time, $userId, $townshipId)
    {
        return $this->order->createOrder($orderCode, $total, $date, $time, $userId, $townshipId);
    }

    public function getOrdersByUserId($user_id)
    {
        return $this->order->getOrdersByUserId($user_id);
    }

}
