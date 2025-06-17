<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "menu";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection to 'menu' DB failed: " . $conn->connect_error);
}

?>