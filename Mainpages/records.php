<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "microwaredb";

// Get the POST data
$name = $_POST["name"];
$value = $_POST["value"];
$unit = $_POST["unit"];
$category = $_POST["category"];

// Create a connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the table 'records' exists, and if not, create it
$sql = "SHOW TABLES FROM $database LIKE 'records'";
$res = mysqli_query($con, $sql);
$rows = $res->fetch_array(MYSQLI_NUM);

if ($rows == NULL) {
    $t = "CREATE TABLE RECORDS (
        NAME VARCHAR(50) PRIMARY KEY,
        VALUE INT,
        UNIT VARCHAR(20),
        CATEGORY VARCHAR(10) CHECK (CATEGORY IN ('Chemical', 'Instrument', 'Glassware', 'Tool'))
    );";
    $res = $con->query($t);
}

$sql= "SELECT * FROM RECORDS WHERE NAME='$name'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0){
    header("Location: check.php?success1=1");
    exit();
}else{
    // Insert the new record
    $sql = "INSERT INTO RECORDS (name, availability, unit, category) VALUES ('$name', '$value', '$unit', '$category')";
    if ($con->query($sql) === TRUE) {
        // Redirect to check.php with success message
        header("Location: check.php?success=1");
        exit(); // Ensure no further code is executed after the redirect
    }else {
        echo "<br>Record not inserted!!";
    }
}

// Unset the variables
unset($name);
unset($value);
unset($unit);
unset($category);

// Close the connection
$con->close();
?>
