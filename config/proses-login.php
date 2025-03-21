<?php
session_start();
require "connect.php";
if(isset($_SESSION['login'])){
    header("location: ../index.php");
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryuser = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");

    if(mysqli_num_rows($queryuser) == 1){
        $result = mysqli_fetch_assoc($queryuser);
        
        $_SESSION['login'] = true;
        $_SESSION['iduser'] = $result['id'];
        $_SESSION['username'] = $result['name'];
        $username = $result['username'];
        $nama = $result['name'];
        header('Location: ../index.php');
        exit();
    }else{
        echo "maaf username atau password salah";
    }
}