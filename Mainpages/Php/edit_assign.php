<?php
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "microwaredb");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
  if(isset($_SESSION['username1'])) {
      $username1 = $_SESSION['username1'];
  } else {
      header("Location: login.php");
      exit;
  }
$name = '';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $result = mysqli_query($con, "SELECT * FROM ASSIGN_RECORDS WHERE id = '$id'");   
    if ($row = mysqli_fetch_assoc($result)) {
            $Name=$row["name"];
            $Quantity=$row["quantity"];
            $Unit=$row["unit"];
            $Category=$row["category"]; 
            $Receiver=$row["receiver"];
            $Lab=$row["lab"];
            $Assign_date=$row["assign_date"];
            $Return_date=$row["return_date"];
            $Status=$row["status"];
    } else {
        die("Record not found.");
    }
}

if (isset($_POST['update'])) {
    $newDate = mysqli_real_escape_string($con, $_POST['return_date']);
    $updateQuery = "UPDATE ASSIGN_RECORDS SET Return_date = '$newDate' WHERE id = '$id'";    
    if (mysqli_query($con, $updateQuery)) {
        header("Location: check_assign_records.php");
        exit();
    } else {
        die("Error updating record: " . mysqli_error($con));
    }
}

if (isset($_POST['Return'])) {
    $rec = "SELECT AVAILABILITY FROM RECORDS WHERE name='$Name'";
    $recResult = $con->query($rec);
    if ($recResult->num_rows > 0) {
      $row = $recResult->fetch_assoc();
      $availability = $row['AVAILABILITY'];
      $newAvailability = $availability + $Quantity;
      // Update availability
      $sql1 = "UPDATE records SET availability = $newAvailability WHERE name = '$Name'";
      if ($con->query($sql1) === TRUE) {
        $updateQuery = "UPDATE ASSIGN_RECORDS SET status = 'Returned' WHERE id = '$id'";
        if (mysqli_query($con, $updateQuery)) {
            header("Location: check_assign_records.php");
            exit();
        } else {
        die("Error updating record: " . mysqli_error($con));
        }
      }
    }
}

// Close the database connection
mysqli_close($con);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Microware</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo4.jpg">
    <link rel="stylesheet" href="../Css/assign_element.css">
</head>
<body>
	<nav id="navhome">
      <img src="../Images/logo4.png" alt="Unavailable" height="55px">
      <a href="homepage.php" style="text-decoration: none; color: white; font-family: Times New Roman; font-size: 25px; font-style: oblique; margin-left: -75%"><h1 style="font-weight: bolder;">Microware</h1></a>
    <span id="Userlogo" class="material-symbols-outlined">account_circle</span>
    </nav>
    <div class="head">
    <h3 class="h2" style="font-size: 100%; font-weight: bold;">Edit Assignment</h3>
    </div>
    <form class="col-8 m-auto mt-5" method="POST">
        <div class="mb-3">
          <label for="exampleInput" class="form-label1" style="text-shadow: 2px 2px #3498db;">Name:</label>
          <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($Name); ?>" id="exampleInput" name="name" aria-describedby="emailHelp" Disabled>
        </div>
        <div class="mb-3">
        <label for="valueInput" style="margin-top:1%; text-shadow: 2px 2px #3498db;" class="form-label">Quantity:</label>
            <div style="display: flex; gap: 10px;">
                <input type="number" class="form-control" placeholder="<?php echo htmlspecialchars($Quantity); ?>" id="valueInput" name="value" aria-describedby="emailHelp"  Disabled>
                <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($Unit); ?>" id="unitInput" name="unit" aria-describedby="emailHelp" Disabled>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Category:</label>
            <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($Category); ?>" id="categoryInput1" aria-describedby="emailHelp" Disabled>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Receiver:</label>
          <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($Receiver); ?>" id="receiverInput" name="receiver" aria-describedby="emailHelp" Disabled>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Receiver Lab:</label>
          <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($Lab); ?>" id="labInput" name="lab" aria-describedby="emailHelp" Disabled>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Assign Date:</label>
          <input type="Date" class="form-control" value="<?php echo htmlspecialchars($Assign_date); ?>" id="assignDate" name="assign_date" aria-describedby="emailHelp" Disabled>
        </div>
        <div class="mb-3">
          <label for="exampleInput" class="form-label" style="text-shadow: 2px 2px #3498db;">Return Date:</label>
          <input type="date" class="form-control" id="returnDate" value="<?php echo htmlspecialchars($Return_date); ?>" name="return_date" aria-describedby="returnDateHelp" required>
        </div>
        <div>
        <center><button type="submit" name="update" class="btn-primary">Update</button>
        &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="Return" class="btn-primary">Return</button></center>
        <br><br><br></div>
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
