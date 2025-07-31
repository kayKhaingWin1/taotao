<?php
// views/order/order_list.php
include_once __DIR__ . '/../../controller/OrderController.php';
include_once __DIR__ . '/../../layouts/header.php';

$order_controller = new OrderController();
$orders = $order_controller->getOrders();
?>

<div class="container-fluid py-4">
    <div class="card shadow rounded-4">
        <div class="card-body">
            <h4 class="mb-4">Order List</h4>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Order Code</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Township</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= htmlspecialchars($order['order_code']) ?></td>
                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                <td><?= $order['total_price'] ?> MMK</td>
                                <td><?= htmlspecialchars($order['township_name']) ?></td>
                                <td>
                                    <?php
                                    $status = ucfirst(strtolower($order['payment_status']));
                                    $badgeClass = 'secondary';
                                    if ($status == 'Paid' || $status == 'Accepted') $badgeClass = 'success';
                                    elseif ($status == 'Declined') $badgeClass = 'danger';
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <a href="invoice.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-light">
                                        <i class="bi bi-eye text-info"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>

?>