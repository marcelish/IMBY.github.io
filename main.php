<?php 
// This is needed for every page to ensure it's connected to the database
require_once('inc/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style2_Main.css">
    <title>Inventory Managed By Yourself</title>
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
<h1>IMBY</h1>
<ul>
    <li>
        <a href="employees.php"> <!-- Link to the employee page -->
            <div class="content">
             <!-- Image wrapped in the anchor -->
                <h2>Employees</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
            </div>
        </a>
    </li>
    <li>
        <a href="add.php"> <!-- Link to the employee page -->
            <div class="content">
                <!-- Image wrapped in the anchor -->
                <h2>Inventory</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
            </div>
        </a>
    </li>
    <li>
        <a href="product.php"> <!-- Link to the employee page -->
            <div class="content">
                <!-- Image wrapped in the anchor -->
                <h2>Products</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
            </div>
        </a>
    </li>
    <li>
        <a href="delivery.php"> <!-- Link to the employee page -->
            <div class="content">
                <!-- Image wrapped in the anchor -->
                <h2>Delivery</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
            </div>
        </a>
    </li>
    <li>
        <a href="invoice.php"> <!-- Link to the employee page -->
            <div class="content">
                <!-- Image wrapped in the anchor -->
                <h2>Invoices</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
            </div>
        </a>
    </li>
</ul>
</body>
</html>