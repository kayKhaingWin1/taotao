<?php
include_once __DIR__ . '/../../controller/BrandController.php';

$id = $_GET['id'];
$brand_controller = new BrandController();

$status = $brand_controller->deleteBrand($id);
if ($status) {
    header('location: brand_list.php?delete_status=success');
    exit;
} else {
    header('location: brand_list.php?delete_status=fail');
    exit;
}
?>
