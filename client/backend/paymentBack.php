<?php
session_start();
include('dbMenuGet.php'); 
include('dbOrder.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subtotal = 0;
    $cartItems = [];
    $username = '';
    $totalPrice = 0;
    $foodQuantityMap = []; 

    if (isset($_POST['subtotal'])) {
        $subtotal = floatval($_POST['subtotal']); 
    }

    if (!empty($_POST['cart_items'])) {
        $cartItems = json_decode($_POST['cart_items'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $cartItems = [];
        }
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }

    $totalPrice = $subtotal + (0.15 * $subtotal);

if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
            $stmt = $conn->prepare("SELECT name FROM menutable WHERE id = ?");
            $stmt->bind_param("i", $item['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $foodName = $row['name'];
                $quantity = $item['quantity'];
                $foodQuantityMap[$foodName] = $quantity;
            }
            $stmt->close();
        }
    }
    $itemsJson = json_encode($foodQuantityMap);
    // for debuging reasons
// echo $itemsJson;
// echo $username;
// echo $totalPrice;
if (!empty($foodQuantityMap) && !empty($username)) {
    $itemsJson = json_encode($foodQuantityMap);

    $insertStmt = $conn2->prepare("INSERT INTO orderTable (customer_name, items, total, status) VALUES (?, ?, ?, 'pending')");
    $insertStmt->bind_param("ssd", $username, $itemsJson, $totalPrice);

    if ($insertStmt->execute()) {
        $orderId = $insertStmt->insert_id;
        header("Location: ../frontend/pages/paymentPage.php?order_id=$orderId&subtotal=$subtotal");
        echo "Order saved successfully.";

    } else {
        echo "Error saving order: " . $insertStmt->error;
    }

    $insertStmt->close();
}

}
?>
