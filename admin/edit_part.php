<?php
// ===== MEMBER 4: Edit Part (Update) =====
require '../db.php';
require 'auth_check.php';

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE parts SET part_name=?, vehicle_make=?, vehicle_model=?, category=?, price=?, stock=?, image_url=? WHERE id=?");
    $stmt->execute([
        $_POST['part_name'],
        $_POST['vehicle_make'],
        $_POST['vehicle_model'],
        $_POST['category'],
        $_POST['price'],
        $_POST['stock'],
        $_POST['image_url'],
        $_POST['id']
    ]);

    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM parts WHERE id = ?");
$stmt->execute([$id]);
$part = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$part) {
    die("Part not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Part</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Spare Part</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $part['id'] ?>">
            <input type="text" name="part_name" value="<?= htmlspecialchars($part['part_name']) ?>" required>
            <input type="text" name="vehicle_make" value="<?= htmlspecialchars($part['vehicle_make']) ?>" required>
            <input type="text" name="vehicle_model" value="<?= htmlspecialchars($part['vehicle_model']) ?>" required>
            <input type="text" name="category" value="<?= htmlspecialchars($part['category']) ?>" required>
            <input type="number" step="0.01" name="price" value="<?= $part['price'] ?>" required>
            <input type="number" name="stock" value="<?= $part['stock'] ?>" required>
            <input type="text" name="image_url" value="<?= htmlspecialchars($part['image_url']) ?>">
            <button type="submit" class="btn">Save Changes</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
