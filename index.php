<?php
session_start();
require "config/connect.php";
if(isset($_SESSION['login'])){
    $iduser = $_SESSION['iduser'];
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
                            <a href="./index.php" class="nav-item nav-link active">Home</a>
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
                        <form class="input-group w-75 mx-auto d-flex" action="recipe.php" method = "Get">
                            <input type="search" name="cari" class="form-control p-3" placeholder="Pencarian" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">Bingung Mau Masak Apa?</h4>
                        <h1 class="mb-5 display-3 text-primary">FoodTopia Solusinya!</h1>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="assets/img/hero-img-1.jpg" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="./recipe-detail.html" class="btn px-4 py-2 text-white rounded">Goreng</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="assets/img/panggang.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="./recipe-detail.html" class="btn px-4 py-2 text-white rounded">Panggang</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="assets/img/rebus.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="./recipe-detail.html" class="btn px-4 py-2 text-white rounded">Rebus</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="assets/img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="./recipe-detail.html" class="btn px-4 py-2 text-white rounded">Bakar</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->

        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>Resep Favorit</h1>
                        </div>
                        <div class="col-lg-8 text-end">
                            <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                        <span class="text-dark" style="width: 130px;">Semua</span>
                                    </a>
                                </li>

                                <?php $kate_data = mysqli_query($koneksi,"SELECT nama FROM kategori");
                                    $data_kate =  mysqli_fetch_all($kate_data,MYSQLI_BOTH);
                                    foreach($data_kate as $kate){
                                        $nama_kategori = $kate['nama'];
                                        // var_dump($nama_kategori);
                                ?>

                                <li class="nav-item">
                                    <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#<?php echo $nama_kategori?>">
                                        <span class="text-dark" style="width: 130px;"><?php echo $nama_kategori; ?></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul> 
                        </div>
                    </div>
                    <div class="tab-content">

                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <?php
                            $allresep = mysqli_query($koneksi, "SELECT resep.*,user.name as chef ,kategori.nama as kategory, COUNT(*) AS suka FROM `like` 
                            INNER JOIN resep ON resep.id = like.resep_id 
                            INNER JOIN user on user.id = resep.user_id
                            INNER JOIN kategori on kategori.id = resep.kategori_id
                            GROUP BY resep_id ORDER BY suka DESC LIMIT 4");
                            $dataresep = mysqli_fetch_all($allresep,MYSQLI_BOTH);
                                        
                            ?>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">

                                    <?php foreach($dataresep as $data){ 
                                         $judul = $data['judul'];
                                         $deskripsi = $data['deskripsi'];
                                         $kategori = $data['kategory'];
                                         $chef = $data['chef'];
                                         $img_resep = $data['foto'];
                                    ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/resep_img/<?php echo $img_resep; ?>" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $kategori; ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?php echo $judul; ?></h4>
                                                    <p><?php echo $deskripsi; ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-6 fw-bold mb-0"><?php echo $chef; ?></p>
                                                        <a href="./recipe-detail.php?R=<?php echo $judul ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-file me-2 text-primary"></i>Baca Selengkapnya</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach($data_kate as $kate){ 
                            $nama_kategori = $kate['nama'];
                        ?>
                        <div id="<?php echo $nama_kategori; ?>" class="tab-pane fade show p-0">

                            <?php
                                $allresep = mysqli_query($koneksi, "SELECT resep.*, user.name AS chef, kategori.nama AS kategori, COUNT(*) AS suka FROM `like` 
                                INNER JOIN resep ON resep.id = `like`.resep_id 
                                INNER JOIN user ON user.id = resep.user_id  
                                INNER JOIN kategori ON kategori.id = resep.kategori_id 
                                WHERE kategori.nama = '$nama_kategori' 
                                GROUP BY resep.id 
                                ORDER BY suka DESC LIMIT 4");
                                $dataresep = mysqli_fetch_all($allresep,MYSQLI_BOTH); 
                            ?>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">

                                    <?php foreach($dataresep as $data){ 
                                        $judul = $data['judul'];
                                        $deskripsi =$data['deskripsi'];
                                        $chef = $data['chef'];
                                        $kategori = $data['kategori'];
                                        $img_resep = $data['foto'];
                                    ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="assets/img/resep_img/<?php echo $img_resep; ?>" class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $kategori; ?></div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><?php echo $judul; ?></h4>
                                                    <p><?php echo $deskripsi; ?></p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-6 fw-bold mb-0"><?php echo $chef; ?></p>
                                                        <a href="./recipe-detail.php?R=<?php echo $judul ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-file me-2 text-primary"></i>Baca Selengkapnya</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->

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
    <script src="assets/js/main.js"></script>
    </body>

</html>