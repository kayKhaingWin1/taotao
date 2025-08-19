<?php
include_once __DIR__ . '/../../controller/ProductController.php';
$product_controller = new ProductController();
$products = $product_controller->getProducts();

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid d-flex justify-content-center mt-3">
    <div class="col-lg-12">

        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-success auto-dismiss">New product added successfully.</div>
        <?php elseif (isset($_GET['update_status'])): ?>
            <div class="alert alert-success auto-dismiss">Product updated successfully.</div>
        <?php elseif (isset($_GET['delete_status']) && $_GET['delete_status'] == 'success'): ?>
            <div class="alert alert-success auto-dismiss">Product deleted successfully.</div>
        <?php endif; ?>

        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mx-3">
                    <a href="create_product.php"
                       class="btn btn-light rounded-4 mb-2"
                       title="Add Product"
                       style="height:32px; display:flex; align-items:center; justify-content:center; font-size:30px;">
                        <p class="text-success mt-3 fs-6 fw-semibold mx-1">Add</p>
                        <i class="bi bi-plus-lg" style="color:green;"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Brand</th>
                                <th>Subcategory</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <?php
                                $color_sizes = $product_controller->getColorSizes($product['id']);
                                $colors = [];
                                $sizes = [];
                                foreach ($color_sizes as $cs) {
                                    if (!in_array($cs['color_code'], $colors)) {
                                        $colors[] = $cs['color_code'];
                                    }
                                    if (!in_array($cs['size'], $sizes)) {
                                        $sizes[] = $cs['size'];
                                    }
                                }

                                $discount = $product_controller->getDiscountByProductId($product['id']);
                                $discount_text = $discount ? $discount['discount'] . '%' : '-';
                                ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td>
                                        <img src="../../uploads/<?= $product['image'] ?>"
                                             style="width: 80px; height: 100px; object-fit: contain;"
                                             class="rounded-3 bg-white shadow-sm">
                                    </td>
                                    <td><?= htmlspecialchars($product['brand_name']) ?></td>
                                    <td><?= htmlspecialchars($product['sub_name']) ?></td>
                                    <td>
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <?php foreach ($colors as $color_code): ?>
                                                <span class="color-block" style="background-color: <?= $color_code ?>;"></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            <?php foreach ($sizes as $size): ?>
                                                <span class="size-tag"><?= htmlspecialchars($size) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($discount_text) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                               title="View Product"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-eye text-info"></i>
                                            </a>
                                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-light btn-sm p-1 me-2"
                                               title="Edit Product"
                                               style="width:32px; height:32px; font-size:16px; display:flex; align-items:center; justify-content:center;">
                                                <i class="bi bi-pencil-fill text-warning"></i>
                                            </a>
                                            <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Delete this product?');"
                                               class="btn btn-light btn-sm p-1"
                                               title="Delete Product"
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

<!-- Styles -->
<style>
    .color-block {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1px solid #999;
        display: inline-block;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.4);
    }

    .size-tag {
        padding: 3px 8px;
        border: 1px solid #333;
        border-radius: 6px;
        font-size: 0.85rem;
        background-color: #f8f9fa;
        color: #000;
    }
</style>

<script>
    window.onload = function () {
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(el => {
            setTimeout(() => {
                el.style.display = 'none';
            }, 3000);
        });
    };
</script>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
