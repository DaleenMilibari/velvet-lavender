<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php?error=invalid_request");
    exit;
}

$product_id = (int) ($_POST['product_id'] ?? 0);
$quantity = (int) ($_POST['quantity'] ?? 1);

if ($product_id <= 0 || $quantity <= 0) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=invalid_product#products");
    exit;
}

// Fetch product
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=not_found#products");
    exit;
}

if ($product['stock_quantity'] < $quantity) {
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=out_of_stock#products");
    exit;
}

// Add to cart
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = [
        'name' => $product['name'],
        'price' => $product['discount_price'] > 0 ? $product['discount_price'] : $product['price'],
        'image' => $product['image'],
        'quantity' => $quantity
    ];
}

// Redirect back to original page without query clutter
$ref = strtok($_SERVER['HTTP_REFERER'], '?');
header("Location: " . $ref . "?added=1#products");
exit;
