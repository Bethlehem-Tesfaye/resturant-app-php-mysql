<?php
session_start();
$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Habesha Restaurant</title>
    <link rel="stylesheet" href="home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="user-menu">
                <div class="logo"><?php echo htmlspecialchars($username[0]) . '.'; ?></div>
                <div class="logout-btn">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <nav class="nav">
                <a href="homePage.php" class="active"><i class="fas fa-home"></i></a>
                <a href="menuDisplay.php"><i class="fas fa-utensils"></i></a>
                <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                <a href="history.php"><i class="fas fa-clipboard-list"></i></a>
            </nav>
        </aside>
        <div class="body">
            <section class="hero">
                <div class="overlay"></div>
                <div class="content">
                    <h1>Welcome to <span>Habesha </span> Restaurant</h1>
                    <p style="color: white; font-size: 1.2em;">
                        Hello, <?php echo htmlspecialchars($username); ?>!
                    </p>
                    <div class="buttons">
                        <a href="menuDisplay.php">Order food for Delivery</a>
                    </div>
                </div>
            </section>

            <section class="info">
                <h1>Our Services</h1>
                <div class="services">
                    <div class="service-card odd">
                        <i class="fas fa-concierge-bell"></i>
                        <h3>Dine-In</h3>
                        <p>Experience traditional Habesha hospitality in a warm, cozy atmosphere.</p>
                    </div>
                    <div class="service-card even">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Takeaway</h3>
                        <p>Order and pick up your favorite dishes with ease and speed.</p>
                    </div>
                    <div class="service-card odd">
                        <i class="fas fa-truck"></i>
                        <h3>Delivery</h3>
                        <p>Enjoy authentic Habesha food delivered right to your doorstep.</p>
                    </div>
                </div>
            </section>

            <footer class="footer">
                <div class="contact">
                    <h3>Get In Touch With Us</h3>
                    <p><i class="fas fa-phone"></i> +251-912-345-678</p>
                    <p><i class="fas fa-envelope"></i> help@habesharesturant.com</p>
                </div>
                <div class="social">
                    <h3>Connect with us on social media</h3>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook-square"></i></a>
                        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>
