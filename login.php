<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "microwaredb";

// Create connection
$con = new mysqli($servername, $username, $password, $database);
session_start();
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Initialize a variable for the alert message
$alertMessage = null;

// Check if username and password are provided via POST
if (isset($_POST["username"], $_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM LOGIN WHERE user_name='$username' AND password='$password'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Invalid query: ' . $con->error);
    }

    // Check if exactly one row is returned
    if ($result->num_rows == 1) {
        $_SESSION['username1'] = $username;
        header("Location: homepage.php?success=1");
        exit;
    } else {
        // Invalid credentials
        header("Location: login.php?login=error");
        exit;
    }
} 

// Close connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microware</title>
    <link rel="icon" type="image/x-icon" href="logo4.jpg">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Your existing CSS */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .left-section {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            width: 49%;
            background-image: url('pic.jpg');
        }
        .centered-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .right-section {
            flex: 1;
            background-color: #0096FF;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .heading {
            color: bisque;
            font-size: 58px;
            font-family: Times New Roman;
            margin-top: -7%;
            margin-bottom: 70px;
        }
        .box {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            height: 250px;
            width: 450px;
            position: relative;
        }
        .box h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            letter-spacing: 2px;
            margin-top: -2%;
            margin-bottom: 4%;
            color: rgb(9, 60, 136);
        }
        /* Input container styling */
        .input-container {
            position: relative;
            margin-bottom: 15px;
        }
        /* Icon styling */
        .icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: black;
        }
        /* Input styling */
        .input-container input[type="text"],
        .input-container input[type="password"] {
            width: 100%;
            padding: 10px 10px 10px 40px;
            margin: 10px 0;
            border: 1px solid #000;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 19px;
            font-family: Sitka;
        }
        .box button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            font-size: 20px;
            margin-top: 3%;
            font-family: Sitka;
            font-weight: bold;
        }
        .box button:hover {
            background-color: #0056b3;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #3A3B3C;
        }
        .custom-alert {
            display: none;
            position: fixed;
            top: 20%;
            right: 16%;
            background: #0096FF;
            color: white;
            z-index: 1000;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    const toggleIcon = document.querySelector(".toggle-password");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    }
}

function showAlert() {
    const urlParams = new URLSearchParams(window.location.search);
    const loginStatus = urlParams.get('login');
    const customAlert = document.getElementById('customAlert');

    if (loginStatus === 'error') {
        // Show custom alert
        customAlert.style.display = 'block';

        // Hide the alert and perform redirection after 2 seconds
        setTimeout(() => {
            customAlert.style.display = 'none';
            window.location.href = 'login.php';
        }, 2000); // 2 seconds delay
    }
}
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    // Handle SweetAlert for logout
    const logout = urlParams.get('logout');
    if (logout == 'true') {
        Swal.fire({
            icon: "success",
            title: "Logged out sucessfully!!...",
            showConfirmButton: false,
            timer: 1500
            });
    }
    // Call showAlert to handle login errors
    showAlert();
};

    </script>
</head>
<body>
    <div class="container">
        <div class="left-section">
        </div>
        <div class="right-section">
            <h1 class="heading">Welcome To Microware</h1>
            <div class="custom-alert" id="customAlert"><h2>Invalid Credentials!!</h2></div>
            <div class="box">
                <h2>LOGIN FORM</h2>
                <form method="post">
                    <div class="input-container">
                        <i class="fas fa-user icon"></i>
                        <input type="text" placeholder="Enter your username" name="username" required>
                    </div>
                    <div class="input-container">
                        <i class="fas fa-key icon"></i>
                        <input type="password" placeholder="Enter your password" name="password" id="password" required>
                        <i class="fa fa-eye-slash toggle-password" onclick="togglePasswordVisibility()"></i>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
