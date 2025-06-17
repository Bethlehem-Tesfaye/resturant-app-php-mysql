<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "menu";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Menu name is required.";
    }

    // Validate price
    if (empty($price)) {
        $errors[] = "Price is required.";
    } elseif (!is_numeric($price)) {
        $errors[] = "Price must be a valid number.";
    } else {
        $price = floatval($price);
    }

    // Validate image upload
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Image upload failed or no file uploaded.";
    } else {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Only JPG, PNG, and GIF images are allowed.";
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) { // 2MB max
            $errors[] = "Image size must be less than 2MB.";
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }

    // Read image file content
    $imageData = file_get_contents($_FILES['image']['tmp_name']);

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO menuTable (image, name, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $null = NULL;
    $stmt->bind_param("bsd", $null, $name, $price);

    $stmt->send_long_data(0, $imageData);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Menu item added successfully!</p>";
        header("Location: ../frontend/displayMenu.php");


    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
