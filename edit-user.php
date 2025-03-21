<?php
session_start();
require "config/connect.php";
if(isset($_SESSION['login'])){
  $iduser = $_SESSION['iduser'];
  $name_user = $_SESSION['username'];
}else{
  header('Location: index.php');
}

//membuat path file gambar
$queryedit =mysqli_query($koneksi, "SELECT * FROM user WHERE id = $iduser");
$profiluser = mysqli_fetch_assoc($queryedit);
$name_img_user = $profiluser['photo'];
$path_foto = "assets/img/profile/". $name_img_user;

if(isset($_POST['edit'])){

    if(!empty($_POST['username'])){
        $username = $_POST['username'];    
        $editname = mysqli_query($koneksi, "UPDATE user SET name ='$username' WHERE id=$iduser ");
    }
 
    //jika file tidak kosong
    if(!empty($_FILES["imguser"]["name"])){
      //jika user sudaah punya foto maka hapus foto sebelumnya
      if(file_exists($path_foto)){
        chmod($path_foto,0755);
        unlink($path_foto);
      }
      //menyimpan foto ke mysql dan folder
      $imgname = $_FILES["imguser"]["name"];
      $tmpname = $_FILES["imguser"]["tmp_name"];

      $new_img_name = $iduser . "_" . $name_user . "_" . $imgname;

      $folder = "assets/img/profile/" . $new_img_name;
      $upload_img = mysqli_query($koneksi, "UPDATE user SET photo = '$new_img_name' WHERE id = $iduser ");
      if(move_uploaded_file($tmpname,$folder)){
        header('Location: profile.php');
        exit();
      }else{
        echo "failed";
      }

  }


    

    header('Location: profile.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EDIT</title>
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
          <form method = "POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="username" class="form-label">Nama</label>
              <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Nama Baru">
            </div>
            <div class="mb-3">
              <label for="foto" class="form-label">Foto Profil</label>
              <input type="file" name="imguser" class="form-control" id="imguser">
            </div>
            <button class="btn btn-success btn-block" name="edit">Edit</button>
            <a href="profile.php" class="btn btn-danger btn-block" name="cancel">Cancel</a>
          </form>
          <hr>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
