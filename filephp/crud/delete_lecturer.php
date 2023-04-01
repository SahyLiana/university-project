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
    $query = mysqli_query($conn, "Select *from lecturers where lecturer_id='$lid'");
    $row = mysqli_fetch_array($query);
    $lname = $row['lecturer_name'];
    $query_update_course = mysqli_query($conn, "Update courses set lecturer=NULL where lecturer='$lname'");
    $query_delete_lecturer = mysqli_query($conn, "Delete from lecturers where lecturer_id='$lid'");
    $query_delete_user = mysqli_query($conn, "Delete from users where userid='$lid'");

    if ($query_delete_lecturer) {
?>
        <script>
            alert("Lecturer deleted successfully");
            window.location.href = "../view/lecturers.php";
        </script>
    <?php
    } else {
    ?> <script>
            alert("Lecturer delete failed");
            window.location.href = "../view/lecturers.php";
        </script>

<?php
    }
}
?>