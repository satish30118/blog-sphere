<?php
include('Functions.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['UserName']) && isset($_POST['FirstName']) && isset($_POST['LastName'])) {
        // Get the submitted form data
        $UserName = trim($_POST['UserName']);
        $FirstName = trim($_POST['FirstName']);
        $LastName = trim($_POST['LastName']);
    }else{
        redirect("SignUp.php");
    }

    try {
        $dbh = connectToDatabase();
        // Check if the username already exists
        $statement = $dbh->prepare("SELECT * FROM User WHERE UserName = ? COLLATE NOCASE; ");
        $statement->bindValue(1, $UserName);
        $statement->execute();

        if ($row=$statement->fetch(PDO::FETCH_ASSOC)) {
            setCookieMessage("Username already exists. Please choose a different username.");
            redirect("SignUp.php");
        } else {
            // Insert new user
            $statement2 = $dbh->prepare("INSERT INTO User (UserName, FirstName, LastName) VALUES (?, ?, ?); ");
            $statement2->bindValue(1, $UserName);
            $statement2->bindValue(2, $FirstName);
            $statement2->bindValue(3, $LastName);
            $statement2->execute();

            // Optionally set a cookie message or redirect after a successful signup
            setCookieMessage("User registered successfully!");
            redirect("SignIn.php");
        }
    } catch (PDOException $e) {
        setCookieMessage("Database error: " . $e->getMessage());
        redirect("SignUp.php");
    }
}
?>
