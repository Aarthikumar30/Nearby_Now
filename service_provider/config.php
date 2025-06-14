<?php
// config.php - Database Connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "service_app_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>