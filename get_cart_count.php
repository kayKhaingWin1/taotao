<?php
session_start();
include_once __DIR__ . '/controller/CartController.php';

header('Content-Type: application/json');

$user_id = $_SESSION['id'] ?? null;
$count = 0;

if ($user_id) {
    $cartController = new CartController();
    $count = $cartController->getUniqueCartCount($user_id); 
}

echo json_encode(['count' => $count]);
