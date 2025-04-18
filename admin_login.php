<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";  // Default MySQL username
$password = "";      // Leave blank if not set
$dbname = "donor_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check the admin credentials
    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // If credentials are correct
    if ($result->num_rows > 0) {
        // Start the session for the admin
        $_SESSION['admin'] = $username;
        // Redirect to dashboard page
        header("Location: dashboard.php");  // Redirect to dashboard page after login
        exit;
    } else {
        echo "<script>alert('Incorrect username or password.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 500px;
            background-color: white;
            border: 2px solid #8B0000;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #8B0000;
            font-size: 24px;
            margin-bottom: 30px;
        }
        label {
            font-size: 18px;
            color: #333;
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            background-color: #8B0000;
            color: white;
            padding: 12px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #A52A2A;
        }
        .back-home {
            text-align: center;
            margin-top: 20px;
        }
        .back-home a {
            text-decoration: none;
            color: #8B0000;
            font-size: 16px;
        }
        .logo1 img {
            width: 200px; /* Adjust size as needed */
            height: auto;
            position: absolute;
            top: 10px; /* Adjust for vertical positioning */
            left: 10px; /* Adjust for horizontal positioning */
            background: none; /* No background for image */
            border: none; /* Ensure there's no border */
        }
    </style>
</head>
<body>
<div class="logo1">
        <img src="img12345.png" alt="Blood Donation Logo Top-Left">
    </div>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="admin_login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login" class="btn">
        </form>
        <div class="back-home">
            <a href="index.php">Back to Home</a>
        </div>
    </div>

</body>
</html>
