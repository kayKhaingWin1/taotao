<?php
declare(strict_types=1);
ob_start();

header('Content-Type: application/json; charset=utf-8');

if (ob_get_length() > 0) {
    ob_clean();
}

session_name('user');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '0'); 

$response = [
    'success' => false,
    'message' => '',
    'order_code' => '',
    'order_id' => 0
];

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new RuntimeException('Invalid request method', 405);
    }

    $userId = $_SESSION['id'] ?? null;
    if (!$userId) {
        throw new RuntimeException('User not logged in', 401);
    }

    $jsonInput = file_get_contents('php://input');
    if ($jsonInput === false) {
        throw new RuntimeException('Failed to read input data', 400);
    }

    $input = json_decode($jsonInput, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('Invalid JSON input: ' . json_last_error_msg(), 400);
    }

    $requiredFields = ['address', 'phone', 'township_id', 'payment_method', 'delivery_fee'];
    foreach ($requiredFields as $field) {
        if (!isset($input[$field])) {
            throw new RuntimeException("Missing required field: $field", 400);
        }
    }

    $requiredFiles = [
        __DIR__ . '/controller/OrderController.php',
        __DIR__ . '/controller/OrderItemController.php',
        __DIR__ . '/controller/CartController.php',
        __DIR__ . '/../include/dbconfig.php'
    ];

    foreach ($requiredFiles as $file) {
        if (!file_exists($file)) {
            throw new RuntimeException("Missing required file: $file", 500);
        }
        require_once $file;
    }

    $db = Database::connect();
    $db->beginTransaction();

    $cartController = new CartController();
    $cartItems = $cartController->getCartItems($userId);

    if (empty($cartItems)) {
        throw new RuntimeException('Cart is empty', 400);
    }

    $subtotal = array_reduce($cartItems, function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    $total = $subtotal + (float)$input['delivery_fee'];
    $orderCode = 'ORD' . time() . random_int(1000, 9999);

    $orderController = new OrderController();
    $orderId = $orderController->createOrder(
        $orderCode,
        $total,
        date('Y-m-d'),
        date('H:i:s'),
        $userId,
        (int)$input['township_id']
    );

    if (!$orderId) {
        throw new RuntimeException('Failed to create order', 500);
    }

    $orderItemController = new OrderItemController();
    foreach ($cartItems as $item) {
        $success = $orderItemController->createOrderItem(
            (int)$item['quantity'],
            (float)$item['price'],
            (int)$item['product_id'],
            (int)$orderId
        );
        
        if (!$success) {
            throw new RuntimeException("Failed to add order item for product: {$item['product_id']}", 500);
        }
    }

    if (!$cartController->clearCart($userId)) {
        throw new RuntimeException('Failed to clear cart', 500);
    }

    $db->commit();

    $response = [
        'success' => true,
        'message' => 'Order placed successfully',
        'order_code' => $orderCode,
        'order_id' => $orderId
    ];

} catch (PDOException $e) {

    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    
    $response = [
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
        'error_code' => $e->getCode()
    ];
    
    error_log("PDO Exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);

} catch (RuntimeException $e) {

    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    
    $response = [
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => $e->getCode()
    ];
    
    error_log("Runtime Exception: " . $e->getMessage());
    http_response_code($e->getCode() ?: 500);

} catch (Throwable $e) {

    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    
    $response = [
        'success' => false,
        'message' => 'An unexpected error occurred',
        'error_code' => 500
    ];
    
    error_log("Unexpected Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);

} finally {
 
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    

    exit;
}