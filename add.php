<?php
session_start();
require_once('inc/config.php');

function redirect($url) {
    header("Location: $url");
    exit;
}

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to the login page if the user is not logged in
    redirect("index.php");
}

// Check if the database connection is successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_quantity = $_POST['item_quantity'];
    $item_manufacturer = $_POST['item_manufacturer'];
    $item_value = $_POST['item_value'];

    // Insert the item data into the database, using the retrieved user_id
    $query = "INSERT INTO inventory (item_name, item_quantity, item_price, item_manufacturer, item_value, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssi", $item_name, $item_quantity, $item_price, $item_manufacturer, $item_value, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Item added to inventory!";
            redirect("add.php"); // Redirect to the main page or any other page as needed
        } else {
            echo "Error: " . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($db);
    }
}

// Display the HTML content
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <title>ADD IN INVENTORY</title>
</head>
<body>
<div class="topnav">
    <a href="main.php">Home</a>
    <a href="employees.php">Employee</a>
    <a href="invoice.php">Invoice</a>
    <a href="product.php">Product</a>
    <a href="delivery.php">Delivery</a>
</div>
    <h2>Inventory</h2>
<div class="container">
<div class="add">
        <form action="add.php" method="post">

        <label for="item_name">Name of Item:</label>
        <input type="text" name="item_name" required>

        <label for="item_price">Price of Item:</label>
        <input type="text" name="item_price" required>

        <label for="item_quantity">Quantity of Item:</label>
        <input type="text" name="item_quantity" required>

        <label for="item_manufacturer">Manufacturer of Item: </label>
        <input type="text" name="item_manufacturer" required>

        <label for="item_value">Value of Item:</label>
        <input type="text" name="item_value" required>

        <input type="submit" value="add">
    </form>
    </div>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Item Quantity</th>
            <th>Item Manufacturer</th>
            <th>Item Value</th>
        </tr>
        <?php
        session_start();
        require_once('inc/config.php');
        // Check if the user is logged in
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            // Redirect to the login page if the user is not logged in
            redirect("index.php");
        }
        // Select and display data from the database for the logged-in user
        $sql = "SELECT * FROM inventory WHERE user_id = ?";
        $stmt = mysqli_prepare($db, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["item_name"]. "</td><td>" . $row["item_price"] . "</td><td>"
                    . $row["item_quantity"]. "</td><td>" . $row["item_manufacturer"] . "</td><td>" . $row["item_value"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>0 results</td></tr>";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($db);
        }

        mysqli_close($db);
        ?>
    </table>
</div>
</body>
</html>
