<?php
session_start(); 
include('dbClient.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in both email and password.'); </script>";
        exit();
    }

    $sql = "SELECT username, password_hash FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['username'] = $row['username'];  
            header("Location: ../frontend/pages/homePage.php");
            exit();
        } else {
            // echo "<script>alert('Invalid password.'); </script>";
            $errors[]="Invalid password";
        }
    } else {
        // echo "<script>alert('User not found.');</script>";
        $errors[]="User not found";
    }

    $stmt->close();
}
?>
<?php if (!empty($errors)): ?>
<script>
    alert("<?php echo implode('\n', array_map('addslashes', $errors)); ?>");
    window.location.href = "../frontend/pages/login.php";

</script>
<?php endif; ?>
