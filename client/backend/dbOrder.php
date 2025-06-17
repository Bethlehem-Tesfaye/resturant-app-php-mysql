<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn3 = new mysqli($servername, $username, $password);
if ($conn3->connect_error) {
    die("Connection failed: " . $conn3->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS orders";
if ($conn3->query($sql) === TRUE) {
    // echo "Database 'orders' created or already exists.<br>";
} else {
    // echo "Error creating database: " . $conn3->error;
}
$conn3->close();

$conn2 = new mysqli($servername, $username, $password, "orders");
if ($conn2->connect_error) {
    die("Connection to 'orders' DB failed: " . $conn->connect_error);
}

$tableSql = "CREATE TABLE IF NOT EXISTS orderTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    location VARCHAR(255),
    items JSON NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    receipt_image LONGBLOB,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";


if ($conn2->query($tableSql) === TRUE) {
    // echo "Table 'orders' created or already exists.<br>";
} else {
    // echo "Error creating table: " . $conn2->error;
}
?>
