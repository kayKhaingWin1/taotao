<?php
include_once __DIR__ . '/../../controller/PaymentController.php';
include_once __DIR__ . '/../../controller/OrderController.php';
include_once __DIR__ . '/../../controller/UserController.php';

$payment_controller = new PaymentController();
$order_controller = new OrderController();
$user_controller = new UserController();


$payments = $payment_controller->getAllPaymentsWithDetails();

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-lg-12">

        <?php
        if (isset($_GET['status'])) {
            $message = match($_GET['status']) {
                'confirmed' => 'Payment confirmed successfully',
                'declined' => 'Payment declined successfully',
                'error' => 'Error processing payment',
                default => 'Operation completed'
            };
            $alert_class = $_GET['status'] == 'error' ? 'alert-danger' : 'alert-success';
            echo '<div class="alert '.$alert_class.' auto-dismiss" role="alert">'.$message.'</div>';
        }
        ?>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Payment Management</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                                <?php
                                $order = $order_controller->getOrder($payment['order_id']);
                                $user = $user_controller->getUser($order['user_id']);
                                $order_total = $order_controller->getOrderTotal($payment['order_id']);
                                ?>
                                <tr>
                                    <td><?= $payment['id'] ?></td>
                                    <td>
                                        <a href="order_detail.php?id=<?= $payment['order_id'] ?>" 
                                           class="text-primary">
                                            #<?= $payment['order_id'] ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($payment['payment_method']) ?></td>
                                    <td>$<?= number_format($order_total + ($order['delivery_fee'] ?? 0), 2) ?></td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $payment['status'] == 'Paid' ? 'success' : 
                                            ($payment['status'] == 'Unpaid' ? 'warning' : 'secondary')
                                        ?>">
                                            <?= $payment['status'] ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, Y', strtotime($payment['created_at'])) ?></td>
                                    <td>
                                        <?php if ($payment['status'] == 'Unpaid'): ?>
                                            <div class="d-flex">
                                                <form action="confirm_payment.php" method="POST" class="me-2">
                                                    <input type="hidden" name="payment_id" value="<?= $payment['id'] ?>">
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Confirm this payment?')">
                                                        <i class="bi bi-check-lg"></i> Confirm
                                                    </button>
                                                </form>
                                                <form action="decline_payment.php" method="POST">
                                                    <input type="hidden" name="payment_id" value="<?= $payment['id'] ?>">
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Decline this payment?')">
                                                        <i class="bi bi-x-lg"></i> Decline
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Completed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>

<script>
    window.onload = function () {
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(function (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        });
    };
</script>