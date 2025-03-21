<?php 
session_start();
require "connect.php";

//jika user sudah login akan menyimpan id user
if(isset($_SESSION['login'])){
      $user_id = $_SESSION['iduser'];
}

if(isset($_POST['status_like'])){
    if(!isset($_SESSION['login'])){
      // Jika pengguna belum login, kembalikan jumlah like tanpa melakukan perubahan pada database
      $resep_id = $_POST['resep_id'];
      echo getRating($resep_id);
      exit();
  } 
}

if (isset($_POST['status_like'])) {

  $resep_id = $_POST['resep_id'];
  $status_like = $_POST['status_like'];

  switch ($status_like) {
        case 'like':
         $sql="INSERT INTO `like` (resep_id, user_id) 
                   VALUES ($resep_id, $user_id)";
         break;
        case 'unlike':
              $sql="DELETE FROM `like` WHERE user_id=$user_id AND resep_id=$resep_id";
              break;
        default:
                break;
  }

  // execute query to effect changes in the database ...
  mysqli_query($koneksi, $sql);
  echo getRating($resep_id);
  exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
  global $koneksi;
  $sql = "SELECT COUNT(*) FROM `like` WHERE resep_id = $id";
  $rs = mysqli_query($koneksi, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}


// Get total number of likes and dislikes for a particular post
function getRating($id)
{
  global $koneksi;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM `like` WHERE resep_id = $id ";
  $likes_rs = mysqli_query($koneksi, $likes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $rating = [
        'likes' => $likes[0],
  ];
  return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  global $koneksi;
  global $user_id;
  $sql = "SELECT * FROM `like` WHERE user_id = $user_id 
                  AND resep_id=$post_id ";
  $result = mysqli_query($koneksi, $sql);
  if (mysqli_num_rows($result) > 0) {
        return true;
  }else{
        return false;
  }
}


$sql = "SELECT * FROM resep";
$result = mysqli_query($koneksi, $sql);
// fetch all posts from database
// return them as an associative array called $posts
$resep = mysqli_fetch_all($result, MYSQLI_ASSOC);