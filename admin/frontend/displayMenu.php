<?php
include('../backend/dbMenu.php');

$sql = "SELECT * FROM menutable";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Menu Management</title>
  <link rel="stylesheet" href="menu.css">
</head>
<body>
  <button class="add-button"  onclick="window.location.href='../frontend/addMenu.php'">Add Menu</button>
  <button class="add-button"  onclick="window.location.href='../frontend/homePage.php'">back to dashboard</button>

  <div class="menu-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='menu-item'>";
            echo "<img src='getImage.php?id=" . $row['id'] . "' class='menu-image'>";
            echo "<div class='menu-info'>";
            echo "<strong>" . htmlspecialchars($row['name']) . "</strong><br>";
            echo "Price: $" . htmlspecialchars($row['price']);
            echo "</div>";
            echo "<div class='menu-actions'>";
            echo "<button class='edit-btn' onclick=\"location.href='edit.php?id=" . $row['id'] . "'\">Edit</button>";
            echo "<button class='delete-btn' onclick=\"location.href='delete.php?id=" . $row['id'] . "'\">Delete</button>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No menu items found.</p>";
    }
    ?>
  </div>

</body>
</html>
