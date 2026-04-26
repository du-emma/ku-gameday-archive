<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<a href="games.php">Back to Games</a>

<?php
$gameID = $_GET["gameID"];

$stmt = mysqli_prepare($conn, "SELECT * FROM Games WHERE gameID = ?");
mysqli_stmt_bind_param($stmt, "i", $gameID);
mysqli_stmt_execute($stmt);
$game = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<div class="card review-card">
    <h2>KU vs <?php echo $game["opponent"]; ?></h2>
    <p>Date: <?php echo $game["gameDate"]; ?></p>
    <p>Location: <?php echo $game["location"]; ?></p>
    <p>Score: KU <?php echo $game["KUscore"]; ?> - <?php echo $game["opponentScore"]; ?></p>
    <p>Result: <?php echo $game["result"]; ?></p>
</div>

<h3>Player Stats</h3>

<?php
$statsQuery = "
SELECT Players.name, Players.number, Players.position, PlayerStats.points,
       PlayerStats.rebounds, PlayerStats.assists, PlayerStats.steals,
       PlayerStats.blocks, PlayerStats.minutesPlayed
FROM PlayerStats
JOIN Players ON PlayerStats.playerID = Players.playerID
WHERE PlayerStats.gameID = ?
";

$stmt = mysqli_prepare($conn, $statsQuery);
mysqli_stmt_bind_param($stmt, "i", $gameID);
mysqli_stmt_execute($stmt);
$stats = mysqli_stmt_get_result($stmt);
?>

<table>
    <tr>
        <th>Player</th>
        <th>#</th>
        <th>Position</th>
        <th>Points</th>
        <th>Rebounds</th>
        <th>Assists</th>
        <th>Steals</th>
        <th>Blocks</th>
        <th>Minutes</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($stats)): ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["number"]; ?></td>
            <td><?php echo $row["position"]; ?></td>
            <td><?php echo $row["points"]; ?></td>
            <td><?php echo $row["rebounds"]; ?></td>
            <td><?php echo $row["assists"]; ?></td>
            <td><?php echo $row["steals"]; ?></td>
            <td><?php echo $row["blocks"]; ?></td>
            <td><?php echo $row["minutesPlayed"]; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Fan Reviews</h3>

<?php
$reviewQuery = "
SELECT Reviews.reviewID, Reviews.userID, Users.name, Reviews.rating,
       Reviews.section, Reviews.comment, Reviews.reviewDate
FROM Reviews
JOIN Users ON Reviews.userID = Users.userID
WHERE Reviews.gameID = ?
";

$stmt = mysqli_prepare($conn, $reviewQuery);
mysqli_stmt_bind_param($stmt, "i", $gameID);
mysqli_stmt_execute($stmt);
$reviews = mysqli_stmt_get_result($stmt);
?>

<?php while ($row = mysqli_fetch_assoc($reviews)): ?>
    <div class="card">
        <p><strong><?php echo $row["name"]; ?></strong> rated this <?php echo $row["rating"]; ?>/10</p>
        <p>Section: <?php echo $row["section"]; ?></p>
        <p><?php echo $row["comment"]; ?></p>
        <p>Date: <?php echo $row["reviewDate"]; ?></p>

        <?php if (isset($_SESSION["userID"]) && $_SESSION["userID"] == $row["userID"]): ?>
            <a href="update_review.php?reviewID=<?php echo $row["reviewID"]; ?>">Update Review</a>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

<?php if (isset($_SESSION["userID"])): ?>
    <a href="add_review.php?gameID=<?php echo $gameID; ?>">Add Review</a>
<?php else: ?>
    <p><a href="login.php">Login</a> to submit a review.</p>
<?php endif; ?>