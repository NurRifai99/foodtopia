<?php
require "config/connect.php";
include "config/proses-like.php";

// if(isset($_SESSION['login'])){
//     $user_id = $_SESSION['iduser'];
// }

if(isset($_GET['R'])){
    $judul = $_GET['R'];

    $query = mysqli_query($koneksi, "SELECT resep.*,user.name as chef, user.photo as img_profil, kategori.nama as kategory FROM resep 
     INNER JOIN user ON user.id=resep.user_id
     INNER JOIN kategori ON kategori.id=resep.kategori_id
     WHERE judul='$judul' ");

    $resep = mysqli_fetch_assoc($query);

        $resepid = $resep['id'];
        $_SESSION['idresep'] = $resepid;
        $deskripsi = $resep['deskripsi'];
        $chef = $resep['chef'];
        $foto_profil = $resep['img_profil'];
        $kategori = $resep['kategory'];
        $foto_resep = $resep['foto'];

        $bahan = $resep['bahan'];
        $bahan_array = explode("\n", $bahan); //menjadikan string menjadi array melalui fungsi explode berdasarkan baris baru
        $langkah = $resep['langkah'];
        $langkah_array = explode("\n",$langkah);
     
}

//jumlah seluruh resep
$jumlah_reseps = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM resep");
$row_resep = mysqli_fetch_assoc($jumlah_reseps);
$jumlah_resep = $row_resep['jml'];

$query_kategori = mysqli_query($koneksi, "SELECT kategori.nama as Kategory, COUNT(*) AS jumlah FROM resep INNER JOIN kategori ON kategori.id=resep.kategori_id GROUP BY kategori_id;");
$row_kate = mysqli_fetch_all($query_kategori,MYSQLI_BOTH);


$kia = mysqli_query($koneksi,"SELECT komentar.*,user.name as orangkomen, user.photo as profilimg FROM komentar INNER JOIN user ON user.id=komentar.user_id WHERE resep_id = $resepid ORDER BY tanggal DESC ");
$komen = mysqli_fetch_all($kia,MYSQLI_BOTH);

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


        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <!-- <a href="index.html" class="navbar-brand"><h1 class="text-primary display-6">FoodTopia</h1></a> -->
                    <a href="./index.php" class="text-nowrap logo-img">
                        <img src="assets/img/logo.svg" width="200" alt="" />
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="./index.php" class="nav-item nav-link">Home</a>
                            <a href="./recipe.php" class="nav-item nav-link">Recipe</a>
                            
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Category</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="category.php?category=Goreng" class="dropdown-item">Goreng</a>
                                    <a href="category.php?category=Rebus" class="dropdown-item">Rebus</a>
                                    <a href="category.php?category=Bakar" class="dropdown-item">Bakar</a>
                                    <a href="category.php?category=Panggang" class="dropdown-item">Panggang</a>
                                </div>
                            </div>
                            <!--<a href="contact.html" class="nav-item nav-link">Contact</a>-->
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-user fa-2x"></i></a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <?php if(isset($_SESSION['login'])){ ?>
                                    <a href="./profile.php" class="dropdown-item">Profile</a>
                                    <a href="./upload.php" class="dropdown-item">Upload</a>
                                    <a href="config/logout.php" class="dropdown-item">Logout</a>
                                    <?php }else{ ?>
                                    <a href="login.php" class="dropdown-item">Login</a>
                                    <a href="signup.php" class="dropdown-item">Sign-Up</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pencarian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <form action="recipe.php" method="GET" class="input-group w-75 mx-auto d-flex">
                            <input type="search" name="cari" class="form-control p-3" placeholder="Pencarian" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->

        <!-- Single Product Start -->
        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">

                                    <a href="#">
                                        <img src="assets/img/resep_img/<?php echo $foto_resep; ?>" class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?php echo $judul; ?></h4>
                                <p class="mb-3">Kategori: <?php echo $kategori; ?></p>
                                <h5 class="fw-bold mb-3">
                                    <?php
                                    if(isset($foto_profil)){   ?>
                                        <img src="assets/img/profile/<?php echo $foto_profil; ?>" class="img-fluid rounded-circle p-3" style="width: 70px; height: 70px;" alt="">
                                    <?php }else{ ?>
                                        <img src="assets/img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 70px; height: 70px;" alt="">
                                   <?php } 
                                    ?>
                                    <?php echo $chef; ?>
                                </h5>
                                <!-- "d-flex mb-4" -->
                                <div class="d-flex mb-4 pl-4">
                                    <div class="like-button">
                                        <p>  
                                            <?php if(isset($_SESSION['login'])){ ?>

                                                <i <?php if(userLiked($resepid)){ ?>
                                                      class="fas fa-heart like fa-lg"
                                                    <?php }else{ ?>
                                                      class="far fa-heart like fa-lg"
                                                    <?php } ?> id="toggle-like-btn" data-rsp=<?php echo $resepid; ?>  > 
                                                </i>
                                                &nbsp;&nbsp;
                                                <span class="likes"><?php echo getLikes($resepid); ?></span> 
                                                <?php }else{ ?>
                                                    <i class="far fa-heart fa-lg" disabled></i>
                                                    &nbsp;&nbsp;
                                                    <span class="likes"><?php echo getLikes($resepid); ?></span> <br><br>
                                                    <span class="like-nologin">Untuk Like silakan <a href="login.php">login</a> </span>
                                                <?php }?>
                                               
                                        </p>
                                    </div>
                                </div>
                                <h5>Deskripsi</h5>
                                
                                <p><?php echo $deskripsi; ?></p>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Bahan & Langkah</button>
                                        <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Komentar</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        
                                        <div class="px-2">
                                            <div class="row g-4">
                                                <div class="col-6">   
                                                    <div class="justify-content-center py-2">
                                                        <div class="col-5">
                                                            <h6 class="mb-0">Bahan:</h6>
                                                        </div>
                                                        <div class="col-15">
                                                            <!--pakai <p> kalau ga bisa-->
                                                            <ul>
                                                                <?php foreach($bahan_array as $item){ 
                                                                  if(!empty(trim($item))){
                                                                ?>
                                                                    <li><?php echo $item; ?></li>
                                                                    <?php } 
                                                                } ?>
                                                              </ul>
                                                        </div>
                                                    </div>
                                                    <div class="justify-content-center py-2">
                                                        <div class="col-5">
                                                            <h6 class="mb-0">Langkah-langkah:</h6>
                                                        </div>
                                                        <div class="col-12">
                                                            <!--pakai <p> kalau ga bisa-->
                                                            <ol>
                                                            <?php foreach($langkah_array as $item){ 
                                                                  if(!empty(trim($item))){
                                                                ?>
                                                                    <li><?php echo $item; ?></li>
                                                                    <?php } 
                                                                } ?>
                                                                <!-- Tambahkan langkah-langkah lainnya sesuai kebutuhan -->
                                                              </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                        
                                        <?php if(count($komen) > 0 ){

                                            foreach($komen as $komentar){ 
                                                $user = $komentar['orangkomen'];
                                                $img_profile = $komentar['profilimg'];
                                                $komennya = $komentar['isi'];
                                                $waktu = $komentar['tanggal'];
                                                $newtanggal = date("F j, Y", strtotime($waktu));
                                             ?>
                                         
                                                <div class="d-flex">
                                                    <?php
                                                    if(isset($img_profile)){ ?>
                                                        <img src="./assets/img/profile/<?php echo $img_profile; ?>" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                                    <?php }else{ ?>
                                                        <img src="./assets/img/avatar.jpg" class="img-fluid rounded-circle p-3" style="width: 100px; height: 100px;" alt="">
                                                    <?php
                                                    }
                                                    ?>
                                                  <div class="">
                                                      <p class="mb-2" style="font-size: 14px;"><?php echo $newtanggal; ?></p>
                                                      <div class="d-flex justify-content-between">
                                                          <h5><?php echo $user ;?></h5>
                                                      </div>
                                                      <p class="text-dark"><?php echo $komennya; ?></p>
                                                  </div>
                                                </div>      
                                        
                                            <?php } 
                                        }else{ ?>
                                            <h4>Jadilah Yang Pertama Komentar</h4>
                                        <?php } ?> 
                                        

                                            
                                        
                                       
                                    </div>
                                </div>
                            </div>

                            <form action="config/proses-komen.php" method="POST">
                                <h4 class="mb-5 fw-bold">Tulis Komentar</h4>

                                <?php
                                 if(isset($_GET['sts_komen']) && $_GET['sts_komen'] == "no" ){
                                    ?>
                                    <p class="alert alert-danger">
                                        Untuk Komentar Anda Harus <a href="login.php" class="alert-link">Login</a>  Terlebih Dahulu
                                    </p>           
                                <?php } ?>

                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="border-bottom rounded my-4">
                                            <textarea name="komentar"  class="form-control border-0" cols="30" rows="8" placeholder="Komentar" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between py-3 mb-5">
                                            <div class="d-flex align-items-center">
                                            </div>
                                            <button name="komen" class="btn border border-secondary text-primary rounded-pill px-4 py-3"> Kirim</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
 
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="row g-4 fruite">
                            <div class="col-lg-12">
                                <form action="recipe.php" method="GET" class="input-group w-100 mx-auto d-flex mb-4">
                                    <input type="search" name="cari" class="form-control p-3" placeholder="cari..." aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                </form>
                                <div class="mb-4">
                                    <h4>Kategori</h4>
                                    <ul class="list-unstyled fruite-categorie">


                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="./recipe.php"><i class="fas fa-apple-alt me-2"></i>Semua</a>
                                                        <span>(<?php echo $jumlah_resep; ?>)</span>
                                                    </div>
                                                </li>
                                                
                                                <?php foreach($row_kate as $kate){
                                                    $katego = $kate['Kategory'];
                                                    $jumlah_kate = $kate['jumlah']; 
                                                    $url_kate = "category.php?category=" . $katego;
                                                ?>
                                                    <li>
                                                        <div class="d-flex justify-content-between fruite-name">
                                                            <a href="<?php echo $url_kate; ?>"><i class="fas fa-apple-alt me-2"></i><?php echo $katego; ?></a>
                                                            <span>(<?php echo $jumlah_kate; ?>)</span>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Product End -->
    

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <img src="assets/img/logo.svg" width="200" alt="" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-4 col-md-2">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Konten FoodTopia</h4>
                            <a class="btn-link" href="./index.html">Home</a>
                            <a class="btn-link" href="./recipe.html">Recipe</a>
                            <a class="btn-link" href="./upload.html">Upload</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-2">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Kategori</h4>
                            <a class="btn-link" href="./recipe.html">Goreng</a>
                            <a class="btn-link" href="./recipe.html">Bakar</a>
                            <a class="btn-link" href="./recipe.html">Panggang</a>
                            <a class="btn-link" href="./recipe.html">Rebus</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-2">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Ikuti Kami</h4>
                        </div>
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="#"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="#"><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href="#"><i class="fab fa-tiktok"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>FoodTopia</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
        <!-- Copyright End -->



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
    <script src="assets/js/skrip.js"></script>
    <script src="assets/js/main.js"></script>
    </body>

</html>