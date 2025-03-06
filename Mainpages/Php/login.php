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
    <link rel="icon" type="image/x-icon" href="../Images/logo4.jpg">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../Css/login.css">
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
