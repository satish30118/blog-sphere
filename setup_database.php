<?php
// Connect to SQLite database
$dbh = new PDO('sqlite:database/Blog.db');

// Enable exceptions for errors
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Create User table
    $dbh->exec("CREATE TABLE IF NOT EXISTS User (
        UserID INTEGER PRIMARY KEY AUTOINCREMENT,
        UserName TEXT NOT NULL UNIQUE,
        FirstName TEXT NOT NULL,
        LastName TEXT NOT NULL
    )");

    // Create Headline table
    $dbh->exec("CREATE TABLE IF NOT EXISTS Headline (
        HeadlineID INTEGER PRIMARY KEY AUTOINCREMENT,
        UserID INTEGER NOT NULL,
        DateTime DATETIME NOT NULL,
        Headline TEXT NOT NULL,
        FOREIGN KEY(UserID) REFERENCES User(UserID)
    )");

    // Create BlogPost table
    $dbh->exec("CREATE TABLE IF NOT EXISTS BlogPost (
        BlogPostID INTEGER PRIMARY KEY AUTOINCREMENT,
        UserID INTEGER NOT NULL,
        HeadlineID INTEGER NOT NULL,
        DateTime DATETIME NOT NULL,
        BlogPost TEXT NOT NULL,
        FOREIGN KEY(UserID) REFERENCES User(UserID),
        FOREIGN KEY(HeadlineID) REFERENCES Headline(HeadlineID)
    )");

    echo "Database and tables created successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
