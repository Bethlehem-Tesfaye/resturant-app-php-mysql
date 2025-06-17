<?php
session_start();
$sessionUsername = $_SESSION['username'] ?? 'Guest';  // Session username stored separately

include('../../backend/dbMenuGet.php');

$sql = "SELECT * FROM menutable";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Display</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                <a href="menuDisplay.php" class="active"><i class="fas fa-utensils"></i></a>
                <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                <a href="history.php"><i class="fas fa-clipboard-list"></i></a>

            </nav>
        </aside>

        <div class="main-content">
            <h1>Menu</h1>
            <?php
            if ($result->num_rows > 0) {
                echo "<div class='food-grid'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='food-item'>";
                    echo "<img src='../../backend/getImage.php?id=" . $row['id'] . "' alt='Menu Image'>";
                    echo "<strong>" . htmlspecialchars($row['name']) . "</strong>";
                    echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                    echo "<div class='food-cart'>";
                    echo "<a href='../../backend/addTocart.php?id=" . $row['id'] . "'><i class='fas fa-plus'></i></a>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No menu items found.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>