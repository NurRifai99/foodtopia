<?php
session_start();
if(!isset($_SESSION['login'])){
  header('Location: index.php');
  exit();
}

require "config/connect.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="assets/img/title.png" />
  <title>Upload</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #e0e5de;">

<div class="container mt-5">
  <div class="row justify-content-center mt-5">
    <img src="assets/img/logo.svg" class="center-image" height="100rem">
    <div class="col-md-8">
        <h2 class="text-center mb-4">Upload Resep</h2>

      <form action="config/proses-upload.php" method="POST" enctype="multipart/form-data">

        <div class="mb-3">
          <label for="foto" class="form-label">Upload Foto</label>
          <input type="file" name="foodimg" class="form-control" id="foto" required title="Pilih Foto Resep Anda">
        </div>
        <div class="mb-3">
          <label for="judul" class="form-label">Judul Resep</label>
          <input type="text" name="judul" class="form-control" id="judul" placeholder="Masukkan judul resep" required title="Masukkan Nama Resep">
        </div>
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi</label>
          <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="Masukkan deskripsi resep"></textarea required title="Masukkan Deskripsi">
        </div>
        <div class="mb-3">
          <label for="bahan" class="form-label">Bahan-bahan</label>
          <textarea class="form-control" name="bahan" id="bahan" rows="5" placeholder="Masukkan bahan-bahan resep"></textarea required title="Masukkan Bahan">
        </div>
        <div class="mb-3">
          <label for="langkah" class="form-label">Langkah-langkah</label>
          <textarea class="form-control" name="langkah" id="langkah" rows="5" placeholder="Masukkan langkah-langkah pembuatan resep"></textarea required title="Masukkan langkah-langkah">
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="select_kategori" class="form-select" id="kategori" required title="Pilih Kategori Dahulu">
                <option selected>Pilih kategori resep</option>
                <?php
                $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                $hasil = mysqli_fetch_all($kategori,MYSQLI_BOTH) ;
                 foreach($hasil as $datac){
                    ?>
                    <option value="<?php echo $datac['id']; ?>"><?php echo $datac['nama']; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <button name="upload" class="btn btn-success btn-block">Upload</button> 
        <a href="./profile.php" class="btn btn-danger btn-block">Cancel</a>

      </form>
    
    </div>
  </div>
  <hr>
</div>

</body>
</html>
