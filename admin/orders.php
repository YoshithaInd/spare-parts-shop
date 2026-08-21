<?php
// ===== MEMBER 4: View Orders (Track Sales) =====
require '../db.php';
require 'auth_check.php';

$stmt = $pdo->query("SELECT o.*, p.part_name FROM orders o
                     JOIN parts p ON o.part_id = p.id
                     ORDER BY o.order_date DESC");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Orders</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <h1>Customer Orders</h1>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <table>
            <tr>
                <th>Order ID</th><th>Customer</th><th>Email</th>
                <th>Part</th><th>Qty</th><th>Total</th><th>Payment Status</th><th>Date</th>
            </tr>
            <?php foreach ($orders as $o): ?>
            <tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['customer_name']) ?></td>
                <td><?= htmlspecialchars($o['customer_email']) ?></td>
                <td><?= htmlspecialchars($o['part_name']) ?></td>
                <td><?= $o['quantity'] ?></td>
                <td>$<?= number_format($o['total_price'], 2) ?></td>
                <td>
                    <span class="status status-<?= strtolower($o['payment_status']) ?>">
                        <?= htmlspecialchars($o['payment_status']) ?>
                    </span>
                </td>
                <td><?= $o['order_date'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
