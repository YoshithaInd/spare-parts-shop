<?php
// ===== MEMBER 3: Process Order (Mock Payment Gateway) =====
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$part_id = $_POST['part_id'];
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$customer_address = $_POST['customer_address'];
$quantity = (int) $_POST['quantity'];

// --- MOCK PAYMENT GATEWAY ---
// In a real system this would call a payment provider's API.
// Here we simply simulate a successful transaction.
$card_number = preg_replace('/\s+/', '', $_POST['card_number']);
$payment_success = strlen($card_number) >= 12; // simple mock validation

if (!$payment_success) {
    die("Payment failed. Please check your card details and try again. <a href='index.php'>Back to store</a>");
}

// Get part price and stock
$stmt = $pdo->prepare("SELECT * FROM parts WHERE id = ?");
$stmt->execute([$part_id]);
$part = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$part || $part['stock'] < $quantity) {
    die("Not enough stock available. <a href='index.php'>Back to store</a>");
}

$total_price = $part['price'] * $quantity;

// Insert order into database (payment already confirmed by mock gateway above)
$stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_address, part_id, quantity, total_price, payment_status)
                       VALUES (?, ?, ?, ?, ?, ?, 'Paid')");
$stmt->execute([$customer_name, $customer_email, $customer_address, $part_id, $quantity, $total_price]);

// Reduce stock
$stmt = $pdo->prepare("UPDATE parts SET stock = stock - ? WHERE id = ?");
$stmt->execute([$quantity, $part_id]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="alert alert-success">
            <h2>✅ Payment Successful!</h2>
            <p>Thank you, <?= htmlspecialchars($customer_name) ?>! Your order has been placed.</p>
        </div>
        <table>
            <tr><th>Part</th><td><?= htmlspecialchars($part['part_name']) ?></td></tr>
            <tr><th>Quantity</th><td><?= $quantity ?></td></tr>
            <tr><th>Total Paid</th><td>$<?= number_format($total_price, 2) ?></td></tr>
            <tr><th>Delivery Address</th><td><?= htmlspecialchars($customer_address) ?></td></tr>
        </table>
        <a href="index.php" class="btn" style="margin-top:15px;">Back to Store</a>
    </div>
</body>
</html>
