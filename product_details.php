<?php
include_once __DIR__ . "/layout/header.php";
include_once __DIR__ . '/controller/ProductController.php';
include_once __DIR__ . '/controller/DiscountController.php';
include_once __DIR__ . '/controller/BrandController.php';
include_once __DIR__ . '/controller/ColorController.php';
include_once __DIR__ . '/controller/SizeController.php';
include_once __DIR__ . '/controller/ProductSizeColorController.php';

$product_controller = new ProductController();
$discount_controller = new DiscountController();
$brand_controller = new BrandController();
$color_controller = new ColorController();
$size_controller = new SizeController();
$pscController = new ProductSizeColorController();

$id = $_GET['id'] ?? 0;

$product = $product_controller->getProduct($id);
if (!$product) {
  echo "Product not found!";
  exit;
}

$discounts = $discount_controller->getDiscountsByProductId($id);
$brand = $brand_controller->getBrand($product['brand_id']);
$colors = $color_controller->getColorsByProductId($id);
$sizes = $size_controller->getSizesByProductId($id);
$productSizeColorMap = $pscController->getByProductId($id);

$hasDiscount = !empty($discounts);
$discount = $hasDiscount ? $discounts[0] : null;
$discountedPrice = $hasDiscount ? $product['price'] * (1 - ($discount['discount'] / 100)) : $product['price'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['name']) ?></title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div id="alertContainer" style="position: fixed; top: 130px; right: 120px; z-index: 1050;width:80%"></div>

  <div class="container my-5 product-detail-wrapper">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <img src="admin_taotao/uploads/<?= $product['image'] ?>"
          class="img-fluid rounded zoom-image shadow-sm"
          alt="<?= $product['name'] ?>"
          style="max-height: 700px; object-fit: cover;">
      </div>

      <div class="col-md-5">
        <h4 class="mb-2"><?= htmlspecialchars($product['name']) ?></h4>

        <?php if ($hasDiscount): ?>
          <div class="d-flex">
            <span class="fw-bold text-dark me-2 fs-5">$<?= number_format($discountedPrice, 2) ?></span>
            <p class="btn btn-dark fw-semibold" style="font-size: 10px;">SAVE TO <?= $discount['discount'] ?>% OFF</p>
            <del class="text-muted mt-1 ms-3" style="font-size: 14px;">$<?= number_format($product['price'], 2) ?></del>
          </div>
        <?php else: ?>
          <p class="fs-4 text-dark mb-3">$<?= number_format($product['price'], 2) ?></p>
        <?php endif; ?>



        <div class="mb-4">
          <p class="mb-1 fw-medium">COLOUR: <span id="selectedColorName">—</span></p>
          <div class="d-flex gap-3">
            <?php foreach ($colors as $color): ?>
              <div class="color-select border"
                style="width: 40px; height: 60px; background-color: <?= $color['color_code'] ?>;"
                data-color="<?= $color['id'] ?>"
                data-name="<?= htmlspecialchars($color['color']) ?>"></div>
            <?php endforeach; ?>

          </div>
        </div>


        <div class="mb-4">
          <p class="mb-1 fw-medium">SIZE</p>
          <div class="d-grid" style="grid-template-columns: repeat(5, 1fr); gap: 8px;">
            <?php foreach ($sizes as $size): ?>
              <div class="size-select text-center py-2 border rounded" data-size="<?= $size['id'] ?>"><?= $size['size'] ?></div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="mb-4 d-flex align-items-center">
          <button class="btn btn-dark px-3 py-2" onclick="adjustQty(-1)">-</button>
          <input type="text" id="qtyInput" value="1" readonly class="form-control text-center mx-2" style="width: 60px;">
          <button class="btn btn-dark px-3 py-2" onclick="adjustQty(1)">+</button>
        </div>

        <div class="mb-4">
          <button class="btn btn-dark w-100 py-3 fw-semibold" id="addToCartBtn" data-product-id="<?= $id ?>">ADD</button>
        </div>

        <div class="mt-4">
          <p class="fw-medium mb-1">PRODUCT DESCRIPTION</p>
          <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>

        <p class="mb-3"><strong>Brand:</strong> <?= htmlspecialchars($brand['name'] ?? 'N/A') ?></p>
      </div>
    </div>
  </div>

</body>

</html>

<script>
  const productSizeColorMap = <?= json_encode($productSizeColorMap) ?>;
  console.log("SizeColorMap:", productSizeColorMap);
</script>

<?php
include_once __DIR__ . "/layout/footer.php";
?>