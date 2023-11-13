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
    $PName = $_POST['PName'];
    $PPrice = $_POST['PPrice'];
    $PCategory = $_POST['PCategory'];

    // Insert the product data into the database
    $query = "INSERT INTO product (PName, PPrice, PCategory, user_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sisi", $PName, $PPrice, $PCategory, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Product added to inventory!";
            redirect("product.php"); // Redirect to the same page to refresh the table
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
    <title>PRODUCT / SERVICES</title>
</head>
<body>
<div class="topnav">
    <a href="main.php">Home</a>
    <a href="add.php">Inventory</a>
    <a href="employees.php">Employee</a>
    <a href="invoice.php">Invoice</a>
    <a href="delivery.php">Delivery</a>
</div>
    <h2>PRODUCT / SERVICES</h2>
<div class = "container">
    <div class="product">
        <form action="product.php" method="post">
            <label for="PName">Name Of Product</label>
            <input type="text" name="PName" required>

            <label for="PPrice">Product Price:</label>
            <input type="text" name="PPrice" required>

            <label for="PCategory">Category:</label>
            <input type="text" name="PCategory" required>

            <input type="submit" value="product">
        </form>
    </div>
    <table>
        <tr>
            <th>Name Of Product</th>
            <th>Product Price</th>
            <th>Category</th>
        </tr>
        <?php
        // Select and display data from the database for the logged-in user
        $sql = "SELECT * FROM product WHERE user_id = ?";
        $stmt = mysqli_prepare($db, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["PName"]. "</td><td>" . $row["PPrice"] . "</td><td>"
                    . $row["PCategory"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>0 results</td></tr>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($db);
        }
        ?>
    </table>
</div>
<a href="supplier.php">
        <button type="button">SUPPLIER</button>
    </a>
</body>
</html>
