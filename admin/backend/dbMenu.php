<?php
$servername = "localhost";
$username = "root";
$password = "";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS menu";
if ($conn->query($sql) === TRUE) {
    // echo "Database 'menu' created or exists already.<br>";
} else {
    // echo "Error creating database: " . $conn->error;
}

$conn->close();

$conn = new mysqli($servername, $username, $password, "menu");
if ($conn->connect_error) {
    die("Connection to 'menu' DB failed: " . $conn->connect_error);
}

$tableSql = "CREATE TABLE IF NOT EXISTS menuTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image LONGBLOB NOT NULL,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";
if ($conn->query($tableSql) === TRUE) {
    // echo "Table 'menuTable' created.<br>";
} else {
    // echo "Error creating table: " . $conn->error;
}

?>
