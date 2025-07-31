<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../controller/FavouriteController.php';

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? '';

$controller = new FavouriteController();

try {
    switch ($action) {
        case 'add':
            if (!isset($input['product_id'])) {
                throw new Exception('Product ID is required');
            }
            $response = $controller->addFavourite($userId, $input['product_id']);
            break;
            
        case 'remove':
            if (!isset($input['product_id'])) {
                throw new Exception('Product ID is required');
            }
            $response = $controller->removeFavourite($userId, $input['product_id']);
            break;
            
        case 'check':
            if (!isset($input['product_id'])) {
                throw new Exception('Product ID is required');
            }
            $response = $controller->checkFavourite($userId, $input['product_id']);
            break;
            
        case 'list':
            $response = $controller->getFavourites($userId);
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);
?>