<link rel="stylesheet" href="addMenu.css">
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "menu";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $errors = [];

    if (empty($name)) $errors[] = "Name is required.";
    if (!is_numeric($price)) $errors[] = "Price must be numeric.";

    $hasNewImage = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK;

    if ($hasNewImage) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $errors[] = "Invalid image type.";
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            $errors[] = "Image too large (max 2MB).";
        }
    }

    if (empty($errors)) {
        if ($hasNewImage) {
            $imageData = file_get_contents($_FILES['image']['tmp_name']);
            $stmt = $conn->prepare("UPDATE menuTable SET name = ?, price = ?, image = ? WHERE id = ?");
            $stmt->bind_param("sdsi", $name, $price, $imageData, $id);
        } else {
            $stmt = $conn->prepare("UPDATE menuTable SET name = ?, price = ? WHERE id = ?");
            $stmt->bind_param("sdi", $name, $price, $id);
        }

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Updated successfully.</p>";
        } else {
            echo "<p style='color:red;'>Update failed: {$stmt->error}</p>";
        }

        $stmt->close();
    } else {
        foreach ($errors as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
    }
}

// Fetch current data
$stmt = $conn->prepare("SELECT name, price FROM menuTable WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($currentName, $currentPrice);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!-- HTML Form -->
<div class="container">
    <button onclick="window.location.href='displayMenu.php'" class="btn">Back to Menu</button>
    <h2>Edit Menu Item</h2>
    <form method="POST" enctype="multipart/form-data">
        <label class="element">Name:</label><br>
        <input type="text" name="name" class="element" value="<?= htmlspecialchars($currentName) ?>"><br><br>

        <label class="element">Price:</label><br>
        <input type="text" name="price" class="element" value="<?= htmlspecialchars($currentPrice) ?>"><br><br>

        <label class="element">Current Image:</label><br>
        <img src="getImage.php?id=<?= $id ?>" width="100"  class="element"><br><br>

        <label class="element">Upload New Image (optional):</label><br>
        <input type="file" name="image" class="element" ><br><br>

        <button type="submit" class="btn">Save Changes</button>
    </form>
</div>