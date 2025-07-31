<?php
include_once __DIR__ . '/../model/PaymentMethod.php';

class PaymentMethodController {
    private $model;

    public function __construct() {
        $this->model = new PaymentMethod();
    }

    public function getPaymentMethods() {
        return $this->model->getPaymentMethods();
    }

    public function getPaymentMethod($id) {
        return $this->model->getPaymentMethod($id);
    }

    public function addPaymentMethod($method) {
        return $this->model->addPaymentMethod($method);
    }

    public function editPaymentMethod($id, $method) {
        return $this->model->editPaymentMethod($id, $method);
    }

    public function deletePaymentMethod($id) {
        return $this->model->deletePaymentMethod($id);
    }
}
