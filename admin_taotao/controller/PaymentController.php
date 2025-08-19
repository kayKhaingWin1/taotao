<?php
include_once __DIR__ . '/../model/Payment.php';

class PaymentController {
    private $payment;

    public function __construct() {
        $this->payment = new Payment();
    }

    public function createPayment($order_id, $pm_id) {
        return $this->payment->createPayment($order_id, $pm_id);
    }

    public function getPaymentByOrder($order_id) {
        return $this->payment->getPaymentByOrder($order_id);
    }

    public function updatePaymentStatus($payment_id, $status) {
        return $this->payment->updatePaymentStatus($payment_id, $status);
    }

    public function getPaymentStatus($order_id) {
        $payment = $this->payment->getPaymentByOrder($order_id);
        return $payment ? $payment['status'] : 'Pending';
    }
public function getAllPaymentsWithDetails() {
    return $this->payment->getAllPaymentsWithDetails();
}
}