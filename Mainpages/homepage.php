<?php
    $con=mysqli_connect("localhost","root","","BookVerse");
    session_start();
    if(isset($_SESSION['username1'])) {
        $username1 = $_SESSION['username1'];
    } else {
        header("Location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="logo4.jpg">
    <title>Microware</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        #navhome{
            top: 0;
            position: sticky;
            height: 11vh;
            display: flex;
            background-color:rgb(11, 148, 153);
            color: white;
            align-items: center;
            justify-content: space-between;
            padding-left: 20px;
            padding-right: 20px;
        }
        .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
        }
        .from1{
            display: flex;
        justify-content: space-around;
        }
        #Userlogo{
            cursor: pointer;
            font-size: 35px;
        }
        .d{
        height: 110vh;
        background-color: blanchedalmond;
        color: black;
        }
        body {
            background-image: url("Background.jpg");
            background-repeat: no-repeat;
            background-position: center 38%;
            background-size: cover;
            overflow: hidden; 
        }
        
        body::-webkit-scrollbar {
        display: none;
        }
        .btn{
        margin-top: 19%;
        margin-left: 8%;
        padding: 15px;
        border-radius: 15px;
        background-color: rgb(11, 148, 153);
        font-size: 38px;
        font-weight: bolder;
        font-family: 'Times New Roman', Times, serif;
        cursor: pointer;
        color: white;
        border-color:white;
        box-shadow: 0 0 2px 2px rgb(99, 98, 98);
        text-decoration: none;
        }
        .btn:hover{
        background-color: #fff;
        color:  rgb(11, 148, 153);
        border-color:  rgb(11, 148, 153);
        transition: all 0.5s;
        }
        .success-message {
            position: absolute; /* Keeps the element out of the normal flow */
            top: 2%; /* Adjust as needed */
            left: 45%; /* Adjust as needed */
            visibility: visible; /* Default visibility */
            color: white;
            font-size: 23px;
            margin: 20px;
            transition: opacity 1s ease-out;
            opacity: 1;
        }
    </style>
    <script>
        // Function to hide the success message after 5 seconds
        function hideMessage() {
            const message = document.getElementById('successMessage');
            if (message) {
                // Start fade-out
                setTimeout(() => {
                    message.style.opacity = '0';  
                    message.style.visibility = 'hidden'; // Optionally hide visibility after fade-out
                }, 5000);

                // Update the URL to clear the success parameter
                setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('success', '0');
                    window.history.replaceState({}, document.title, url);
                }, 6000); // 1 second after starting fade-out
            }
        }

    </script>
</head>
<body onload="hideMessage()">
    <nav id="navhome">
      <img src="logo4.png" alt="Unavailable" height="55px">
        <a style="text-decoration: none; color: white; font-family: Times New Roman; font-size: 25px; font-style: oblique; margin-left: -37%"><h1>Microware</h1></a>
        <center><div id="successMessage" class="success-message"><?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>Login Successful!!<?php endif; ?></div></center>
        <span id="Userlogo" class="material-symbols-outlined">account_circle</span>
    </nav>
    <div class="button">
        <center>
        <a href="equipment.php"><button type="button" name="button" class="btn" style="margin-left: 0.5%;">Add New Element</button></a>
        <a href="Check.php"><button type="button" name="button" class="btn">Check Inventory</button></a>
        <a href="assignment.php"><button type="button" name="button" class="btn">Assigned Element</button></a>
        </center>
    </div>

    <script>
        document.getElementById('Userlogo').addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will be logged out.',
                showCancelButton: true,
                confirmButtonColor: '#009E60',
                cancelButtonColor: '#C70039',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
        });
    </script>
    </body>
</html>
