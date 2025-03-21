<?php
session_start();
require "connect.php";
if(isset($_SESSION['login'])){
    header("location: ../index.php");
}

if(isset($_POST['signup'])){
    $email = $_POST['email'];
    $username = $_POST['username'];
    $passw = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$email' ");
    $cekemail = mysqli_num_rows($query);

    if($cekemail > 0){
        echo "maaf email sudah ada";
    }else{
        $signup = mysqli_query($koneksi, "INSERT INTO user (username,name,password) VALUES ('$email','$username','$passw') ");

        if($signup){
            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$email' ");
            $datauser = mysqli_fetch_assoc($query);

            $_SESSION['login'] = true;
            $_SESSION['iduser'] = $datauser['id'];
            $_SESSION['username'] = $datauser['name'];
            header('Location: ../index.php');
            exit();
        }
    }
}