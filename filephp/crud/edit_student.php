<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center">
    <?php
    require('../config/config.php');
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

    <?php
    $stid = $_GET['id'];
    $query_fecth = mysqli_query($conn, "Select *from students where student_id='$stid'");
    $row_num = $query_fecth->num_rows;
    if ($row_num == 1) {
        $row_fecth = mysqli_fetch_assoc($query_fecth);
    }

    ?>

    <div class="container p-0 my-auto rounded shadow-sm">
        <div class="mb-3 bg-light p-3">
            <h2 class="bg-light text-primary text-center">Edit Student</h2>
        </div>
        <form action="" method="POST">
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="sid" class="fw-bold">Student ID:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="sid" id="sid" disabled class="fs-5 p-3 form-control w-100" value='<?php echo $_GET["id"] ?>'>
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="sname" class="fw-bold">Student name:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="sname" id="sname" class="p-3 fs-5 form-control w-100" value='<?php echo $_GET["name"] ?>' placeholder="eg:John Doe">
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="dep_id" class="fw-bold">Department Id:</label>
                </div>
                <div class="col-5">
                    <select class="form-select" name="dep_id" id="dep_id">
                        <?php $dep_name = $_GET['dep_name'];

                        $querydept = mysqli_query($conn, "Select *from departments where dep_id != '$dep_name';");
                        $querydeptstd = mysqli_query($conn, "Select *from departments where dep_id='$dep_name'");
                        $row = mysqli_fetch_assoc($querydeptstd);
                        ?>

                        <option value="<?php echo $dep_name ?>" selected><?php echo $row['dep_name'] ?></option>
                        <?php


                        while ($rowdpt = mysqli_fetch_assoc($querydept)) {
                        ?> <option value="<?php echo $rowdpt['dep_id'] ?>"> <?php echo $rowdpt['dep_name'] ?>
                            </option>
                        <?php
                        }

                        ?>
                    </select>
                </div>
            </div>
            <!-- <?php echo "dp is" . $dep_name; ?> -->
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="year" class="fw-bold">Year:</label>
                </div>
                <div class="col-5">
                    <select class="form-select" name="year" id="year">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>

            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="semester" class="fw-bold">Semester:</label>
                </div>
                <div class="col-5">
                    <select class="form-select" name="semester" id="semester">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                    </select>
                </div>
            </div>

            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="contact" class="fw-bold">Contact:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="contact" id="contact" class="p-3 fs-5 form-control w-100" value="<?php echo $row_fecth['contact'] ?>" placeholder="eg:+861234567">
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
                // header('location:students.php');
            ?>
                <script type="text/javascript">
                    window.location.href = "../view/students.php";
                </script>
                <?php
            }
            if (isset($_POST['submit'])) {
                $sname = $_POST['sname'];
                $sid = $_GET['id'];
                $changesid = $sid;
                $dep_id = $_POST['dep_id'];
                $year = $_POST['year'];
                $semester = $_POST['semester'];
                $contact = $_POST['contact'];
                if (
                    !empty($changesid) && !empty($sname) && !empty($sid) && !empty($dep_id) &&
                    !empty($year) && !empty($semester) && !empty($contact)
                ) {                //echo $cid;
                    $queryupdate = mysqli_query($conn, "Update students set student_id='$changesid',student_name='$sname',dep_name='$dep_id',contact='$contact',year='$year',
                    semester='$semester' 
                    where student_id='$sid';");
                    // $queryusers = mysqli_query($conn, "Select *from users where userid='$sid'");
                    // $rowstd = mysqli_num_rows($query);
                    // if ($rowstd > 0) {
                    //     $queryupdateusers = mysqli_query($conn, "update users set userid='$sid',username='$sname',dep_id='$dep_id'");
                    // }
                    if ($queryupdate) {
                        $query_check = mysqli_query($conn, "Select *from users where userid='$sid';");
                        $rowcount = $query_check->num_rows;
                        if ($rowcount == 1) {
                            $queryupdate_lec_users = mysqli_query($conn, "Update users set userid='$changesid',username='$sname',dep_id='$dep_id' where userid='$sid';");
                        }
                ?>
                        <script type="text/javascript">
                            alert('Update successful.');
                            window.location.href = '../view/students.php';
                        </script>
                    <?php
                        // echo "<script> alert('Update successful.')</script>";
                        // echo "window.location.href='departments.php'";
                    } else { ?>
                        <script type="text/javascript">
                            alert('Update failed.');
                            window.location.href = '../view/students.php';
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