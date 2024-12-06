<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "tio_itec116_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user input
    $student_number = mysqli_real_escape_string($conn, $_POST['stud_num']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $mobile2 = mysqli_real_escape_string($conn, $_POST['mobile2']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $email2 = mysqli_real_escape_string($conn, $_POST['email2']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Hash the password before saving it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Registration and expiry dates
    $registration_date = date("Y-m-d"); // Current date
    $expiry_date = date("Y-m-d", strtotime("+5 months", strtotime($registration_date))); // 5 months later

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email_main='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Email already exists!");</script>';
    } else {
        // Insert user data
        $insert_query = "INSERT INTO users (student_number, course, first_name, last_name, birthday, gender, address, phone_main, phone_secondary, email_main, email_secondary, password, registration_date, expiry_date)
                        VALUES ('$student_number', '$course', '$first_name', '$last_name', '$birthday', '$gender', '$address', '$mobile', '$mobile2', '$email', '$email2', '$hashed_password', '$registration_date', '$expiry_date')";
        if (mysqli_query($conn, $insert_query)) {
            echo '<script>alert("Registration successful!");</script>';
            // Redirect to login page
            echo '<script>window.location.href = "login.php";</script>';
        } else {
            echo '<script>alert("Failed to register user. Please try again.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("bg2.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            margin: 10px 5px 5px 20px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 35px;
            width: 700px;
        }

        .main h2 {
            margin-top: -3px;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #004d00;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color : rgb(230, 230, 230, 0.7);
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 15px;
            border-radius: 10px;
            border: none;
            background-color: #008000;
            color: white;
            cursor: pointer;
            width: 45%;
            font-size: 16px;
            margin-right: 10px;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #514ca6;
        }
    </style>
</head>
<body>
    <div class="bg-image">
        <div class="main">
            <h2>Registration Form</h2>
            <form method="POST" action="">
                <label for="stud_num">Student Number:</label>
                <input type="text" id="stud_num" name="stud_num" maxlength="9" required />

                <label for="course">Course / Program:</label>
                <input type="text" id="course" name="course" required />

                <label for="first">First Name:</label>
                <input type="text" id="first" name="first" required />

                <label for="last">Last Name:</label>
                <input type="text" id="last" name="last" required />

                <label for="birthday">Birthday:</label>
                <input type="date" id="birthday" name="birthday" />

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Others</option>
                    <option value="notspecific">Not Specified</option>
                </select>

                <label for="address">Address:</label>
                <textarea id="address" name="address" cols="86" rows="5" required></textarea><hr>

                <h3>Contact Info</h3>
                <label for="mobile">Main Phone Number:</label>
                <input type="text" id="mobile" name="mobile" maxlength="11" required />

                <label for="mobile2">Secondary Phone Number:</label>
                <input type="text" id="mobile2" name="mobile2" maxlength="11" />

                <label for="email">Main Email Address:</label>
                <input type="email" id="email" name="email" required />

                <label for="email2">Secondary Email Address:</label>
                <input type="email" id="email2" name="email2" />

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />

                <label for="registrationDate">Registration Date:</label>
                <input type="text" id="registrationDate" name="registrationDate" value="<?php echo date('Y-m-d'); ?>" disabled />

                <label for="expiry">Expiry Date:</label>
                <input type="text" id="expiry" name="expiry" value="<?php echo date('Y-m-d', strtotime('+5 months')); ?>" disabled />

                <input type="submit" value="Submit" />
                <input type="reset" value="Reset" /><br />

                <p>Already have an account? <a href="login.php">Login!</a></p>
            </form>
        </div>
    </div>
</body>
</html>