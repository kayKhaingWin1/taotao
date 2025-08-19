<?php
header('Content-Type: application/json');

session_name('user');
session_start();


// 启用错误报告（调试完成后应关闭）
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 检查请求方法
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// 检查登录状态
$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// 获取并验证输入数据
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['address'], $input['phone'], $input['township_id'], $input['payment_method'], $input['delivery_fee'])) {
    http_response_code(400);
    exit;
}

try {
    include_once __DIR__ . '/controller/OrderController.php';
    include_once __DIR__ . '/controller/OrderItemController.php';
    include_once __DIR__ . '/controller/CartController.php';

    $cartController = new CartController();
    $cartItems = $cartController->getCartItems($userId);

    if (empty($cartItems)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Cart is empty']);
        exit;
    }

    // 计算总价
    $subtotal = array_sum(array_map(function($item) {
        return $item['price'] * $item['quantity'];
    }, $cartItems));

    $total = $subtotal + floatval($input['delivery_fee']);
    $order_code = 'ORD' . time() . rand(1000, 9999);

    // 创建订单
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

    // 创建订单项
    $orderItemController = new OrderItemController();
    foreach ($cartItems as $item) {
        $success = $orderItemController->createOrderItem(
            $item['quantity'],
            $item['price'],
            $item['product_id'],
            $orderId
        );
        if (!$success) {
            throw new Exception('Failed to add order items');
        }
    }

    // 清空购物车
    $cartController->clearCart($userId);

    // 返回成功响应（包含 order_code）
    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully',
        'order_code' => $order_code
    ]);

} catch (Exception $e) {
    http_response_code(500);
    error_log("Order Error: " . $e->getMessage()); 
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage() 
    ]);
}