<?php
session_start();
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request.';
    header('Location: manage-add.php');
    exit();
}

try {
    $name = trim($_POST['productName']);
    $categoryId = (int) $_POST['category'];
    $stock = (int) $_POST['stock'];
    $price = (float) $_POST['price'];
    $description = trim($_POST['description']);

    $allowedCategoryIds = [2, 3, 5, 6];
    if (
        empty($name) || !in_array($categoryId, $allowedCategoryIds) ||
        $stock < 1 || $price < 0 || empty($description)
    ) {
        $_SESSION['error'] = 'Invalid product data. Ensure you selected a correct category.';
        header('Location: manage-add.php');
        exit();
    }

    // Generate slug
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

    // Handle image upload
    if (!isset($_FILES['productImage']) || $_FILES['productImage']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = 'Image upload failed.';
        header('Location: manage-add.php');
        exit();
    }

    $imageTmp = $_FILES['productImage']['tmp_name'];
    $imageMime = mime_content_type($imageTmp);
    $imageExt = strtolower(pathinfo($_FILES['productImage']['name'], PATHINFO_EXTENSION));

    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    $allowedExts  = ['jpg', 'jpeg', 'png'];

    if (!in_array($imageMime, $allowedTypes) || !in_array($imageExt, $allowedExts)) {
        $_SESSION['error'] = 'Only JPG, JPEG, and PNG images are allowed.';
        header('Location: manage-add.php');
        exit();
    }

    // Directory
    $uploadDir = realpath(__DIR__ . '/../assets/images/products');
    if (!$uploadDir || !is_dir($uploadDir)) {
        mkdir(__DIR__ . '/../assets/images/products', 0755, true);
        $uploadDir = realpath(__DIR__ . '/../assets/images/products');
    }

    // Generate custom image name
    $prefixMap = [
        2 => 'BQT',
        3 => 'VASE',
        5 => 'CAKE',
        6 => 'CHOC'
    ];
    $prefix = $prefixMap[$categoryId] ?? 'IMG';

    // Auto-generate xx > 15 based on time (unique enough)
    $xx = rand(16, 999);
    $uniqueImageName = $prefix . $xx . '.' . $imageExt;
    $fullPath = $uploadDir . '/' . $uniqueImageName;

    if (!move_uploaded_file($imageTmp, $fullPath)) {
        $_SESSION['error'] = 'Failed to save the uploaded image.';
        header('Location: manage-add.php');
        exit();
    }

    $imagePath = 'assets/images/products/' . $uniqueImageName;

    // Insert into DB
    $stmt = $pdo->prepare("INSERT INTO products (name, slug, category_id, stock_quantity, price, description, image)
                           VALUES (:name, :slug, :category_id, :stock, :price, :description, :image)");

    $stmt->execute([
        'name' => $name,
        'slug' => $slug,
        'category_id' => $categoryId,
        'stock' => $stock,
        'price' => $price,
        'description' => $description,
        'image' => $imagePath
    ]);

    $_SESSION['success'] = 'Product added successfully!';
    header('Location: manage-add.php');
    exit();
} catch (Exception $e) {
    error_log('Add product error: ' . $e->getMessage());
    $_SESSION['error'] = 'An unexpected error occurred while adding the product.';
    header('Location: manage-add.php');
    exit();
}
