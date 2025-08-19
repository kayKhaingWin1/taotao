<?php
include_once __DIR__ . '/../../controller/ProductController.php';

$id = $_GET['id'];
$product_controller = new ProductController();
$status = $product_controller->deleteProduct($id);

if ($status) {
    header('location: product_list.php?delete_status=success');
} else {
    header('location: product_list.php?delete_status=fail');
}
exit;
