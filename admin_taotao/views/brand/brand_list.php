<?php
include_once __DIR__ . '/../../controller/BrandController.php';
$brand_controller = new BrandController();
$brands = $brand_controller->getBrands();
include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-lg-10">

        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-success auto-dismiss">New brand added successfully.</div>
        <?php elseif (isset($_GET['update_status'])): ?>
            <div class="alert alert-success auto-dismiss">Brand updated successfully.</div>
        <?php elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'success'): ?>
            <div class="alert alert-success auto-dismiss">Brand deleted successfully.</div>
        <?php endif; ?>

      
        <div class="d-flex justify-content-end mx-3">
            <a href="create_brand.php"
               class="btn btn-light rounded-4"
               title="Add Brand"
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
                                <th>Name</th>
                                <th>Profile Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands as $brand): ?>
                                <tr>
                                    <td><?= $brand['id']; ?></td>
                                    <td><?= htmlspecialchars($brand['name']); ?></td>
                                    <td>
                                        <img src="../../uploads/<?= $brand['profile_img']; ?>" alt="Profile"
                                             class="img-fluid rounded-3 bg-white shadow-sm"
                                             style="max-width: 150px; height: auto;">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="brand.php?id=<?= $brand['id']; ?>"
                                               class="btn btn-light btn-sm p-1 me-2"
                                               title="View Brand"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-eye text-info"></i>
                                            </a>
                                            <a href="edit_brand.php?id=<?= $brand['id']; ?>"
                                               class="btn btn-light btn-sm p-1 me-2"
                                               title="Edit Brand"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-pencil-fill text-warning"></i>
                                            </a>
                                            <a href="delete_brand.php?id=<?= $brand['id']; ?>"
                                               onclick="return confirm('Are you sure to delete this brand?');"
                                               class="btn btn-light btn-sm p-1"
                                               title="Delete Brand"
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

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
