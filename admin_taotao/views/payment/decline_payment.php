<?php
include_once __DIR__ . '/../../controller/PaymentController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_id = $_POST['payment_id'];
    $payment_controller = new PaymentController();
    
    if ($payment_controller->updatePaymentStatus($payment_id, 'Declined')) {
        header("Location: payment_list.php?status=declined");
    } else {
        header("Location: payment_list.php?status=error");
    }
    exit();
}