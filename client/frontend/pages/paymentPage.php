<?php
session_start();
include('../../backend/dbOrder.php');
$username = $_SESSION['username'] ?? 'Guest';
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
  // die("Order ID is missing.");
}
$orderId = intval($_GET['order_id']);


if (!isset($_GET['subtotal']) || empty($_GET['subtotal'])) {
  die("Order ID is missing.");
}
$subtotal = intval($_GET['subtotal']);

$stmt = $conn2->prepare("SELECT customer_name, items, total, status FROM orderTable WHERE id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

if ($order = $result->fetch_assoc()) {
  $total = floatval($order['total']);
  $deliveryFee = round($subtotal * 0.15, 2);
} else {
  die("No order found with ID: $orderId");
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Payment Page</title>
  <link rel="stylesheet" href="pay.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="user-menu">
        <div class="logo"><?php echo htmlspecialchars($username[0]) . '.'; ?></div>
        
      </div>
      <nav class="nav">
        <a href="homePage.php"><i class="fas fa-home"></i></a>
        <a href="menuDisplay.php"><i class="fas fa-utensils"></i></a>
        <a href="cart.php" class="active"><i class="fas fa-shopping-cart"></i></a>
        <a href="history.php"><i class="fas fa-clipboard-list"></i></a>

      </nav>
    </aside>

    <div class="payment-box">
      <div class="left-panel">
        <div class="summary">
          <h3>Bill</h3>
          <hr>
          <p>Subtotal <span>$<?php echo number_format($subtotal, 2); ?></span></p>
          <p>Delivery Fee <span>$<?php echo number_format($deliveryFee, 2); ?></span></p>
          <p class="total">Total <span>$<?php echo number_format($total, 2); ?></span></p>
        </div>
      </div>

      <div class="right-panel">
        <h2>Payment Details</h2>
        <hr>
        <p>Billing Options</p>


        <form id="payment-form" action="../../backend/conformPayment.php" method="post" enctype="multipart/form-data">
          <div class="billing-options">
            <label class="btn">
              <input type="radio" name="billing" value="cash" checked />
              <p>
              <h3>Cash</h3>
              </p>
            </label>
            <label class="btn">
              <input type="radio" name="billing" value="transfer" />
              <p>
              <h3>Transfer</h3>
              </p>
            </label>
          </div>

          <div class="form-group">
            <label for="location">Location:</label>
            <input
              type="text"
              id="location"
              name="location"
              placeholder="Enter your address"
              required />
          </div>

          <div class="form-group hideable">
            <label>Transaction Id</label>
            <input type="text" name="transactionID" />
          </div>

          <div class="form-group hideable">
            <label for="image">Upload your Receipt:</label>
            <input type="file" id="image" name="image" accept="image/*" />
          </div>

          <input type="hidden" name="order_id" value="<?php echo $orderId; ?>" />

          <button type="submit">Confirm Payment</button>
        </form>

      </div>
    </div>
  </div>

  <script src="pay.js"></script>
</body>

</html>