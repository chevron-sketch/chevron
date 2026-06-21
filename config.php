<?php


$host = "localhost";
$user = "root";
$pass = "";
$dbname = "portfolio_chevron";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error() .
        "<br>Pastikan MySQL di XAMPP sudah running dan database 'portfolio_chevron' sudah dibuat (import database.sql lewat phpMyAdmin).");
}

mysqli_set_charset($conn, "utf8mb4");
