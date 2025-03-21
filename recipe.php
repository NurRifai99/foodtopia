<?php
session_start();
require "config/connect.php";

$jumlah_reseps = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM resep");
$row_resep = mysqli_fetch_assoc($jumlah_reseps);
$jumlah_resep = $row_resep['jml'];

$query_kategori = mysqli_query($koneksi, "SELECT kategori.nama as Kategory, COUNT(*) AS jumlah FROM resep INNER JOIN kategori ON kategori.id=resep.kategori_id GROUP BY kategori_id;");
$row_kate = mysqli_fetch_all($query_kategori,MYSQLI_BOTH);
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
                    </a>>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="./index.php" class="nav-item nav-link">Home</a>
                            <a href="./recipe.php" class="nav-item nav-link active">Recipe</a>
                            
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
                        <form method = "GET" class="input-group w-75 mx-auto d-flex">
                            <input type="search" name = "cari" class="form-control p-3" placeholder="Pencarian" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->

        <!-- Recipe Start-->
        <div class="container-fluid fruite py-5" id="all-br">
            <div class="container py-5">
                <h1 class="mb-4">Resep Masakan</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <form method = "GET" class="input-group w-100 mx-auto d-flex">
                                    <input type="search" name = "cari" id="search-input" class="form-control p-3" placeholder="cari..." aria-describedby="search-icon-1">
                                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                                </form>
                            </div>
                            <div class="col-6"></div>
                        </div>
                        <div class="row g-4">
                            
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3"><br>

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
                                    <div class="col-lg-12">
                                        <h4>Berdasarkan</h4>
                                        <form id="sortForm" action="recipe.php" method="post">
                                        <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-1" name="sort" value="favorit" <?php if(isset($_POST['sort']) && $_POST['sort']=='favorit') { echo "checked"; }  ?> >
                                                <label for="Categories-1"> Favorit</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-2" name="sort" value="terbaru" <?php if(isset($_POST['sort']) && $_POST['sort']=='terbaru') { echo "checked" ;}  ?> >                     
                                                <label for="Categories-2"> Terbaru</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-3" name="sort" value="terlama" <?php if(isset($_POST['sort']) && $_POST['sort']=='terlama') { echo "checked" ;}  ?> >                                         
                                                <label for="Categories-3"> Terlama</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9" id="vok">

                                <?php
                                    $batas = 6;
                                    $halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                    $first_card_perpage = ($halaman * $batas ) - $batas;
                                ?>

                                <?php 

                                 if(isset($_POST['sort'])){
                                    $sort = $_POST['sort'];

                                    switch($sort){
                                        case 'favorit':
                                            $urut = "suka DESC";
                                        break;
                                        case 'terbaru':
                                            $urut = "tanggal DESC";
                                        break;
                                        case 'terlama':
                                            $urut = "tanggal ASC";
                                        break;
                                        default:
                                            $urut = "tanggal DESC";
                                        break;
                                    }
                                    
                                 }else{
                                    $urut = "tanggal DESC";
                                 }

                                    if(isset($_GET['cari'])){ //mendapatkan kata kunci dari method get

                                        $cari = $_GET['cari']; //menyimpan kata kunci ke variable $cari
                                       
                                        $query = "SELECT resep.*, user.name AS chef, kategori.nama AS kategory, COUNT(`like`.resep_id) AS suka
                                        FROM resep
                                        INNER JOIN user ON user.id = resep.user_id
                                        INNER JOIN kategori ON kategori.id = resep.kategori_id
                                        LEFT JOIN `like` ON `like`.resep_id = resep.id
                                        WHERE resep.judul LIKE '%" . $cari ."%' OR user.name LIKE '%". $cari ."%'
                                        GROUP BY resep.id ORDER BY $urut
                                        LIMIT $first_card_perpage, $batas";
                        
                                        $queri_tanpa_batasan = "SELECT resep.* ,user.name as chef , kategori.nama as kategory FROM resep 
                                        INNER JOIN user ON user.id=resep.user_id
                                        INNER JOIN kategori ON kategori.id = resep.kategori_id
                                        WHERE judul LIKE '%" . $cari ."%' OR name LIKE '%". $cari ."%' ORDER BY $urut ";
                                        ?>  
                                        <h4>Hasil Pencarian Dari : <?php echo $cari; ?></h4>  

                                    <?php
                                    } else { 
                                        $query = "SELECT resep.*, user.name AS chef, kategori.nama AS kategory, COUNT(`like`.resep_id) AS suka
                                        FROM resep
                                        INNER JOIN user ON user.id = resep.user_id
                                        INNER JOIN kategori ON kategori.id = resep.kategori_id
                                        LEFT JOIN `like` ON `like`.resep_id = resep.id
                                        GROUP BY resep.id ORDER BY $urut
                                        LIMIT $first_card_perpage, $batas";

                                        $queri_tanpa_batasan = "SELECT resep.*, user.name as chef, kategori.nama as kategory FROM resep 
                                        INNER JOIN user ON user.id = resep.user_id
                                        INNER JOIN kategori ON kategori.id = resep.kategori_id ORDER BY $urut";
                                                                     
                                     } ?>


                     

                                <div class="row g-4 justify-content-center" id="all-recipe">                    

                                <?php
                                              
                                 $hasil = mysqli_query($koneksi,$query);
                                 $result = mysqli_fetch_all($hasil, MYSQLI_BOTH);

                                 if(count($result) > 0 ){
                                    foreach($result as $data){
                                        $judul = $data['judul'];
                                        $deskripsi = $data['deskripsi'];
                                        $user = $data['chef'];
                                        $kategory = $data['kategory'];
                                        $foto_resep = $data['foto'];
                                ?>
                                    <div class="col-md-6 col-lg-6 col-xl-4" id="hasil-urut" >
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="assets/img/resep_img/<?php echo $foto_resep; ?>" class="img-fluid w-100 rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $kategory; ?></div>
                                            <!-- border border-secondary -->
                                            <div class="p-4 border-top-0 rounded-bottom">
                                                <h4><?php echo $judul; ?></h4>
                                                <p><?php echo $deskripsi; ?></p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-6 fw-bold mb-0"><?php echo $user; ?></p>
                                                    <a href="./recipe-detail.php?R=<?php echo $judul; ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-file me-2 text-primary"></i>Baca Selengkapnya</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                               <?php }                                  
                                 }else{ ?>
                                    <h4>Tidak Ada Hasil Yang Relavan</h4> 
                               <?php  } ?>             
                                    
                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <?php 
                                            $previous = $halaman - 1;
                                            $next = $halaman + 1;

                                            $data_resep = mysqli_query($koneksi, $queri_tanpa_batasan);
                                            $jumlah_data = mysqli_num_rows($data_resep);
                                            $jumlah_halaman = ceil($jumlah_data / $batas);

                                            if($jumlah_halaman > 1){

                                                if(isset($_GET['cari'])){
                                                    $cari = $_GET['cari'];

                                                    if($halaman > 1){ ?>
                                                        <a <?php if($halaman > 1) { echo "href='?cari=$cari&page=$previous'";} ?> class="rounded">&laquo;</a>
                                                        <a href="<?php echo"?page=1"; ?>" class="rounded " >1</a>
                                                <?php } ?>
    
    
                                                <input class="rounded" type="text" name="" id="pageinput" placeholder = "<?php echo $halaman; ?>" onkeypress="if(event.keyCode==13){changePage();}">
                                                
                                                <?php 
                                                    if($halaman < $jumlah_halaman){ ?>
                                                        <a <?php echo "href='?cari=$cari&page=$jumlah_halaman'"; ?> class="rounded"><?php echo $jumlah_halaman; ?></a>
                                                        <a <?php if($halaman < $jumlah_halaman) { echo "href='?cari=$cari&page=$next'"; } ?> class="rounded">&raquo;</a>
                                                <?php }   

                                                }else{
                                                    
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
                                        } ?>
                                                                        
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
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/lightbox/js/lightbox.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.js"></script>
<?php echo $html; ?>
    <!-- Template Javascript -->
    <script src="assets/js/skrip.js"></script>
    <script src="assets/js/main.js"></script>
    </body>

</html>