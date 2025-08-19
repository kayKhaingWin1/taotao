<?php
include_once __DIR__ . '/../../controller/OrderController.php';
include_once __DIR__ . '/../../controller/OrderItemController.php';
include_once __DIR__ . '/../../controller/UserController.php';

$order_controller = new OrderController();
$order_item_controller = new OrderItemController();
$user_controller = new UserController();

$order_id = $_GET['id'];
$order = $order_controller->getOrder($order_id);
$order_items = $order_item_controller->getItemsByOrderId($order_id);
$order_total = $order_controller->getOrderTotal($order_id);
$user = $user_controller->getUser($order['user_id']);


include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container my-5">
    <div class="card shadow-lg rounded-3 border-0 overflow-hidden">
        <div class="card-header bg-outline-dark text-dark py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-0 fw-bold"><i class="fas fa-receipt me-2"></i>INVOICE</h2>
                    <p class="mb-0">Order #<?= $order['id'] ?></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1"><strong>Date:</strong> <?= date('F j, Y', strtotime($order['date'])) ?></p>
                    <p class="mb-1"><strong>Status:</strong>
                        <span class="badge bg-<?= $order['payment_status'] == 'Paid' ? 'success' : 'warning' ?>">
                            <?= $order['payment_status'] ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">
            <div class="row mb-5">
                <div class="col-md-6">
                    <h5 class="fw-bold text-primary">From:</h5>
                    <p class="mb-1">Your Company Name</p>
                    <p class="mb-1">123 Business Street</p>
                    <p class="mb-1">City, State 10001</p>
                    <p class="mb-1">Phone: (123) 456-7890</p>
                    <p class="mb-0">Email: info@yourcompany.com</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <h5 class="fw-bold text-primary">To:</h5>
                    <p class="mb-1"><?= htmlspecialchars($user['name']) ?></p>
                    <p class="mb-1"><?= htmlspecialchars($user['address']) ?></p>
                    <p class="mb-1"><?= htmlspecialchars($order['township_name']) ?></p>
                    <p class="mb-1">Phone: <?= htmlspecialchars($user['phone_no']) ?></p>
                    <p class="mb-0">Email: <?= htmlspecialchars($user['email']) ?></p>
                </div>
            </div>

            <!-- Order Items Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_items as $index => $item): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../../uploads/<?= $item['product_image'] ?>" class="me-3" width="60" height="60" style="object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0"><?= htmlspecialchars($item['product_name']) ?></h6>
                                            <small class="text-muted">SKU: PROD-<?= $item['product_id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><?= $item['quantity'] ?></td>
                                <td class="text-end">$<?= number_format($item['price'], 2) ?></td>
                                <td class="text-end">$<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


            <div class="row mt-4">
                <div class="col-lg-5 ms-auto">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-end">Subtotal</th>
                                    <td class="text-end">$<?= number_format($order_total, 2) ?></td>
                                </tr>
                                <tr>
                                    <th class="text-end">Delivery Fee</th>
                                    <td class="text-end">$<?= number_format($order['delivery_fee'] ?? 0, 2) ?></td>
                                </tr>
                                <tr class="fw-bold">
                                    <th class="text-end">Total</th>
                                    <td class="text-end">$<?= number_format($order_total + ($order['delivery_fee'] ?? 0), 2) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-5 p-4 bg-light rounded">
                <h5 class="fw-bold mb-3">Payment Instructions</h5>
                <p class="mb-2">Please make payment to complete your order. You can pay via:</p>
                <ul>
                    <li>Bank Transfer: Account #123456789 (Your Bank Name)</li>
                    <li>Mobile Payment: 09XXXXXXXX (WavePay, KBZPay, etc.)</li>
                </ul>
                <p class="mb-0 text-muted"><small>Please include your order number (#<?= $order['id'] ?>) in the payment reference.</small></p>
            </div>
        </div>


        <div class="card-footer bg-light py-3">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0"><small>Thank you for your business!</small></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-primary me-2" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Print Invoice
                    </button>
                    <a href="order_list.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .card,
        .card * {
            visibility: visible;
        }

        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }

        .no-print {
            display: none !important;
        }
    }
</style>