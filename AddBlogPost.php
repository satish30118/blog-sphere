<?php
    include('Functions.php');
    $cookieUser = getCookieUser();
    
    if (!isset($_POST['Post']) || !isset($_GET['Headline'])) {
        setCookieMessage("Post and Headline are required");
        exit;
    }

    // Trim and sanitize inputs
    $blogPost = trim($_POST['Post']);
    $headline = trim($_GET['Headline']);

    try {
        $dbh = connectToDatabase();

        // Get the UserID based on the username from the cookie
        $userStatement = $dbh->prepare('SELECT UserID FROM User WHERE UserName = ?');
        $userStatement->execute([$cookieUser]);
        $userId = $userStatement->fetchColumn();

        if (!$userId) {
            setCookieMessage("User not found, please login if you are not");
            exit;
        }

        // Get the HeadlineID based on the headline title
        $headlineStatement = $dbh->prepare('SELECT HeadlineID FROM Headline WHERE Headline = ? COLLATE NOCASE');
        $headlineStatement->execute([$headline]);
        $headlineId = $headlineStatement->fetchColumn();

        if (!$headlineId) {
            setCookieMessage("Can't found Headline, try again");
            exit;
        }

        // Set the timestamp to Melbourne time
        date_default_timezone_set("Australia/Melbourne");
        $dateTime = date("Y-m-d H:i:s");

        // Insert the new blog post into the BlogPost table
        $insertStatement = $dbh->prepare('
            INSERT INTO BlogPost (UserID, BlogPost, DateTime, HeadlineID) 
            VALUES (?, ?, ?, ?)
        ');
        $insertStatement->execute([$userId, $blogPost, $dateTime, $headlineId]);

        // Redirect back to Blog.php with the headline in the query string
        redirect("Blog.php?Headline=" . urlencode($headline));

    } catch (PDOException $e) {
        setCookieMessage("Database error: " . $e->getMessage());
        redirect("Blog.php?Headline=". urlencode($headline));
    }
?>
