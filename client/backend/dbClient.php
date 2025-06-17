<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS Users";
if ($conn->query($sql) === TRUE) {
    // echo "Database 'Users' created or exists already.<br>";
} else {
    // echo "Error creating database: " . $conn->error;
}

$conn = new mysqli($servername, $username, $password, "Users");
if ($conn->connect_error) {
    die("Connection to 'Users' DB failed: " . $conn->connect_error);
}

$userSql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($userSql) === TRUE) {
    // echo "Table 'users' created.<br>";
} else {
    // echo "Error creating table: " . $conn->error;
}
?>
