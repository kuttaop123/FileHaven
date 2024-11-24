<?php
require 'db/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username already exists. Please choose a different username.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("ss", $username, $hashed_password);

            if ($insert_stmt->execute()) {
                $success = "Account created successfully. <a href='login.php'>Login here</a>";
            } else {
                $error = "Error: Could not create account.";
            }
        }
    } else {
        $error = "Both fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0093E9;
background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);

        }
        .form-container {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            padding-right:40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 50px 15px #04BADE;
            border:0.5px solid black;
            height:70vh;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 107.5%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
        .success {
            color: green;
            font-size: 14px;
            text-align: center;
        }
        p {
            text-align: center;
        }
        a {
            color: #4CAF50;
        }
        nav {
            background-color: #333;
            overflow: hidden;
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
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Sign Up</a>
    </nav>
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php 
        if (!empty($error)) { echo "<p class='error'>$error</p>"; }
        if (!empty($success)) { echo "<p class='success'>$success</p>"; }
        ?>
        <form action="signup.php" method="POST">
            <label for="username">Name:</label>
            <input type="text" id="name" name="username" required>
            
            <label for="password">Age:</label>
            <input type="text" id="password" name="password" required>
            

            <label for="password">Username:</label>
            <input type="text" id="username" name="password" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
