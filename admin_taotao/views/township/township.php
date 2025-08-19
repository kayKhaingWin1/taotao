<?php
include_once __DIR__ . '/../../controller/TownshipController.php';
include_once __DIR__ . '/../../layouts/header.php';

$id = $_GET['id'];
$controller = new TownshipController();
$township = $controller->getTownship($id);
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="card shadow rounded-4 p-4" style="max-width: 600px; width: 100%;">
            <h4 class="mb-3 text-dark fw-semibold">Township Details</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item px-0"><strong>ID:</strong> <?= $township['id'] ?></li>
                <li class="list-group-item px-0"><strong>Name:</strong> <?= htmlspecialchars($township['name']) ?></li>
                <li class="list-group-item px-0"><strong>Fee:</strong> <?= htmlspecialchars($township['fee']) ?> MMK</li>
            </ul>
            <div class="mt-4">
                <a href="township_list.php" class="btn btn-outline-secondary me-2">← Back</a>
                <a href="edit_township.php?id=<?= $township['id'] ?>" class="btn btn-warning">✏️ Edit</a>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>