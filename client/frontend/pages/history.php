<?php
session_start();

include('../../backend/dbOrder.php');
$username = $_SESSION['username'] ?? 'Guest';


$sql = "SELECT * FROM orderTable ORDER BY order_date DESC";
$result = mysqli_query($conn2, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Status</title>
    <link rel="stylesheet" href="history.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo"><?php echo htmlspecialchars($username[0]) . '.'; ?></div>
            <nav class="nav">
                <a href="homePage.php"><i class="fas fa-home"></i></a>
                <a href="menuDisplay.php"><i class="fas fa-utensils"></i></a>
                <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                <a href="history.php" class="active"><i class="fas fa-clipboard-list"></i></a>
            </nav>
        </aside>

        <main class="box">
            <h2>Orders</h2>
            <p class="description">
                Here you can find your orders sorted according to date.
            </p>

            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $items = json_decode($row['items'], true); // decode the JSON field
                    echo '<div class="order-card">';
                    echo '  <div class="order-row">';
                    echo '      <strong>Customer Name:</strong>';
                    echo '      <span>' . htmlspecialchars($row['customer_name']) . '</span>';
                    echo '  </div>';
                    echo '  <div class="order-row">';
                    echo '      <strong>Location:</strong>';
                    echo '      <span>' . htmlspecialchars($row['location']) . '</span>';
                    echo '  </div>';
                    echo '  <div class="order-row">';
                    echo '      <strong>Ordered Date:</strong>';
                    echo '      <span>' . htmlspecialchars($row['order_date']) . '</span>';
                    echo '  </div>';
                    echo '  <div class="order-row">';
                    echo '      <strong>Food Ordered:</strong>';
                    echo '      <span>';
                    if (is_array($items)) {
                        foreach ($items as $food => $quantity) {
                            echo htmlspecialchars($food) . ' (x' . htmlspecialchars($quantity) . '), ';
                        }
                    } else {
                        echo 'Invalid item data';
                    }
                    echo '      </span>';
                    echo '  </div>';
                    echo '  <div class="order-row">';
                    echo '      <strong>Total Price:</strong>';
                    echo '      <span>$' . htmlspecialchars($row['total']) . '</span>';
                    echo '  </div>';
                    echo '  <div class="order-row">';
                    echo '      <strong>Order status:</strong>';
                    echo '      <span class="status">● ' . htmlspecialchars($row['status']) . '</span>';
                    echo '  </div>';
                    echo '</div>';
                    echo '<br>';
                    echo '<br>';
                }
            } else {
                echo '<p>No orders found.</p>';
            }
            ?>
        </main>
    </div>
</body>

</html>
