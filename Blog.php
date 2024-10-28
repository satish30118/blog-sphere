<?php
include('Functions.php');

// Check if 'Headline' is set in the GET request; if not, redirect to Headlines.php
if (isset($_GET['Headline'])) {
    $thisHeadline = $_GET['Headline'];
} else {
    redirect("Headlines.php");
}

$cookieMessage = getCookieMessage();
$cookieUser = getCookieUser();

try {
    // Connect to the database
    $dbh = connectToDatabase();

    // Get the HeadlineID based on the provided headline name
    $headlineStatement = $dbh->prepare('SELECT HeadlineID FROM Headline WHERE Headline = ? COLLATE NOCASE');
    $headlineStatement->execute([$thisHeadline]);
    $headlineId = $headlineStatement->fetchColumn();

    // If the headline ID is not found, redirect back to Headlines.php
    if (!$headlineId) {
        redirect("Headlines.php");
    }

    // Count the number of posts within this headline
    $countStatement = $dbh->prepare('SELECT COUNT(*) FROM BlogPost WHERE HeadlineID = ?');
    $countStatement->execute([$headlineId]);
    $postCount = $countStatement->fetchColumn();

    // Retrieve all posts for this headline
    $postStatement = $dbh->prepare('
            SELECT User.UserName, BlogPost.Post, BlogPost.DateTime
            FROM BlogPost
            INNER JOIN User ON BlogPost.UserID = User.UserID
            WHERE BlogPost.HeadlineID = ?
            ORDER BY BlogPost.DateTime DESC
        ');
    $postStatement->execute([$headlineId]);
    $posts = $postStatement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($thisHeadline); ?> - CSE4IFU Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="row" id="header">
            <h3><?php echo htmlspecialchars($thisHeadline); ?> - Posts</h3>
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
                echo "<a>Welcome, " . htmlspecialchars($cookieUser). "</a>";
            }
            ?>
        </div>

        <div class="row" id="content">
            <?php
            if ($cookieMessage != "") {
                echo "<p class='cookie-message center'>$cookieMessage</p>";
            }
            ?>

            <h2 class="center">Posts for "<?php echo htmlspecialchars($thisHeadline); ?>" (Total Posts: <?php echo $postCount; ?>)</h2>
            <table class="headlines-table">
                <tr>
                    <th>User</th>
                    <th>Post</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($post['UserName']); ?></td>
                        <td><?php echo htmlspecialchars($post['Post']); ?></td>
                        <td><?php echo htmlspecialchars($post['DateTime']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>

            <?php if ($cookieUser != ""): ?>
                <div class="new-headline">

                    <form action="AddBlogPost.php?Headline=<?php echo urlencode($thisHeadline); ?>" method="POST">
                        <h3>Create a New Post</h3>
                        <label for="new-post">Post:</label>
                        <textarea id="new-post" name="Post" rows="4" required></textarea>
                        <div class="form-btn">
                        <button type="submit">Add Post</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <p class="center">You must be logged in to create a post.</p>
            <?php endif; ?>
        </div>

        <div class="row" id="footer">
            <h4>Your Full Name – Your Student Number – CSE4IFU Sem 2, 2024</h4>
        </div>
    </div>
</body>

</html>