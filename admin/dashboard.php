<?php
// ===== MEMBER 4: Admin Dashboard (Inventory Management - Read) =====
require '../db.php';
require 'auth_check.php';

$stmt = $pdo->query("SELECT * FROM parts ORDER BY id DESC");
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Quick sales summary
$orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalSales = $pdo->query("SELECT COALESCE(SUM(total_price),0) FROM orders")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <h1>Admin Dashboard</h1>
            <div>
                <span>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></span>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <h3><?= $orderCount ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="stat-card">
                <h3>$<?= number_format($totalSales, 2) ?></h3>
                <p>Total Sales</p>
            </div>
            <div class="stat-card">
                <h3><?= count($parts) ?></h3>
                <p>Parts in Catalog</p>
            </div>
        </div>

        <a href="add_part.php" class="btn">+ Add New Part</a>
        <a href="orders.php" class="btn btn-secondary">View Orders</a>

        <table>
            <tr>
                <th>ID</th><th>Part</th><th>Vehicle</th><th>Category</th>
                <th>Price</th><th>Stock</th><th>Actions</th>
            </tr>
            <?php foreach ($parts as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['part_name']) ?></td>
                <td><?= htmlspecialchars($p['vehicle_make']) ?> <?= htmlspecialchars($p['vehicle_model']) ?></td>
                <td><?= htmlspecialchars($p['category']) ?></td>
                <td>$<?= number_format($p['price'], 2) ?></td>
                <td><?= $p['stock'] ?></td>
                <td class="actions">
                    <a href="edit_part.php?id=<?= $p['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="delete_part.php?id=<?= $p['id'] ?>" class="btn btn-danger"
                       onclick="return confirm('Delete this part?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
