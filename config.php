<?php

$host = "sql301.infinityfree.com";
$user = "if0_42906909";
$password = "YOUR_PASSWORD";
$dbname = "if0_42906909_campusevent";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

#echo "Database connected successfully!";

?>
