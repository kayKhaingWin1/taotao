<?php
include_once __DIR__ . '/controller/CartController.php';
include_once __DIR__ . '/layout/header.php';

$cart_id = $_POST['cart_id'];
$action = $_POST['action'];

$cartController = new CartController();


$items = $cartController->getCartItems($_SESSION['id']);

foreach ($items as $item) {
    if ($item['cart_id'] == $cart_id) {
        $quantity = $item['quantity'];
        break;
    }
}

if ($action === 'increase') {
    $quantity++;
} elseif ($action === 'decrease' && $quantity > 1) {
    $quantity--;
} else {
    exit; 
}

$cartController->updateCartQuantity($cart_id, $quantity);
