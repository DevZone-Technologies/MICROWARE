<?php
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "microwaredb");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $name = mysqli_real_escape_string($con, $_GET['id']);
    $sql = "DELETE FROM RECORDS WHERE NAME = '$name'";
    if (mysqli_query($con, $sql)) {
        header("Location: ChecK.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>
