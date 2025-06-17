<?php
session_start();
include('../../backend/dbMenuGet.php');
$sessionUsername = $_SESSION['username'] ?? 'Guest';
// Handle remove item from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $removeId = (int)$_POST['remove_id'];
    if (isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($id) => $id != $removeId));
    }
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$ids = $_SESSION['cart'];

if (count($ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $conn->prepare("SELECT id, name, price FROM menutable WHERE id IN ($placeholders)");
    $types = str_repeat('i', count($ids));
    $stmt->bind_param($types, ...$ids);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Cart Page</title>
  <link rel="stylesheet" href="cart.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <div class="user">
                <div class="logo"><?php echo htmlspecialchars($sessionUsername[0]) . '.'; ?></div>
                <div class="logout-btn">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
      <nav class="nav">
        <a href="homePage.php"><i class="fas fa-home"></i></a>
        <a href="menuDisplay.php"><i class="fas fa-utensils"></i></a>
        <a href="cart.php" class="active"><i class="fas fa-shopping-cart"></i></a>
        <a href="history.php"><i class="fas fa-clipboard-list"></i></a>

      </nav>
    </aside>

    <main class="cart-main">
      <h1>CART</h1>
      <div class="cart-content">
        <div class="cart-items">
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="cart-item" data-id="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                <div class="item-details">
                  <div>
                    <p><?= htmlspecialchars($row['name']) ?></p>
                    <span class="item-total">$<?= number_format($row['price'], 2) ?></span>
                  </div>
                  <div class="quantity-controls">
                    <button class="decrease">−</button>
                    <span class="quantity">1</span>
                    <button class="increase">+</button>
                  </div>
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="remove_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="delete-btn" title="Remove from cart">🗑</button>
                  </form>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>Your cart is empty.</p>
          <?php endif; ?>
        </div>

        <div class="cart-summary">
          <div class="subtotal-box">
            <h2>Your Subtotal</h2>
           <form action="../../backend/paymentBack.php" method="post">
              <p>Subtotal: $<span id="subtotal">0.00</span></p>
              <input type="hidden" id="subtotalInput" name="subtotal" value="0">
              <!-- New: Hidden input for cart items -->
              <input type="hidden" id="cartItemsInput" name="cart_items" value="">
              <button type="submit" class="confirm-btn">Order</button>
          </form>
            
          </div>
        </div>
      </div>
    </main>
  </div>

  <script type="module" src="cart.js"></script>
</body>
</html>
