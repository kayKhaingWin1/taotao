<?php
include_once __DIR__ . '/../../controller/TownshipController.php';
$township_controller = new TownshipController();
$townships = $township_controller->getTownships();

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid d-flex justify-content-center">
    <div class="col-lg-10">
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-success auto-dismiss">New township added successfully.</div>
        <?php elseif (isset($_GET['update_status'])): ?>
            <div class="alert alert-success auto-dismiss">Township updated successfully.</div>
        <?php elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'success'): ?>
            <div class="alert alert-success auto-dismiss">Township deleted successfully.</div>
        <?php endif; ?>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mx-3 mb-3">
                    <a href="create_township.php"
                       class="btn btn-light rounded-4"
                       title="Add Township"
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
                                <th>Name</th>
                                <th>Fee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($townships as $township): ?>
                                <tr>
                                    <td><?= $township['id'] ?></td>
                                    <td><?= htmlspecialchars($township['name']) ?></td>
                                    <td><?= htmlspecialchars($township['fee']) ?> MMK</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="township.php?id=<?= $township['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                               title="View"
                                               style="width:32px; height:32px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-eye text-info"></i>
                                            </a>
                                            <a href="edit_township.php?id=<?= $township['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                               title="Edit"
                                               style="width:32px; height:32px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-pencil-fill text-warning"></i>
                                            </a>
                                            <a href="delete_township.php?id=<?= $township['id'] ?>" onclick="return confirm('Delete this township?');"
                                               class="btn btn-light btn-sm p-1"
                                               title="Delete"
                                               style="width:32px; height:32px; display:flex; align-items:center; justify-content:center;">
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
    window.onload = function () {
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(el => {
            setTimeout(() => el.style.display = 'none', 3000);
        });
    };
</script>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
