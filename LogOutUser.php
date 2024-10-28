<?php
include('Functions.php');
session_start();

// Clear all session variables if sessions are used
$_SESSION = [];

// Destroy the session
session_destroy();

// Delete the user cookie if it exists
deleteCookie("CookieUser");

// Optionally, set a message to confirm successful logout
setCookieMessage("You have been successfully logged out.");

// Redirect to the SignIn page
redirect("SignIn.php");
?>
