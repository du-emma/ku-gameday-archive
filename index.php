<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<nav>
    <a href="index.php">Home</a>
    <a href="games.php">Search Games</a>
    <a href="add_game.php">Add Game</a>

    <?php if (isset($_SESSION["userID"])): ?>
        <span>Logged in as <?php echo $_SESSION["name"]; ?></span>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>

<div class="card">
    <h1>KU GameDay Archive</h1>
    <p>Search past KU basketball games, view player stats, and read or submit fan reviews.</p>
</div>