<?php
include 'admin_auth.php';  // Ensure only admins can access
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php');
    exit();
}

$user_id = $_GET['id'];

// Fetch user details
$user_query = "SELECT * FROM users WHERE id='$user_id'";
$user = $conn->query($user_query)->fetch_assoc();

// Fetch user uploads
$upload_query = "SELECT * FROM uploads WHERE user_id='$user_id' ORDER BY uploaded_at DESC";
$uploads = $conn->query($upload_query);

// Fetch user comments
$comment_query = "SELECT * FROM comments WHERE user_id='$user_id' ORDER BY commented_at DESC";
$comments = $conn->query($comment_query);

include 'header.php';
?>

<div class="container mt-5">
    <h2>User Details: <?= $user['username'] ?></h2>

    <h4>User Information</h4>
    <p>Email: <?= $user['email'] ?></p>

    <h4>Uploads</h4>
    <ul class="list-group">
        <?php
        if ($uploads->num_rows > 0) {
            while ($upload = $uploads->fetch_assoc()) {
                echo "<li class='list-group-item'>
                        <a href='{$upload['file_path']}' target='_blank'>{$upload['file_name']}</a>
                      </li>";
            }
        } else {
            echo "<li class='list-group-item'>No uploads found.</li>";
        }
        ?>
    </ul>

    <h4 class="mt-4">Comments</h4>
    <ul class="list-group">
        <?php
        if ($comments->num_rows > 0) {
            while ($comment = $comments->fetch_assoc()) {
                echo "<li class='list-group-item'>{$comment['comment_text']}</li>";
            }
        } else {
            echo "<li class='list-group-item'>No comments found.</li>";
        }
        ?>
    </ul>
</div>

<?php include 'footer.php'; ?>
