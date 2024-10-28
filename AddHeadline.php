<?php
include('Functions.php');
$cookieUser = getCookieUser();

if (isset($cookieUser)) {

    if (isset($_POST['headline'])) {
        $headline = trim($_POST['headline']);

        try {
            $dbh = connectToDatabase();

            // Check if the headline already exists
            $statement = $dbh->prepare('SELECT COUNT(*) FROM Headline WHERE Headline = ? COLLATE NOCASE');
            $statement->execute([$headline]);
            $headlineExists = $statement->fetchColumn();

            if ($headlineExists > 0) {
                // If the headline exists, set a cookie message
                setCookieMessage("The headline already exists. Please try a different one.");
                redirect("Headlines.php");
            } else {
                // Retrieve the user's ID based on the username from the cookie
                $userStatement = $dbh->prepare('SELECT UserID FROM User WHERE UserName = ?');
                $userStatement->execute([$cookieUser]);
                $userId = $userStatement->fetchColumn();

                if ($userId) {
                    // Set the timezone to Melbourne and get the current datetime
                    date_default_timezone_set("Australia/Melbourne");
                    $dateTime = date("Y-m-d H:i:s");

                    // Insert the new headline into the database
                    $insertStatement = $dbh->prepare('
                        INSERT INTO Headline (UserID, DateTime, Headline) 
                        VALUES (?, ?, ?)
                    ');
                    $insertStatement->execute([$userId, $dateTime, $headline]);

                    // Set a success message and redirect back to Headlines.php
                    setCookieMessage("Headline added successfully.");
                    redirect("Headlines.php");
                } else {
                    echo "Error: User not found.";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        redirect("Headlines.php");
    }
} else {
    setCookieMessage("User should be login for this!");
    redirect("Headlines.php");
}
