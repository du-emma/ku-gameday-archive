<?php include "db.php"; ?>
<link rel="stylesheet" href="style.css">

<h2>Register</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

<a href="login.php">Already have an account?</a>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO Users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<p>Account created. <a href='login.php'>Login here</a></p>";
    } else {
        echo "<p>Error: email may already exist.</p>";
    }
}
?>