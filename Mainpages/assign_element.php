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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <title>Microware</title>
    <link rel="icon" type="image/x-icon" href="logo4.jpg">
    
<style>
      * {
          margin: 0;
          padding: 0;
      }
      body {
        background-image: url("lab.jpg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        height: 100%;
        backdrop-filter: blur(7px);
        overflow: auto;
      }
      body::-webkit-scrollbar {
        display: none;
      }
      #navhome {
          top: 0;
          position: sticky;
          height: 11vh;
          display: flex;
          background-color: #6898FF;
          color: white;
          align-items: center;
          justify-content: space-between;
          padding-left: 20px;
          padding-right: 20px;
      }

      #exampleInput {
        border-width: 2px;
        border-color: #3481FE;
        font-size: 18px;
        font-family: serif;
      }

      #categorySelect {
        border-width: 2px;
        border-color: #3481FE;
        font-size: 19px;
        padding-left: 20px;
        font-family: serif;
        color: rgb(97, 90, 90);
        width: 100%;
      }
      .head {
        text-align: center;
        color: #034EEE;
        font-family: serif;
        font-size: 50px;
        font-weight: bold;
        margin-top: 1%;
        text-shadow: 0 0 4px white;
        margin-bottom: 0%;
      }

      .form-label {
        color: #04517a;
        font-weight: bold;
        font-family: sitka text;
        text-shadow: 0 0 2px white;
        font-size: 35px;
        display: flex;
        align-items: center;
      }
      
      .form-label1 {
        color: #04517a;
        font-weight: bold;
        font-family: sitka text;
        text-shadow: 0 0 2px white;
        font-size: 35px;
        display: flex;
        align-items: center;
        margin-top: -3.5%;
      }

      .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 48
      }

      .form-group {
          display: flex;
          align-items: center;
          gap: 10px;
          margin-bottom: 20px;
      }

      #Userlogo {
        cursor: pointer;
        font-size: 35px;
      }

      #searchlogo {
        cursor: pointer;
        border: 2px solid white;
        border-radius: 4px;
      }

      .form-control {
          height: 40px;
          flex: 1;
      }

      .btn-primary {
        color: #034EEE;
        font-family: serif;
        font-weight: bold;
        margin-top: 3%;
        text-align: center;
        font-size: 25px;
        height: 50px;
        width: 150px;
        border: 2px solid #3481FE;
        border-radius: 8px;
      }
      .btn-primary:hover {
        background-color: #04517a;
        color: white;
        border: 2px solid white;
        border-radius: 8px;
      }
      #valueInput, #unitInput{
        width: 25%; 
        border-width: 2px;
        border-color: #3481FE;
        font-size: 18px;
        padding-left: 20px;
        font-family: serif;
        color: rgb(97, 90, 90);
    }
    #receiverInput, #labInput, #assignDate, #returnDate{
        border-width: 2px;
        border-color: #3481FE;
        font-size: 18px;
        padding-left: 20px;
        font-family: serif;
        color: rgb(97, 90, 90);
    }
    </style>
</head>
<body>
	<nav id="navhome">
      <img src="logo4.png" alt="Unavailable" height="55px">
      <a href="homepage.php" style="text-decoration: none; color: white; font-family: Times New Roman; font-size: 25px; font-style: oblique; margin-left: -75%"><h1 style="font-weight: bolder;">Microware</h1></a>
      <span id="Userlogo" class="material-symbols-outlined">account_circle</span>
  </nav>
    <div class="head">
        <h3 class="h2" style="font-size: 100%; font-weight: bold;">Assign Element</h3>
    </div>
    <form class="col-8 m-auto mt-5" method="POST" action="assign_records.php">
        <div class="mb-3">
          <label for="exampleInput" class="form-label1" style="text-shadow: 2px 2px #3498db;">Name:</label>
          <input type="text" class="form-control" placeholder="  Enter Element Name" id="exampleInput" name="name" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="valueInput" style="margin-top:1%; text-shadow: 2px 2px #3498db;" class="form-label">Quantity:</label>
          <div style="display: flex; gap: 10px;">
            <input type="number" class="form-control" placeholder="Enter Value" id="valueInput" name="value" aria-describedby="emailHelp" required>
            <input type="text" class="form-control" placeholder="Enter Unit" id="unitInput" name="unit" aria-describedby="emailHelp" required>
          </div>
        </div>
        <div class="mb-3">
            <label for="exampleInput" style="margin-top:1%; text-shadow: 2px 2px #3498db;" class="form-label">Category:</label>
            <select class="form-control" id="categorySelect" name="category" aria-describedby="emailHelp" required>
                <option value="" disabled selected hidden>Select a Category</option>
                <option value="chemical">Chemical</option>
                <option value="glassware">Glassware</option>
                <option value="instrument">Instrument</option>
                <option value="tool">Tool</option>
            </select>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Receiver:</label>
          <input type="text" class="form-control" placeholder="  Enter Receiver Name" id="receiverInput" name="receiver" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Receiver Lab:</label>
          <input type="text" class="form-control" placeholder="  Enter Receiver Lab" id="labInput" name="lab" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Assign Date:</label>
          <input type="date" class="form-control" id="assignDate" name="assign_date" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Return Date:</label>
          <input type="date" class="form-control" id="returnDate" name="return_date" aria-describedby="emailHelp" required>
        </div>
        <div>
        <center><button type="submit" class="btn-primary">Submit</button></center>
        <br><br><br>
        </div>
      </form>
      <script>
        document.getElementById('Userlogo').addEventListener('click', function () {
            Swal.fire({
                position: "center",
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
