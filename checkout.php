<?php
// ===== MEMBER 3: Checkout Page =====
require 'db.php';

$part_id = $_GET['part_id'] ?? null;

if (!$part_id) {
    die("No part selected.");
}

$stmt = $pdo->prepare("SELECT * FROM parts WHERE id = ?");
$stmt->execute([$part_id]);
$part = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$part) {
    die("Part not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>

        <div class="checkout-summary">
            <img src="<?= htmlspecialchars($part['image_url']) ?>" alt="<?= htmlspecialchars($part['part_name']) ?>" style="width:120px;">
            <div>
                <h3><?= htmlspecialchars($part['part_name']) ?></h3>
                <p><?= htmlspecialchars($part['vehicle_make']) ?> - <?= htmlspecialchars($part['vehicle_model']) ?></p>
                <p class="price">$<?= number_format($part['price'], 2) ?> each</p>
                <p>In stock: <?= $part['stock'] ?></p>
            </div>
        </div>

        <form method="POST" action="process_order.php" id="checkoutForm">
            <input type="hidden" name="part_id" value="<?= $part['id'] ?>">

            <label>Full Name</label>
            <input type="text" name="customer_name" id="customer_name" placeholder="Your full name" required>

            <label>Email</label>
            <input type="email" name="customer_email" id="customer_email" placeholder="you@example.com" required>

            <label>Delivery Address</label>
            <input type="text" name="customer_address" id="customer_address" placeholder="Delivery address" required>

            <label>Quantity</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $part['stock'] ?>" required>

            <hr>
            <h3>Payment Details (Mock Gateway)</h3>
            <label>Card Number</label>
            <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>

            <div style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <label>Expiry (MM/YY)</label>
                    <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5" required>
                </div>
                <div style="flex:1;">
                    <label>CVV</label>
                    <input type="text" name="card_cvv" placeholder="123" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="btn" style="margin-top:15px;">Complete Purchase</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
