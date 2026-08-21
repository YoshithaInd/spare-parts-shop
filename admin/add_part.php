<?php
// ===== MEMBER 4: Add New Part (Create) =====
require '../db.php';
require 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO parts (part_name, vehicle_make, vehicle_model, category, price, stock, image_url)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['part_name'],
        $_POST['vehicle_make'],
        $_POST['vehicle_model'],
        $_POST['category'],
        $_POST['price'],
        $_POST['stock'],
        $_POST['image_url'] ?: 'https://via.placeholder.com/200x150?text=Part'
    ]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Part</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Spare Part</h1>
        <form method="POST" id="partForm">
            <input type="text" name="part_name" id="part_name" placeholder="Part Name" required>
            <input type="text" name="vehicle_make" id="vehicle_make" placeholder="Vehicle Make (e.g. Toyota)" required>
            <input type="text" name="vehicle_model" id="vehicle_model" placeholder="Vehicle Model (e.g. Corolla)" required>
            <input type="text" name="category" id="category" placeholder="Category (e.g. Engine, Brakes)" required>
            <input type="number" step="0.01" name="price" id="price" placeholder="Price" required>
            <input type="number" name="stock" id="stock" placeholder="Stock Quantity" required>
            <input type="text" name="image_url" placeholder="Image URL (optional)">
            <button type="submit" class="btn">Add Part</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="../script.js"></script>
</body>
</html>
