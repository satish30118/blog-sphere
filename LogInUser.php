<?php
include('Functions.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['UserName'])) {
        $UserName = trim($_POST['UserName']);
        try {
            $dbh = connectToDatabase();
            $statement = $dbh->prepare("SELECT * FROM User WHERE UserName = ? COLLATE NOCASE; ");
            $statement->bindValue(1, $UserName);
            $statement->execute();

            if ($row=$statement->fetch(PDO::FETCH_ASSOC)) {
                setCookieMessage("User Login Sucessfully.");
                setCookieUser($UserName);
                redirect("HomePage.php");
    
            } else {
                setCookieMessage("Invalid username. Please try again.");
                redirect("SignIn.php");
            }
        } catch (PDOException $e) {
            setCookieMessage("Database error: " . $e->getMessage());
            redirect("SignIn.php");
        }
    } else {
        setCookieMessage("Please enter a username.");
        redirect("SignIn.php");
    }
}
?>
