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
    <link rel="stylesheet" href="../Css/Check.css"/>

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
                    url.searchParams.set('success1', '0');
                    url.searchParams.set('error', '0');
                    url.searchParams.set('error1', '0');
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
                <button id="searchlogo" class="material-symbols-outlined" name="search" >search</button>
            </div>
        </form>

        <span id="Userlogo" class="material-symbols-outlined">account_circle</span>
    </nav>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <center><div id="successMessage" class="success-message">Element successfully added!</div></center>
        <?php endif; ?>
    <?php if (isset($_GET['success1']) && $_GET['success1'] == 1): ?>
        <center><div id="successMessage" class="success-message">Element already present!</div></center>
        <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <center><div id="successMessage" class="error-message">Availibility low!</div></center>
        <?php endif; ?>
    <?php if (isset($_GET['error1']) && $_GET['error1'] == 1): ?>
        <center><div id="successMessage" class="error-message">Element not found!</div></center>
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
                <option value="AVAILABILITY" <?php if ($selectedSort == 'AVAILABILITY') echo 'selected'; ?>>Availability</option>
            </select>

            &nbsp;&nbsp;Order:
            <select name="order" style="font-size: 20px; font-family: playfair display;">
                <option value="ASC" <?php if ($selectedOrder == 'ASC') echo 'selected'; ?>>Ascending</option>
                <option value="DESC" <?php if ($selectedOrder == 'DESC') echo 'selected'; ?>>Descending</option>
                <option class="order-option hidden" value="Below" <?php if ($selectedOrder == 'Below') echo 'selected'; ?>>Below 50</option>
                <option class="order-option hidden" value="Between" <?php if ($selectedOrder == 'Between') echo 'selected'; ?>>Between 50 to 100</option>
                <option class="order-option hidden" value="Above" <?php if ($selectedOrder == 'Above') echo 'selected'; ?>>Above 100</option>
            </select>
            <button type="submit" name="apply" class="btn-primary">Apply</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="export.php" class="btn-primary1">Export to Excel</a>
        </form>
        <h1>Records of Element</h1><br>
        <table>
            <tr>
                <th>SL NO.</th>
                <th>CATEGORY</th>
                <th>NAME</th>
                <th>AVAILABILITY</th>
                <th colspan="2">MODIFY</th>
            </tr>
            <?php
            // Prepare default SQL query
            $sql = "SELECT * FROM RECORDS ORDER BY NAME ASC";

            // If form is submitted
            if (isset($_POST['apply'])) {
    $category = mysqli_real_escape_string($con, $selectedCategory);
    $sort = mysqli_real_escape_string($con, $selectedSort);
    $order = mysqli_real_escape_string($con, $selectedOrder);

    // Build SQL query based on selected filters
    if ($sort == 'NAME') {
        if ($category == 'all') {
            $sql = "SELECT * FROM RECORDS ORDER BY NAME $order"; // Use $order directly
        } else {
            $sql = "SELECT * FROM RECORDS WHERE CATEGORY = '$category' ORDER BY NAME $order"; // Use $order directly
        }
    } elseif ($sort == 'AVAILABILITY') {
        if ($category == 'all') {
            if ($order == 'Below') {
                $sql = "SELECT * FROM RECORDS WHERE AVAILABILITY < 50";
            } elseif ($order == 'Between') {
                $sql = "SELECT * FROM RECORDS WHERE AVAILABILITY >= 50 AND AVAILABILITY <= 100";
            } elseif ($order == 'Above') {
                $sql = "SELECT * FROM RECORDS WHERE AVAILABILITY > 100";
            } else {
                $sql = "SELECT * FROM RECORDS ORDER BY AVAILABILITY $order"; // Use $order directly
            }
        } else {
            if ($order == 'Below') {
                $sql = "SELECT * FROM RECORDS WHERE CATEGORY = '$category' AND AVAILABILITY < 50";
            } elseif ($order == 'Between') {
                $sql = "SELECT * FROM RECORDS WHERE CATEGORY = '$category' AND AVAILABILITY >= 50 AND AVAILABILITY <= 100";
            } elseif ($order == 'Above') {
                $sql = "SELECT * FROM RECORDS WHERE CATEGORY = '$category' AND AVAILABILITY > 100";
            } else {
                $sql = "SELECT * FROM RECORDS WHERE CATEGORY = '$category' ORDER BY AVAILABILITY $order"; // Use $order directly
            }
        }
    }
}

            
            if (isset($_POST['search'])) {
                $element=$_POST['element'];
                $sql = "SELECT * FROM RECORDS WHERE Name LIKE '$element%'";
            }
// Execute the query
$result = mysqli_query($con, $sql);
            
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}            
$i = 1;
if (mysqli_num_rows($result) > 0) {
    ?>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo intcap(htmlspecialchars($row["CATEGORY"])); ?></td>
            <td><?php echo htmlspecialchars($row["NAME"]); ?></td>
            <td><?php echo htmlspecialchars($row["AVAILABILITY"]) . ' ' . htmlspecialchars($row["UNIT"]); ?></td>
            <td><button id='action1'><a href="edit.php?id=<?php echo urlencode($row['NAME']); ?>" style="text-decoration:none; color:blue;">Edit</a></button></td>
            <td><button id='action2'><a href="#" onclick="confirmDelete('<?php echo htmlspecialchars($row['NAME']); ?>')" style="text-decoration:none; color:blue;">Delete</a></button></td>    
        </tr>
        <?php
        $i++;
    }
} else {
    echo "<tr><td colspan='6'><b>No data found</b></td></tr>";
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
                    window.location.href = 'delete.php?id=' + encodeURIComponent(name);
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
        function toggleOrderOptions() {
    const sortBy = document.getElementById('sortBy').value;
    const orderSelect = document.querySelector('select[name="order"]');
    const orderOptions = document.querySelectorAll('.order-option');

    if (sortBy === 'AVAILABILITY') {
        orderOptions.forEach(option => option.classList.remove('hidden'));
    } else {
        orderOptions.forEach(option => option.classList.add('hidden'));
        if( orderSelect.value === 'DESC'){
            orderSelect.value = 'DESC' ;
        }
        else{
            orderSelect.value = 'ASC' ;  // Automatically set the order to 'Ascending'
        }
    }
}

// Call the function on page load to set initial visibility
document.addEventListener('DOMContentLoaded', function() {
    toggleOrderOptions();
});


        // Call the function on page load to set initial visibility
        document.addEventListener('DOMContentLoaded', function() {
            toggleOrderOptions();
        });
    </script>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
