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
            <h2 class="bg-light text-primary text-center">Update Course Unit</h2>
        </div>
        <form action="" method="POST">
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="cid" class="fw-bold">Course ID:</label>
                </div>
                <div class="col-5">
                    <input type="text" disabled name="cid" id="cid" class="fs-5 p-3 form-control w-100" value='<?php echo $_GET["id"] ?>' placeholder="eg:BCSIT">
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="cname" class="fw-bold">Course name:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="cname" id="cname" class="p-3 fs-5 form-control w-100" value='<?php echo $_GET["name"] ?>' placeholder="eg:Computer Science">
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="year" class="fw-bold">Year:</label>
                </div>
                <div class="col-5">
                    <select class="form-select" name="year">
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
                    <select class="form-select" name="semester">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                    </select>
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="lecturer" class="fw-bold">Lecturer</label>
                </div>
                <div class="col-5">
                    <select class="form-select" name="lecturer">
                        <option value=""></option>
                        <?php
                        $query_lecturer = mysqli_query($conn, "Select *from lecturers;");
                        while ($row_lecturer = mysqli_fetch_assoc($query_lecturer)) {
                        ?>
                            <option value="<?php echo $row_lecturer['lecturer_name'] ?>">
                                <?php
                                $did = $row_lecturer['dep_id'];
                                $query_select_dpt = mysqli_query($conn, "Select *from departments where dep_id='$did';");
                                $row_dpt = mysqli_fetch_assoc($query_select_dpt);
                                echo $row_lecturer['lecturer_name'] . ":Department of " . $row_dpt['dep_name'] ?></option>
                        <?php
                        }
                        ?>
                        <!-- <option value="1">lecturer1</option>
                                            <option value="2">lecturer2</option> -->
                    </select>
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
                // header('location:courses.php');
            ?>
                <script type="text/javascript">
                    window.location.href = "../view/courses.php";
                </script>
                <?php
            }
            if (isset($_POST['submit'])) {
                $cname = $_POST['cname'];
                $cid = $_GET['id'];
                $year = $_POST['year'];
                $semester = $_POST['semester'];
                $lecturer = $_POST['lecturer'];
                echo $cid;
                $queryupdate = mysqli_query($conn, "Update courses set course_name='$cname',year='$year',semester='$semester',lecturer='$lecturer' where course_id='$cid';");
                if ($queryupdate) { ?>
                    <script type="text/javascript">
                        alert('Update successful.');
                        window.location.href = '../view/courses.php';
                    </script>
                <?php
                    // echo "<script> alert('Update successful.')</script>";
                    // echo "window.location.href='departments.php'";
                } else { ?>
                    <script type="text/javascript">
                        alert('Update successful.');
                        window.location.href = '../view/courses.php';
                    </script><?php
                                // echo "<script> alert('Update failed.')</script>";
                                // // echo "<p>Update failed</p>";
                                // echo "window.location.href='departments.php'";
                            }
                        }
                                ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>