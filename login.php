<?php 
session_start();
if(isset($_SESSION['login'])){
  header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/png" href="assets/img/title.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .center-image {
      display: block;
      margin: auto;
    }
  </style>
</head>
<body style="background-color: #e0e5de;">

<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <a href="index.php">
            <img src="assets/img/logo.svg" class="center-image" width="300rem" alt="">
          </a>
          <p class="card-title text-center mb-4">Temukan Resep yang Menarik</p>
          <form action="config/proses-login.php" method = "POST">
            <div class="mb-3">
              <label for="username" class="form-label">Email</label>
              <input type="email" name="username" class="form-control" id="username" placeholder="Masukkan Email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password">
            </div>
            <button class="btn btn-success btn-block" name="login">Login</button>
          </form>
          <hr>
          <p class="text-center mb-0">Belum punya akun? <a href="./signup.php">Buat Akun</a></p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
