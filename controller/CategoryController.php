<?php
include_once __DIR__ . '/../model/Category.php';

class CategoryController {
    private $category;
    function __construct()
    {
        $this->category = new Category();
    }

    public function getCategories(){
        return $this->category->getCategories();
    }
}

?>