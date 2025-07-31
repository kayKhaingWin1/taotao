<?php
include_once __DIR__ . '/../model/ColorSize.php';

class ColorSizeController {
    private $model;

    public function __construct() {
        $this->model = new ColorSize();
    }

    public function getColors() {
        return $this->model->getColors();
    }

    public function getSizes() {
        return $this->model->getSizes();
    }

    public function getItem($type, $id) {
        return $this->model->getItem($type, $id);
    }

    public function addItem($type, $name, $color_code) {
        return $this->model->addItem($type, $name,$color_code);
    }

    public function updateItem($type, $id, $name,$color_code) {
        return $this->model->updateItem($type, $id, $name,$color_code);
    }

    public function deleteItem($type, $id) {
        return $this->model->deleteItem($type, $id);
    }
}

?>