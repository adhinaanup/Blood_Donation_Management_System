<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Donor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            text-align: left;
            border: 2px solid black;
            padding: 50px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
        h1 {
            color: #8B0000;
            text-align: center;
            margin-bottom: 40px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: inline-block;
            width: 120px;
            color: #8B0000;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="date"], select {
            width: 200px;
            padding: 8px;
            margin-left: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .button {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 20px;
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
    </style>
    <script>
        function validateForm() {
            const dobInput = document.getElementById('dob').value;
            const dob = new Date(dobInput);
            const today = new Date();

            if (dob > today) {
                alert('Date of birth cannot be in the future.');
                return false;
            }

            const age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();

            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            if (age < 18 || age > 65) {
                alert('Age must be between 18 and 65 years.');
                return false;
            }

            const mobile = document.getElementById('mobile').value;
            const mobilePattern = /^[0-9]{10}$/;

            if (!mobilePattern.test(mobile)) {
                alert('Mobile number must be 10 digits.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<div class="logo1">
        <img src="img12345.png" alt="Blood Donation Logo Top-Left">
    </div>
    <div class="container">
        <h1>Add Donor</h1>
        <form action="insert_donor.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="dob">DOB:</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="blood_type">Blood Type:</label>
                <select id="blood_type" name="blood_type" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile No:</label>
                <input type="text" id="mobile" name="mobile" pattern="[0-9]{10}" required>
            </div>
            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="button">Submit</button>
        </form>
        <div class="back-home">
            <a href="index.php">Back to Home</a>
        </div>
    </div>

</body>
</html>
