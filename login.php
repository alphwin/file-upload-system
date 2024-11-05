<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin']; // This must be set

            if ($_SESSION['is_admin'] == 1) {
                header('Location: admin_dashboard.php'); // Redirect to admin dashboard
            } else {
                header('Location: user_dashboard.php'); // Redirect to regular user dashboard
            }
            exit();
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        $error_message = "Username not found. Please register.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <title>Login</title>
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>

    <!-- Display any error messages -->
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger">
            <?= $error_message ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="login.php" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <!-- Link to Registration Page -->
    <p class="mt-3">
        Don't have an account? <a href="register.php">Register here</a>.
    </p>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
