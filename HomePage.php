<?php // <--- do NOT put anything before this PHP tag
    include('Functions.php');
    $cookieMessage = getCookieMessage();
    $cookieUser = getCookieUser();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Homepage - Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="row" id="header">
            <h3>Homepage - CSE4IFU</h3>
        </div>

        <div class="row" id="nav">  
            | <a href="Homepage.php">Home</a>
            | <a href="Headlines.php">Headlines</a>
            | <a href="About.php">About</a>
            <?php
                if ($cookieUser == "") {
                    echo '<a href="SignUp.php">Sign Up</a> | ';
                    echo '<a href="SignIn.php">Sign In</a>';
                } else {
                    echo '<a href="LogOutUser.php">Sign Out</a> | ';
                    echo '<a> Welcome ' . htmlspecialchars($cookieUser) . '</a>';
                }
            ?>

        </div>

        <div class="row" id="content">
            <?php 
                if ($cookieMessage != "") {
                    echo "<p>$cookieMessage</p>";
                }
            ?>
            <p class="home-para">Welcome to the My blog! Here, users can share their thoughts and explore interesting posts.</p>
            <img src="https://plus.unsplash.com/premium_photo-1669904022334-e40da006a0a3?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Welcome Image">
        </div>

        <div class="row" id="footer">
            <h4>Your Full Name – Your Student Number – Sem 2, 2024</h4>
        </div>
    </div>
</body>
</html>
