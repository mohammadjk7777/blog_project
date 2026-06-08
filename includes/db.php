<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "blog_project";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("اتصال به دیتابیس با شکست مواجه شد: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>