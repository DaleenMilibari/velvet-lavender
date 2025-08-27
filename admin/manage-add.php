<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
require_once __DIR__ . '/../includes/auth-check.php';
require_once __DIR__ . '/../includes/admin-header.php';

$pageTitle = 'Add New Product';
?>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Velvet Lavender</p>
					<h1>Add New Product</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- add product form -->
<div class="faqs-list">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<?php if (isset($_SESSION['success'])): ?>
					<div class="alert alert-success">
						<?= $_SESSION['success'];
						unset($_SESSION['success']); ?>
					</div>
				<?php endif; ?>
				<?php if (isset($_SESSION['error'])): ?>
					<div class="alert alert-danger">
						<?= $_SESSION['error'];
						unset($_SESSION['error']); ?>
					</div>
				<?php endif; ?>

				<form id="addProductForm" action="manage-add-handler.php" method="POST" enctype="multipart/form-data" novalidate>
					<label for="productName" class="form-label">Product Name:</label>
					<input type="text" id="productName" name="productName" class="form-control" class="form-control">

					<label for="category" class="form-label">Category:</label>
					<select id="category" name="category" class="form-control">
						<option value="">Select Category</option>
						<option value="2">Flower Bouquets</option>
						<option value="3">Flower Vases</option>
						<option value="5">Cakes</option>
						<option value="6">Chocolate Boxes</option>
					</select>

					<label for="stock" class="form-label">Stock Quantity:</label>
					<input type="number" id="stock" name="stock" class="form-control">

					<label for="price" class="form-label">Price (SAR):</label>
					<input type="number" id="price" name="price" class="form-control">

					<label for="description" class="form-label">Description:</label>
					<textarea id="description" name="description" class="form-control"></textarea>

					<label for="productImage" class="form-label">Product Image:</label>
					<input type="file" id="productImage" name="productImage" class="form-control" accept="image/*">

					<button type="submit" class="boxed-btn mt-3">Add Product</button>
				</form>

			</div>
		</div>
	</div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>