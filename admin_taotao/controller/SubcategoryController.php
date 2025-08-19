<?php
include_once __DIR__ . '/../model/Subcategory.php';

class SubcategoryController {
    private $subcategory;

    function __construct()
    {
        $this->subcategory = new Subcategory();
    }

    public function getSubcategories()
    {
        return $this->subcategory->getSubcategories();
    }

    public function addSubcategory($name, $image, $cat_id)
    {
        return $this->subcategory->addSubcategory($name, $image, $cat_id);
    }

    public function getSubcategory($id)
    {
        return $this->subcategory->getSubcategory($id);
    }

    public function editSubcategory($id, $name, $image, $cat_id)
    {
        return $this->subcategory->editSubcategory($id, $name, $image, $cat_id);
    }

    public function deleteSubcategory($id)
    {
        return $this->subcategory->deleteSubcategory($id);
    }
}
