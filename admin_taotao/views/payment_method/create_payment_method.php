<?php
include_once __DIR__ . '/../../controller/PaymentMethodController.php';
$controller = new PaymentMethodController();
$method = '';
$error = '';

if (isset($_POST['submit'])) {
    $method = trim($_POST['method']);
    if ($method !== '') {
        if ($controller->addPaymentMethod($method)) {
            header('location: payment_method_list.php?status=success');
            exit;
        }
    } else {
        $error = 'Please enter payment method name.';
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Add Payment Method</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Method</label>
                            <input type="text" name="method" class="form-control rounded-3" value="<?= htmlspecialchars($method) ?>">
                            <?php if ($error): ?><div class="text-danger small mt-1"><?= $error ?></div><?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="submit" class="btn btn-success px-4">Add</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                        </div>
                        <div class="text-end mt-4">
                            <a href="payment_method_list.php" class="text-decoration-none">← Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
