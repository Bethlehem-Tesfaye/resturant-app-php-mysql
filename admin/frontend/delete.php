<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "menu";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM menuTable WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: displayMenu.php");
        exit;
    } else {
        echo "<p style='color:red;'>Failed to delete item: {$stmt->error}</p>";
    }

    $stmt->close();
} else {
    echo "<p style='color:red;'>Invalid ID provided.</p>";
}

$conn->close();
?>
