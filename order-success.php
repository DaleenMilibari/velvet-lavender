<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();

// Redirect if no recent order found
if (!isset($_SESSION['order_info'])) {
    header("Location: index.php");
    exit();
}

$order = $_SESSION['order_info'];
$page_title = "Order Confirmation";

require_once __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container text-center">
        <div class="breadcrumb-text">
            <p>Your floral & sweet journey begins!</p>
            <h1>Order Successful</h1>
        </div>
    </div>
</div>

<!-- Order Summary Section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <!-- Confirmation Text -->
            <div class="col-lg-8 offset-lg-2 text-center">
                <h2 class="mb-4">Thank You, <?= htmlspecialchars($order['customer_name']) ?>!</h2>
                <p class="mb-3">Your order was placed successfully on <strong><?= date('F j, Y, g:i a', strtotime($order['order_date'])) ?></strong>.</p>
                <p>We’ve sent a confirmation email to <strong><?= htmlspecialchars($order['email']) ?></strong>.</p>
                <p>You’ll receive your items shortly at:</p>
                <p><strong><?= nl2br(htmlspecialchars($order['address'])) ?></strong></p>
                <?php if (!empty($order['notes'])): ?>
                    <p class="mt-3"><em>Note: <?= nl2br(htmlspecialchars($order['notes'])) ?></em></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="row mt-5">
            <div class="col-lg-8 offset-lg-2">
                <div class="order-details-wrap">
                    <h4>Your Order Summary</h4>
                    <table class="order-details">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['cart_items'] as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td class="text-center"><?= $product['quantity'] ?></td>
                                    <td class="text-right">
                                        <img src="assets/images/icons/saudi-riyal-symbol.png" width="10">
                                        <?= number_format($product['price'] * $product['quantity'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2"><strong>Total (incl. shipping)</strong></td>
                                <td class="text-right">
                                    <strong><img src="assets/images/icons/saudi-riyal-symbol.png" width="10">
                                        <?= number_format($order['total_amount'], 2) ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center mt-4">
                        <a href="index.php" class="boxed-btn">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Clear session order info after showing it once
unset($_SESSION['order_info']);
require_once __DIR__ . '/includes/footer.php';
?>