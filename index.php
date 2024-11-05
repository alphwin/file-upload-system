<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Redirect to login if user is not logged in
    exit();
}
?>

<?php
include 'header.php';
include 'db.php';  // Include the database connection file
?>
<p>Welcome, <?= $_SESSION['username'] ?>!</p>
<a href="logout.php" class="btn btn-danger">Logout</a>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload and Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Upload Files or Videos</h2>

        <!-- Upload Form -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fileToUpload" class="form-label">Select file to upload:</label>
                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>

        <!-- Display Uploaded Files from the Logged-in User -->
        <div class="mt-5">
            <h4>Your Uploaded Files:</h4>
            <ul class="list-group">
                <?php
                // Fetch uploads for the logged-in user
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM uploads WHERE user_id='$user_id' ORDER BY uploaded_at DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li class='list-group-item'>";
                        echo "<h5>" . $row['file_name'] . "</h5>";
                        echo "<a href='" . $row['file_path'] . "' target='_blank'>View File</a>";

                        // Fetch comments for this specific file
                        $upload_id = $row['id'];
                        $comment_sql = "SELECT comment_text FROM comments WHERE upload_id='$upload_id' ORDER BY commented_at DESC";
                        $comment_result = $conn->query($comment_sql);

                        if ($comment_result->num_rows > 0) {
                            echo "<h6 class='mt-3'>Comments:</h6>";
                            echo "<ul class='list-group'>";
                            while ($comment = $comment_result->fetch_assoc()) {
                                echo "<li class='list-group-item'>" . $comment['comment_text'] . "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No comments yet.</p>";
                        }

                        // Comment form for this file
                        echo "
                        <form action='comment.php' method='post' class='mt-3'>
                            <input type='hidden' name='upload_id' value='$upload_id'>
                            <div class='mb-3'>
                                <label for='comment_text' class='form-label'>Add a Comment:</label>
                                <textarea name='comment_text' class='form-control' rows='2' required></textarea>
                            </div>
                            <button type='submit' class='btn btn-secondary'>Post Comment</button>
                        </form>";

                        echo "</li>";
                    }
                } else {
                    echo "<li class='list-group-item'>No files uploaded yet.</li>";
                }
                ?>
            </ul>
        </div>
    </div>

<?php
include 'footer.php';  // Include the footer file
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
