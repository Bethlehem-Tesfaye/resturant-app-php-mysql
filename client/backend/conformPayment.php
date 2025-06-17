<?php
session_start();
include('dbOrder.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $billingMethod = $_POST['billing'] ?? '';
    $location = $_POST['location'];
    $tranId = $_POST['transactionID'];
    $orderId = $_POST['order_id'];

    if ($billingMethod === 'cash') {
        $sqlUpdate = "UPDATE orderTable SET location = ? WHERE id = ?";
        $stmt = $conn2->prepare($sqlUpdate);
        if (!$stmt) {
            die("Prepare failed: " . $conn2->error);
        }

        $stmt->bind_param("si", $location, $orderId);
        if ($stmt->execute()) {
            // echo "<p style='color:green;'>Location added successfully!</p>";
        } else {
            // echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();

        // Update status to 'completed'
        $sqlStatus = "UPDATE orderTable SET status = 'completed' WHERE id = ?";
        $stmt = $conn2->prepare($sqlStatus);
        if (!$stmt) {
            die("Prepare failed: " . $conn2->error);
        }

        $stmt->bind_param("i", $orderId);
        if ($stmt->execute()) {
            $_SESSION['cart'] = [];
            header('location: ../frontend/pages/history.php');

            // echo "<p style='color:green;'>Status changed successfully!</p>";

        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } elseif ($billingMethod === 'transfer') {
        // Only alter transaction_id column if not exists
        $alterSQL = "ALTER TABLE orderTable ADD COLUMN IF NOT EXISTS transaction_id VARCHAR(255)";
        if ($conn2->query($alterSQL) === TRUE) {
            // echo "<p style='color:green;'>Checked/added 'transaction_id' column successfully.</p>";
        } else {
            echo "<p style='color:red;'>Error altering table: " . $conn2->error . "</p>";
        }

        $errors = [];
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Image upload failed or no file uploaded.";
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['image']['type'];
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = "Only JPG, PNG, and GIF images are allowed.";
            }
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                $errors[] = "Image size must be less than 2MB.";
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
            exit;
        }

        $imageData = file_get_contents($_FILES['image']['tmp_name']);

        $sqlUpdate = "UPDATE orderTable SET transaction_id = ?, location = ?, receipt_image = ? WHERE id = ?";
        $stmt = $conn2->prepare($sqlUpdate);
        if (!$stmt) {
            die("Prepare failed: " . $conn2->error);
        }

        $null = NULL; 
        $stmt->bind_param("ssbi", $tranId, $location, $null, $orderId);
        $stmt->send_long_data(2, $imageData);

        if ($stmt->execute()) {
            $_SESSION['cart'] = [];
            header('location: ../frontend/pages/history.php');


            // echo "<p style='color:green;'>Transfer info and image uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}
