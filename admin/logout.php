<?php
// ===== MEMBER 1: Admin Logout =====
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
