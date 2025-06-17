<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS admins";
if ($conn->query($sql) === TRUE) {
    // echo "Database 'admins' created or exists already.<br>";
} else {
    // echo "Error creating database: " . $conn->error;
}
$conn->close();

$database = "admins";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully!";



?>
