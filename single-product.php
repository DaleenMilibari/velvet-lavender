<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
ob_start(); // Start output buffering BEFORE any output
session_start();
require_once 'config.php';

$page_title = "Product Details";
include 'includes/header.php';

// Handle Add to Cart / Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;
    $action = $_POST['action'] ?? 'add';

    $stmt = $pdo->prepare("SELECT name, price, discount_price, stock_quantity, image FROM products WHERE product_id = ?");
    $stmt->execute([$product_id]);
    $product_data = $stmt->fetch();

    if ($product_data && $product_data['stock_quantity'] >= $quantity) {
        $price = $product_data['discount_price'] > 0 ? $product_data['discount_price'] : $product_data['price'];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product_data['name'],
                'price' => $price,
                'image' => $product_data['image'],
                'quantity' => $quantity
            ];
        }

        if ($action === 'checkout') {
            header("Location: checkout.php");
        } else {
            header("Location: single-product.php?id=$product_id&added=1");
        }
        exit(); // to stop further output
    } else {
        $error = "Sorry, not enough stock available.";
    }
}

// Fetch Product Info
if (!isset($_GET['id'])) {
    header("Location: 404.php");
    exit();
}

$product_id = (int) $_GET['id'];

try {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name AS category_name, pc.name AS parent_category
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        LEFT JOIN categories pc ON c.parent_id = pc.category_id
        WHERE p.product_id = ?
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        header("Location: 404.php");
        exit();
    }

    $related_stmt = $pdo->prepare("
        SELECT * FROM products 
        WHERE category_id = ? AND product_id != ?
        ORDER BY RAND()
        LIMIT 3
    ");
    $related_stmt->execute([$product['category_id'], $product_id]);
    $related_products = $related_stmt->fetchAll();
} catch (PDOException $e) {
    die("<div class='container text-center py-5'><h2>Error loading product: " . $e->getMessage() . "</h2></div>");
}

$page_title = $product['name'];
?>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>See more Details</p>
                    <h1><?= htmlspecialchars($product['name']) ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- single product -->
<div class="single-product mt-150 mb-150">
    <div class="container">
        <?php if (isset($_GET['added'])): ?>
            <div class="alert alert-success text-center">Item added to cart!</div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-5">
                <div class="single-product-img">
                    <img src="<?= BASE_URL . htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                        class="img-fluid">
                </div>
            </div>
            <div class="col-md-7">
                <div class="single-product-content">
                    <h1><?= htmlspecialchars($product['name']) ?></h1>
                    <p class="single-product-pricing">
                        <img src="<?= BASE_URL ?>assets/images/icons/saudi-riyal-symbol.png" width="20px">
                        <?= number_format($product['price'], 2) ?>
                    </p>
                    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                    <div class="single-product-form">
                        <form action="single-product.php?id=<?= $product_id ?>" method="POST" novalidate>
                            <input type="hidden" name="product_id" value="<?= $product_id ?>">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" class="form-control mb-3" style="width: 120px;">
                            <button type="submit" name="action" value="add" class="cart-btn">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button type="submit" name="action" value="checkout" class="checkout-btn">
                                Checkout
                            </button>
                        </form>
                        <p class="product-categories mt-3">
                            <strong>Categories:</strong>
                            <?= htmlspecialchars($product['parent_category'] . ' › ' . $product['category_name']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<div class="more-products mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="purple-text">Related</span> Products</h3>
                    <p>Take a look at other beautiful products you might love!</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($related_products as $related): ?>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            <a href="single-product.php?id=<?= $related['product_id'] ?>">
                                <img src="<?= BASE_URL . htmlspecialchars($related['image']) ?>"
                                    alt="<?= htmlspecialchars($related['name']) ?>"
                                    class="img-fluid">
                            </a>
                        </div>
                        <h3><?= htmlspecialchars($related['name']) ?></h3>
                        <p class="product-price">
                            <img src="<?= BASE_URL ?>assets/images/icons/saudi-riyal-symbol.png" width="20px">
                            <?= number_format($related['price'], 2) ?>
                        </p>
                        <form action="single-product.php?id=<?= $related['product_id'] ?>" method="POST" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="<?= $related['product_id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" name="action" value="add" class="cart-btn">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
ob_end_flush();
?>