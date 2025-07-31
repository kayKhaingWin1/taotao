<?php
session_name('user');
session_start();


if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in first.']);
    exit;
}

include_once __DIR__ . '/controller/CartController.php';

$userId = $_SESSION['id'];
$productSizeColorId = $_POST['productSizeColorId'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if (!$productSizeColorId || !is_numeric($productSizeColorId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid productSizeColorId.']);
    exit;
}

$cartController = new CartController();
$success = $cartController->addToCart($userId, $productSizeColorId, $quantity);

echo json_encode([
    'success' => $success,
    'message' => $success ? 'Added to cart!' : 'Failed to add to cart.'
]);
?>
