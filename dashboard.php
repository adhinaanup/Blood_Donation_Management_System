
<?php
// Start the session
session_start();

// Check if the admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
date_default_timezone_set('Asia/Kolkata');
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donor_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle donor deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // First, delete from blooddonations table
    $sql1 = "DELETE FROM blooddonations WHERE donor_id='$delete_id'";
    $conn->query($sql1); // No need to check for result since we handle errors later

    // Now, delete from donors table
    $sql2 = "DELETE FROM donors WHERE id='$delete_id'";
    if ($conn->query($sql2) === TRUE) {
        echo "<script>alert('Donor and related records deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting donor: " . $conn->error . "');</script>";
    }
    
    // Redirect back to avoid refresh delete issue
    header("Location: dashboard.php?view_all_donors=true");
    exit;
}


// Handle donor addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $blood_type = $_POST['blood_type'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    $sql = "INSERT INTO donors (name, dob, gender, blood_type, address, mobile, email) 
            VALUES ('$name', '$dob', '$gender', '$blood_type', '$address', '$mobile', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        // Get the donor_id of the newly added donor
        $donor_id = $conn->insert_id;
        
        // Insert into blooddonations table with current date and time
        $donation_datetime = date('Y-m-d H:i:s'); // Current date and time
        $insert_blood_sql = "INSERT INTO blooddonations (donor_id, blood_type, donation_date) 
                             VALUES ($donor_id, '$blood_type', '$donation_datetime')";
        
        if ($conn->query($insert_blood_sql) === TRUE) {
            echo "<script>alert('Donor and donation record added successfully');</script>";
        } else {
            echo "<script>alert('Error adding donation record: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Error adding donor: " . $conn->error . "');</script>";
    }
}

// Fetch donor details if "View All Donor Details" is clicked
$donors = [];
if (isset($_GET['view_all_donors'])) {
    $sql = "SELECT * FROM donors";  // assuming 'donors' is the table name for donor data
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $donors[] = $row;
        }
    }
}



$blood_inventory = [];

// Fetch blood type counts and insert into blood_inventory
if (isset($_GET['blood_inventory'])) {
    // Clear existing data in blood_inventory before inserting new data
    $conn->query("DELETE FROM blood_inventory");

    $sql = "SELECT blood_type, COUNT(*) AS count FROM donors GROUP BY blood_type";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Store in the array
            $blood_inventory[] = $row;

            // Insert into blood_inventory table
            $blood_type = $row['blood_type'];
            $count = $row['count'];
            $insert_sql = "INSERT INTO blood_inventory (blood_type, count) VALUES ('$blood_type', $count)";
            $conn->query($insert_sql);
        }
    }
}


// Fetch donor details for a specific blood type if "View Details" is clicked
$blood_type_donors = [];
if (isset($_GET['view_donors_by_blood_type'])) {
    $blood_type = $_GET['view_donors_by_blood_type'];
    $sql = "SELECT * FROM donors WHERE blood_type='$blood_type'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $blood_type_donors[] = $row;
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 20% 80%;
            height: 100vh;
        }

        .sidebar {
            background-color: #8B0000;
            color: white;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            margin: 15px 0;
            display: block;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: #A52A2A;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar a.logout {
            text-align: center;
        }

        .main-content {
            padding: 20px;
        }

        h1 {
            color: #8B0000;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn {
            background-color: #FF6347;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #FF4500;
        }

        /* Add Donor Form Styling */
        form {
            max-width: 600px;
            margin: 0 auto;
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
            width: 100px;
            padding: 10px;
            margin: 20px auto;
            background-color: #8B0000;
            color: white;
            border: none;
            border-radius: 30px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #A52A2A;
        }

        input[type="submit"] {
            background-color: #8B0000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #A52A2A;
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

<div class="dashboard">
    <div class="sidebar">
        <div>
            <h2>Admin Dashboard</h2>
            <a href="dashboard.php?view_all_donors=true">View All Donor Details</a>
            <a href="dashboard.php?add_donor=true">Add Donor</a>
            <a href="dashboard.php?blood_inventory=true">Blood Inventory</a>
        </div>
        <a href="index.php" class="logout">Logout</a>
    </div>

    <div class="main-content">
        <?php if (isset($_GET['view_all_donors'])): ?>
            <h2>All Donor Details</h2>
            <?php if (count($donors) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date Of Birth</th>
			                <th>Gender</th>
                            <th>Blood Group</th>
			                <th>Address</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Action</th> <!-- Added for delete button -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donors as $donor): ?>
                            <tr>
                                <td><?php echo $donor['id']; ?></td>
                                <td><?php echo $donor['name']; ?></td>
                                <td><?php echo $donor['dob']; ?></td>
			                    <td><?php echo $donor['gender']; ?></td>
                                <td><?php echo $donor['blood_type']; ?></td>
				                <td><?php echo $donor['address']; ?></td>
                                <td><?php echo $donor['mobile']; ?></td>
                                <td><?php echo $donor['email']; ?></td>
                                <td>
                                    <a href="dashboard.php?delete_id=<?php echo $donor['id']; ?>" onclick="return confirm('Are you sure you want to delete this donor?');">
                                        <button class="delete-btn">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No donors found.</p>
            <?php endif; ?>
        
        <?php elseif (isset($_GET['add_donor'])): ?>
            <h1>Add Donor</h1>
            <form action="dashboard.php?add_donor=true" method="POST" onsubmit="return validateForm()">
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

               

                <button type="submit" class="button">Add Donor</button>
            </form>
        
            <?php elseif (isset($_GET['blood_inventory'])): ?>
            <h2>Blood Inventory</h2>
            <?php if (count($blood_inventory) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Blood Type</th>
                            <th>Count</th>
                            <th>View Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blood_inventory as $blood): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($blood['blood_type']); ?></td>
                                <td><?php echo htmlspecialchars($blood['count']); ?></td>
                                <td>
                                    <a href="dashboard.php?view_donors_by_blood_type=<?php echo urlencode($blood['blood_type']); ?>">
                                        <button class="delete-btn">View Details</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No blood inventory data found.</p>
            <?php endif; ?>

        <?php elseif (isset($_GET['view_donors_by_blood_type'])): ?>
            <h2>Donors with Blood Type: <?php echo htmlspecialchars($_GET['view_donors_by_blood_type']); ?></h2>
            <?php if (count($blood_type_donors) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date Of Birth</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blood_type_donors as $donor): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($donor['id']); ?></td>
                                <td><?php echo htmlspecialchars($donor['name']); ?></td>
                                <td><?php echo htmlspecialchars($donor['dob']); ?></td>
                                <td><?php echo htmlspecialchars($donor['gender']); ?></td>
                                <td><?php echo htmlspecialchars($donor['address']); ?></td>
                                <td><?php echo htmlspecialchars($donor['mobile']); ?></td>
                                <td><?php echo htmlspecialchars($donor['email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No donors found for this blood type.</p>
            <?php endif; ?>

        <?php else: ?>
            <h2>Welcome to the Admin Dashboard</h2>
            <p>Select an option from the left menu to proceed.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

