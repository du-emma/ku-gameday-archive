<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<nav>
    <a href="index.php">Home</a>
    <a href="games.php">Search Games</a>
</nav>

<h2>Search Games</h2>

<form method="GET">
    <input type="text" name="opponent" placeholder="Opponent">
    <input type="text" name="season" placeholder="Season, ex: 2023-2024">
    <select name="location">
        <option value="">Any Location</option>
        <option value="Home">Home</option>
        <option value="Away">Away</option>
        <option value="Neutral">Neutral</option>
    </select>
    <button type="submit">Search</button>
</form>

<?php
$query = "SELECT * FROM Games WHERE 1=1";
$params = [];
$types = "";

if (!empty($_GET["opponent"])) {
    $query .= " AND opponent LIKE ?";
    $params[] = "%" . $_GET["opponent"] . "%";
    $types .= "s";
}

if (!empty($_GET["season"])) {
    $query .= " AND season = ?";
    $params[] = $_GET["season"];
    $types .= "s";
}

if (!empty($_GET["location"])) {
    $query .= " AND location = ?";
    $params[] = $_GET["location"];
    $types .= "s";
}

$stmt = mysqli_prepare($conn, $query);

if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<table>
    <tr>
        <th>Date</th>
        <th>Season</th>
        <th>Opponent</th>
        <th>Location</th>
        <th>Score</th>
        <th>Result</th>
        <th>Details</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row["gameDate"]; ?></td>
            <td><?php echo $row["season"]; ?></td>
            <td><?php echo $row["opponent"]; ?></td>
            <td><?php echo $row["location"]; ?></td>
            <td><?php echo $row["KUscore"] . " - " . $row["opponentScore"]; ?></td>
            <td><?php echo $row["result"]; ?></td>
            <td><a href="game_details.php?gameID=<?php echo $row["gameID"]; ?>">View</a></td>
        </tr>
    <?php endwhile; ?>
</table>