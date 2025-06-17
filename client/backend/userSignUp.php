<?php
session_start(); // Start session at the top
include('dbClient.php');

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];
 
if (empty($name)) {
    $errors[] = "Name is required.";
}
if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (empty($password)) {
    $errors[] = "Password is required.";
}

if (empty($errors)) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $name, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Username or email already exists.";
    }
    $stmt->close();
}

if (empty($errors)) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $passwordHash);

    if ($stmt->execute()) {
        $_SESSION['username'] = $name; 
        header("Location: ../frontend/pages/homePage.php");
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
} else {
    foreach ($errors as $error) {
        // echo "<p style='color:red;'>$error</p>";
    }
}
?>
<?php if (!empty($errors)): ?>
<script>
    alert("<?php echo implode('\n', array_map('addslashes', $errors)); ?>");
    window.location.href = "../frontend/pages/signup.php";

</script>
<?php endif; ?>

