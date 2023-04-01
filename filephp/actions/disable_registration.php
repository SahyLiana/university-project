<?php
require_once('../config/config.php');
if (!isset($_SESSION['username'])) {
    header('location:../view/dashboard.php');
} else {
    if ($_SESSION['title'] != 'admin') {
        header('location:../view/dashboard.php');
    } else {
        $queryEnable = mysqli_query($conn, "Update register set enable_registration='no'");
        // echo "ok";
        header('location:../view/dashboard.php');
    }
}
