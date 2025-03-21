<?php
session_start();

//session_unset(); menghapus nilai session
session_destroy(); //menghapus seluruh session
header('Location: ../index.php');