<?php
include('Functions.php');
$cookieMessage = getCookieMessage();
$cookieUser = getCookieUser();
?>

<!DOCTYPE html>
<html>

<head>
    <title>About - CSE4IFU Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="row" id="header">
            <h3>About CSE4IFU Blog</h3>
        </div>


        <div class="row" id="nav">
            <a href="Homepage.php">Home</a> |
            <a href="Headlines.php">Headlines</a> |
            <a href="About.php">About</a>
            <?php
            if ($cookieUser == "") {
                echo ' | <a href="SignUp.php">Sign Up</a> | <a href="SignIn.php">Sign In</a>';
            } else {
                echo ' | <a href="LogOutUser.php">Sign Out</a> | ';
                echo "<a>Welcome, " . htmlspecialchars($cookieUser) . "</a>";
            }
            ?>
        </div>

        <div class="row" id="content">
            <div class="about-section">
                <h2>About This Blog</h2>
                <p>This blog is a platform for students and enthusiasts to share insights, experiences, and knowledge on various topics. It aims to foster a community where ideas can be freely exchanged and discussed.</p>

                <h3>About the Creator</h3>
                <p>My name is [Your Name], a student of CSE4IFU. This blog is part of my project for Semester 2, 2024. I am passionate about web development and enjoy creating user-friendly platforms where people can connect and share their thoughts.</p>
            </div>
        </div>

        <div class="row" id="footer">
            <h4>Your Full Name – Your Student Number – CSE4IFU Sem 2, 2024</h4>
        </div>
    </div>
</body>

</html>