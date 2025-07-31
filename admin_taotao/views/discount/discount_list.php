<?php
include_once __DIR__ . '/../../controller/DiscountController.php';
$discount_controller = new DiscountController();
$discounts = $discount_controller->getDiscounts();

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-lg-10">

        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-success auto-dismiss">New discount added successfully.</div>
        <?php elseif (isset($_GET['update_status'])): ?>
            <div class="alert alert-success auto-dismiss">Discount updated successfully.</div>
        <?php elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'success'): ?>
            <div class="alert alert-success auto-dismiss">Discount deleted successfully.</div>
        <?php endif; ?>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mx-3 mb-3">
                    <a href="create_discount.php"
                       class="btn btn-light rounded-4"
                       title="Add Discount"
                       style="height:32px; display:flex; align-items:center; justify-content:center; font-size:16px; padding: 0 12px;">
                        <span class="text-success me-1" style="margin-top:2px;">Add</span>
                        <i class="bi bi-plus-lg" style="color:green;"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Discount (%)</th>
                                <th>Voucher Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($discounts as $discount): ?>
                                <tr>
                                    <td><?= $discount['id'] ?></td>
                                    <td><?= htmlspecialchars($discount['discount']) ?>%</td>
                                    <td><?= htmlspecialchars($discount['voucher_code']) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="discount.php?id=<?= $discount['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                               title="View Discount"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-eye text-info"></i>
                                            </a>
                                            <a href="edit_discount.php?id=<?= $discount['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                               title="Edit Discount"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-pencil-fill text-warning"></i>
                                            </a>
                                            <a href="delete_discount.php?id=<?= $discount['id'] ?>" onclick="return confirm('Delete this discount?');"
                                               class="btn btn-light btn-sm p-1"
                                               title="Delete Discount"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-x-lg text-danger"></i>
                                            </a>
                                        </div>
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

<script>
    window.onload = function() {
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(el => {
            setTimeout(() => {
                el.style.display = 'none';
            }, 3000);
        });
    };
</script>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
