<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once 'config.php';
$page_title = "Flower Bouquets";
include 'includes/header.php';

try {
	$stmt = $pdo->prepare("
        SELECT * 
        FROM products 
        WHERE category_id = 2
        AND is_active = 1
        ORDER BY created_at DESC
    ");
	$stmt->execute();
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	die("<div class='alert alert-danger'>Database Error: " . $e->getMessage() . "</div>");
}
?>

<!-- Notification -->
<?php if (isset($_GET['added'])): ?>
	<div class="alert alert-success text-center" id="cart-msg" style="position: fixed; top: 50px; right: 30px; z-index: 9999; background-color: rgb(122, 156, 125); color: white; padding: 15px; border-radius: 10px;">
		Item added to cart!
	</div>
<?php elseif (isset($_GET['error'])): ?>
	<div class="alert alert-danger text-center" id="cart-msg" style="position: fixed; top: 50px; right: 30px; z-index: 9999; background-color: rgb(198, 126, 123); color: white; padding: 15px; border-radius: 10px;">
		<?= htmlspecialchars($_GET['error']) === 'out_of_stock' ? 'Not enough stock available.' : 'Something went wrong.' ?>
	</div>
<?php endif; ?>
<script>
	setTimeout(() => {
		const alert = document.getElementById('cart-msg');
		if (alert) alert.style.display = 'none';
	}, 3000);
</script>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Handcrafted Arrangements</p>
					<h1>Flower Bouquets</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- products -->
<a id="products"></a>
<div class="product-section mt-150 mb-150">
	<div class="container">
		<?php if (!empty($products)): ?>
			<div class="row product-lists">
				<?php foreach ($products as $product): ?>
					<div class="col-lg-4 col-md-6 text-center">
						<div class="single-product-item">
							<div class="product-image">
								<a href="single-product.php?id=<?= $product['product_id'] ?>">
									<img src="<?= BASE_URL . $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
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
								<input type="hidden" name="redirect" value="flowers-bouquets.php">
								<button type="submit" class="cart-btn">
									<i class="fas fa-shopping-cart"></i> Add to Cart
								</button>
							</form>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="alert alert-warning text-center">
				<h4>No Bouquets Found!</h4>
				<p>We're currently updating our collection. Please check back later.</p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php include 'includes/footer.php'; ?>