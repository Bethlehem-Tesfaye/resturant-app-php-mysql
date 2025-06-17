<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "orders";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = intval($_POST['order_id']);

    if (isset($_POST['approve'])) {
        $stmt = $conn->prepare("UPDATE orderTable SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['deny'])) {
        $stmt = $conn->prepare("DELETE FROM orderTable WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: ../frontend/viewOrder.php");
    exit();
}

$conn->close();
?>
