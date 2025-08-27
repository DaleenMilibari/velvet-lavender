<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';

// Handle clear history action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_history'])) {
	setcookie('past_orders', '', time() - 3600, '/'); // Expire the cookie
	$_COOKIE['past_orders'] = null; // Clear from PHP as well
	header("Location: past-purchases.php");
	exit();
}
?>

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2 text-center">
				<div class="breadcrumb-text">
					<p>Thank you for choosing Velvet Lavender! Here are your previous orders.</p>
					<h1>Past Purchases</h1>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- orders area -->
<div class="past-orders container my-5">
	<?php
	$orders = isset($_COOKIE['past_orders']) ? json_decode($_COOKIE['past_orders'], true) : [];

	if (empty($orders)) {
		echo '<div class="text-center"><p class="lead">No past purchases found.</p><a href="index.php" class="boxed-btn">Start Shopping</a></div>';
	} else {
		foreach ($orders as $order) {
			$total = 0;
			echo '<div class="order border p-3 mb-4 shadow-sm rounded">';
			echo '<div class="order-header d-flex justify-content-between mb-2">';
			echo '<span class="order-id font-weight-bold">Order ID: ' . htmlspecialchars($order['order_id']) . '</span>';
			echo '<span class="order-date text-muted">Date: ' . htmlspecialchars($order['date']) . '</span>';
			echo '</div><div class="order-details row">';

			foreach ($order['items'] as $item) {
				$itemTotal = $item['price'] * $item['quantity'];
				$total += $itemTotal;

				echo '<div class="col-md-6 mb-3 d-flex">';
				echo '<div class="item-image mr-3" style="width: 100px;"><img src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '" class="img-fluid rounded"></div>';
				echo '<div class="item-info">';
				echo '<h5>' . htmlspecialchars($item['name']) . '</h5>';
				echo '<p class="mb-1"><img src="assets/images/icons/saudi-riyal-symbol.png" width="13"> ' . number_format($item['price'], 2) . '</p>';
				echo '<p class="mb-0">Quantity: ' . (int)$item['quantity'] . '</p>';
				echo '</div></div>';
			}

			echo '</div><div class="order-footer d-flex justify-content-between align-items-center border-top pt-2 mt-2">';
			echo '<span class="total-price font-weight-bold">Total: <img src="assets/images/icons/saudi-riyal-symbol.png" width="13"> ' . number_format($total, 2) . '</span>';
			echo '<span class="order-status badge badge-success">Status: ' . htmlspecialchars($order['status']) . '</span>';
			echo '</div></div>';
		}
	}
	?>
</div>

<?php include 'includes/footer.php'; ?>