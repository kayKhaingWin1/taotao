<?php
include_once __DIR__ . '/../../controller/ColorSizeController.php';
include_once __DIR__ . '/../../layouts/header.php';

$type = $_GET['type'] ?? 'color';
$id = $_GET['id'] ?? 0;
$title = ucfirst($type);
$controller = new ColorSizeController();
$item = $controller->getItem($type, $id);
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow rounded-4 p-4" style="max-width: 600px; width: 100%;">
        <h4 class="mb-4 text-dark"><?= $title ?> Details</h4>
        <ul class="list-group list-group-flush">
            <li class="list-group-item px-0"><strong>ID:</strong> <?= $item['id'] ?></li>
            <li class="list-group-item px-0"><strong>Name:</strong> <?= htmlspecialchars($item['name']) ?></li>
        </ul>
        <div class="mt-4">
            <a href="color_size_list.php" class="btn btn-outline-secondary me-2">← Back</a>
            <a href="edit_color_size.php?type=<?= $type ?>&id=<?= $item['id'] ?>" class="btn btn-warning">✏️ Edit</a>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
