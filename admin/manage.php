<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
require_once __DIR__ . '/../includes/auth-check.php'; // Protect the page
require_once __DIR__ . '/../includes/admin-header.php';

$pageTitle = 'Admin Dashboard';
?>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Velvet Lavender</p>
					<h1>Admin Dashboard</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- management function area -->
<div class="faqs-list">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<div class="mgmt-function text-center">
					<button class="function-btn" onclick="window.location.href='manage-add.php'">Add Product</button>
					<button class="function-btn" onclick="window.location.href='manage-update.php'">Update Product</button>
					<button class="function-btn" onclick="window.location.href='manage-delete.php'">Delete Product</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>