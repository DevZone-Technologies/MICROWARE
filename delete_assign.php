<?php
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "microwaredb");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql = "DELETE FROM ASSIGN_RECORDS WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        header("Location: check_assign_records.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>
