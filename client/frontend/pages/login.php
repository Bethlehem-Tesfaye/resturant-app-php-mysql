<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="login.css"/>
</head>
<body>
  <div class="container">
    <div class="login-box">
      <!-- <h2 class="logo">Logo Here</h2> -->
      <p class="welcome">Welcome back !!!</p>
      <h1 class="title">Login</h1>

      <form action="../../backend/userLogin.php" id="login-form"  method="post">
        <label>Email</label>
        <input type="email" name="email" id="email" />

        <div class="password-row">
          <label>Password</label>
          <!-- <a href="#" class="forgot">Forgot Password?</a> -->
        </div>
        <input type="password" placeholder="***********" name="password" required />

        <button type="submit" class="login-btn">
          SIGN IN →
        </button>
      </form>

      <p class="signup-text">
        I don’t have an account ? <a href="signup.php">Sign up</a>
      </p>
    </div>
  </div>
  <!-- <script type="module" src="../navigation/home.js"></script> -->
</body>
</html>
