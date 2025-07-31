<?php
include_once __DIR__ . '/../../controller/TownshipController.php';

$controller = new TownshipController();
$name = '';
$fee = '';
$errors = [];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $fee = $_POST['fee'];

    if (empty($name)) $errors['name'] = 'Please enter township name';
    if ($fee === '' || !is_numeric($fee)) $errors['fee'] = 'Please enter valid fee';

    if (empty($errors)) {
        if ($controller->addTownship($name, $fee)) {
            header("Location: township_list.php?status=success");
            exit;
        }
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Add Township</h3>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Township Name</label>
                            <input type="text" name="name" class="form-control rounded-3" value="<?= htmlspecialchars($name) ?>">
                            <?php if (isset($errors['name'])): ?><div class="text-danger small"><?= $errors['name'] ?></div><?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Delivery Fee (MMK)</label>
                            <input type="number" name="fee" class="form-control rounded-3" value="<?= htmlspecialchars($fee) ?>">
                            <?php if (isset($errors['fee'])): ?><div class="text-danger small"><?= $errors['fee'] ?></div><?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="submit" class="btn btn-success px-4">Add</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                        </div>
                        <div class="text-end mt-4">
                            <a href="township_list.php" class="text-decoration-none">← Back to Township List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
