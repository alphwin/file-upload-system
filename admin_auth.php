<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Redirect non-admin users or non-logged-in users to login
    header('Location: login.php');
    exit();
}
?>
