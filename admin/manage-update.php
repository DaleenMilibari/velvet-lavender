<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/admin-header.php';

$product = [
    'product_id' => '',
    'name' => '',
    'category_id' => '',
    'stock_quantity' => '',
    'price' => '',
    'description' => '',
    'image' => ''
];

$search_error = '';
$update_success = '';
$update_error = '';

$productOptions = $pdo->query("SELECT product_id, name FROM products ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchName = trim($_GET['search']);
    if (!empty($searchName)) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? LIMIT 1");
        $stmt->execute(["%$searchName%"]);
        $found = $stmt->fetch();
        if ($found) {
            $product = $found;
        } else {
            $search_error = "Product not found. Please try another name.";
        }
    } else {
        $search_error = "Please enter a product name to search.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && $_POST['productId'] !== '') {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $categoryId = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $imagePath = '';
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES["productImage"]["tmp_name"]);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($fileType, $allowedTypes)) {
            $targetDir = __DIR__ . '/../assets/images/products/';
            $fileName = basename($_FILES["productImage"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
                $imagePath = 'assets/images/products/' . $fileName;
            }
        } else {
            $update_error = "Invalid file type. Only JPEG, PNG, and GIF are allowed.";
        }
    }

    if (empty($update_error)) {
        $sql = "UPDATE products SET name = :name, category_id = :category, stock_quantity = :stock, price = :price, description = :description";
        if (!empty($imagePath)) {
            $sql .= ", image = :image";
        }
        $sql .= " WHERE product_id = :id";

        $stmt = $pdo->prepare($sql);
        $params = [
            'name' => $productName,
            'category' => $categoryId,
            'stock' => $stock,
            'price' => $price,
            'description' => $description,
            'id' => $productId
        ];
        if (!empty($imagePath)) {
            $params['image'] = $imagePath;
        }

        if ($stmt->execute($params)) {
            $update_success = "Product updated successfully!";
            $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();
        } else {
            $update_error = "Error updating product.";
        }
    }
}
?>

<!-- HTML -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Velvet Lavender</p>
                    <h1>Update Item</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="faqs-list">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">

                <?php if ($search_error): ?>
                    <div class="alert alert-danger"><?= $search_error ?></div>
                <?php endif; ?>
                <?php if ($update_success): ?>
                    <div class="alert alert-success"><?= $update_success ?></div>
                <?php endif; ?>
                <?php if ($update_error): ?>
                    <div class="alert alert-danger"><?= $update_error ?></div>
                <?php endif; ?>

                <!-- Search -->
                <form action="manage-update.php" method="GET" class="mb-4">
                    <label for="search" class="form-label">Search Product by Name:</label>
                    <input type="text" id="search" name="search" class="form-control" list="productList">
                    <datalist id="productList">
                        <?php foreach ($productOptions as $opt): ?>
                            <option value="<?= htmlspecialchars($opt['name']) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                    <div class="mt-2 text-end">
                        <button type="submit" class="boxed-btn">Search</button>
                        <a href="manage-update.php" class="bordered-btn">Reset</a>
                    </div>
                </form>

                <!-- Update Form -->
                <form id="uppdateProductForm" action="manage-update.php" method="POST" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="productId" value="<?= $product['product_id'] ?>">

                    <label for="productName" class="form-label">Product Name:</label>
                    <input type="text" id="productName" name="productName" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" <?= $product['product_id'] ? '' : 'readonly' ?>>

                    <label for="category" class="form-label">Category:</label>
                    <select id="category" name="category" class="form-control" <?= $product['product_id'] ? '' : 'disabled' ?>>
                        <option value="">Select Category</option>
                        <option value="2" <?= $product['category_id'] == 2 ? 'selected' : '' ?>>Flower Bouquets</option>
                        <option value="3" <?= $product['category_id'] == 3 ? 'selected' : '' ?>>Flower Vases</option>
                        <option value="5" <?= $product['category_id'] == 5 ? 'selected' : '' ?>>Cakes</option>
                        <option value="6" <?= $product['category_id'] == 6 ? 'selected' : '' ?>>Chocolate Boxes</option>
                    </select>

                    <label for="stock" class="form-label">Stock Quantity:</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="<?= $product['stock_quantity'] ?>" min="1" <?= $product['product_id'] ? '' : 'readonly' ?>>

                    <label for="price" class="form-label">Price (SAR):</label>
                    <input type="number" id="price" name="price" class="form-control" value="<?= $product['price'] ?>" step="0.01" min="1" <?= $product['product_id'] ? '' : 'readonly' ?>>

                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" <?= $product['product_id'] ? '' : 'readonly' ?>><?= htmlspecialchars($product['description']) ?></textarea>

                    <label for="productImage" class="form-label">Product Image:</label>
                    <input type="file" id="productImage" name="productImage" class="form-control" accept="image/*" <?= $product['product_id'] ? '' : 'disabled' ?>>

                    <?php if (!empty($product['image'])): ?>
                        <div class="mt-2">
                            <img src="/velvet_lavender/<?= $product['image'] ?>" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    <?php endif; ?>

                    <div class="mt-4">
                        <button type="submit" class="boxed-btn" <?= $product['product_id'] ? '' : 'disabled' ?>>Update Product</button>
                        <a href="manage-update.php" class="bordered-btn">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>