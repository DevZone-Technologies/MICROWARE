<?php
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
    <link rel="stylesheet" href="../Css/equipment.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Microware</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo4.jpg">
</head>
<body>
	<nav id="navhome">
      <img src="../Images/logo4.png" alt="Unavailable" height="55px">
      <a href="homepage.php" style="text-decoration: none; color: white; font-family: Times New Roman; font-size: 25px; font-style: oblique; margin-left: -75%"><h1 style="font-weight: bolder;">Microware</h1></a>
    <span id="Userlogo" class="material-symbols-outlined">account_circle</span>
    </nav>
    <div class="head">
        <h3 class="h2" style="font-size: 100%; font-weight: bold;">New Element</h3>
    </div>
    <form class="col-8 m-auto mt-5" method="POST" action="records.php">
        <div class="mb-3">
          <label for="exampleInput" class="form-label1" style="text-shadow: 2px 2px #3498db;">Name:</label>
          <input type="text" class="form-control" placeholder="  Enter Name" id="exampleInput" name="name" aria-describedby="emailHelp" required>
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
        <div>
        <center><button type="submit" class="btn-primary">Submit</button></center>
        </div>
      </form>
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
