<?php

session_name('user');
session_start();

include_once __DIR__ . '/../controller/CategoryController.php';
include_once __DIR__ . '/../controller/SubcategoryController.php';
include_once __DIR__ . '/../controller/CartController.php';

$catController = new CategoryController();
$subCatController = new SubcategoryController();
$cart_controller = new CartController();

$categories = $catController->getCategories();

$user_id = $_SESSION['id'] ?? null;

$cartCount = 0;
if ($user_id) {
    $cartCount = $cart_controller->getUniqueCartCount($user_id);
}

$bgColors = ['#000000', '#343a40', '#6c757d', '#495057', '#adb5bd'];
$randomBg = $bgColors[array_rand($bgColors)];

$userName = $_SESSION['name'] ?? null;
$firstLetter = $userName ? strtoupper($userName[0]) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="my_css/style.css">
</head>

<body>
    <div class="container-fluid py-1 bg-body-tertiary px-4">
        <div class="top-nav d-flex justify-content-end">
            <p class="mx-1 fw-semibold">EN |</p>
            <p class="mx-1 fw-semibold">$USD</p>
            <p class="mx-2 fw-semibold">Need Help?</p>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
        <div class="container-fluid">


            <a class="navbar-brand" href="index.php">
                <img class="logo" src="img/logo.png" alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse mx-5 d-none d-lg-block">
                <ul class="navbar-nav fw-medium align-items-center">

                    <li class="nav-item dropdown position-static mega-dropdown me-4">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown">Categories</a>

                        <div class="dropdown-menu bg-white p-4 category-dropdown shadow-lg" aria-labelledby="categoryDropdown">
                            <div class="d-flex">

                                <div class="category-list pe-4 border-end">
                                    <?php foreach ($categories as $index => $cat): ?>
                                        <div class="category-item d-flex align-items-center mb-3" data-category="<?= $cat['id'] ?>">
                                            <img src="admin_taotao/uploads/<?= $cat['image'] ?>" class="category-icon me-2" alt="<?= $cat['name'] ?>">
                                            <span><?= htmlspecialchars($cat['name']) ?></span>
                                        </div>

                                    <?php endforeach; ?>
                                </div>

                                <div class="subcategory-list ps-4 flex-grow-1" id="subcategory-container">
                                    <a href="product.php?category=<?= $categories[0]['id'] ?>" class="view-all-link">👁 View All</a>

                                </div>
                            </div>
                        </div>
                    </li>
                    <div class="d-flex align-items-center">
                        <div class="category-scroll-area d-flex align-items-center me-lg-5" style="max-width: 44%; position: relative;">
                            <div class="category-scroll d-flex flex-nowrap overflow-x-auto pe-4">
                                <?php foreach ($categories as $cat): ?>
                                    <div class="me-4">
                                        <a class="nav-link text-nowrap" href="product.php?category=<?= $cat['id'] ?>">
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="scroll-controls ms-2 d-flex">
                                <button class="scroll-btn btn btn-light me-1 scroll-left">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="scroll-btn btn btn-light scroll-right">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>



                        <div class="navIcon d-none d-lg-flex align-items-center mx-lg-5">
                            <a href="#"><i class="bi bi-search fs-5 me-5"></i></a>


                            <div class="dropdown">
                                <a href="#" class="text-black" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person fs-4 me-5"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end p-3 shadow" style="min-width: 250px; background-color: #fff; border: 1px solid #000; border-radius: 12px;">
                                    <?php if ($userName): ?>
                                        <li class="d-flex align-items-center mb-3">
                                            <div style="width: 40px;height: 40px; background-color: <?= $randomBg ?>;color: #fff;font-weight: bold;display: flex;align-items: center;justify-content: center;border-radius: 50%;margin-right: 10px;font-size: 18px;">
                                                <?= $firstLetter ?>
                                            </div>
                                            <span class="fw-bold text-dark"><?= htmlspecialchars($userName) ?></span>
                                        </li>

                                        <hr class="dropdown-divider">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center mb-2" href="#" style="color: #000;">
                                                <i class="bi bi-person-circle me-2 fs-5"></i> My Account
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center mb-2" href="#" style="color: #000;">
                                                <i class="bi bi-clock-history me-2 fs-5"></i> Order History
                                            </a>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center text-danger" href="logout.php">
                                                <i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center mb-2" href="login.php" style="color: #000;">
                                                <i class="bi bi-box-arrow-in-right me-2 fs-5"></i> Sign Up / Login
                                            </a>
                                        </li>
                                        <hr class="dropdown-divider">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center mb-2" href="#" style="color: #000;">
                                                <i class="bi bi-person-circle me-2 fs-5"></i> My Account
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="#" style="color: #000;">
                                                <i class="bi bi-clock-history me-2 fs-5"></i> Order History
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>


                            <a href="favourites.php"><i class="bi bi-heart fs-5 me-5"></i></a>
                            <a href="cart.php" class="position-relative">
                                <i class="bi bi-bag fs-5"></i>
                                <span id="cart-badge"
                                    class="position-absolute top-0 start-100 translate-middle badge bg-dark rounded-circle"
                                    style="font-size: 0.6rem; padding: 0.3em 0.45em; <?= $cartCount > 0 ? '' : 'display:none;' ?>">
                                    <?= $cartCount ?>
                                </span>
                            </a>



                        </div>
                    </div>


            </div>
    </nav>


    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar"
        aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <?php foreach ($categories as $cat): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php?category=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="nav-item border-top mt-2">
                    <a class="nav-link" href="#"><i class="bi bi-person me-2 fs-4"></i> Account</a>
                    <a class="btn btn-light px-3 py-1 mt-2">Sign in</a>
                </li>
                <li class="nav-item border-top">
                    <a class="nav-link" href="#"><i class="bi bi-heart me-2 fs-5"></i> Wishlist</a>
                </li>
                <li class="nav-item border-top">
                    <a class="nav-link" href="#"><i class="bi bi-box-seam me-2 fs-5"></i> My Orders</a>
                </li>
            </ul>
        </div>
    </div>

</body>

</html>

<script>
    function updateCartCount() {
        console.log("Fetching cart count...");
        fetch('/taotao/get_cart_count.php')
            .then(response => response.json())
            .then(data => {
                console.log("Received data:", data);
                const badge = document.getElementById('cart-badge');
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => {
                console.error("Fetch failed:", error);
            });
    }

    document.addEventListener('DOMContentLoaded', updateCartCount);
</script>