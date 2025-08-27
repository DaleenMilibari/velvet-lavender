<?php
session_start();
$pageTitle = 'Admin Login';
require_once __DIR__ . '/includes/admin-header.php';
?>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<h1>Admin Login</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- login form -->
<div class="faqs-list mt-5 mb-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 offset-lg-3">
				<?php if (isset($_SESSION['error'])): ?>
					<div class="alert alert-danger text-center">
						<?= htmlspecialchars($_SESSION['error']) ?>
						<?php unset($_SESSION['error']); ?>
					</div>
				<?php endif; ?>

				<div class="login-form">
					<form action="authenticate-admin.php" method="post" id="adminLoginForm" novalidate>
						<div class="mb-3">
							<label for="username" class="form-label">Username:</label>
							<input type="text" id="username" name="username" class="form-control" placeholder="Enter your username">
						</div>

						<div class="mb-4">
							<label for="password" class="form-label">Password:</label>
							<input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
						</div>

						<div class="d-grid gap-2">
							<button type="submit" class="boxed-btn">Login</button>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>