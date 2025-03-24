<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marketmithra"; // Ensure the database name is correct

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
