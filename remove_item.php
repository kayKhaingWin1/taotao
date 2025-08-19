<?php
include_once __DIR__ . '/controller/CartController.php';
include_once __DIR__ . '/layout/header.php';

$cart_id = $_POST['cart_id'];

$cartController = new CartController();
$cartController->removeFromCart($cart_id);
