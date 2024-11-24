<?php
$host = 'localhost'; // Server name
$user = 'root';      // Database username
$pass = '';          // Database password (leave empty for XAMPP)
$db_name = 'db_sfms'; // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>
