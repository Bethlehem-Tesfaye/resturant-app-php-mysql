<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "orders";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM orderTable ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Status</title>
    <link rel="stylesheet" href="viewOrder.css" />
</head>

<body>
    <div class="container">
        <main class="box">
    <button onclick="window.location.href='homePage.php'" class="btn">Back to Dashboard</button>

            <h2>Orders</h2>
            <p class="description">
                Here you can find your orders sorted according to date.
            </p>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="order-card">
                        <div class="order-row">
                            <strong>Ordered Date:</strong>
                            <span><?= date('M d, Y H:i:s', strtotime($row['order_date'])) ?></span>
                        </div>
                        <div class="order-row">
                            <strong>Customer Name:</strong>
                            <span><?= htmlspecialchars($row['customer_name']) ?></span>
                        </div>
                        <div class="order-row">
                            <strong>Food Ordered:</strong>
                            <span>
                                <?php
                                $items = json_decode($row['items'], true);
                                $foodList = [];
                                foreach ($items as $food => $qty) {
                                    $foodList[] = htmlspecialchars("$food (x$qty)");
                                }
                                echo implode(', ', $foodList);
                                ?>
                            </span>
                        </div>
                        <div class="order-row">
                            <strong>Total Price:</strong>
                            <span><?= number_format($row['total'], 2) ?></span>
                        </div>
                        <div class="order-row">
                            <strong>Payment Receipt:</strong><br>
                            <?php if (!empty($row['receipt_image'])): ?>
                                <img src="getImageOrder.php?id=<?= $row['id'] ?>" alt="Receipt" width="200" height="200" />

                            <?php else: ?>
                                <span>No receipt</span>
                            <?php endif; ?>
                        </div>
                        <br>
                        <div class="order-row">
                            <strong>Status:</strong>
                            <span>
                                <?php if ($row['status'] === 'pending'): ?>
                                    <form action="../backend/updateStatus.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="approve" class="approve-btn">Approve</button>
                                        <button type="submit" name="deny" class="deny-btn" onclick="return confirm('Are you sure you want to deny and remove this order?')">Deny</button>
                                    </form>
                                <?php else: ?>
                                    <span class="completed">Completed</span>
                                <?php endif; ?>
                            </span>
                        </div>


                    </div> <br><br>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No orders found.</p>
            <?php endif; ?>

        </main>
    </div>
</body>

</html>