<?php
require_once('../config/config.php');
if (!isset($_SESSION['username'])) {
    header('location:../view/admin.php');
} else if ($_SESSION['title'] != 'admin') {
    header('location:../view/admin.php');
} else {
    // echo "Delete page";
    $lid = $_GET['id'];
    //echo $id;
    $query_delete = mysqli_query($conn, "Delete from students where student_id='$lid'");
    $query_delete_user = mysqli_query($conn, "Delete from users where userid='$lid'");
    if ($query_delete) {
?>
        <script>
            alert("Student deleted successfully");
            window.location.href = "../view/students.php";
        </script>
    <?php
    } else {
    ?> <script>
            alert("Student delete failed");
            window.location.href = "../view/students.php";
        </script>

<?php
    }
}
?>