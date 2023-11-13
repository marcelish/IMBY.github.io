<?php
require_once('inc/config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <title>User Registration</title>
</head>
<body>
    <div class="main">
        <h1>Register</h1>
        <form action="register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="phonenumber">Phone Number:</label>
            <input type="text" name="phonenumber" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required>

            <label for="bname">Business Name:</label>
            <input type="text" name="bname" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

<?php
require_once('inc/config.php');

// Function to redirect to another page
function redirect($url) {
    header("Location: $url");
    exit; // No code is executed after the redirection
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $dob = $_POST['dob'];
    $bname = $_POST['bname'];

    // Insert the user data into the database
    $query = "INSERT INTO users (name, email, phonenumber, password, dob, bname) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $phonenumber, $password, $dob, $bname);

        if (mysqli_stmt_execute($stmt)) {
            // Retrieve the user ID after successful registration
            $user_id = mysqli_insert_id($db);

            // Store the user ID in the session
            session_start();
            $_SESSION['user_id'] = $user_id;

            echo "User registration successful!";
            redirect("main.php");
        } else {
            echo "Error: " . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($db);
    }

    mysqli_close($db);
}
?>