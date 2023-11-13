<?php
require_once('inc/config.php');
session_start();

function redirect($url) {
    header("Location: $url");
    exit;
}

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to the login page if the user is not logged in
    redirect("login.php");
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $orderNum = $_POST['orderNum'];
    $price = $_POST['price'];
    $detail = $_POST['detail'];
    $comment = $_POST['comment'];

    // Insert the item data into the database
    $query = "INSERT INTO invoice (orderNum, price, detail, comment, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $orderNum, $price, $detail, $comment, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Invoice added to inventory!";
            // No redirection after adding an invoice; let the user stay on the same page
        } else {
            echo "Execution error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Statement preparation error: " . mysqli_error($db);
    }
}

// Display the HTML content
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <title>INVOICE</title>
</head>
<body>
<div class="topnav">
    <a href="main.php">Home</a>
    <a href="add.php">Inventory</a>
    <a href="employees.php">Employee</a>
    <a href="product.php">Product</a>
    <a href="delivery.php">Delivery</a>
</div>
<h2>RECEIVED INVOICES</h2>
<div class = "container">
    <div class="invoice">
        <form action="invoice.php" method="post">
            <label for="orderNum">Add the order number</label>
            <input type="text" name="orderNum" required>

            <label for="price">Invoice Price:</label>
            <input type="text" name="price" required>

            <label for="detail">Brief description:</label>
            <input type="text" name="detail" required>

            <label for="comment">Extra Comments: </label>
            <input type="text" name="comment">

            <input type="submit" value="invoice">
        </form>
    </div>
        <table>
            <tr>
                <th>Order Number</th>
                <th>Invoice Price</th>
                <th>Brief Description</th>
                <th>Extra Comments</th>
            </tr>
            <?php
            // Select and display data from the database for the logged-in user
            $sql = "SELECT * FROM invoice WHERE user_id = ?";
            $stmt = mysqli_prepare($db, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row["orderNum"]. "</td><td>" . $row["price"] . "</td><td>"
                        . $row["detail"]. "</td><td>" . $row["comment"] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No received invoices</td></tr>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($db);
            }
            
            // Close the database connection here
            mysqli_close($db);
            ?>
        </table>
    </div>
</div>
</body>
</html>