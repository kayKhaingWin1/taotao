<?php
include_once __DIR__ . '/../model/Subcategory.php';

class SubcategoryController {
    private $subcategory;

    public function __construct() {
        $this->subcategory = new Subcategory();
    }

    public function getSubcategories() {
        return $this->subcategory->getSubcategories();
    }

    public function getSubcategoriesByCategoryId($categoryId) {
        return $this->subcategory->getSubcategoriesByCategoryId($categoryId);
    }
}
?>
