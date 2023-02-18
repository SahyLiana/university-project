<?php
require('../config/config.php');
if (!isset($_SESSION['username'])) {
    header('location:view/admin');
} else if ($_SESSION['title'] != 'admin') {
    header('location:view/admin.php');
} else {
    // echo "Delete page";
    $id = $_GET['id'];
    $deletequery = mysqli_query($conn, "Delete from departments where dep_id='$id'");
    $querystds = mysqli_query($conn, "Select *from students where dep_name='$id'");
    $row_std = $querystds->num_rows;
    if ($row_std != 0) {
        $deletestds = mysqli_query($conn, "Delete from students where dep_name='$id'");
    }
    echo "delete";
    if ($deletequery) {
?>
        <script>
            // alert("Department deleted successfully");
            window.location.href = "../view/departments.php";
        </script>
    <?php

    } else {
    ?>
        <script>
            alert("Department delete Failed");
            window.location.href = "../view/departments.php";
        </script>
<?php
    }
    // header('location:departments.php');
} ?>