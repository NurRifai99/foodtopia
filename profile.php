<?php

session_start();

require "config/connect.php";

if(isset($_SESSION['login'])){
    $iduser = $_SESSION['iduser'];
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id = $iduser ");

    if(mysqli_num_rows($query) == 1){
        $row = mysqli_fetch_assoc($query);
        $namauser = $row['name'];
        $username = $row['username'];
        $fotouser = $row['photo'];
    }

    $batas = 6;
    $halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $first_card_perpage = ($halaman * $batas ) - $batas;

    $previous = $halaman - 1;
    $next = $halaman + 1;

    $queri_tanpa_batas = "SELECT resep.*,user.name as chef, kategori.nama as kategory  FROM resep 
    INNER JOIN user ON user.id = resep.user_id
    INNER JOIN kategori ON kategori.id=resep.kategori_id
    WHERE user_id=$iduser";

    $data_resep = mysqli_query($koneksi, $queri_tanpa_batas);
    $jumlah_data = mysqli_num_rows($data_resep);
    $jumlah_halaman = ceil($jumlah_data / $batas);

    $resep_user = mysqli_query($koneksi,"SELECT resep.*,user.name as chef, kategori.nama as kategory  FROM resep 
                                INNER JOIN user ON user.id = resep.user_id
                                INNER JOIN kategori ON kategori.id=resep.kategori_id
                                WHERE user_id=$iduser ORDER BY tanggal DESC limit $first_card_perpage,$batas");

    $hasil_resep_user = mysqli_fetch_all($resep_user,MYSQLI_BOTH);

}else{
    header('Location: index.php');
}

?>
<!DOCTYPE html> 
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>FoodTopia</title>
        <link rel="shortcut icon" type="image/png" href="assets/img/title.png" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="assets/css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->
        
        <!-- Recipe Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                
                <h3 class="mb-4"><a href="./index.php" class="btn btn-primary btn-sm ms-2"><i class="fa fa-home"></i></a>  My Profile</h3>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-lg-3">     
                            <?php if(isset($_SESSION['login'])){ ?>   
                                        <div class="card">
                                            <?php if(isset($fotouser)){ ?>
                                            <img src="assets/img/profile/<?php echo $fotouser; ?>" class="card-img-top" alt="<?php echo $fotouser; ?>">
                                            <?php }else{ ?>
                                                <img src="assets/img/avatar.jpg" alt="avatar" class="card-img-top" >
                                            <?php } ?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $namauser; ?></h5>
                                                <p class="card-text"><?php echo $username; ?></p>
                                             

                                                <div class="col-lg-6 col-md-2">
                                                    <div class="d-flex flex-column text-start ">
                                                        <!-- <h4 class="text-light mb-3">Konten FoodTopia</h4> -->
                                                        <a class="btn btn-primary btn-block" href="edit-user.php">Edit</a><br>
                                                        <a class="btn btn-primary btn-block" href="upload.php">Upload</a><br>
                                                        <a class="btn btn-danger btn-block" href="config/logout.php">Logout</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>  
                                        <?php } ?>

                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                <?php
                                if($jumlah_halaman < 1){
                                    echo "<h4>Ayo Buat Resep anda sendiri!</h4>";
                                } 
                                ?>

                                <?php foreach($hasil_resep_user as $item_user){ 
                                        $judul = $item_user['judul'];
                                        $deskripsi = $item_user['deskripsi'];
                                        $chef = $item_user['chef'];
                                        $kategori = $item_user['kategory'];
                                        $resep_img = $item_user['foto'];

                                    ?>
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="assets/img/resep_img/<?php echo $resep_img; ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $kategori; ?><a href="config/hapus-resep.php?hapus_resep=<?php echo $judul; ?>" class="btn btn-danger btn-sm ms-2" onclick="deleteRecipe()"><i class="fa fa-trash"></i></a></div>
                                            <div class="p-4 border-top-0 rounded-bottom"> <!--border border-secondary-->
                                                <h4><?php echo $judul; ?></h4>
                                                <p ><?php echo $deskripsi; ?></p> <!--coba pake class="text-truncate" sama aja karena judul-->
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-6 fw-bold mb-0"><?php echo $chef; ?></p>
                                                    <a href="recipe-detail.php?R=<?php echo $judul;?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-file me-2 text-primary"></i>Baca Selengkapnya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">

                                            <?php 
                                            if($jumlah_halaman > 1){

                                                if($halaman > 1){ ?>
                                                        <a <?php if($halaman > 1) { echo "href='?page=$previous'";} ?> class="rounded">&laquo;</a>
                                                        <a href="<?php echo"?page=1"; ?>" class="rounded " >1</a>
                                                <?php } ?>
    
    
                                                <input class="rounded" type="text" name="" id="pageinput" placeholder = "<?php echo $halaman; ?>" onkeypress="if(event.keyCode==13){changePage();}">
                                                
                                                <?php 
                                                    if($halaman < $jumlah_halaman){ ?>
                                                        <a href="<?php echo "?page=$jumlah_halaman"; ?>" class="rounded"><?php echo $jumlah_halaman; ?></a>
                                                        <a <?php if($halaman < $jumlah_halaman) { echo "href='?page=$next'"; } ?> class="rounded">&raquo;</a>
                                                <?php 
                                                    }
                                            }
                                            ?>
                                        
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recipe End-->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/lib/easing/easing.min.js"></script>
    <script src="/assets/lib/waypoints/waypoints.min.js"></script>
    <script src="/assets/lib/lightbox/js/lightbox.min.js"></script>
    <script src="/assets/lib/owlcarousel/owl.carousel.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/skrip.js"></script>
    </body>

</html>