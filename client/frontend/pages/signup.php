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
      <p class="welcome">Welcome!!!</p>
      <h1 class="title">Sign up</h1>

      <form action="../../backend/userSignUp.php" method="post">
        <label>Name</label>
        <input type="text" name="name" id="name" />      
        <label>Email</label>
        <input type="email" name="email" id="email" />

        <div class="password-row">
          <label>Password</label>
        </div>
        <input type="password" placeholder="***********" name="password" required />

        <button type="submit" class="login-btn">
          SIGN UP →
        </button>
      </form>

      <p class="signup-text">
        have an account already? <a href="login.php">login</a>
      </p>
    </div>
  </div>
</body>
</html>
