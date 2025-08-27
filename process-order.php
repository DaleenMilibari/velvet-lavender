<?php
session_start();
require_once __DIR__ . '/config.php';

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_order'])) {
    $transactionStarted = false;

    try {
        // === Server-side field validation ===
        $required = ['name', 'email', 'phone', 'address'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields.");
            }
        }

        // === Validate: Full name (two words, no numbers) ===
        if (!preg_match("/^[a-zA-Z]+ [a-zA-Z]+$/", $_POST['name'])) {
            throw new Exception("Full name must contain two words with letters only.");
        }

        // === Validate: Saudi phone number ===
        if (!preg_match("/^\+9665[0-9]{8}$/", $_POST['phone'])) {
            throw new Exception("Phone number must follow +9665XXXXXXXX format.");
        }

        // === Validate: Email ===
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        // === Begin DB Transaction ===
        $pdo->beginTransaction();
        $transactionStarted = true;

        // === Stock Validation and Deduction ===
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $quantity = (int)$item['quantity'];

            $stmt = $pdo->prepare("
                UPDATE products 
                SET stock_quantity = stock_quantity - :qty 
                WHERE product_id = :product_id AND stock_quantity >= :min_qty
            ");
            $stmt->bindValue(':qty', $quantity, PDO::PARAM_INT);
            $stmt->bindValue(':min_qty', $quantity, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                throw new Exception("Insufficient stock for product ID: $product_id");
            }
        }

        // === Commit Transaction ===
        $pdo->commit();

        // === Store Order Info in Session ===
        $_SESSION['order_info'] = [
            'customer_name' => htmlspecialchars($_POST['name']),
            'email'         => htmlspecialchars($_POST['email']),
            'phone'         => htmlspecialchars($_POST['phone']),
            'address'       => htmlspecialchars($_POST['address']),
            'notes'         => htmlspecialchars($_POST['notes'] ?? ''),
            'order_date'    => date('Y-m-d H:i:s'),
            'total_amount'  => $_SESSION['total'] ?? 0,
            'cart_items'    => $_SESSION['cart']
        ];

        // === Prepare Cookie Data (Persist for 1 Year) ===
        $pastOrders = isset($_COOKIE['past_orders']) ? json_decode($_COOKIE['past_orders'], true) : [];

        $newOrder = [
            'order_id' => uniqid('#ORD'),
            'date'     => date('Y-m-d'),
            'status'   => 'Delivered',
            'items'    => $_SESSION['cart']
        ];
        $pastOrders[] = $newOrder;

        setcookie(
            'past_orders',
            json_encode($pastOrders),
            time() + (365 * 24 * 60 * 60),
            "/"
        );

        // === Clear Cart ===
        unset($_SESSION['cart']);

        // === Redirect to Success Page ===
        header("Location: order-success.php");
        exit();
    } catch (Exception $e) {
        if ($transactionStarted) {
            $pdo->rollBack();
        }

        $_SESSION['error'] = "Order failed: " . $e->getMessage();
        header("Location: checkout.php");
        exit();
    }
} else {
    header("Location: checkout.php");
    exit();
}
