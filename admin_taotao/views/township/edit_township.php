<?php
include_once __DIR__ . '/../../controller/TownshipController.php';
$controller = new TownshipController();

$id = $_GET['id'];
$township = $controller->getTownship($id);
$name = $township['name'] ?? '';
$fee = $township['fee'] ?? '';
$errors = [];

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $fee = $_POST['fee'];

    if (empty($name)) $errors['name'] = 'Please enter township name';
    if ($fee === '' || !is_numeric($fee)) $errors['fee'] = 'Please enter valid fee';

    if (empty($errors)) {
        if ($controller->editTownship($id, $name, $fee)) {
            header("Location: township_list.php?update_status=success");
            exit;
        }
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Edit Township</h3>
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
                            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                            <a href="township_list.php" class="btn btn-outline-secondary px-4">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
