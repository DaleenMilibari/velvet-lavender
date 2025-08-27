<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-header.php';
require_once __DIR__ . '/../config.php';

$categoryNames = [
	2 => 'Flower Bouquets',
	3 => 'Flower Vases',
	5 => 'Cakes',
	6 => 'Chocolate Boxes'
];

$product = null;
$searchError = '';
$deleteSuccess = '';
$deleteError = '';

$productOptions = $pdo->query("SELECT product_id, name FROM products ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Handle search
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
	$searchTerm = trim($_GET['search']);
	$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :search LIMIT 1");
	$stmt->execute(['search' => "%$searchTerm%"]);
	$product = $stmt->fetch();
	if (!$product) {
		$searchError = "Product not found.";
	}
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
	$productId = (int) $_POST['productId'];
	try {
		$stmt = $pdo->prepare("SELECT image FROM products WHERE product_id = :id");
		$stmt->execute(['id' => $productId]);
		$image = $stmt->fetchColumn();
		if ($image && file_exists(__DIR__ . '/../' . $image)) {
			unlink(__DIR__ . '/../' . $image);
		}

		$stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id");
		$stmt->execute(['id' => $productId]);
		$deleteSuccess = "Product deleted successfully!";
		$product = null;
	} catch (Exception $e) {
		$deleteError = "Failed to delete product.";
	}
}
?>

<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Velvet Lavender</p>
					<h1>Delete Item</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="faqs-list">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">

				<?php if ($searchError): ?>
					<div class="alert alert-danger"><?= $searchError ?></div>
				<?php endif; ?>

				<?php if ($deleteSuccess): ?>
					<div class="alert alert-success"><?= $deleteSuccess ?></div>
				<?php endif; ?>

				<?php if ($deleteError): ?>
					<div class="alert alert-danger"><?= $deleteError ?></div>
				<?php endif; ?>

				<!-- Text Search with Auto List -->
				<form action="manage-delete.php" method="GET">
					<label for="search" class="form-label">Search Product Name:</label>
					<input type="text" id="search" name="search" list="productList" class="form-control" placeholder="Type to search..." required>
					<datalist id="productList">
						<?php foreach ($productOptions as $option): ?>
							<option value="<?= htmlspecialchars($option['name']) ?>">
							<?php endforeach; ?>
					</datalist>
					<div class="button-container mt-3">
						<button type="submit" class="boxed-btn">Search</button>
					</div>
				</form>

				<!-- Delete Form -->
				<form action="manage-delete.php" method="POST" class="mt-4" onsubmit="return confirm('Are you sure you want to delete this product?');">
					<input type="hidden" name="productId" value="<?= $product['product_id'] ?? '' ?>">

					<label class="form-label">Product Name:</label>
					<input type="text" class="form-control" value="<?= htmlspecialchars($product['name'] ?? '') ?>" readonly>

					<label class="form-label">Category:</label>
					<input type="text" class="form-control" value="<?= $product ? ($categoryNames[$product['category_id']] ?? 'Unknown') : '' ?>" readonly>

					<label class="form-label">Price (SAR):</label>
					<input type="text" class="form-control" value="<?= htmlspecialchars($product['price'] ?? '') ?>" readonly>

					<?php if (!empty($product['image'])): ?>
						<div class="mt-3">
							<label class="form-label">Product Image:</label><br>
							<img src="/velvet_lavender/<?= $product['image'] ?>" alt="Product Image" class="img-thumbnail" style="max-width: 200px;">
						</div>
					<?php endif; ?>

					<div class="button-container mt-4">
						<button type="submit" class="boxed-btn" <?= $product ? '' : 'disabled' ?>>Delete Product</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>