<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php';

// Determine current page to highlight menu
$current_page = basename($_SERVER['PHP_SELF']);

// Get cart item count
$cart_count = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Shop beautiful flower bouquets, elegant vases, delicious cakes, and luxurious chocolate boxes. Perfect gifts for any occasion. Enjoy a seamless shopping experience!">

    <title><?= isset($page_title) ? "$page_title | Velvet Lavender" : "Velvet Lavender" ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="<?= BASE_URL ?>assets/images/icons/velvet-lavender-logo.png">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Poppins:400,700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/main.css?v=1.1">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/responsive.css?v=1.1">
</head>

<body>
    <!-- Loader -->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>

    <!-- Header -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- Logo -->
                        <div class="site-logo">
                            <a href="<?= BASE_URL ?>index.php">
                                <img src="<?= BASE_URL ?>assets/images/icons/velvet-lavender-logo.png" alt="Velvet Lavender Logo">
                            </a>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="main-menu">
                            <ul>
                                <li class="<?= $current_page === 'index.php' ? 'current-list-item' : '' ?>">
                                    <a href="<?= BASE_URL ?>index.php">Home</a>
                                </li>
                                <li class="<?= in_array($current_page, ['flowers.php', 'flower-bouquets.php', 'flower-vases.php']) ? 'current-list-item' : '' ?>">
                                    <a href="<?= BASE_URL ?>flowers.php">Flowers</a>
                                    <ul class="sub-menu">
                                        <li><a href="<?= BASE_URL ?>flower-bouquets.php">Flower Bouquets</a></li>
                                        <li><a href="<?= BASE_URL ?>flower-vases.php">Flower Vases</a></li>
                                    </ul>
                                </li>
                                <li class="<?= in_array($current_page, ['cakes-chocolates.php', 'cakes.php', 'chocolate-boxes.php']) ? 'current-list-item' : '' ?>">
                                    <a href="<?= BASE_URL ?>cakes-chocolates.php">Cakes & Chocolates</a>
                                    <ul class="sub-menu">
                                        <li><a href="<?= BASE_URL ?>cakes.php">Cakes</a></li>
                                        <li><a href="<?= BASE_URL ?>chocolate-boxes.php">Chocolate Boxes</a></li>
                                    </ul>
                                </li>
                                <li class="<?= $current_page === 'contact.php' ? 'current-list-item' : '' ?>">
                                    <a href="<?= BASE_URL ?>contact.php">Contact</a>
                                </li>
                                <li>
                                    <!-- Icons: Search, Cart, Account -->
                                    <div class="header-icons">
                                        <a class="past-purchases-icon" href="past-purchases.php"><i class="fas fa-receipt"></i>
                                            <a class="shopping-cart" href="<?= BASE_URL ?>cart.php">
                                                <i class="fas fa-shopping-cart"></i>
                                                <?php if ($cart_count > 0): ?>
                                                    <span class="cart-count"><?= $cart_count ?></span>
                                                <?php endif; ?>
                                            </a>
                                            <a class="account-icon" href="<?= BASE_URL ?>admin-login.php">
                                                <i class='fas fa-user-alt'></i>
                                            </a>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Area -->
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3>Search For:</h3>
                            <form action="<?= BASE_URL ?>search.php" method="GET">
                                <input type="text" name="q" placeholder="Search products..." required>
                                <button type="submit">Search <i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>