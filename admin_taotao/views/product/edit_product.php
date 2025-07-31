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

$id = $_GET['id'];
$product = $product_controller->getProduct($id);
$brands = $brand_controller->getBrands();
$subcategories = $subcategory_controller->getSubcategories();
$colors = $colorsizes_controller->getColors();
$sizes = $colorsizes_controller->getSizes();
$discounts = $discount_controller->getDiscounts();

$name = $product['name'] ?? '';
$price = $product['price'] ?? '';
$description = $product['description'] ?? '';
$image = $product['image'] ?? '';
$brand_id = $product['brand_id'] ?? '';
$sub_id = $product['sub_id'] ?? '';
$current_discount = $product_controller->getDiscountByProductId($id)['id'] ?? '';
$selected_colorsizes = $product_controller->getColorSizes($id);

$selected_colors = array_unique(array_column($selected_colorsizes, 'color_code'));
$selected_sizes = array_unique(array_column($selected_colorsizes, 'size'));

$errors = [];

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $brand_id = $_POST['brand_id'];
    $sub_id = $_POST['sub_id'];
    $newImage = $_FILES['image']['name'] ?? '';
    $color_ids = $_POST['color_ids'] ?? [];
    $size_ids = $_POST['size_ids'] ?? [];
    $discount_id = $_POST['discount_id'] ?? null;

    if (empty($name)) $errors['name'] = "Please enter product name";
    if (empty($price)) $errors['price'] = "Please enter price";
    if (empty($description)) $errors['description'] = "Please enter description";
    if (empty($brand_id)) $errors['brand_id'] = "Please select a brand";
    if (empty($sub_id)) $errors['sub_id'] = "Please select a subcategory";

    if (!empty($newImage)) {
        $targetDir = "../../uploads/";
        $targetFile = $targetDir . basename($newImage);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $newImage;
        } else {
            $errors['image'] = "Image upload failed.";
        }
    }

    if (empty($errors)) {
        $product_controller->editProduct($id, $name, $price, $description, $image, $brand_id, $sub_id);
        $product_controller->deleteProductColorSize($id); 
        foreach ($color_ids as $color_id) {
            foreach ($size_ids as $size_id) {
                $product_controller->addProductColorSize($id, $color_id, $size_id);
            }
        }

        if (!empty($discount_id)) {
            $product_controller->deleteDiscountFromProduct($id); 
            $product_controller->addDiscountToProduct($id, $discount_id);
        }

        header('location: product_list.php?update_status=success');
        exit;
    }
}

include_once __DIR__ . '/../../layouts/header.php';
?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Edit Product</h3>
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
                            <label class="form-label">Current Image</label><br>
                            <img src="../../uploads/<?= $image ?>" class="rounded-3" style="max-width: 120px;"><br>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image" class="form-control rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" class="form-select rounded-3">
                                <option value="">-- Select Brand --</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $brand_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($brand['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subcategory</label>
                            <select name="sub_id" class="form-select rounded-3">
                                <option value="">-- Select Subcategory --</option>
                                <?php foreach ($subcategories as $sub): ?>
                                    <option value="<?= $sub['id'] ?>" <?= $sub['id'] == $sub_id ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                     
                        <div class="mb-3">
                            <label class="form-label">Discount</label>
                            <select name="discount_id" class="form-select rounded-3">
                                <option value="">-- Select Discount --</option>
                                <?php foreach ($discounts as $discount): ?>
                                    <option value="<?= $discount['id'] ?>" <?= $discount['id'] == $current_discount ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($discount['voucher_code']) ?> - <?= $discount['discount'] ?>%
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Color / Size selections -->
                        <div class="mb-3">
                            <label class="form-label">Colors</label>
                            <div class="d-flex flex-wrap gap-3">
                                <?php foreach ($colors as $color): ?>
                                    <label class="color-option position-relative" style="cursor:pointer;">
                                        <input type="checkbox" name="color_ids[]" value="<?= $color['id'] ?>" <?= in_array($color['color_code'], $selected_colors) ? 'checked' : '' ?> class="d-none">
                                        <span class="color-circle" style="background-color: <?= $color['color_code'] ?>;"></span>
                                        <span class="checkmark">&#10003;</span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sizes</label>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($sizes as $size): ?>
                                    <label class="size-option" style="cursor:pointer;">
                                        <input type="checkbox" name="size_ids[]" value="<?= $size['id'] ?>" <?= in_array($size['size'], $selected_sizes) ? 'checked' : '' ?> class="d-none">
                                        <span class="size-box px-3 py-1 border rounded text-dark"><?= htmlspecialchars($size['size']) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                            <a href="product_list.php" class="btn btn-outline-secondary px-4">← Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- styles + script from create_product -->
<style>
    .color-option .color-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid #ccc;
    }

    .color-option .checkmark {
        position: absolute;
        top: 2px;
        right: 6px;
        font-size: 16px;
        color: #000;
        display: none;
    }

    .color-option input:checked + .color-circle {
        border: 3px solid #000;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.4);
    }

    .color-option input:checked ~ .checkmark {
        display: block;
    }

    .size-option .size-box {
        border: 2px solid #ccc;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .size-option input:checked + .size-box {
        border-color: #000;
        background-color: #e0e0e0;
        color: #000;
        font-weight: bold;
    }
</style>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
