<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<h2>Add New Game</h2>

<form method="POST">
    <input type="date" name="gameDate" required>
    <input type="text" name="season" placeholder="Season" required>
    <input type="text" name="opponent" placeholder="Opponent" required>

    <select name="location">
        <option value="Home">Home</option>
        <option value="Away">Away</option>
        <option value="Neutral">Neutral</option>
    </select>

    <input type="number" name="KUscore" placeholder="KU Score" required>
    <input type="number" name="opponentScore" placeholder="Opponent Score" required>

    <select name="result">
        <option value="Win">Win</option>
        <option value="Loss">Loss</option>
    </select>

    <button type="submit">Add Game</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_prepare($conn, "
        INSERT INTO Games (gameDate, season, opponent, location, KUscore, opponentScore, result)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "ssssiis",
        $_POST["gameDate"],
        $_POST["season"],
        $_POST["opponent"],
        $_POST["location"],
        $_POST["KUscore"],
        $_POST["opponentScore"],
        $_POST["result"]
    );

    mysqli_stmt_execute($stmt);

    echo "<p>Game added successfully.</p>";
}
?>