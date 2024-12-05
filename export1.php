<?php
// Connect to the database
$con = mysqli_connect("localhost", "root", "", "microwaredb");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Output headers so that the file is downloaded rather than displayed
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="microware_assignment_records.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Fetch the data to be exported
$category = isset($_POST['category']) ? mysqli_real_escape_string($con, $_POST['category']) : 'all';
$sort = isset($_POST['sort']) ? mysqli_real_escape_string($con, $_POST['sort']) : 'NAME';
$order = isset($_POST['order']) ? mysqli_real_escape_string($con, $_POST['order']) : 'ASC';
$element = isset($_POST['element']) ? mysqli_real_escape_string($con, $_POST['element']) : '';

$sql = "SELECT * FROM ASSIGN_RECORDS";
if ($category != 'all') {
    $sql .= " WHERE CATEGORY = '$category'";
}
$sql .= " ORDER BY $sort $order";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Start output of Excel file
echo "<table border='1'>";
echo "<tr>";
echo "<th>SL NO.</th>";
echo "<th>NAME</th>";
echo "<th>QUANTITY</th>";
echo "<th>CATEGORY</th>";
echo "<th>RECEIVER</th>";
echo "<th>RECEIVER LAB</th>";
echo "<th>ASSIGN DATE</th>";
echo "<th>RETURN DATE</th>";
echo "<th>STATUS</th>";
echo "</tr>";

$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $assignDate = (new DateTime($row["assign_date"]))->format('d-m-Y');
    $returnDate = (new DateTime($row["return_date"]))->format('d-m-Y');
    
    echo "<tr>";
    echo "<td>" . $i++ . "</td>";
    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["quantity"]) . ' ' . htmlspecialchars($row["unit"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["category"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["receiver"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["lab"]) . "</td>";
    echo "<td>" . $assignDate . "</td>";
    echo "<td>" . $returnDate . "</td>";
    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
    echo "</tr>";
}

echo "</table>";

// Close the database connection
mysqli_close($con);
?>
