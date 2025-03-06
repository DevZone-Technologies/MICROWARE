<?php
function intcap($string) {
    return ucwords(strtolower($string));
}
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
// Initialize variables for previous selections
$selectedCategory = isset($_POST['category']) ? $_POST['category'] : 'all';
$selectedSort = isset($_POST['sort']) ? $_POST['sort'] : 'NAME';
$selectedOrder = isset($_POST['order']) ? $_POST['order'] : 'ASC';

$element = isset($_POST['element']) ? mysqli_real_escape_string($con, $_POST['element']) : '';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microware</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="../Images/logo4.jpg">
    <link rel="stylesheet" href="../Css/check_assign_records.css"/>
    <script>
        // Function to hide the success message after 5 seconds
        function hideMessage() {
            const message = document.getElementById('successMessage');
            if (message) {
                setTimeout(() => {
                    message.style.opacity = '0';  // Start fade-out
                }, 5000);

                setTimeout(() => {
                    message.style.display = 'none';  // Remove element from layout
                    // Update the URL to clear the success parameter
                    const url = new URL(window.location.href);
                    url.searchParams.set('success', '0');
                    window.history.replaceState({}, document.title, url);
                }, 6000); // 1 second after starting fade-out
            }
        }
    </script>
</head>

<body style="background-image: none;" onload="hideMessage()">
    <nav id="navhome">
        <img src="../Images/logo4.png" alt="Logo Unavailable" height="55px">
        <a href="homepage.php" style="text-decoration: none; color: white; font-family: Times New Roman; font-style: oblique; font-size: 25px; margin-left: -25%;">
            <h1>Microware</h1>
        </a>
        <form class="form1" method="post">
            <div class="search-container">
                <input id="input1" type="text" placeholder="Search an element" name="element" value="<?php echo htmlspecialchars($element); ?>">
                <button id="searchlogo" class="material-symbols-outlined" name="search">search</button>
            </div>
        </form>

        <span id="Userlogo" class="material-symbols-outlined">account_circle</span>
    </nav>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <center><div id="successMessage" class="success-message">Element successfully added!</div></center>
    <?php endif; ?>
    <center>
    <form method="POST">
        Category:
            <select name="category" style="font-size: 20px; font-family: playfair display;">
            <option value="all" <?php if ($selectedCategory == 'all') echo 'selected'; ?>>All</option>
            <option value="Chemical" <?php if ($selectedCategory == 'Chemical') echo 'selected'; ?>>Chemical</option>
            <option value="Glassware" <?php if ($selectedCategory == 'Glassware') echo 'selected'; ?>>Glassware</option>
            <option value="Instrument" <?php if ($selectedCategory == 'Instrument') echo 'selected'; ?>>Instrument</option>
            <option value="Tool" <?php if ($selectedCategory == 'Tool') echo 'selected'; ?>>Tool</option>
        </select>
        &nbsp;&nbsp;Sort By:
        <select id="sortBy" name="sort" style="font-size: 20px; font-family: playfair display;" onchange="toggleOrderOptions()">
            <option value="NAME" <?php if ($selectedSort == 'NAME') echo 'selected'; ?>>Name</option>
            <option value="assign_date" <?php if ($selectedSort == 'assign_date') echo 'selected'; ?>>Assign Date</option>
            <option value="return_date" <?php if ($selectedSort == 'return_date') echo 'selected'; ?>>Return Date</option>
        </select>
        &nbsp;&nbsp;Order:
        <select name="order" style="font-size: 20px; font-family: playfair display;">
            <option value="ASC" <?php if ($selectedOrder == 'ASC') echo 'selected'; ?>>Ascending</option>
            <option value="DESC" <?php if ($selectedOrder == 'DESC') echo 'selected'; ?>>Descending</option>
        </select>
        <button type="submit" name="apply" class="btn-primary">Apply</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="export1.php" class="btn-primary1">Export to Excel</a>
    </form>
    <h1>Records of Assigned Elements</h1><br>
    <table>
        <tr>
            <th>SL NO.</th>
            <th>NAME</th>
            <th>QUANTITY</th>
            <th>CATEGORY</th>
            <th>RECEIVER</th>
            <th>RECEIVER LAB</th>
            <th>ASSIGN DATE</th>
            <th>RETURN DATE</th>
            <th>STATUS</th>
            <th>MODIFY</th>
        </tr>
        <?php
        // Prepare default SQL query
        $sql = "SELECT * FROM ASSIGN_RECORDS ORDER BY NAME ASC";

        // If form is submitted
        if (isset($_POST['apply'])) {
            $category = mysqli_real_escape_string($con, $selectedCategory);
            $sort = mysqli_real_escape_string($con, $selectedSort);
            $order = mysqli_real_escape_string($con, $selectedOrder);
            if ($category == 'all') {
                $sql = "SELECT * FROM ASSIGN_RECORDS ORDER BY $sort $order";
            } else {
                // Adjust SQL to filter by the selected category
                $sql = "SELECT * FROM ASSIGN_RECORDS WHERE CATEGORY = '$category' ORDER BY $sort $order";
            }
        }
        if (isset($_POST['search'])) {
            $element = $_POST['element'];
            $sql = "SELECT * FROM ASSIGN_RECORDS WHERE Name LIKE '$element%'";
        }

        // Execute the query
        $result = mysqli_query($con, $sql);

        if (!$result) {
            die("Query failed: " . mysqli_error($con));
        }            
        $i = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["quantity"]) . ' ' . htmlspecialchars($row["unit"]); ?></td>
                    <td><?php echo intcap(htmlspecialchars($row["category"])); ?></td>
                    <td><?php echo intcap(htmlspecialchars($row["receiver"])); ?></td>
                    <td><?php echo intcap(htmlspecialchars($row["lab"])); ?></td>
                    <?php
                        $date1 = new DateTime($row["assign_date"]); 
                        $formattedDate1 = $date1->format('d-m-Y'); 
                        $date = new DateTime($row["return_date"]); 
                        $formattedDate = $date->format('d-m-Y'); 
                    ?>
                    <td><?php echo htmlspecialchars($formattedDate1); ?></td>
                    <td><?php echo htmlspecialchars($formattedDate); ?></td>
                    <td><?php echo intcap(htmlspecialchars($row["status"])); ?></td>
                    <td>
                        <?php if (strtolower($row["status"]) == "returned"): ?>
                            <button id='action2'><a onclick="confirmDelete('<?php echo htmlspecialchars($row['id']); ?>')" style="text-decoration:none; color:Blue;">Delete</a></button>
                        <?php else: ?>
                            <button id='action1'><a href="edit_assign.php?id=<?php echo urlencode($row['id']); ?>" style="text-decoration:none; color:blue;">Edit</a></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        } else {
            echo "<tr><td colspan='10'><b>No data found</b></td></tr>";
        }
        ?>
    </table>
    </center>
</body>
<script>
    function confirmDelete(name) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to delete.php with the element's name as a query parameter
                    window.location.href = 'delete_assign.php?id=' + encodeURIComponent(name);
                }
            });
        }
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
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
