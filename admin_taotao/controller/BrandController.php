<?php
include_once __DIR__ . '/../model/Brand.php';

class BrandController {
    private $brand;

    public function __construct()
    {
        $this->brand = new Brand();
    }

    public function getBrands()
    {
        return $this->brand->getBrands();
    }

    public function addBrand($name, $profile, $profile_img, $bg_img, $address)
    {
        return $this->brand->addBrand($name, $profile, $profile_img, $bg_img, $address);
    }

    public function getBrand($id)
    {
        return $this->brand->getBrand($id);
    }

    public function editBrand($id, $name, $profile, $profile_img, $bg_img, $address)
    {
        return $this->brand->editBrand($id, $name, $profile, $profile_img, $bg_img, $address);
    }

    public function deleteBrand($id)
    {
        return $this->brand->deleteBrand($id);
    }
}
