<?php
include_once __DIR__ . '/controller/CartController.php';
include_once __DIR__ . '/layout/header.php';

$cartController = new CartController();
$cartController->clearCart($_SESSION['id']);
