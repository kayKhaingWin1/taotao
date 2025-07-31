<?php
include_once __DIR__ . '/../../controller/ColorSizeController.php';
include_once __DIR__ . '/../../layouts/header.php';

$controller = new ColorSizeController();
$colors = $controller->getColors();
$sizes = $controller->getSizes();
?>

<div class="container py-5">
    <?php if (isset($_GET['color_status'])): ?>
        <div class="alert alert-success auto-dismiss">Color updated successfully.</div>
    <?php endif; ?>
    <?php if (isset($_GET['size_status'])): ?>
        <div class="alert alert-success auto-dismiss">Size updated successfully.</div>
    <?php endif; ?>

    <div class="row">
        <!-- Colors Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg rounded-4 border-0"> 
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Colors</h5>
                    <a href="create_color_size.php?type=color" class="btn btn-light p-1 rounded-circle" title="Add Color" style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; font-size:20px;"><i class="bi bi-plus-lg" style="color:green;"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($colors as $color): ?>
                        <?php if ($color['status'] !== 'deleted'): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <span style="display:inline-block; width: 36px; height: 36px; border-radius: 50%; background-color: <?= htmlspecialchars($color['color_code']) ?>; border: 1px solid #ccc;"></span> 
                                    <span><?= htmlspecialchars($color['color']) ?></span>
                                </div>
                                <div class="d-flex">
                                    <a href="edit_color_size.php?type=color&id=<?= $color['id'] ?>" class="btn btn-light btn-sm p-1 me-2" title="Edit Color" style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-pencil-fill text-warning"></i></a>
                                    <a href="delete_color_size.php?type=color&id=<?= $color['id'] ?>" class="btn btn-light btn-sm p-1" onclick="return confirm('Are you sure to delete this color?');" title="Delete Color" style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-x-lg text-danger"></i></a>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Sizes Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sizes</h5>
                    <a href="create_color_size.php?type=size" class="btn btn-light btn-sm p-1" title="Add Size" style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; font-size:20px;"><i class="bi bi-plus-lg" style="color:green;"></i></a>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($sizes as $size): ?>
                        <?php if ($size['status'] !== 'deleted'): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($size['size']) ?></span>
                                <div class="d-flex">
                                    <a href="edit_color_size.php?type=size&id=<?= $size['id'] ?>" class="btn btn-light btn-sm p-1 me-2" title="Edit Size" style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-pencil-fill text-warning"></i></a>
                                    <a href="delete_color_size.php?type=size&id=<?= $size['id'] ?>" class="btn btn-light btn-sm p-1" onclick="return confirm('Are you sure to delete this size?');" title="Delete Size" style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-x-lg text-danger"></i></a>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
window.onload = function () {
    const alerts = document.querySelectorAll('.auto-dismiss');
    alerts.forEach(alert => {
        setTimeout(() => alert.style.display = 'none', 3000);
    });
};
</script>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
