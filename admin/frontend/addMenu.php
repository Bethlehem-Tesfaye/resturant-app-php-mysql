<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="addMenu.css">
</head>

<body>
    <div class="container">
        <button onclick="window.location.href='displayMenu.php'" class="btn">Back to Menu</button>
        <h2>Add a New Menu Item</h2>
        <form action="../backend/insertMenu.php" method="post" enctype="multipart/form-data">

            <label for="image" class="element">Upload Image:</label><br>
            <input type="file" id="image" name="image" class="element" accept="image/*" required><br><br>

            <label for="name" class="element">Menu Name:</label><br>
            <input type="text" id="name" name="name" class="element" required><br><br>

            <label for="price" class="element">Price:</label><br>
            <input type="number" id="price" name="price" class="element" step="0.01" required><br><br>

            <input type="submit" class="btn" value=" Add Item">
        </form>
    </div>
</body>

</html>