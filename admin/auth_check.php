<?php
// ===== MEMBER 1: Auth Guard (include this at top of every protected admin page) =====
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
