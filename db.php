<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "ku_gameday_archive");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>