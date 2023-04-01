<?php
require_once('../config/config.php');
if (!isset($_SESSION['username'])) {
    header('location:../view/admin.php');
} else if ($_SESSION['title'] != 'admin') {
    header('location:../view/sadmin.php');
} else {
    // echo "Delete page";
    $id = $_GET['id'];
    $depid = $_GET['depid'];
    echo $id;
    $query_delete = mysqli_query($conn, "Delete from courses where course_id='$id' AND dep_id='$depid'");
    $query_deleteRegister = mysqli_query($conn, "Delete from register where cu_id='$id'");
    if ($query_delete) {
?>
        <script>
            alert("Course Unit deleted successfully");
            window.location.href = "../view/courses.php";
        </script>
    <?php
    } else {
    ?> <script>
            alert("Course Unit delete failed");
            window.location.href = "../view/courses.php";
        </script>

<?php
    }
}
?>