<?php
include_once __DIR__ . '/../../controller/ProductController.php';
include_once __DIR__ . '/../../controller/BrandController.php';
include_once __DIR__ . '/../../controller/SubcategoryController.php';
include_once __DIR__ . '/../../controller/ColorSizeController.php';
include_once __DIR__ . '/../../controller/DiscountController.php';

$product_controller = new ProductController();
$brand_controller = new BrandController();
$subcategory_controller = new SubcategoryController();
$colorsizes_controller = new ColorSizeController();
$discount_controller = new DiscountController();

$brands = $brand_controller->getBrands();
$subcategories = $subcategory_controller->getSubcategories();
$colors = $colorsizes_controller->getColors();
$sizes = $colorsizes_controller->getSizes();
$discounts = $discount_controller->getDiscounts();

$name = $price = $description = $image = $brand_id = $sub_id = $discount_id = '';
$errors = [];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $brand_id = $_POST['brand_id'];
    $sub_id = $_POST['sub_id'];
    $discount_id = $_POST['discount_id'] ?? null;
    $color_ids = $_POST['color_ids'] ?? [];
    $size_ids = $_POST['size_ids'] ?? [];
    $image = $_FILES['image']['name'] ?? '';

    if (empty($name)) $errors['name'] = "Please enter product name";
    if (empty($price)) $errors['price'] = "Please enter price";
    if (empty($description)) $errors['description'] = "Please enter description";
    if (empty($image)) $errors['image'] = "Please choose an image";
    if (empty($brand_id)) $errors['brand_id'] = "Please select a brand";
    if (empty($sub_id)) $errors['sub_id'] = "Please select a subcategory";

    if (empty($errors)) {
        $targetDir = "../../uploads/";
        $targetFile = $targetDir . basename($image);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $status = $product_controller->addProduct($name, $price, $description, $image, $brand_id, $sub_id);
            if ($status) {
                $product_id = $product_controller->getLastInsertedProductId();
                foreach ($color_ids as $color_id) {
                    foreach ($size_ids as $size_id) {
                        $product_controller->addProductColorSize($product_id, $color_id, $size_id);
                    }
                }
                if (!empty($discount_id)) {
                    $product_controller->addDiscountToProduct($product_id, $discount_id);
                }
                header('location: product_list.php?status=success');
                exit;
            }
        } else {
            $errors['image'] = "Image upload failed.";
        }
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Add Product</h3>
                    <form method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control rounded-3" value="<?= htmlspecialchars($name) ?>">
                            <?php if (isset($errors['name'])): ?><div class="text-danger small"><?= $errors['name'] ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control rounded-3" value="<?= htmlspecialchars($price) ?>" step="0.01">
                            <?php if (isset($errors['price'])): ?><div class="text-danger small"><?= $errors['price'] ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control rounded-3" rows="4"><?= htmlspecialchars($description) ?></textarea>
                            <?php if (isset($errors['description'])): ?><div class="text-danger small"><?= $errors['description'] ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control rounded-3">
                            <?php if (isset($errors['image'])): ?><div class="text-danger small"><?= $errors['image'] ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Brand</label>
                            <select name="brand_id" class="form-select rounded-3">
                                <option value="">-- Select Brand --</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $brand_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($brand['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['brand_id'])): ?><div class="text-danger small"><?= $errors['brand_id'] ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Subcategory</label>
                            <select name="sub_id" class="form-select rounded-3">
                                <option value="">-- Select Subcategory --</option>
                                <?php foreach ($subcategories as $sub): ?>
                                    <option value="<?= $sub['id'] ?>" <?= $sub['id'] == $sub_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['sub_id'])): ?><div class="text-danger small"><?= $errors['sub_id'] ?></div><?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Discount</label>
                            <select name="discount_id" class="form-select rounded-3">
                                <option value="">-- Optional --</option>
                                <?php foreach ($discounts as $discount): ?>
                                    <option value="<?= $discount['id'] ?>" <?= $discount['id'] == $discount_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($discount['voucher_code']) ?> (<?= $discount['discount'] ?>%)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Color Selection -->
                        <div class="mb-3">
                            <label class="form-label">Select Colors</label>
                            <div class="d-flex flex-wrap gap-3">
                                <?php foreach ($colors as $color): ?>
                                    <label class="color-option position-relative" style="cursor: pointer;">
                                        <input type="checkbox" name="color_ids[]" value="<?= $color['id'] ?>" class="d-none">
                                        <span class="color-circle" style="background-color: <?= $color['color_code'] ?>;"></span>
                                        <span class="checkmark">&#10003;</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Size Selection -->
                        <div class="mb-3">
                            <label class="form-label">Select Sizes</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($sizes as $size): ?>
                                    <label class="size-option" style="cursor: pointer;">
                                        <input type="checkbox" name="size_ids[]" value="<?= $size['id'] ?>" class="d-none">
                                        <span class="size-box px-3 py-1 border rounded text-dark"><?= htmlspecialchars($size['size']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="submit" class="btn btn-success px-4">Add</button>
                            <button type="reset" class="btn btn-outline-danger px-4">Clear</button>
                            <button type="button" id="clearSelections" class="btn btn-outline-dark px-4">Clear Color/Size</button>
                        </div>

                        <div class="text-end mt-4">
                            <a href="product_list.php" class="text-decoration-none">← Back to Product List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .color-option .color-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid #ccc;
        transition: all 0.3s;
    }
    .color-option .checkmark {
        position: absolute;
        top: 2px;
        right: 6px;
        font-size: 16px;
        color: #000;
        display: none;
    }
    .color-option.active .color-circle {
        border: 3px solid #000;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.4);
    }
    .color-option.active .checkmark {
        display: block;
    }
    .color-option:hover .color-circle {
        border-color: #888;
    }
    .size-option .size-box {
        border: 2px solid #ccc;
        background-color: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .size-option.active .size-box {
        border-color: #000;
        background-color: #e0e0e0;
        color: #000;
        font-weight: bold;
    }
</style>

<script>
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function () {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle('active', checkbox.checked);
        });
    });
    document.querySelectorAll('.size-option').forEach(option => {
        option.addEventListener('click', function () {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            this.classList.toggle('active', checkbox.checked);
        });
    });
    document.getElementById('clearSelections').addEventListener('click', function () {
        document.querySelectorAll('.color-option input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
            cb.closest('.color-option').classList.remove('active');
        });
        document.querySelectorAll('.size-option input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
            cb.closest('.size-option').classList.remove('active');
        });
    });
</script>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
