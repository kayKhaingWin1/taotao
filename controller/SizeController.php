<?php
include_once __DIR__ . '/../model/Size.php';

class SizeController
{
    private $size;

    public function __construct()
    {
        $this->size = new Size();
    }

    public function getSizes()
    {
        return $this->size->getSizes();
    }

        public function getSizesByProductId($productId)
    {
        return $this->size->getSizesByProductId($productId);
    }
}
