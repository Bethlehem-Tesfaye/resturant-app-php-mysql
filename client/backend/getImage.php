<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "menu";

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("Missing image ID");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    exit("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$sql = "SELECT image FROM menuTable WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imageData);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    header("Content-Type: image/jpeg"); // or png if you're storing PNGs
    echo $imageData;
} else {
    http_response_code(404);
    echo "Image not found.";
}

$stmt->close();
$conn->close();
?>
