<?php
header('Content-Type: application/json');
include_once 'controller/SubcategoryController.php';

if (isset($_GET['category_id'])) {
    $subCatCtrl = new SubcategoryController();
    $subcats = $subCatCtrl->getSubcategoriesByCategoryId($_GET['category_id']);
    echo json_encode($subcats);
} else {
    echo json_encode([]);
}
