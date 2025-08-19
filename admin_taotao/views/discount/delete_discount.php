<?php
include_once __DIR__ . '/../../controller/DiscountController.php';

$id = $_GET['id'];
$discount_controller = new DiscountController();

$status = $discount_controller->deleteDiscount($id);
if ($status) {
    header('location: discount_list.php?delete_status=success');
}
?>
