<?php
include_once __DIR__ . '/../../controller/PaymentController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['payment_id'];
    $payment_controller = new PaymentController();
    
    if ($payment_controller->updatePaymentStatus($payment_id, 'Paid')) {
        header("Location: payment_list.php?status=confirmed");
    } else {
        header("Location: payment_list.php?status=error");
    }
    exit();
}