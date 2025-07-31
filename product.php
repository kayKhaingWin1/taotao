<?php
include_once __DIR__ . "/layout/header.php";
include_once __DIR__ . '/controller/CategoryController.php';
include_once __DIR__ . '/controller/ProductController.php';
include_once __DIR__ . '/controller/SubcategoryController.php';
include_once __DIR__ . '/controller/BrandController.php';
include_once __DIR__ . '/controller/ColorController.php';
include_once __DIR__ . '/controller/SizeController.php';
include_once __DIR__ . '/controller/DiscountController.php';

$product_controller = new ProductController();
$subcategory_controller = new SubcategoryController();
$brand_controller = new BrandController();
$color_controller = new ColorController();
$size_controller = new SizeController();
$category_controller = new CategoryController();
$discount_controller = new DiscountController();

$categoryId = $_GET['category'] ?? 0;
$categories = $category_controller->getCategories();
$categoryName = "All Products";
foreach ($categories as $cat) {
    if ($cat['id'] == $categoryId) {
        $categoryName = $cat['name'];
        break;
    }
}

$keyword = $_GET['search'] ?? '';
$filters = [
    'category' => $_GET['category'] ?? '',
    'subcategory' => $_GET['subcategory'] ?? '',
    'brand' => $_GET['brand'] ?? '',
    'color' => $_GET['color'] ?? '',
    'size' => $_GET['size'] ?? '',
    'price_min' => $_GET['price_min'] ?? '',
    'price_max' => $_GET['price_max'] ?? '',
    'has_discount' => $_GET['has_discount'] ?? ''
];

$sort = $_GET['sort'] ?? '';

$products = $product_controller->getFilteredProducts($keyword, $filters, $sort, $categoryId);
$brands = $brand_controller->getBrands();
$subcategories = !empty($filters['category']) ? $subcategory_controller->getSubcategoriesByCategoryId($filters['category']) : [];
$colors = $color_controller->getColors();
$sizes = $size_controller->getSizes();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Grid</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include_once 'layout/header.php'; ?>

    <div class="container my-4">
        <!-- <div class="filter-bar bg-white p-3 shadow-sm z-1" style="width: 100%;" id="filterBar">
            <form method="GET" id="filterForm" class="row g-3 align-items-center">
                <input type="hidden" name="category" value="<?= htmlspecialchars($categoryId) ?>">
                <div class="col-md-3">
                    <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($keyword) ?>" class="form-control" oninput="debounceSubmit()">
                </div>

                <div class="col-md-2">
                    <select name="sort" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $sort == '' ? 'selected' : '' ?>>Sort By</option>
                        <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price Low to High</option>
                        <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price High to Low</option>
                        <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Name A-Z</option>
                        <option value="name_desc" <?= $sort == 'name_desc' ? 'selected' : '' ?>>Name Z-A</option>
                    </select>

                </div>

                <div class="col-md-1">
                    <select name="brand" class="form-select pe-3" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['brand'] == '' ? 'selected' : '' ?>>Brand</option>
                        <?php foreach ($brands as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= $filters['brand'] == $b['id'] ? 'selected' : '' ?>><?= $b['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="subcategory" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['subcategory'] == '' ? 'selected' : '' ?>>Subcategory</option>
                        <?php foreach ($subcategories as $sub): ?>
                            <option value="<?= $sub['id'] ?>" <?= $filters['subcategory'] == $sub['id'] ? 'selected' : '' ?>><?= $sub['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-1">
                    <select name="color" class="form-select pe-3" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['color'] == '' ? 'selected' : '' ?>>Color</option>
                        <?php foreach ($colors as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $filters['color'] == $c['id'] ? 'selected' : '' ?>><?= $c['color'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-1">
                    <select name="size" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['size'] == '' ? 'selected' : '' ?>>Size</option>
                        <?php foreach ($sizes as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $filters['size'] == $s['id'] ? 'selected' : '' ?>><?= $s['size'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="has_discount" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['has_discount'] == '' ? 'selected' : '' ?>>Discount</option>
                        <option value="1" <?= $filters['has_discount'] == '1' ? 'selected' : '' ?>>On Discount</option>
                    </select>
                </div>

            </form>


            <div class="mt-3 d-flex flex-wrap align-items-center gap-2" id="active-filters">
            </div>
        </div> -->

        <div class="filter-bar bg-white p-3 shadow-sm z-1" style="width: 100%;" id="filterBar">
            <form method="GET" id="filterForm" class="row g-3 align-items-center">
                <input type="hidden" name="category" value="<?= htmlspecialchars($categoryId) ?>">

                <div class="col-12 col-md-4 col-lg-3">
                    <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($keyword) ?>" class="form-control" oninput="debounceSubmit()">
                </div>

                <div class="col-6 col-md-4 col-lg-2">
                    <select name="sort" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $sort == '' ? 'selected' : '' ?>>Sort By</option>
                        <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price Low to High</option>
                        <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price High to Low</option>
                        <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Name A-Z</option>
                        <option value="name_desc" <?= $sort == 'name_desc' ? 'selected' : '' ?>>Name Z-A</option>
                    </select>
                </div>

                <!-- Brand -->
                <div class="col-6 col-md-4 col-lg-1">
                    <select name="brand" class="form-select pe-3" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['brand'] == '' ? 'selected' : '' ?>>Brand</option>
                        <?php foreach ($brands as $b): ?>
                            <option value="<?= $b['id'] ?>" <?= $filters['brand'] == $b['id'] ? 'selected' : '' ?>><?= $b['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Subcategory -->
                <div class="col-6 col-md-4 col-lg-2">
                    <select name="subcategory" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['subcategory'] == '' ? 'selected' : '' ?>>Subcategory</option>
                        <?php foreach ($subcategories as $sub): ?>
                            <option value="<?= $sub['id'] ?>" <?= $filters['subcategory'] == $sub['id'] ? 'selected' : '' ?>><?= $sub['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Color -->
                <div class="col-6 col-md-4 col-lg-1">
                    <select name="color" class="form-select pe-3" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['color'] == '' ? 'selected' : '' ?>>Color</option>
                        <?php foreach ($colors as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $filters['color'] == $c['id'] ? 'selected' : '' ?>><?= $c['color'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Size -->
                <div class="col-6 col-md-4 col-lg-1">
                    <select name="size" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['size'] == '' ? 'selected' : '' ?>>Size</option>
                        <?php foreach ($sizes as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $filters['size'] == $s['id'] ? 'selected' : '' ?>><?= $s['size'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Discount -->
                <div class="col-6 col-md-4 col-lg-2">
                    <select name="has_discount" class="form-select" style="font-size:14px;" onchange="submitForm()">
                        <option value="" disabled <?= $filters['has_discount'] == '' ? 'selected' : '' ?>>Discount</option>
                        <option value="1" <?= $filters['has_discount'] == '1' ? 'selected' : '' ?>>On Discount</option>
                    </select>
                </div>

            </form>

            <div class="mt-3 d-flex flex-wrap align-items-center gap-2" id="active-filters"></div>
        </div>


        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($products as $product): ?>
                <?php
                $discounts = $discount_controller->getDiscountsByProductId($product['id']);
                $hasDiscount = !empty($discounts);
                $discount = $hasDiscount ? $discounts[0] : null;
                $discountedPrice = $hasDiscount ? $product['price'] * (1 - ($discount['discount'] / 100)) : $product['price'];
                ?>
                <div class="col">
                    <a href="product_details.php?id=<?= $product['id'] ?>" class="text-decoration-none text-dark">
                        <div class="card product-card border-0 shadow-sm h-100 overflow-hidden">
                            <div class="position-relative">
                                <img src="admin_taotao/uploads/<?= $product['image'] ?>" class="product-img w-100" alt="<?= $product['name'] ?>">
                                <?php if ($hasDiscount): ?>
                                    <span class="badge bg-danger discount-badge position-absolute top-0 start-0 m-2"><?= $discount['discount'] ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title text-truncate mb-1"><?= htmlspecialchars($product['name']) ?></h6>
                                <?php if ($hasDiscount): ?>
                                    <div class="mb-1 small">
                                        <del class="text-muted">$<?= number_format($product['price'], 2) ?></del>
                                        <span class="fw-bold ms-2 text-danger">$<?= number_format($discountedPrice, 2) ?></span>
                                    </div>
                                <?php else: ?>
                                    <p class="text-dark small mb-1 fw-semibold">$<?= number_format($product['price'], 2) ?></p>
                                <?php endif; ?>


                                <div class="mb-1">
                                    <?php foreach (explode(',', $product['color_codes']) as $code): ?>
                                        <span class="color-circle me-1" style="background-color: <?= $code ?>"></span>
                                    <?php endforeach; ?>
                                </div>


                                <div>
                                    <?php foreach (explode(',', $product['sizes']) as $sz): ?>
                                        <span class="size-box small me-1"><?= $sz ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>





</body>

</html>
<?php
include_once __DIR__ . "/layout/footer.php";
?>