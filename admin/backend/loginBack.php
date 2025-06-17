<?php
include('dbConnect.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($name) || empty($password)) {
        echo "<script>alert('Please fill in both username and password.');</script>";
    } else {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['admin'] = $row['username'];
                header("Location: ../frontend/homePage.php");
                exit();
            } else {
                echo "<script>
                    alert('Invalid password.');
                    setTimeout(function() {
                        window.location.href = '../frontend/loginPage.php';
                    }, 100); // 100 milliseconds delay
                    </script>";
                exit();
            }
        } else {
            echo "<script>alert('User not found.');</script>";
        }
    }
}
