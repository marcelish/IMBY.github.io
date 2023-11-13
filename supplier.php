<?php
// Include the database connection configuration
require_once('inc/config.php');
session_start();

function redirect($url) {
    header("Location: $url");
    exit;
}

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to login page or handle the case where the user is not logged in
    redirect("login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $SName = $_POST['SName'];
    $SPhone = $_POST['SPhone'];

    // Insert the supplier data into the database
    $query = "INSERT INTO supplier (SName, SPhone, user_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $SName, $SPhone, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Supplier added!";
            redirect("supplier.php"); // Redirect to the same page to refresh the table
        } else {
            echo "Error: " . mysqli_error($db); // Display an error message related to the database execution
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($db); // Display an error message related to the prepared statement creation
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <title>SUPPLIER</title>
</head>
<body>
<div class="topnav">
    <a href="main.php">Home</a>
    <a href="add.php">Inventory</a>
    <a href="employees.php">Employee</a>
    <a href="invoice.php">Invoice</a>
    <a href="product.php">Product</a>
    <a href="delivery.php">Delivery</a>
</div>
    <h2>SUPPLIER FOR PRODUCT / SERVICE</h2>
    <div class = "container">
    <div class="supplier">
        <form action="supplier.php" method="post">
            <label for="SName">Supplier Name</label>
            <input type="text" name="SName" required>

            <label for="SPhone">Supplier Phone</label>
            <input type="text" name="SPhone" required>

            <input type="submit" value="supplier">
        </form>
    </div>
    <table>
        <tr>
            <th>Supplier Name</th>
            <th>Supplier Phone</th>
        </tr>
        <?php
        // Select and display data from the database for the logged-in user
        $sql = "SELECT * FROM supplier WHERE user_id = ?";
        $stmt = mysqli_prepare($db, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["SName"]. "</td><td>" . $row["SPhone"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>0 results</td></tr>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($db);
        }
        ?>
    </table>
    </div>
</body>
</html>
