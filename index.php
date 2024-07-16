<?php
session_start();
include "Components/_navbar.php";

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header("location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Page Layout</title>
    <style>
        /* Basic CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navbar Styles (Sample) */
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        .navbar ul li {
            margin: 0 10px;
        }

        .navbar ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        /* Main Section Styles */
        .main-section {
            padding: 220px 0;
            text-align: center;
        }

        .main-section h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .main-section p {
            font-size: 1.2em;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        h1{
            font-size:30px;
            margin-bottom:30px;
        }

    </style>
</head>
<body>

    <!-- Navbar Component -->

    <!-- Main Section -->
    <section class="main-section">
        <div class="container">
            <h2>Welcome to Our Website </h2>
            <h1><?php echo $_SESSION['mail']?></h1>
            <p>Feel free to post your doubts</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Your Company. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
