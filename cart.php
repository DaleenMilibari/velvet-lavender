<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
session_start();
require_once __DIR__ . '/config.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle POST actions *before* sending any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_item'])) {
        $product_id = (int)$_POST['product_id'];
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['cart_message'] = "Item removed from cart.";
        $_SESSION['cart_message_type'] = "success";
        header("Location: cart.php");
        exit();
    }

    if (isset($_POST['update_quantities']) && isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $product_id => $qty) {
            $product_id = (int)$product_id;
            $qty = (int)$qty;
            if ($qty < 1) continue;

            $stmt = $pdo->prepare("SELECT stock_quantity FROM products WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();

            if ($product && $qty <= $product['stock_quantity']) {
                $_SESSION['cart'][$product_id]['quantity'] = $qty;
                $_SESSION['cart_message'] = "Cart updated.";
                $_SESSION['cart_message_type'] = "success";
            } else {
                $_SESSION['cart_message'] = "Only {$product['stock_quantity']} in stock.";
                $_SESSION['cart_message_type'] = "error";
            }
        }
        header("Location: cart.php");
        exit();
    }

    if (isset($_POST['empty_cart'])) {
        $_SESSION['cart'] = [];
        $_SESSION['cart_message'] = "Cart cleared.";
        $_SESSION['cart_message_type'] = "success";
        header("Location: cart.php");
        exit();
    }
}

// Show flash message once
$message = $_SESSION['cart_message'] ?? null;
$type = $_SESSION['cart_message_type'] ?? null;
unset($_SESSION['cart_message'], $_SESSION['cart_message_type']);

// Load cart items from DB
$subtotal = 0;
$cart_items = [];

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
    $stmt->execute($ids);

    while ($row = $stmt->fetch()) {
        $id = $row['product_id'];
        $qty = $_SESSION['cart'][$id]['quantity'];
        $price = $row['discount_price'] > 0 ? $row['discount_price'] : $row['price'];
        $total = $price * $qty;

        $cart_items[] = [
            'id' => $id,
            'name' => $row['name'],
            'image' => $row['image'],
            'price' => $price,
            'quantity' => $qty,
            'stock' => $row['stock_quantity'],
            'total' => $total
        ];
        $subtotal += $total;
    }
}

$shipping = 30;
$total = $subtotal + $shipping;
$_SESSION['total'] = $total;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumb -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container text-center">
        <div class="breadcrumb-text">
            <p>Where every bouquet tells a story of care</p>
            <h1>Cart</h1>
        </div>
    </div>
</div>

<!-- Flash Message -->
<?php if ($message): ?>
    <div class="alert alert-<?= $type === 'error' ? 'danger' : 'success' ?> text-center mt-3">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<!-- Cart Table -->
<div class="cart-section mt-150 mb-150">
    <div class="container">
        <?php if (empty($cart_items)): ?>
            <div class="text-center">
                <h4>Your cart is empty.</h4>
                <a href="index.php" class="boxed-btn mt-3">Continue Shopping</a>
            </div>
        <?php else: ?>
            <form id="cartForm" action="cart.php" method="POST" novalidate>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-table-wrap">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr>
                                            <td>
                                                <button type="submit" name="delete_item" value="1" class="btn text-danger p-0" onclick="return confirm('Remove this item?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                            </td>
                                            <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="50"></td>
                                            <td><?= htmlspecialchars($item['name']) ?></td>
                                            <td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10"> <?= number_format($item['price'], 2) ?></td>
                                            <td>
                                                <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" class="form-control w-50 d-inline">
                                            </td>
                                            <td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10"> <?= number_format($item['total'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <button type="submit" name="update_quantities" class="boxed-btn">Update Cart</button>
                                <button type="submit" name="empty_cart" class="boxed-btn" onclick="return confirm('Clear your cart?')">Empty Cart</button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">
                        <div class="total-section">
                            <table class="total-table">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10"> <?= number_format($subtotal, 2) ?></td>
                                </tr>
                                <tr>
                                    <td>Shipping:</td>
                                    <td><img src="assets/images/icons/saudi-riyal-symbol.png" width="10"> <?= number_format($shipping, 2) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total:</strong></td>
                                    <td><strong><img src="assets/images/icons/saudi-riyal-symbol.png" width="10"> <?= number_format($total, 2) ?></strong></td>
                                </tr>
                            </table>
                            <div class="mt-3">
                                <a href="checkout.php" class="boxed-btn black">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>