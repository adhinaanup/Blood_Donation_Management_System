<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Management System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .container {
            text-align: center;
        }

        .logo img {
            width: 400px; 
            height: auto;
            display: block;
            margin: 0 auto;
            background: none; 
            border: none; 
        }

        /* Logo1 (top-left logo) */
        .logo1 img {
            width: 200px; 
            height: auto;
            position: absolute;
            top: 10px; 
            left: 10px; 
            background: none; 
            border: none; 
        }

        /* Title Styling */
        .title {
            font-size: 3rem;
            color: #a00000;
            margin-top: 20px;
        }

        /* Subtitle or message */
        .subtitle {
            font-size: 1.2rem;
            color: #333;
            margin-top: 10px;
            margin-bottom: 40px;
        }


        .button {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background-color: #8B0000;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            text-align: center;
        }
        .button:hover {
            background-color: #A52A2A;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #a00000;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo Section -->
        <div class="logo1">
            <img src="img12345.png" alt="Blood Donation Logo Top-Left">
        </div>
        <div class="logo">
            <img src="img24.png" alt="Blood Donation Logo Center"> <!-- Your image here -->
        </div>
        
        <!-- Title and Welcome Message -->
        <div class="title">Blood Donation Management System</div>
        <div class="subtitle">Join hands to save lives. Donate blood, give hope!</div>
    </div>

    <!-- Continue Button -->
    <form action="index.php" method="get">
        <button class="button" type="submit">Login →</button>
    </form>

    <!-- Footer Section -->
    <footer>
        <p>Contact Us: +91 9867546784 | Email: bloodbond@gmail.com</p>
    </footer>
</body>
</html>
