<?php
include_once __DIR__ . '/../../controller/ProductController.php';
include_once __DIR__ . '/../../controller/BrandController.php';
include_once __DIR__ . '/../../controller/SubcategoryController.php';

$product_controller = new ProductController();
$brand_controller = new BrandController();
$subcategory_controller = new SubcategoryController();

$id = $_GET['id'];
$product = $product_controller->getProduct($id);
$brand = $brand_controller->getBrand($product['brand_id']);
$sub = $subcategory_controller->getSubcategory($product['sub_id']);

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow rounded-4 p-4" style="max-width: 800px; width: 100%;">
        <div class="row g-4 align-items-center">
            <div class="col-md-5 text-center">
                <img src="../../uploads/<?= $product['image'] ?>" class="img-fluid rounded-3" alt="Product Image" style="max-height: 250px; object-fit: contain;">
            </div>
            <div class="col-md-7">
                <h4 class="mb-3 text-dark fw-semibold">Product Details</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0"><strong>ID:</strong> <?= $product['id'] ?></li>
                    <li class="list-group-item px-0"><strong>Name:</strong> <?= htmlspecialchars($product['name']) ?></li>
                    <li class="list-group-item px-0"><strong>Price:</strong> $<?= number_format($product['price'], 2) ?></li>
                    <li class="list-group-item px-0"><strong>Description:</strong> <?= htmlspecialchars($product['description']) ?></li>
                    <li class="list-group-item px-0"><strong>Brand:</strong> <?= htmlspecialchars($brand['name']) ?></li>
                    <li class="list-group-item px-0"><strong>Subcategory:</strong> <?= htmlspecialchars($sub['name']) ?></li>
                </ul>
                <div class="mt-4">
                    <a href="product_list.php" class="btn btn-outline-secondary me-2">← Back</a>
                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning">✏️ Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
