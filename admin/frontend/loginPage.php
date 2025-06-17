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
      <p class="welcome"></p>
      <h1 class="title">Login</h1>

      <form  id="login-form" action="../backend/loginBack.php" method="post">
        <label>Username</label>
        <input type="text" name="username" id="username" />

        <div class="password-row">
          <label>Password</label>
        </div>
        <input type="password" placeholder="***********" required name="password"/>

        <button type="submit" class="login-btn">
          LOG IN →
        </button>
      </form>
      </div>
  </div>
  <script type="module" src="../navigation/home.js"></script>
</body>
</html>

