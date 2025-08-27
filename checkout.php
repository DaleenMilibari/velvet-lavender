<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
	$_SESSION['message'] = "Your cart is empty";
	$_SESSION['message_type'] = "error";
	header("Location: cart.php");
	exit();
}

// Calculate totals
$subtotal = 0;
$cart_items = [];

foreach ($_SESSION['cart'] as $product_id => $item) {
	$subtotal += $item['price'] * $item['quantity'];
	$cart_items[] = [
		'id' => $product_id,
		'name' => $item['name'],
		'price' => $item['price'],
		'quantity' => $item['quantity'],
		'total' => $item['price'] * $item['quantity']
	];
}

$shipping = 30;
$total = $subtotal + $shipping;
$_SESSION['total'] = $total;
?>

<!-- Breadcrumb -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Fresh and Organic</p>
					<h1>Checkout</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Checkout Section -->
<div class="checkout-section mt-150 mb-150">
	<div class="container">
		<!-- Show error (from process-order.php) -->
		<?php if (isset($_SESSION['error'])): ?>
			<div class="alert alert-danger text-center mb-4">
				<?= htmlspecialchars($_SESSION['error']) ?>
			</div>
			<?php unset($_SESSION['error']); ?>
		<?php endif; ?>

		<form action="process-order.php" method="POST" id="checkoutForm" novalidate>
			<div class="row">
				<!-- Billing Info -->
				<div class="col-lg-8">
					<div class="checkout-accordion-wrap">
						<div class="accordion" id="checkoutAccordion">
							<div class="card single-accordion">
								<div class="card-header" id="headingOne">
									<h5 class="mb-0">
										<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">
											Billing Address
										</button>
									</h5>
								</div>
								<div id="collapseOne" class="collapse show" data-parent="#checkoutAccordion">
									<div class="card-body">
										<div class="billing-address-form">
											<p><input type="text" name="name" placeholder="Full Name" required></p>
											<p><input type="email" name="email" placeholder="Email" required></p>
											<p><input type="tel" name="phone" placeholder="Phone Number" required></p>
											<p><textarea name="address" cols="30" rows="4" placeholder="Full Address" required></textarea></p>
											<p><textarea name="notes" cols="30" rows="3" placeholder="Order Notes (optional)"></textarea></p>
											<input type="hidden" name="save_order" value="1">
										</div>
									</div>
								</div>
							</div>

							<!-- Payment Method -->
							<div class="card single-accordion">
								<div class="card-header" id="headingTwo">
									<h5 class="mb-0">
										<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo">
											Payment Method
										</button>
									</h5>
								</div>
								<div id="collapseTwo" class="collapse" data-parent="#checkoutAccordion">
									<div class="card-body">
										<div class="payment-method">
											<div class="form-check">
												<input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
												<label class="form-check-label" for="cod">
													Cash on Delivery
												</label>
											</div>
											<!-- Add other methods here -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Order Summary -->
				<div class="col-lg-4">
					<div class="order-details-wrap">
						<table class="order-details">
							<thead>
								<tr>
									<th>Your Order</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($cart_items as $item): ?>
									<tr>
										<td><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></td>
										<td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10px"> <?= number_format($item['total'], 2) ?></td>
									</tr>
								<?php endforeach; ?>
								<tr>
									<td>Subtotal</td>
									<td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10px"> <?= number_format($subtotal, 2) ?></td>
								</tr>
								<tr>
									<td>Shipping</td>
									<td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10px"> <?= number_format($shipping, 2) ?></td>
								</tr>
								<tr>
									<td><strong>Total</strong></td>
									<td><strong><img src="assets/images/icons/saudi-riyal-symbol.png" width="10px"> <?= number_format($total, 2) ?></strong></td>
								</tr>
							</tbody>
						</table>
						<br>
						<button type="submit" class="boxed-btn">Place Order</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include 'includes/footer.php'; ?>