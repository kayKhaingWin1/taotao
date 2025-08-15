<?php
header('Content-Type: application/json');

session_name('user');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['address'], $input['phone'], $input['township_id'], $input['payment_method'], $input['delivery_fee'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    include_once __DIR__ . '/controller/OrderController.php';
    include_once __DIR__ . '/controller/OrderItemController.php';
    include_once __DIR__ . '/controller/CartController.php';
    include_once __DIR__ . '/../include/dbconfig.php';

    $db = Database::connect();

    $db->beginTransaction();

    $cartController = new CartController();
    $cartItems = $cartController->getCartItems($userId);

    if (empty($cartItems)) {
        throw new Exception('Cart is empty');
    }

    $subtotal = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $cartItems));

    $total = $subtotal + floatval($input['delivery_fee']);
    $order_code = 'ORD' . time() . rand(1000, 9999);

    $orderController = new OrderController();
    $orderId = $orderController->createOrder(
        $order_code,
        $total,
        date('Y-m-d'),
        date('H:i:s'),
        $userId,
        $input['township_id']
    );

    if (!$orderId) {
        throw new Exception('Failed to create order');
    }

    $orderItemController = new OrderItemController();
    foreach ($cartItems as $item) {
        $success = $orderItemController->createOrderItem(
            $item['quantity'],
            $item['price'],
            $item['product_id'],
            $orderId
        );
        if (!$success) {
            throw new Exception('Failed to add order item: Product ID ' . $item['product_id']);
        }
    }

    if (!$cartController->clearCart($userId)) {
        throw new Exception('Failed to clear cart');
    }

    $db->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully',
        'order_code' => $order_code,
        'order_id' => $orderId
    ]);

} catch (PDOException $e) {

    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
        'error_code' => $e->getCode()
    ]);
} catch (Exception $e) {

    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    
    error_log("Order Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}