<?php
include_once __DIR__ . '/../../controller/DiscountController.php';

$id = $_GET['id'];
$discount_controller = new DiscountController();
$discountData = $discount_controller->getDiscount($id);

$discount = $discountData['discount'] ?? '';
$voucher_code = $discountData['voucher_code'] ?? '';
$error_discount = '';
$error_voucher = '';

if (isset($_POST['update'])) {
    $discount = $_POST['discount'];
    $voucher_code = $_POST['voucher_code'];

    if (!empty($discount) && !empty($voucher_code)) {
        $status = $discount_controller->editDiscount($id, $discount, $voucher_code);
        if ($status) {
            header('location: discount_list.php?update_status=success');
            exit;
        }
    } else {
        if (empty($discount)) $error_discount = "Please enter discount percentage";
        if (empty($voucher_code)) $error_voucher = "Please enter voucher code";
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4 text-dark">Edit Discount</h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Discount Percentage</label>
                            <input type="number" name="discount" class="form-control rounded-3" step="0.01" value="<?= htmlspecialchars($discount) ?>">
                            <?php if ($error_discount): ?>
                                <div class="text-danger small mt-1"><?= $error_discount ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Voucher Code</label>
                            <input type="text" name="voucher_code" class="form-control rounded-3" value="<?= htmlspecialchars($voucher_code) ?>">
                            <?php if ($error_voucher): ?>
                                <div class="text-danger small mt-1"><?= $error_voucher ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                        </div>
                        <div class="text-end mt-4">
                            <a href="discount_list.php" class="text-decoration-none">← Back to Discount List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
