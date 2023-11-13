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
    $empName = $_POST['empName'];
    $empAddress = $_POST['empAddress'];
    $empPhone = $_POST['empPhone'];

    // Insert the employee data into the database
    $query = "INSERT INTO employees (empName, empAddress, empPhone, user_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $empName, $empAddress, $empPhone, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Employee added to DATABASE!";
            redirect("employees.php"); // Redirect to the same page to refresh the table
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
    <title>ADD EMPLOYEE IN INVENTORY</title>
</head>
<body>
<div class="topnav">
    <a href="main.php">Home</a>
    <a href="add.php">Inventory</a>
    <a href="invoice.php">Invoice</a>
    <a href="product.php">Product</a>
    <a href="delivery.php">Delivery</a>
</div>
<h2>Employees</h2>
<div class = container>
    <div class="Employees">
        <form action="employees.php" method="post">
            <label for="empName">Employee Name:</label>
            <input type="text" name="empName" required>

            <label for="empAddress">Emp Address:</label>
            <input type="text" name="empAddress" required>

            <label for="empPhone">Emp Phone:</label>
            <input type="text" name="empPhone" required>

            <input type="submit" value="employee">
        </form>
    </div>
    <table>
        <tr>
            <th>Employee Name</th>
            <th>Emp Address</th>
            <th>Emp Phone</th>
        </tr>
            <?php
            // Select and display data from the database for the logged-in user
            $sql = "SELECT * FROM employees WHERE user_id = ?";
            $stmt = mysqli_prepare($db, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row["empName"]. "</td><td>" . $row["empAddress"] . "</td><td>"
                        . $row["empPhone"]. "</td></tr>";
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
</body>
</html>
