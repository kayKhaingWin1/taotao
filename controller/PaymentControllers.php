<?php
include_once __DIR__ . '/../model/Payment.phps';

class PaymentControllers
{
    private $payment;

    function __construct()
    {
        $this->payment = new Payments();
    }

    public function createPayment($payment_method_id, $order_id)
    {
        return $this->payment->createPayment($payment_method_id, $order_id);
    }
    public function getPaymentMethod($method)
    {
        return $this->payment->getPaymentMethod($method);
    }
   
}
