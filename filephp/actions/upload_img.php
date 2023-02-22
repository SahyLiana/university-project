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
                $query_sql = mysqli_query($conn, "Update students set profile='$fileDestination' where student_id='$id'");
                // header("Location:../view/view_student.php");
?>
                <script>
                    alert("Successfull!");
                    window.location.href = "../view/view_student.php?id=<?php echo $id ?>";
                </script>
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

            ?>
            <script>
                alert("There is an error during uploading...");
                window.location.href = "../view/view_student.php?id=<?php echo $id ?>";
            </script>
        <?php
        }
    } else {

        ?>
        <script>
            alert("This type of file is not supported...");
            window.location.href = "../view/view_student.php?id=<?php echo $id ?>";
        </script>
<?php
    }
}
