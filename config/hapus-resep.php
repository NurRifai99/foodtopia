<?php 
session_start();
require "connect.php";

if(isset($_SESSION['login'])){
    $iduser = $_SESSION['iduser'];

    if(isset($_GET['hapus_resep'])){
        $judul_resep = $_GET['hapus_resep'];

        $hapus_img_query = mysqli_query($koneksi, "SELECT * FROM resep WHERE judul='$judul_resep'");
        if($hapus_img_query){

            $row_img = mysqli_fetch_assoc($hapus_img_query);
            $foto_img = $row_img['foto'];
            $path_img_resep = "../assets/img/resep_img/" . $foto_img;
            
            if(file_exists($path_img_resep)){
                chmod($path_img_resep, 0777);
                unlink($path_img_resep);
            }

            $hapus = mysqli_query($koneksi, "DELETE  FROM resep WHERE user_id=$iduser AND judul = '$judul_resep'");
            if($hapus){
                header('Location: ../profile.php');
                exit();
            }
        }
        
    }
}else{
    header('Location: ../index.php');
    exit();
}

