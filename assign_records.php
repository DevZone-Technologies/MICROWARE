<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "microwaredb";

// Get the POST data
$name = $_POST["name"];
$value = $_POST["value"];
$unit = $_POST["unit"];
$receiver = $_POST["receiver"];
$lab = $_POST["lab"];
$assign_date = $_POST["assign_date"];
$return_date = $_POST["return_date"];

// Create a connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the table 'assign_records' exists, and if not, create it
$sql = "SHOW TABLES LIKE 'assign_records'";
$res = $con->query($sql);

if ($res->num_rows == 0) {
    $t = "CREATE TABLE assign_records (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(50),
        quantity INT,
        unit VARCHAR(20),
        category VARCHAR(10) CHECK (category IN ('Chemical', 'Instrument', 'Glassware', 'Tool')),
        receiver VARCHAR(20),
        lab VARCHAR(15),
        assign_date DATE,
        return_date DATE,
        status VARCHAR(10) CHECK (status IN ('Assigned', 'Returned'))
    );";
    if (!$con->query($t)) {
        die("Table creation failed: " . $con->error);
    }
}
// current availability
$rec = "SELECT * FROM RECORDS WHERE name='$name'";
$recResult = $con->query($rec);
if ($recResult->num_rows > 0) {
    $row = $recResult->fetch_assoc();
    $availability = $row['AVAILABILITY'];
    $category = $row['CATEGORY'];
    $newAvailability = $availability - $value;
    if($newAvailability>=0){
        // Update availability
        $sql1 = "UPDATE records SET availability = $newAvailability WHERE name = '$name'";
        if ($con->query($sql1) === TRUE) {
            // Insert the new record
            $sql = "INSERT INTO ASSIGN_RECORDS (name, quantity, unit, category, receiver, lab, assign_date, return_date, status) 
            VALUES ('$name', '$value', '$unit', '$category', '$receiver', '$lab', '$assign_date', '$return_date', 'Assigned')";
            if ($con->query($sql) === TRUE) {
                // Redirect to check.php with success message
                header("Location: check_assign_records.php?success=1");
                exit(); // Ensure no further code is executed after the redirect
            } else {
                echo "Error inserting record: " . $con->error;
            }
        }else {
            echo "Error updating record: " . $con->error;
        }
    }else{
            header("Location: Check.php?error=1");
                exit(); // Ensure no further code is executed after the redirect
    }
}else {
        header("Location: Check.php?error1=1");
        exit();
} 

// Close the connection
$con->close();
?>
