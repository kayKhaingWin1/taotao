<?php
include_once __DIR__ . '/../../controller/SubcategoryController.php';

$id = $_GET['id'];
$subcategory_controller = new SubcategoryController();

$status = $subcategory_controller->deleteSubcategory($id);
if ($status) {
    header('location: subcategory_list.php?delete_status=success');
    exit;
} else {
    header('location: subcategory_list.php?delete_status=fail');
    exit;
}
?>
