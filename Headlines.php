<?php
include('Functions.php');
$cookieMessage = getCookieMessage();
$cookieUser = getCookieUser();

// Get the current page number from the URL, default to 1 if not set
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Limit to 5 headlines per page
$offset = ($currentPage - 1) * $limit;

try {
    // Connect to the database
    $dbh = connectToDatabase();

    // Count the total number of headlines for pagination
    $countStatement = $dbh->prepare('SELECT COUNT(HeadlineID) FROM Headline');
    $countStatement->execute();
    $totalHeadlines = $countStatement->fetchColumn();
    $totalPages = ceil($totalHeadlines / $limit);

    // Prepare and execute SQL to get the current page's headlines with limit and offset
    $statement = $dbh->prepare('
        SELECT User.UserName, Headline.Headline, Headline.DateTime
        FROM Headline
        INNER JOIN User ON Headline.UserID = User.UserID
        ORDER BY Headline.HeadlineID DESC
        LIMIT ? OFFSET ?
    ');
    $statement->bindValue(1, $limit, PDO::PARAM_INT);
    $statement->bindValue(2, $offset, PDO::PARAM_INT);
    $statement->execute();
    $headlines = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Headlines - CSE4IFU Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="row" id="header">
            <h3>Headlines - CSE4IFU</h3>
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
            <table class="headlines-table">
                <tr>
                    <th>Created by</th>
                    <th>Headline</th>
                    <th>Date Created</th>
                </tr>
                <?php
                foreach ($headlines as $headline) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($headline['UserName']) . "</td>";
                    echo "<td><a href='Blog.php?Headline=" . urlencode($headline['Headline']) . "'>" . htmlspecialchars($headline['Headline']) . "</a></td>";
                    echo "<td>" . htmlspecialchars($headline['DateTime']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <br>
            <?php if ($cookieUser != ""): ?>
                <!-- Form to create a new headline if user is logged in -->
                <div class="new-headline">
                    <form action="AddHeadline.php" method="POST">
                        <h3>Create a New Headline</h3>
                        <label for="headline">Headline:</label>
                        <input type="text" id="headline" name="headline" required>
                        <br>
                        <div class="form-btn">
                        <button type="submit">Add Headline</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <p class="center">You must be logged in to create a headline.</p>
            <?php endif; ?>

            <!-- Pagination Links -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="Headlines.php?page=<?php echo $currentPage - 1; ?>">Previous</a>
                <?php endif; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <a href="Headlines.php?page=<?php echo $currentPage + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="row" id="footer">
            <h4>Your Full Name – Your Student Number – CSE4IFU Sem 2, 2024</h4>
        </div>
    </div>
</body>
</html>
