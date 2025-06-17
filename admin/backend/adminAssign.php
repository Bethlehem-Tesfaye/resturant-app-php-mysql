<?php
    include('dbConnect.php');

$username = 'beth_lehem';
$password = password_hash('admin123', PASSWORD_DEFAULT); 
$email = 'bethlehem.tesfaye15@gmail.com';
$full_name = 'Bethlehem Tesfaye';

$sql = "INSERT INTO admin (username, password, email, full_name)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $password, $email, $full_name);

if ($stmt->execute()) {
    echo "Admin inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}
?>
