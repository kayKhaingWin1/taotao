<?php
include_once __DIR__ . '/../../controller/CategoryController.php';

$id = $_GET['id'];
$category_controller = new CategoryController();

$status = $category_controller->deleteCategory($id);
if($status)
{
    header('location: category_list.php?delete_status=success');
}
?>