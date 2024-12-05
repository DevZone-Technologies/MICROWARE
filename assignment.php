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
        body{
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
        margin-top: 13%;
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
    </style>
</head>
<body>
  <nav id="navhome">
      <img src="logo4.png" alt="Unavailable" height="55px">
      <a href="homepage.html" style="text-decoration: none; color: white; font-family: Times New Roman; font-size: 25px; font-style: oblique; margin-left: -75%"><h1>Microware</h1></a>

        <span id="Userlogo" class="material-symbols-outlined">account_circle</span></a>
    </nav>
	<br><br><br><br><br>
    <div class="button">
        <center>
            <a href="assign_element.php"><button type="button" name="button" class="btn" style="margin-left: 0.5%;" >Element Assignment</button></a>
            <a href="check_assign_records.php"><button type="button" name="button" class="btn">Assignment Record</button></a>

        </center>
    </div>

</body>
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
                    setTimeout(function () {
                        Swal.fire({
                            title: 'Logged Out!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "logout.php";
                            }
                        });
                    });
                }
            });
        });
</script>
</html>
