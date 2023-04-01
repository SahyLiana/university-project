<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center">
    <?php
    require_once('../config/config.php');
    if (!isset($_SESSION['username'])) {
        header('location:../view/admin.php');
    }
    if ($_SESSION['title'] != 'admin') {
        header('location:../view/admin.php');
    }
    //else {
    //     echo "Update";
    //     echo $_GET['id'] . ":" . $_GET['name'];
    //     //     // echo $_SESSION['vname'];
    //     //     // echo "Update page";
    //     //     // $id = $_GET['id'];
    //     //     // echo "Update";
    //     //     // echo $_SESSION['dname'];
    //     //     // $va = $_SESSION['dname'];
    //     //     // $vid = $_SESSION['ddid'];
    //     //     // $queryupdate = mysqli_query($conn, "Update departments set dep_name='$va' where dep_id='$vid'");
    // } 
    ?>

    <div class="container p-0 my-auto rounded shadow-sm">
        <div class="mb-3 bg-light p-3">
            <h2 class="bg-light text-primary text-center">Edit Lecturer</h2>
        </div>
        <form action="" method="POST">
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="lid" class="fw-bold">Lecturer ID:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="lid" id="lid" disabled class="fs-5 p-3 form-control w-100" value='<?php echo $_GET["id"] ?>'>
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="lname" class="fw-bold">Lecturer name:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="lname" id="lname" class="p-3 fs-5 form-control w-100" value='<?php echo $_GET["name"] ?>' placeholder="eg:John Doe">
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="dep_id" class="fw-bold">Department Id:</label>
                </div>
                <div class="col-5">
                    <select class="form-select" name="dep_id" id="dep_id">
                        <?php
                        $querydept = mysqli_query($conn, "Select *from departments;");

                        while ($rowdpt = mysqli_fetch_assoc($querydept)) {
                        ?>
                            <option value="<?php echo $rowdpt['dep_id'] ?>"> <?php echo $rowdpt['dep_name']; ?></option>
                        <?php
                        }

                        ?>
                    </select>
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="contact" class="fw-bold">Contact:</label>
                </div>
                <div class="col-5">
                    <?php
                    $id = $_GET['id'];
                    $query_lec = mysqli_query($conn, "Select *from lecturers where lecturer_id='$id'");
                    $row_lec = mysqli_fetch_assoc($query_lec);
                    ?>
                    <input type="text" name="contact" id="contact" value="<?php echo $row_lec['contact'] ?>" class="p-3 fs-5 form-control w-100" placeholder="eg:+861234567">
                </div>
            </div>

            <div class="row me-3 mb-3">
                <div class="col d-flex gap-3 justify-content-end">
                    <button class=" btn btn-primary btn-lg " name="submit">Submit</button>
                    <button class="btn btn-secondary btn-lg" name="cancel">Cancel</button>
                </div>
            </div>

            <?php
            if (isset($_POST['cancel'])) {
                header('location:../view/lecturers.php');
            }
            if (isset($_POST['submit'])) {
                $lname = $_POST['lname'];
                $lid = $_GET['id'];
                $changelid = $_POST['lid'];
                $dep_id = $_POST['dep_id'];
                $contact = $_POST['contact'];
                if (
                    !empty($changelid) && !empty($lname) && !empty($lid) && !empty($dep_id) &&
                    !empty($contact)
                ) {                //echo $cid;
                    $queryupdate = mysqli_query($conn, "Update lecturers set lecturer_id='$changelid',lecturer_name='$lname',dep_id='$dep_id',contact='$contact' where lecturer_id='$lid';");

                    if ($queryupdate) {
                        $query_check = mysqli_query($conn, "Select *from users where userid='$lid';");
                        $rowcount = $query_check->num_rows;
                        if ($rowcount == 1) {
                            $query = mysqli_query($conn, "Select *from lecturers where lecturer_id='$lid'");
                            $query_update_lec_courses = mysqli_query($conn, "Update courses set lecturer='$lname' where lecturer=''");
                            $queryupdate_lec_users = mysqli_query($conn, "Update users set userid='$changelid',username='$lname',dep_id='$dep_id' where userid='$lid';");
                        }
            ?>
                        <script type="text/javascript">
                            alert('Update successful.');
                            window.location.href = '../view/lecturers.php';
                        </script>
                    <?php
                        // echo "<script> alert('Update successful.')</script>";
                        // echo "window.location.href='departments.php'";
                    } else { ?>
                        <script type="text/javascript">
                            alert('Update failed.');
                            window.location.href = '../view/lecturers.php';
                        </script><?php
                                    // echo "<script> alert('Update failed.')</script>";
                                    // // echo "<p>Update failed</p>";
                                    // echo "window.location.href='departments.php'";
                                }
                            } else {
                                    ?>
                    <script type="text/javascript">
                        alert('Please fill the informations...');
                    </script>
            <?php
                            }
                        } ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>