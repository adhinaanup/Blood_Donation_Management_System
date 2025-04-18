<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
        .button {
            width: 100%;
            background-color: #8B0000;
            color: white;
            padding: 12px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 30px;
        }
        .button:hover {
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
            width: 200px; 
            height: auto;
            position: absolute;
            top: 10px; 
            left: 10px; 
            background: none; 
            border: none; 
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
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
    </style>
</head>
<body>
    <div class="logo1">
        <img src="img12345.png" alt="Blood Donation Logo Top-Left">
    </div>
    <div class="container">
        <h2>Home Page</h2>
        
        <!-- Admin Login Button -->
        <form action="admin_login.php" method="GET">
            <input type="submit" value="Admin Login" class="button">
        </form>
        
        <!-- Add Donor Button -->
        <form action="add_donor.php" method="GET">
            <input type="submit" value="Add Donor" class="button">
        </form>
        <div class="back-home">
            <a href="form.php">Back </a>
        </div>
    </div>
</body>
</html>
