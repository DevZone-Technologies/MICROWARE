<?php
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "microwaredb");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Output headers so that the file is downloaded rather than displayed
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="microware_records.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Fetch the data to be exported
$sql = "SELECT * FROM RECORDS";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Start output of Excel file
echo "<table border='1'>";
echo "<tr>";
echo "<th>SL NO.</th>";
echo "<th>CATEGORY</th>";
echo "<th>NAME</th>";
echo "<th>AVAILABILITY</th>";
echo "<th>UNIT</th>";
echo "</tr>";

$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    echo "<td>" . htmlspecialchars($row["CATEGORY"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["NAME"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["AVAILABILITY"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["UNIT"]) . "</td>";
    echo "</tr>";
}

echo "</table>";

// Close the database connection
mysqli_close($con);
?>
