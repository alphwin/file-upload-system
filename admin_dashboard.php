<?php
include 'admin_auth.php';  // Ensure only admins can access
include 'db.php';  // Include database connection

// Fetch metrics: total users, total uploads, total comments
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_uploads = $conn->query("SELECT COUNT(*) AS total FROM uploads")->fetch_assoc()['total'];
$total_comments = $conn->query("SELECT COUNT(*) AS total FROM comments")->fetch_assoc()['total'];

include 'header.php';  // Admin header (you can create a separate admin header if needed)
?>


<div class="container mt-5">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h4 class="card-title"><?= $total_users ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Uploads</div>
                <div class="card-body">
                    <h4 class="card-title"><?= $total_uploads ?></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Total Comments</div>
                <div class="card-body">
                    <h4 class="card-title"><?= $total_comments ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management -->
    <h3 class="mt-5">User Management</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Uploads</th>
                <th>Comments</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $user_query = "SELECT u.id, u.username, u.email, 
                                  (SELECT COUNT(*) FROM uploads WHERE user_id=u.id) AS upload_count, 
                                  (SELECT COUNT(*) FROM comments WHERE user_id=u.id) AS comment_count 
                           FROM users u";
            $user_result = $conn->query($user_query);

            if ($user_result->num_rows > 0) {
                while ($user = $user_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['username']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['upload_count']}</td>
                            <td>{$user['comment_count']}</td>
                            <td>
                                <a href='user_details.php?id={$user['id']}' class='btn btn-sm btn-primary'>View</a>
                                <a href='delete_user.php?id={$user['id']}' class='btn btn-sm btn-danger'>Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
