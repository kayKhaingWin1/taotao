<?php
include_once __DIR__ . '/../../controller/ColorSizeController.php';

$controller = new ColorSizeController();
$type = $_GET['type'] ?? 'color';
$id = $_GET['id'] ?? 0;
$title = ucfirst($type);

$item = $controller->getItem($type, $id);
$name = $type === 'color' ? ($item['color'] ?? '') : ($item['size'] ?? '');
$color_code = $item['color_code'] ?? '';

$error_name = '';
$error_code = '';

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $color_code = $_POST['color_code'] ?? null;

    if (empty($name)) {
        $error_name = "Please enter $type name";
    }

    if ($type === 'color' && empty(trim($color_code))) {
        $error_code = "Please enter color code";
    }

    if (empty($error_name) && empty($error_code)) {
        $status = $controller->updateItem($type, $id, $name, $color_code);
        if ($status) {
            header("location: color_size_list.php?{$type}_status=success");
            exit;
        }
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container mt-5 bg-body-tertiary">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="card-title text-center mb-4 text-dark">Edit <?= $title ?></h3>
                    <form method="post">
                        <!-- name -->
                        <div class="mb-3">
                            <label class="form-label"><?= $title ?> Name</label>
                            <input type="text" name="name" class="form-control rounded-3" value="<?= htmlspecialchars($name) ?>">
                            <?php if ($error_name): ?>
                                <div class="text-danger small mt-1"><?= $error_name ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- color_code -->
                        <?php if ($type === 'color'): ?>
                            <div class="mb-3">
                                <label class="form-label">Color Code</label>
                                <input type="text" name="color_code" class="form-control rounded-3" value="<?= htmlspecialchars($color_code) ?>" placeholder="#000000">
                                <?php if ($error_code): ?>
                                    <div class="text-danger small mt-1"><?= $error_code ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                            <a href="color_size_list.php" class="btn btn-outline-secondary px-4">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
