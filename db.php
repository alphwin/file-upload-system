<?php
$servername = "localhost";  // Update with your server details if not localhost
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "file_upload_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
