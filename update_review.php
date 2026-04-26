<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<?php
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
}

$reviewID = $_GET["reviewID"];
$userID = $_SESSION["userID"];

$stmt = mysqli_prepare($conn, "SELECT * FROM Reviews WHERE reviewID = ? AND userID = ?");
mysqli_stmt_bind_param($stmt, "ii", $reviewID, $userID);
mysqli_stmt_execute($stmt);
$review = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$review) {
    die("You can only update your own reviews.");
}
?>

<h2>Update Review</h2>

<form method="POST">
    <input type="number" step="0.1" min="1" max="10" name="rating" value="<?php echo $review["rating"]; ?>" required>
    <input type="text" name="section" value="<?php echo $review["section"]; ?>">
    <textarea name="comment" required><?php echo $review["comment"]; ?></textarea>
    <button type="submit">Update Review</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST["rating"];
    $section = $_POST["section"];
    $comment = $_POST["comment"];

    $stmt = mysqli_prepare($conn, "UPDATE Reviews SET rating = ?, section = ?, comment = ? WHERE reviewID = ? AND userID = ?");
    mysqli_stmt_bind_param($stmt, "dssii", $rating, $section, $comment, $reviewID, $userID);
    mysqli_stmt_execute($stmt);

    header("Location: game_details.php?gameID=" . $review["gameID"]);
    exit();
}
?>