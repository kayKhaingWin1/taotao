<?php
include_once __DIR__ . '/../model/Category.php';

class CategoryController {
    private $category;
    function __construct()
    {
        $this->category = new Category();
    }

    public function getCategories()
    {
        return $this->category->getCategories();
    }

    public function addCategory($name, $image)
    {
        return $this->category->addCategory($name, $image);
    }

    public function getCategory($id)
    {
        return $this->category->getCategory($id);
    }

    public function editCategory($id, $name, $image)
    {
        return $this->category->editCategory($id, $name, $image);
    }

    public function deleteCategory($id)
    {
        return $this->category->deleteCategory($id);
    }

    // public function getMenuByRestaurant($resturant_id)
    // {
    //     return $this->menu->getMenuByRestaurant($resturant_id);
    // }

    // public function getTotalMenus(){
    //     return $this->menu->getTotalMenus();
    // }
}
