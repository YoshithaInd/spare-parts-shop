<?php
// ===== MEMBER 2: Catalog Viewing + Search/Filter (Vehicle Lookup) =====
require 'db.php';

// Get filter values from the URL (GET request)
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$make = $_GET['make'] ?? '';

// Build the query dynamically based on filters
$sql = "SELECT * FROM parts WHERE 1=1";
$params = [];

if ($search !== '') {
    $sql .= " AND part_name LIKE ?";
    $params[] = "%$search%";
}
if ($category !== '') {
    $sql .= " AND category = ?";
    $params[] = $category;
}
if ($make !== '') {
    $sql .= " AND vehicle_make = ?";
    $params[] = $make;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$parts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get distinct categories and makes for the filter dropdowns
$categories = $pdo->query("SELECT DISTINCT category FROM parts ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
$makes = $pdo->query("SELECT DISTINCT vehicle_make FROM parts ORDER BY vehicle_make")->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Vehicle Spare Parts Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <h1>🚗 Vehicle Spare Parts Store</h1>
            <a href="admin/login.php" class="btn btn-secondary">Admin Login</a>
        </div>

        <!-- Search / Filter (Vehicle Lookup) -->
        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Search part name..."
                   value="<?= htmlspecialchars($search) ?>">

            <select name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="make">
                <option value="">All Makes</option>
                <?php foreach ($makes as $mk): ?>
                    <option value="<?= htmlspecialchars($mk) ?>" <?= $make === $mk ? 'selected' : '' ?>>
                        <?= htmlspecialchars($mk) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn">Filter</button>
            <a href="index.php" class="btn btn-secondary">Clear</a>
        </form>

        <!-- Parts Catalog Grid -->
        <div class="parts-grid">
            <?php if (empty($parts)): ?>
                <p>No parts found matching your search.</p>
            <?php endif; ?>

            <?php foreach ($parts as $p): ?>
            <div class="part-card">
                <img src="<?= htmlspecialchars($p['image_url']) ?>" alt="<?= htmlspecialchars($p['part_name']) ?>">
                <h3><?= htmlspecialchars($p['part_name']) ?></h3>
                <p class="compat"><?= htmlspecialchars($p['vehicle_make']) ?> - <?= htmlspecialchars($p['vehicle_model']) ?></p>
                <p class="category-tag"><?= htmlspecialchars($p['category']) ?></p>
                <p class="price">$<?= number_format($p['price'], 2) ?></p>
                <p class="stock">Stock: <?= $p['stock'] ?></p>
                <a href="checkout.php?part_id=<?= $p['id'] ?>" class="btn">Buy Now</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
