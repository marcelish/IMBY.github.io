<?php
//this is needed for every page to ensure is connected to the database
include("inc/config.php");
// function to redirect to another page
function redirect($url) {
    header("Location: $url");
    exit; //no code is executed after the redirection
}
// Retrieve user input
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize input to prevent SQL injection
$email = mysqli_real_escape_string($db, $email);

// Query the database to get the hashed password
$query = "SELECT password FROM users WHERE email = '$email'";
$result = mysqli_query($db, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];

    // Verify the entered password against the hashed password
    if (password_verify($password, $hashedPassword)) {
        // Successful login
        echo "Login successful! Welcome, $email.";
        redirect("main.php");
    } else {
        // Failed login
        echo "Login failed. Please check your email and password.";
    }
} else {
    // Database query error
    echo "Database query error: " . mysqli_error($db);
}

// Close the database connection
mysqli_close($db);
?>