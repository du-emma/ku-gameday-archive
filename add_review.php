<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<?php
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
}

$gameID = $_GET["gameID"];
?>

<h2>Add Review</h2>

<form method="POST">
    <input type="number" step="0.1" min="1" max="10" name="rating" placeholder="Rating 1-10" required>
    <input type="text" name="section" placeholder="Section">
    <textarea name="comment" placeholder="Comment" required></textarea>
    <button type="submit">Submit Review</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_SESSION["userID"];
    $rating = $_POST["rating"];
    $section = $_POST["section"];
    $comment = $_POST["comment"];
    $reviewDate = date("Y-m-d");

    $stmt = mysqli_prepare($conn, "INSERT INTO Reviews (userID, gameID, rating, section, comment, reviewDate) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iidsss", $userID, $gameID, $rating, $section, $comment, $reviewDate);
    mysqli_stmt_execute($stmt);

    header("Location: game_details.php?gameID=$gameID");
    exit();
}
?>