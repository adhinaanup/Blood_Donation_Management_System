<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Default MySQL username in WAMP
$password = "";      // Leave blank if you haven't set a password
$dbname = "donor_db";  // Your database name

date_default_timezone_set('Asia/Kolkata');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$blood_type = $_POST['blood_type'];
$address = $_POST['address'];
$mobile = $_POST['mobile'];
$email = $_POST['email'];

// Validate mobile number (exactly 10 digits)
if (!preg_match('/^\d{10}$/', $mobile)) {
    die("Phone number must be exactly 10 digits.");
}

// Calculate age from DOB
$dobDate = new DateTime($dob);
$today = new DateTime();
$age = $today->diff($dobDate)->y;

// Validate age (between 18 and 65)
if ($age < 18 || $age > 65) {
    die("Donor must be between 18 and 65 years old.");
}

// Insert data into the database
$sql = "INSERT INTO donors (name, dob, gender, blood_type, address, mobile, email)
        VALUES ('$name', '$dob', '$gender', '$blood_type', '$address', '$mobile', '$email')";


if ($conn->query($sql) === TRUE) {
    echo '<div class="success-page">
            <div class="logo-center">
                <img src="img12345.png" alt="Blood Donation Logo">
            </div>
            <h1>Donor Added Successfully</h1>
            <p>Thank you for submitting the donor information.</p>
            <a href="index.php" class="btn-home">Return to Homepage</a>
          </div>';
          
          $donor_id = $conn->insert_id;

        // Insert the donor details into the blooddonations table
        $donation_datetime = date('Y-m-d H:i:s'); // Current date and time in IST
        $insert_blood_sql = "INSERT INTO blooddonations (donor_id, blood_type, donation_date) 
                             VALUES ($donor_id, '$blood_type', '$donation_datetime')";

        if ($conn->query($insert_blood_sql) === TRUE) {
            echo "<script>alert('Donor and donation record added successfully');</script>";
        } else {
            echo "<script>alert('Error adding donation record: " . $conn->error . "');</script>";
        }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<style>
    .success-page {
        font-family: Arial, sans-serif;
        text-align: center;
        margin-top: 50px;
        position: relative;
    }
    .logo-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        margin-bottom: 20px;
    }
    .logo-center img {
        width: 200px;
        height: auto;
    }
    h1 {
        color: #8B0000;
    }
    .btn-home {
        background-color: #8B0000;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 20px;
    }
    .btn-home:hover {
        background-color: #A52A2A;
    }
</style>
