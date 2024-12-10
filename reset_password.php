<?php
require 'db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);

    if (!empty($username) && !empty($new_password)) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_query = "UPDATE users SET password = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $hashed_password, $username);

            if ($update_stmt->execute()) {
                echo "Password reset successfully. Please log in.";
            } else {
                echo "Error: Could not reset password.";
            }
        } else {
            echo "No user found with that username.";
        }
    } else {
        echo "Both fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #0093E9;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 300px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 50px 15px #04BADE;
            border:0.5px solid black;
        }

        .form-container h2 {
            text-align: center;
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #4cae4c;
        }

        .form-container p {
            text-align: center;
            font-size: 14px;
        }

        .form-container a {
            color: #5cb85c;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
        nav {
            background-color: #333;
            overflow: hidden;
            margin-top:0;
            width:220vh;
            margin-left:-20px;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>
<nav>
        <a href="index.html">Home</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign Up</a>
    </nav>
    <div class="form-container">
        <h2>Reset Password</h2>
        <?php 
        if (!empty($error)) { echo "<p class='error'>$error</p>"; }
        if (!empty($success)) { echo "<p class='success'>$success</p>"; }
        ?>
        <form action="reset_password.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <button type="submit">Reset Password</button>
        </form>
        <p>Remembered your password? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
