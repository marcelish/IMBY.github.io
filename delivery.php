<?php
// Include the database connection configuration
require_once('inc/config.php');
session_start();

function redirect($url) {
    header("Location: $url");
    exit;
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to the login page or handle the case where the user is not logged in
    redirect("login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $DCustomer = $_POST['DCustomer'];
    $LCity = $_POST['LCity'];
    $LStreet = $_POST['LStreet'];
    $LCountry = $_POST['LCountry'];

    // Insert the location data into the database
    $query = "INSERT INTO location (LCity, LStreet, LCountry, user_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $LCity, $LStreet, $LCountry, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            // Get the auto-generated location ID
            $DAddress = mysqli_insert_id($db);

            // Insert the delivery data with the location ID
            $query = "INSERT INTO delivery (DCustomer, DAddress, user_id) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sii", $DCustomer, $DAddress, $user_id);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Delivery and location data added!";
                    // Reload the page to display the updated table
                    header("Refresh:0");
                } else {
                    echo "Error: " . mysqli_error($db);
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($db);
            }
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
    <title>DELIVERY</title>
</head>
<body>
<div class="topnav">
    <a href="main.php">Home</a>
    <a href="add.php">Inventory</a>
    <a href="employees.php">Employee</a>
    <a href="invoice.php">Invoice</a>
    <a href="product.php">Product</a>
</div>
    <h2>DELIVERY INFORMATION</h2>
    <div class = "container">
    <div class="delivery">
        <form action="delivery.php" method="post">

            <label for="DCustomer">Customer Name</label>
            <input type="text" name="DCustomer" required>

            <label for="LCity">City</label>
            <input type="text" name="LCity" required>

            <label for="LStreet">Street</label>
            <input type="text" name="LStreet" required>

            <label for="LCountry">Country</label>
            <input type="text" name="LCountry" required>

            <input type="submit" value="Submit Delivery Info">
        </form>
    </div>
    <table>
            <tr>
                <th>Customer Name</th>
                <th>City</th>
                <th>Street</th>
                <th>Country</th>
            </tr>
            <?php
            // Select and display data from the database for the logged-in user
            $sql = "SELECT D.DCustomer, L.LCity, L.LStreet, L.LCountry FROM delivery D
                    JOIN location L ON D.DAddress = L.id
                    WHERE D.user_id = ?";
            $stmt = mysqli_prepare($db, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row["DCustomer"] . "</td><td>" . $row["LCity"] . "</td><td>"
                            . $row["LStreet"] . "</td><td>" . $row["LCountry"] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No delivery information</td></tr>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($db);
            }

            mysqli_close($db);
            ?>
        </table>
    </div>
    </div>
</body>
</html>
