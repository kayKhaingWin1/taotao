<?php
include_once __DIR__ . '/../../controller/PaymentMethodController.php';
$controller = new PaymentMethodController();

$id = $_GET['id'];
if ($controller->deletePaymentMethod($id)) {
    header('location: payment_method_list.php?delete_status=success');
    exit;
}
