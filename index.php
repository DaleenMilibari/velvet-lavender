<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once 'config.php';
$page_title = "Velvet Lavender - Premium Florist & Gift Boutique";
require_once __DIR__ . '/includes/header.php';

try {
	$stmt = $pdo->query("
        SELECT p.*, c.name AS category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        WHERE c.category_id IN (2, 3, 5, 6)
        ORDER BY RAND()
        LIMIT 9
    ");
	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	error_log("Database error: " . $e->getMessage());
	$products = [];
}
?>

<!-- Notification -->
<?php if (isset($_GET['added'])): ?>
	<div class="alert alert-success text-center" id="cart-msg" style="position: fixed; top: 50px; right: 30px; z-index: 9999; background-color: #73a878; color: white; padding: 15px; border-radius: 10px;">
		Item added to cart!
	</div>
<?php elseif (isset($_GET['error'])): ?>
	<div class="alert alert-danger text-center" id="cart-msg" style="position: fixed; top: 50px; right: 30px; z-index: 9999; background-color: #b85e5b; color: white; padding: 15px; border-radius: 10px;">
		<?= htmlspecialchars($_GET['error']) === 'out_of_stock' ? 'Not enough stock available.' : 'Something went wrong.' ?>
	</div>
<?php endif; ?>

<script>
	setTimeout(() => {
		const alert = document.getElementById('cart-msg');
		if (alert) alert.style.display = 'none';
	}, 3000);
</script>

<main>
	<!-- Hero Slider -->
	<div class="homepage-slider">
		<div class="single-homepage-slider homepage-bg-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-lg-7 offset-lg-1 offset-xl-0">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">Baked Everyday</p>
								<h1>Delicious Cake</h1>
								<div class="hero-btns">
									<a href="cakes.php" class="boxed-btn">Cake Collection</a>
									<a href="contact.php" class="bordered-btn">Contact Us</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="single-homepage-slider homepage-bg-2">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1 text-center">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">Mega Sale Going On!</p>
								<h1>Get Eid Discount</h1>
								<div class="hero-btns">
									<a href="contact.php" class="boxed-btn">Contact Us</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="single-homepage-slider homepage-bg-3">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1 text-right">
						<div class="hero-text">
							<div class="hero-text-tablecell">
								<p class="subtitle">Fresh Everyday</p>
								<h1>Stunning Flowers</h1>
								<div class="hero-btns">
									<a href="flowers.php" class="boxed-btn">Flower Collection</a>
									<a href="contact.php" class="bordered-btn">Contact Us</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Features Section -->
	<div class="list-section pt-80 pb-80">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon"><i class="fas fa-shipping-fast"></i></div>
						<div class="content">
							<h3>Free Delivery</h3>
							<p>When order over 200 SAR</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
					<div class="list-box d-flex align-items-center">
						<div class="list-icon"><i class="fas fa-phone-volume"></i></div>
						<div class="content">
							<h3>24/7 Support</h3>
							<p>Get support all day</p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="list-box d-flex justify-content-start align-items-center">
						<div class="list-icon"><i class="fas fa-sync"></i></div>
						<div class="content">
							<h3>Express Delivery</h3>
							<p>Within 90 minutes!</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Product Section -->
	<section class="product-section mt-150 mb-150" id="products">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">
						<h3><span class="purple-text">Our</span> Products</h3>
						<p>Explore our most loved floral arrangements and sweet treats</p>
					</div>
				</div>
			</div>
			<div class="row">
				<?php if (!empty($products)): ?>
					<?php foreach ($products as $product): ?>
						<div class="col-lg-4 col-md-6 text-center">
							<div class="single-product-item">
								<div class="product-image">
									<a href="single-product.php?id=<?= $product['product_id'] ?>">
										<img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
									</a>
								</div>
								<h3><?= htmlspecialchars($product['name']) ?></h3>
								<p class="product-price">
									<img src="/velvet_lavender/assets/images/icons/saudi-riyal-symbol.png" width="20px">
									<?= number_format($product['price'], 2) ?>
								</p>
								<form action="cart-action.php#products" method="POST">
									<input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
									<input type="hidden" name="quantity" value="1">
									<button type="submit" class="cart-btn" onclick="setTimeout(() => { window.location.hash = 'products'; }, 10);">
										<i class="fas fa-shopping-cart"></i> Add to Cart
									</button>
								</form>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<div class="col-12 text-center">
						<p class="text-muted">No products found.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!-- Clients logo -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="section-title">
						<h3><span class="purple-text">Our</span> Clients</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/images/icons/lara-logo.png" alt="Lara Logo">
						</div>
						<div class="single-logo-item">
							<img src="assets/images/icons/larana-logo.png" alt="Larana Logo">
						</div>
						<div class="single-logo-item">
							<img src="assets/images/icons/noah-logo.png" alt="Noah Logo">
						</div>
						<div class="single-logo-item">
							<img src="assets/images/icons/harness-logo.png" alt="Harness Logo">
						</div>
						<div class="single-logo-item">
							<img src="assets/images/icons/borcelle-logo.png" alt="Borcelle Logoo">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end clients logo -->
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>