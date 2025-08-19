<?php
include_once __DIR__ . '/../../controller/SubcategoryController.php';

$subcategory_controller = new SubcategoryController();
$subcategories = $subcategory_controller->getSubcategories();

include_once __DIR__ . '/../../layouts/header.php';

$grouped_subcategories = [];
foreach ($subcategories as $subcategory) {
    $grouped_subcategories[$subcategory['category_name']][] = $subcategory;
}
?>

<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-lg-10">

        <?php
        if (isset($_GET['status'])) {
            echo '<div class="alert alert-success auto-dismiss" role="alert">New subcategory added successfully.</div>';
        } elseif (isset($_GET['update_status'])) {
            echo '<div class="alert alert-success auto-dismiss" role="alert">Subcategory updated successfully.</div>';
        } elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'success') {
            echo '<div class="alert alert-success auto-dismiss" role="alert">Subcategory deleted successfully.</div>';
        } elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'fail') {
            echo '<div class="alert alert-danger auto-dismiss" role="alert">Cannot delete subcategory due to related data.</div>';
        }
        ?>

        <!-- Add Button (Same Style as Product Page) -->
        <div class="d-flex justify-content-end mx-3">
            <a href="create_subcategory.php"
                class="btn btn-light rounded-4"
                title="Add Subcategory"
                style="height:32px; display:flex; align-items:center; justify-content:center; font-size:16px; padding: 0 12px;">
                <span class="text-success me-1" style="margin-top:2px;">Add</span>
                <i class="bi bi-plus-lg" style="color:green;"></i>
            </a>
        </div>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Subcategory Name</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grouped_subcategories as $category_name => $subs): ?>
                                <tr>
                                    <td colspan="5" style="background:#f0f0f0; font-weight:bold; text-align:left;">
                                        <?= htmlspecialchars($category_name); ?>
                                    </td>
                                </tr>
                                <?php foreach ($subs as $subcategory): ?>
                                    <tr>
                                        <td><?= $subcategory['id']; ?></td>
                                        <td><?= htmlspecialchars($subcategory['name']); ?></td>
                                        <td>
                                            <img src="../../uploads/<?= $subcategory['image']; ?>" alt=""
                                                 class="img-fluid rounded-3 bg-white shadow-sm"
                                                 style="max-width: 150px; height: auto;">
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="subcategory.php?id=<?= $subcategory['id']; ?>"
                                                   class="btn btn-light btn-sm p-1 me-2"
                                                   title="View Subcategory"
                                                   style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-eye text-info"></i>
                                                </a>
                                                <a href="edit_subcategory.php?id=<?= $subcategory['id']; ?>"
                                                   class="btn btn-light btn-sm p-1 me-2"
                                                   title="Edit Subcategory"
                                                   style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-pencil-fill text-warning"></i>
                                                </a>
                                                <a href="delete_subcategory.php?id=<?= $subcategory['id']; ?>"
                                                   onclick="return confirm('Are you sure to delete this subcategory?');"
                                                   class="btn btn-light btn-sm p-1"
                                                   title="Delete Subcategory"
                                                   style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                    <i class="bi bi-x-lg text-danger"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>

<script>
    window.onload = function () {
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(function (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        });
    };
</script>
