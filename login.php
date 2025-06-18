<?php
// login.php
session_start();
if (isset($_SESSION['kasir'])) {
    header('Location: index.php');
    exit;
}
include 'config/db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $q = mysqli_query($conn, "SELECT * FROM kasir WHERE username='$username' AND password=MD5('$password')");
    if (mysqli_num_rows($q) == 1) {
        $_SESSION['kasir'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $msg = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | Drippin'</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,700">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-modern page-fade">
  <div class="login-animated-card mx-auto">
    <div class="login-title mb-4">Login</div>
    <?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>
    <form method="post" autocomplete="off">
      <div class="form-group mb-3 position-relative">
        <span class="input-icon">
          <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 10a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" stroke="#aaa" stroke-width="1.5"/><path d="M17 17a7 7 0 10-14 0" stroke="#aaa" stroke-width="1.5"/></svg>
        </span>
        <label for="username" class="form-label">Username</label>
        <input id="username" type="text" class="form-control" name="username" required autofocus>
      </div>
      <div class="form-group mb-3 position-relative">
        <span class="input-icon">
          <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="9" width="12" height="7" rx="3.5" stroke="#aaa" stroke-width="1.5"/><circle cx="10" cy="7" r="3" stroke="#aaa" stroke-width="1.5"/></svg>
        </span>
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control" name="password" required>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
      </div>
    </form>
    <div class="login-footer">
      &copy; <span id="year"></span> Drippin' Coffee Shop. 
      <br>
      All rights reserved.
    </div>
  </div>
  <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
</body>
</html>
