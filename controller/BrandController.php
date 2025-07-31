<?php
include_once __DIR__ . '/../model/Brand.php';

class BrandController
{
    private $brand;

    public function __construct()
    {
        $this->brand = new Brand();
    }

    public function getBrands()
    {
        return $this->brand->getBrands();
    }

    public function getBrand($id)
{
    return $this->brand->getBrand($id);
}

}
