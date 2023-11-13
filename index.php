<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style.css">
    <title>Inventory Managed By Yourself</title>
</head>
<body>
    <div class="main">
        <h1>IMBY</h1>
        <p>Who we are: Inventory Tracking website suited for your Personal and Business Needs</p>
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <input type="submit" value="Login">
        </form>
        <a href="register.php">Don't have an account? Register Here</a>
    </div>
</body>
</html>
