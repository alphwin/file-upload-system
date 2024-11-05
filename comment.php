<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $upload_id = $_POST['upload_id'];
    $comment_text = $_POST['comment_text'];
    $user_id = $_SESSION['user_id'];  // Get the logged-in user ID

    // Insert the comment into the database
    // Assuming you have $user_id in session or passed in as data
    $sql = "INSERT INTO comments (upload_id, comment_text, user_id, commented_at) VALUES ('$upload_id', '$comment_text', '$user_id', NOW())";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the uploads page
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment on Uploaded File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Write a Comment</h2>

        <!-- Display uploaded file -->
        <div class="mb-4">
            <?php
            // Fetch the file details from the database
            $sql = "SELECT file_name, file_path FROM uploads WHERE id='$upload_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $file = $result->fetch_assoc();
                echo "<h4>Uploaded File: " . $file['file_name'] . "</h4>";
                echo "<a href='" . $file['file_path'] . "' target='_blank'>View File</a>";
            } else {
                echo "<p>File not found.</p>";
            }
            ?>
        </div>

        <!-- Comment Form -->
        <form action="comment.php?upload_id=<?= $upload_id ?>" method="post">
            <div class="mb-3">
                <textarea class="form-control" name="comment" rows="3" placeholder="Leave a comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Comment</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
