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
  <title>Sign-Up</title>
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
          <form action="config/proses-signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Nama</label>
                <input type="text" name= "username" class="form-control" id="nama" placeholder="Masukkan nama">
              </div>
            <div class="mb-3">
              <label for="username" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="username" placeholder="Masukkan Email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name= "password" class="form-control" id="password" placeholder="Masukkan password">
            </div>
            <button name ="signup" class="btn btn-success btn-block">Sign Up</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
