<?php

include_once '../config/config.php';
if (isset($_POST['upload_photo'])) {
    // $file = $_FILES['photo'];
    // print_r($file);
    // echo "test";
    //echo $_GET['id'];
    $id = $_GET['id'];
    $fileName = $_FILES['photo']['name'];
    $fileTmpName = $_FILES['photo']['tmp_name'];
    $fileSize = $_FILES['photo']['size'];
    $fileError = $_FILES['photo']['error'];
    $fileType = $_FILES['photo']['type'];

    $fileExt = explode('.', $fileName); //return an array
    $fileActualExt = strtolower(end($fileExt)); //return the last index of the array

    $allowedExt = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowedExt)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = '../userimage/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $query_select_student = mysqli_query($conn, "Select *from students where student_id='$id'");
                $query_select_lecturer = mysqli_query($conn, "Select *from lecturers where lecturer_id='$id'");
                $row_std = $query_select_student->num_rows;
                $row_lec = $query_select_lecturer->num_rows;

                if ($row_std > 0) {
                    $query_sql = mysqli_query($conn, "Update students set profile='$fileDestination' where student_id='$id'");

                    if ($query_sql) {
?>
                        <script>
                            alert("Successfull!");
                            window.location.href = "../view/view_student.php?id=<?php echo $id ?>";
                        </script>
                    <?php
                    }
                } else if ($row_lec > 0) {
                    $query_sql = mysqli_query($conn, "Update lecturers set profile='$fileDestination' where lecturer_id='$id'");
                    if ($query_sql) {
                    ?>
                        <script>
                            alert("Successfull!");
                            window.location.href = "../view/view_lecturer.php?id=<?php echo $id ?>";
                        </script>
                    <?php
                    }
                    ?>
                <?php
                }
                // header("Location:../view/view_student.php");
                ?>
            <?php
            } else {
            ?>
                <script>
                    alert("Sorry,your file is too big!");
                    window.location.href = "../view/view_student.php?id=<?php echo $id ?>";
                </script>
            <?php
            }
        } else {
            if ($row_std > 0) {
            ?>
                <script>
                    alert("There is an error during uploading...");
                    window.location.href = "../view/view_student.php?id=<?php echo $id ?>";
                </script>
            <?php
            } else if ($row_lec > 0) {
            ?>
                <script>
                    alert("There is an error during uploading...");
                    window.location.href = "../view/view_lecturer.php?id=<?php echo $id ?>";
                </script>
        <?php
            }
        }
    } else {

        ?>
        <script>
            alert("This type of file is not supported...");
            window.location.href = "../view/dashboard.php?id=<?php echo $id ?>";
        </script>
<?php
    }
}
