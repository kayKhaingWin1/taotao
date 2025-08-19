<?php
include_once __DIR__ . '/layout/header.php';
include_once __DIR__ . '/controller/CartController.php';
include_once __DIR__ . '/controller/DiscountController.php';

if (!isset($_SESSION['id'])) {
    $isLoggedIn = false;
} else {
    $isLoggedIn = true;
    $user_id = $_SESSION['id'];

    $cart_controller = new CartController();
    $cartItems = $cart_controller->getCartItems($user_id);
    $cartCount = $cart_controller->getUniqueCartCount($user_id);

    $discount_controller = new DiscountController();

    $subtotal = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
</head>

<body class="bg-light text-dark">
    <div class="container py-5">
        <h4 class="mb-4 text-start">My Shopping Bag</h4>
        <?php if (!$isLoggedIn): ?>
            <div class="text-center py-5">
                <img src="img/login_needed.png" style="width: 180px;height:150px;">
                <p class="text-center text-danger fw-bold">You need to log in first.</p>
            </div>
        <?php else: ?>
            <?php if (count($cartItems) > 0): ?>
                <div class="d-flex justify-content-between my-2">
                    <p><span class="fw-bold"><?= $cartCount ?> items</span> in your bag</p>
                    <a href="javascript:void(0);" id="clear-cart" class="btn btn-outline-secondary">Clear All Items</a>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-md-8">
                    <?php if (count($cartItems) > 0): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                            $discounts = $discount_controller->getDiscountsByProductId($item['product_id']);
                            $hasDiscount = count($discounts) > 0;
                            $price = $item['price'];
                            $discountPrice = $price;

                            if ($hasDiscount) {
                                $percent = $discounts[0]['discount'];
                                $discountPrice = $price * (1 - $percent / 100);
                            }

                            $subtotal += $hasDiscount ? ($discountPrice * $item['quantity']) : ($price * $item['quantity']);
                            ?>

                            <div class="d-flex flex-wrap gap-3 p-3 bg-white cart-item border-bottom">
                                <div style="flex: 0 0 auto; width: 150px; height: 200px; overflow: hidden;">
                                    <div style="position: relative; flex: 0 0 auto; width: 150px; height: 200px; overflow: hidden;">
                                        <?php if ($hasDiscount): ?>
                                            <div style="position: absolute; top: 8px; left: 8px; background-color: black; color: white; padding: 2px 4px; font-size: 0.85rem; border-radius: 5px;">
                                                -<?= $percent ?>%
                                            </div>
                                        <?php endif; ?>
                                        <img src="admin_taotao/uploads/<?= $item['image'] ?>" alt="Product Image"
                                            style="width: 100%; height: 100%; object-fit:cover;">
                                    </div>
                                </div>

                                <div style="flex: 1 1 200px; min-width: 150px;">
                                    <h5 class="text-truncate" style="max-width: 100%;margin-bottom:65px;"><?= $item['product_name'] ?></h5>
                                    <div class="d-flex flex-wrap gap-1 text-muted" style="font-size: 1rem;">
                                        <span class="me-2">Size- <?= $item['size'] ?></span>
                                        <span class="mx-2">|</span>
                                        <img style="height: 30px;width:30px;border-radius:50%;background-color: <?= $item['color_code'] ?>;">
                                        <span><?= $item['color'] ?></span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <div style="flex: 0 0 100px; font-weight: 600;">
                                        <?php if ($hasDiscount): ?>
                                            <span style="color: red;">$<?= number_format($discountPrice, 2) ?></span>
                                        <?php else: ?>
                                            $<?= number_format($price, 2) ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn qty-btn decrease" data-id="<?= $item['cart_id'] ?>"><i class="bi bi-dash"></i></button>
                                        <span><?= $item['quantity'] ?></span>
                                        <button class="btn qty-btn increase" data-id="<?= $item['cart_id'] ?>"><i class="bi bi-plus"></i></button>
                                    </div>

                                    <div class="text-end">
                                        <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                        <button name="remove" class="btn btn-outline-danger rounded-circle">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <img src="img/empty_bag.png" style="width: 250px;height:240px;">
                            <p class="text-center text-danger">Your Cart is Empty</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (count($cartItems) > 0): ?>
                    <div class="col-md-4">
                        <div class="card p-4 bg-white shadow-sm border-0 rounded-4">
                            <h4 class="mb-3">Order Summary</h4>
                            <hr>
                            <div>
                                <?php foreach ($cartItems as $item): ?>
                                    <?php
                                    $discounts = $discount_controller->getDiscountsByProductId($item['product_id']);
                                    $hasDiscount = count($discounts) > 0;
                                    $price = $item['price'];
                                    $discountPrice = $price;
                                    if ($hasDiscount) {
                                        $percent = $discounts[0]['discount'];
                                        $discountPrice = $price * (1 - $percent / 100);
                                    }

                                    $colorText = $item['color'] ? "({$item['color']})" : '';
                                    $sizeText = $item['size'] ? "({$item['size']})" : '';
                                    $productName = $item['product_name'];
                                    ?>
                                    <div class="d-flex justify-content-between small border-bottom py-1">
                                        <div class="d-flex">
                                            <p class="text-truncate" style="max-width: 120px;">
                                                <?= $productName ?></p>
                                            <p><?= $colorText ?> </p>
                                            <p><?= $sizeText ?></p>
                                            <p>x <?= $item['quantity'] ?></p>
                                        </div>
                                        <div>$<?= number_format($discountPrice * $item['quantity'], 2) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                            <p class="text-end">Total: <strong>$<?= number_format($subtotal, 2) ?></strong></p>
                            <a href="order.php" class="btn btn-dark w-100 mt-3">Proceed to Checkout</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        $(function() {
            $('.qty-btn').click(function() {
                const cartId = $(this).data('id');
                const action = $(this).hasClass('increase') ? 'increase' : 'decrease';
                console.log(`Cart ID: ${cartId}, Action: ${action}`);
            });
        });
    </script>
</body>

</html>

<?php
include_once __DIR__ . '/layout/footer.php';
?>