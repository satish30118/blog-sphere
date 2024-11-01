<?php
    // Include functions and retrieve any cookie messages
    include('Functions.php');
    $cookieMessage = getCookieMessage();
?>
<!DOCTYPE html>
<html>
<head>
    <title>SignUp - My Blog</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> 
</head>
<body>
    <div class="container">
        <div class="row" id="header">
            <h3>CSE4IFU - SignUp</h3>
        </div>

        <div class="row" id="nav">  
              <a href="Homepage.php">Home</a>
            | <a href="Headlines.php">Headlines</a>
            | <a href="About.php">About</a>
            | <a href="SignIn.php">Sign In</a>
            <a href="SignUp.php">Sign Up</a>
        </div>

        <div class="row" id="content">
            <?php 
                if ($cookieMessage != "") {
                    echo "<p class='center cookie-message'>$cookieMessage</p>";
                }
            ?>
            <div class="auth-form">
            <form action="AddUser.php" method="POST">
            <h2>Sign Up</h2>
                <label for="username">Username:</label>
                <input type="text" id="username" name="UserName" required placeholder="Enter Your Username">
                <br>
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="FirstName" required placeholder="Enter Your First Name">
                <br>
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="LastName" required placeholder="Enter Your Last Name">
                <br>
                <button type="submit">Sign Up</button>
            </form>
            </div>
        </div>

        <div class="row" id="footer">
            <h4>Your Full Name – Your Student Number –  Sem 2, 2024</h4>
        </div>
    </div>
</body>
</html>
