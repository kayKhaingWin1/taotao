<?php
include_once __DIR__ . '/../../controller/BrandController.php';
include_once __DIR__ . '/../../layouts/header.php';

$id = $_GET['id'];
$brand_controller = new BrandController();
$brand = $brand_controller->getBrand($id);
?>

<div class="container py-5">
    <div class="card shadow rounded-4 p-4 mx-auto" style="max-width: 650px;">

        <div class="position-relative" style="min-height: 200px;">
            <img src="../../uploads/<?php echo $brand['bg_img']; ?>"
                class="img-fluid rounded-4 w-100"
                style="height: 200px; object-fit: cover;"
                alt="Background Image">

            <!-- Profile Image -->
            <div class="position-absolute start-50 translate-middle-x" style="top: 130px;">
                <img src="../../uploads/<?php echo $brand['profile_img']; ?>"
                    alt="Profile Image"
                    class="rounded-circle border border-3 border-white shadow bg-white"
                    style="width: 110px; height: 110px; object-fit: contain;">
            </div>
        </div>

        <!-- Brand Info -->
        <div class="mt-5 pt-5 text-center">
            <h4 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($brand['name']); ?></h4>
            <p class="text-muted"><?php echo nl2br(htmlspecialchars($brand['profile'])); ?></p>

            <ul class="list-group list-group-flush mt-4 text-start">
                <li class="list-group-item px-0"><strong>ID:</strong> <?php echo $brand['id']; ?></li>
                <li class="list-group-item px-0"><strong>Address:</strong> <?php echo htmlspecialchars($brand['address']); ?></li>
            </ul>

            <div class="mt-4 text-end">
                <a href="brand_list.php" class="btn btn-outline-secondary me-2">← Back</a>
                <a href="edit_brand.php?id=<?php echo $brand['id']; ?>" class="btn btn-warning">✏️ Edit</a>
            </div>
        </div>

    </div>
</div>

    <?php include_once __DIR__ . '/../../layouts/footer.php'; ?>