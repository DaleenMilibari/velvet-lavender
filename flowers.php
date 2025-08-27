<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once 'config.php';
$page_title = "Flowers";
include 'includes/header.php';

// Notification
if (isset($_GET['added']) || isset($_GET['error'])) {
    $msg = isset($_GET['added'])
        ? 'Item added to cart!'
        : (htmlspecialchars($_GET['error']) === 'out_of_stock'
            ? 'Not enough stock available.'
            : 'Something went wrong.');

    $bgColor = isset($_GET['added']) ? 'rgb(122, 156, 125)' : 'rgb(198, 126, 123)';
    echo "<div class='alert text-center' id='cart-msg' style='position: fixed; top: 50px; right: 30px; z-index: 9999; padding: 15px; border-radius: 10px; background-color: $bgColor; color: white;'>$msg</div>";
    echo "<script>setTimeout(() => { document.getElementById('cart-msg').style.display = 'none'; }, 3000);</script>";
}

try {
    // Flower subcategories
    $category_stmt = $pdo->prepare("SELECT category_id, name, slug FROM categories WHERE parent_id = 1");
    $category_stmt->execute();
    $categories = $category_stmt->fetchAll();

    // Products under category 1 (Flowers)
    $product_stmt = $pdo->prepare("
        SELECT p.*, c.slug AS category_slug
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        JOIN categories pc ON c.parent_id = pc.category_id
        WHERE pc.category_id = 1
        ORDER BY p.created_at DESC
    ");
    $product_stmt->execute();
    $products = $product_stmt->fetchAll();

    shuffle($products);
} catch (PDOException $e) {
    die("<div class='col-12 text-center'><p class='text-danger'>Database error: " . $e->getMessage() . "</p></div>");
}
?>

<!-- Breadcrumb -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Flowers</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products -->
<a id="products"></a>
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-filters">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <?php foreach ($categories as $category): ?>
                            <li data-filter=".<?= htmlspecialchars($category['slug']) ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row product-lists">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6 text-center <?= htmlspecialchars($product['category_slug']) ?>">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="single-product.php?id=<?= $product['product_id'] ?>">
                                    <img src="<?= BASE_URL . htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                </a>
                            </div>
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p class="product-price">
                                <img src="<?= BASE_URL ?>assets/images/icons/saudi-riyal-symbol.png" width="20px">
                                <?= number_format($product['price'], 2) ?>
                            </p>
                            <form action="cart-action.php#products" method="POST">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No flowers found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>