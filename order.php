<?php
include_once __DIR__ . '/layout/header.php';
include_once __DIR__ . '/controller/TownshipController.php';
include_once __DIR__ . '/controller/PaymentMethodController.php';
include_once __DIR__ . '/controller/CartController.php';
include_once __DIR__ . '/controller/DiscountController.php';

$townshipController = new TownshipController();
$paymentMethodController = new PaymentMethodController();
$cartController = new CartController();
$discountController = new DiscountController();

$user_id = $_SESSION['id'] ?? null;
$cartItems = $user_id ? $cartController->getCartItems($user_id) : [];

foreach ($cartItems as &$item) {
    $item['original_price'] = $item['price'];
    $discounts = $discountController->getDiscountsByProductId($item['product_id']);

    if (!empty($discounts)) {
        $discount = $discounts[0];
        $item['price'] = $item['price'] * (1 - $discount['discount'] / 100);
        $item['discount'] = [
            'id' => $discount['id'],
            'value' => $discount['discount'],
            'code' => $discount['voucher_code']
        ];
    }
}
unset($item);

$subtotal = array_sum(array_map(function ($item) {
    return $item['price'] * $item['quantity'];
}, $cartItems));

$townships = $townshipController->getAllTownships();
$paymentMethods = $paymentMethodController->getActiveMethods();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Place Order - TaoTao</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .order-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .order-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 0.5rem;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .original-price {
            text-decoration: line-through;
            color: #6c757d;
        }

        .discount-price {
            color: #dc3545;
            font-weight: 600;
        }

        .discount-badge {
            background-color: #28a745;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
        }

        .btn-submit {
            background: #000;
            color: #fff;
            padding: 0.75rem;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #333;
        }

        @media (max-width: 768px) {
            .order-card {
                padding: 1.5rem;
            }

            .product-img {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="order-card">
            <h1 class="order-title">Confirm Your Order</h1>

            <?php if (!$user_id): ?>
                <div class="alert alert-warning">Please <a href="login.php" class="alert-link">login</a> to place an order.</div>
            <?php elseif (empty($cartItems)): ?>
                <div class="alert alert-info text-center py-5">
                    <h3>Your cart is empty.</h3>
                    <p>You need to add items to the cart before placing an order.</p>
                    <a href="index.php" class="btn btn-dark mt-3">Go to Shop</a>
                </div>
            <?php else: ?>
                <form id="checkout-form" novalidate>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($_SESSION['name'] ?? '') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="tel" class="form-control" name="phone" id="phone" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">Shipping Address</label>
                        <input type="text" class="form-control" name="address" id="address" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="township_id" class="form-label fw-semibold">Delivery Area</label>
                            <select class="form-select" name="township_id" id="township_id" required>
                                <?php foreach ($townships as $town): ?>
                                    <option value="<?= $town['id'] ?>" data-fee="<?= $town['fee'] ?>">
                                        <?= htmlspecialchars($town['name']) ?> (<?= $town['fee'] ?> Ks)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label fw-semibold">Payment Method</label>
                            <select class="form-select" name="payment_method" id="payment_method" required>
                                <?php foreach ($paymentMethods as $method): ?>
                                    <option value="<?= $method['id'] ?>"><?= htmlspecialchars($method['method']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <h4 class="mt-5 mb-3 fw-semibold">Order Summary</h4>

                    <?php if (empty($cartItems)): ?>
                        <div class="alert alert-info">Your cart is empty.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th class="text-end">Qty</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="admin_taotao/uploads/<?= htmlspecialchars($item['image']) ?>"
                                                        class="product-img me-3"
                                                        alt="<?= htmlspecialchars($item['product_name']) ?>">
                                                    <div>
                                                        <div class="fw-medium"><?= htmlspecialchars($item['product_name']) ?></div>
                                                        <?php if ($item['discount'] ?? false): ?>
                                                            <small class="discount-badge">
                                                                <?= $item['discount']['value'] ?>% OFF (<?= $item['discount']['code'] ?>)
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($item['color'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($item['size'] ?? '-') ?></td>
                                            <td class="text-end"><?= $item['quantity'] ?></td>
                                            <td class="text-end">
                                                <?php if ($item['discount'] ?? false): ?>
                                                    <span class="original-price d-block"><?= number_format($item['original_price'], 2) ?> Ks</span>
                                                    <span class="discount-price"><?= number_format($item['price'], 2) ?> Ks</span>
                                                <?php else: ?>
                                                    <?= number_format($item['price'], 2) ?> Ks
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end fw-semibold">
                                                <?= number_format($item['price'] * $item['quantity'], 2) ?> Ks
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr>
                                        <th colspan="5" class="text-end">Subtotal</th>
                                        <th class="text-end" data-value="<?= $subtotal ?>" id="subtotal"><?= number_format($subtotal, 2) ?> Ks</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-end">Delivery Fee</th>
                                        <th class="text-end" id="delivery-fee">0 Ks</th>
                                    </tr>
                                    <tr class="table-active">
                                        <th colspan="5" class="text-end">Total</th>
                                        <th class="text-end" id="total-price"><?= number_format($subtotal, 2) ?> Ks</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-submit btn-lg">
                                <span class="submit-text">Place Order</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </div>



    <?php include_once __DIR__ . '/layout/footer.php'; ?>