<?php
include_once __DIR__ . '/../model/PaymentMethod.php';

class PaymentMethodController
{
    private $paymentMethod;

    public function __construct()
    {
        $this->paymentMethod = new PaymentMethod();
    }

    public function getActiveMethods()
    {
        return $this->paymentMethod->getActiveMethods();
    }

  

}
