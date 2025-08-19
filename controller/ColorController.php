<?php
include_once __DIR__ . '/../model/Color.php';

class ColorController
{
    private $color;

    public function __construct()
    {
        $this->color = new Color();
    }

    public function getColors()
    {
        return $this->color->getColors();
    }
    public function getColorsByProductId($productId)
    {
        return $this->color->getColorsByProductId($productId);
    }
}
