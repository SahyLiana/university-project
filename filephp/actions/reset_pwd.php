<?php
require_once('../config/config.php');
if (!isset($_SESSION['username'])) {
    header('location:../view/admin');
} else if ($_SESSION['title'] != 'admin') {
    header('location:../view/admin.php');
} else {
    echo $_GET['id'];
    $ID = $_GET['id'];
    $newPassword = md5("123456789");
    $queryUpdate = mysqli_query($conn, "Update users set password='$newPassword' where userid='$ID' ");
    header('location:../view/dashboard.php');
}
