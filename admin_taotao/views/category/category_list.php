<?php
include_once __DIR__ . '/../../controller/CategoryController.php';
$category_controller = new CategoryController();
$categories = $category_controller->getCategories();

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-lg-10">

        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-success auto-dismiss">New category added successfully.</div>
        <?php elseif (isset($_GET['update_status'])): ?>
            <div class="alert alert-success auto-dismiss">Category updated successfully.</div>
        <?php elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'success'): ?>
            <div class="alert alert-success auto-dismiss">Category deleted successfully.</div>
        <?php endif; ?>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mx-3 mb-3">
                    <a href="create_category.php"
                        class="btn btn-light rounded-4"
                        title="Add Category"
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
                                <th>Icon</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['id'] ?></td>
                                    <td><?= htmlspecialchars($category['name']) ?></td>
                                    <td>
                                        <img src="../../uploads/<?= $category['image'] ?>" style="max-width: 150px; height: auto;" class="rounded bg-white shadow-sm">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="category.php?id=<?= $category['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                                title="View Category"
                                                style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-eye text-info"></i>
                                            </a>
                                            <a href="edit_category.php?id=<?= $category['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                                title="Edit Category"
                                                style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-pencil-fill text-warning"></i>
                                            </a>
                                            <a href="delete_category.php?id=<?= $category['id'] ?>" onclick="return confirm('Delete this category?');"
                                                class="btn btn-light btn-sm p-1"
                                                title="Delete Category"
                                                style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
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

<!-- Auto-dismiss alert script -->
<script>
    window.onload = function() {
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(el => {
            setTimeout(() => {
                el.style.display = 'none';
            }, 3000);
        });
    };
</script>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>