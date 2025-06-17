<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "menu";

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("Missing element ID");
}

$id = intval($_GET['id']);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = $id;

header("Location: ../frontend/pages/menuDisplay.php");
exit;
?>
