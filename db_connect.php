<?php
$host = "localhost";
$user = "root";          // change if you're not using XAMPP
$password = "";          // set your MySQL password here
$database = "logtrack_main";  // name of your database

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
