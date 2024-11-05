<?php
include 'admin_auth.php';  // Ensure only admins can access
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit();
}

$user_id = $_GET['id'];

// Delete user uploads
$conn->query("DELETE FROM uploads WHERE user_id='$user_id'");

// Delete user comments
$conn->query("DELETE FROM comments WHERE user_id='$user_id'");

// Delete user account
$conn->query("DELETE FROM users WHERE id='$user_id'");

header('Location: admin_dashboard.php');
exit();
?>
