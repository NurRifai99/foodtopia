<?php 
session_start();
require "connect.php";

if(isset($_SESSION['idresep'])){
    $idresep = $_SESSION['idresep'];
    $cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT judul FROM resep WHERE id=$idresep"));
    $judul = $cek['judul'];

    if(isset($_POST['komen'])){

        if(isset($_SESSION['login'])){
            $userkomen = $_SESSION['iduser'];

            $tanggal = date('Y-m-d H:i:s');
            $isikomen = $_POST['komentar'];

            $insertkomen = mysqli_query($koneksi, "INSERT INTO komentar (isi,user_id,resep_id,tanggal) VALUES ('$isikomen','$userkomen','$idresep','$tanggal') ");
            if($insertkomen){           
                header("Location: ../recipe-detail.php?R=$judul");
                exit();
            }else{
                die("Database query failed: " . mysqli_error($koneksi));
            }
        }else{  
            header("Location: ../recipe-detail.php?R=$judul&sts_komen=no");
        }
    }
}

