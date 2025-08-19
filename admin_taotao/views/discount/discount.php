<?php
include_once __DIR__ . '/../../layouts/header.php';
include_once __DIR__ . '/../../controller/DiscountController.php';

$id = $_GET['id'];
$discount_controller = new DiscountController();
$discount = $discount_controller->getDiscount($id);
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="card shadow rounded-4 p-4" style="max-width: 800px; width: 100%;">
            <div class="row g-4 align-items-center">
                <div class="col-md-12">
                    <h4 class="mb-3 text-dark fw-semibold">Discount Details</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0"><strong>ID:</strong> <?= $discount['id'] ?></li>
                        <li class="list-group-item px-0"><strong>Discount:</strong> <?= $discount['discount'] ?>%</li>
                        <li class="list-group-item px-0"><strong>Voucher Code:</strong> <?= htmlspecialchars($discount['voucher_code']) ?></li>
                    </ul>
                    <div class="mt-4">
                        <a href="discount_list.php" class="btn btn-outline-secondary me-2">← Back</a>
                        <a href="edit_discount.php?id=<?= $discount['id'] ?>" class="btn btn-warning">✏️ Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>