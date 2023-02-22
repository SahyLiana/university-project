<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php require('../config/config.php');
    if (!isset($_SESSION['username'])) {
        header('location:admin.php');
    }

    ?>
    <!-- <h1>Welcome <?php echo $_SESSION['username'] ?></h1> -->
    <div class="d-flex">
        <?php
        // if (isset($_POST['logout'])) {
        //     session_unset();
        //     header('location:admin.php');
        // }
        ?>
        <style>
            #edit:hover {
                color: white;

            }

            #edit {
                color: blue;
            }

            #trash {
                color: red;
            }

            #trash:hover {
                color: white;
            }

            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                padding: 0;
                margin: 0;
                left: 0;
                width: 25%
            }

            /* .left {
    width: 25%;
} */

            .right {
                width: 75%;
                margin-left: 25%;
            }

            .cont {
                max-width: 1200px;
            }
        </style>

        <div class="h-100  sidebar align-items-stretch  navbar navbar-dark bg-dark ">
            <div class="nav flex-column w-100  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="w-100 d-flex bg-black flex-row text-white align-items-end">
                    <img src="images\logo.png" class="img-container w-25">
                    <h3 class="fw-bold w-100 text-center">School Panel</h3>
                </div>
                <p class=" ps-3 pt-3 text-white-50"> Welcome <?php echo $_SESSION['username'] ?></p>

                <a href="dashboard.php" class=" nav-link "><i class="fa fa-home me-1"></i>Home</a>
                <?php
                if ($_SESSION['title'] == "admin") {
                ?>
                    <a href="departments.php" class=" nav-link"><i class="fas fa-school me-1"></i>Departments</a>
                <?php
                } ?>
                <?php
                if ($_SESSION['title'] == 'student') { ?>
                    <a href="exam_registration.php" class=" nav-link"><i class=" fa fa-register me-1"></i>Register for exam</a>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                ?><a href="students.php" class=" nav-link"><i class="fas fa-graduation-cap me-1"></i>Students</a>
                <?php
                }
                ?>
                <a href="lecturers.php " class=" nav-link"><i class="fas fa-chalkboard-teacher me-1"></i>Lecturers</a>
                <a href="courses.php" class="active nav-link"><i class="fas fa-book-reader me-1"></i>Courses</a>
                <a href="settings.php" class=" nav-link"><i class="fa fa-cog me-1"></i>Settings</a>
                <button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Log out
                </button>
            </div>
        </div>
        <div class="right">
            <div class="bg-light d-flex justify-content-between px-3 py-4 text-black">
                <h4>Courses</h4>
                <?php
                if ($_SESSION['title'] == 'admin') {
                ?>
                    <input type="button" value="Add +" class="btn rounded-pill w-25 fw-bold btn-success " data-bs-toggle="modal" data-bs-target="#addcourses">
                <?php
                }
                ?>
                <!-- <input type="button" value="Add+" class="btn w-25 fw-bold btn-success " data-bs-toggle="modal" data-bs-target="#addcourses"> -->
            </div>
            <?php
            if ($_SESSION['title'] == 'admin') {
                $queryselec_dept = mysqli_query($conn, "Select *from departments");
            } else if ($_SESSION['title'] == 'lecturer') {
                $user = $_SESSION['userid'];
                $querycheck = mysqli_query($conn, "Select *from lecturers where lecturer_id='$user'");
                $rows = mysqli_fetch_assoc($querycheck);
                $dp = $rows['dep_id'];
                $queryselec_dept = mysqli_query($conn, "Select *from departments where dep_id='$dp';");
            } else {
                $user = $_SESSION['userid'];
                $querycheck = mysqli_query($conn, "Select *from students where student_id='$user'");
                $rows = mysqli_fetch_assoc($querycheck);
                $dp = $rows['dep_name'];
                $queryselec_dept = mysqli_query($conn, "Select *from departments where dep_id='$dp';");
            }

            while ($rowdepartments = mysqli_fetch_assoc($queryselec_dept)) {
            ?>
                <div class=" my-5 px-3">
                    <h3>Department of <span class=" text-success"><?php echo $rowdepartments['dep_name'] ?></span></h3>
                    <hr>
                    <?php
                    $depid = $rowdepartments['dep_id'];
                    $queryselec_courses = mysqli_query($conn, "Select *from courses where dep_id='$depid' ORDER BY year ASC,semester ASC;");
                    $row_check_courses = $queryselec_courses->num_rows;
                    if ($row_check_courses > 0) {
                    ?>
                        <div class=" my-4 table-responsive-md">
                            <table class=" table table-dark table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:20%">Course Id</th>
                                        <th style="width:20%">Course Name</th>
                                        <!-- <th>Department Name</th> -->
                                        <th style="width:10%">Year</th>
                                        <th style="width:10%">Semester</th>
                                        <th style="width:30%">Lecturer</th>
                                        <?php
                                        if ($_SESSION['title'] == 'admin') {
                                        ?>
                                            <th class="text-center" style="width:10%">Actions</th>
                                        <?php
                                        }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($rowcourses = mysqli_fetch_assoc($queryselec_courses)) {
                                    ?>
                                        <tr style="cursor: pointer;">
                                            <td><?php echo $rowcourses['course_id'] ?></td>
                                            <td><?php echo $rowcourses['course_name'] ?></td>
                                            <!-- <td><?php echo $rowcourses['co_id'] ?></td> -->
                                            <td><?php echo $rowcourses['year'] ?></td>
                                            <td><?php echo $rowcourses['semester'] ?></td>
                                            <td><?php
                                                if (empty($rowcourses['lecturer'])) {
                                                    echo "Empty";
                                                } else {
                                                    echo $rowcourses['lecturer'];
                                                } ?></td>
                                            <?php
                                            if ($_SESSION['title'] == 'admin') { ?>
                                                <td class=" text-center"><a id="edit" href="../crud/edit_course.php?id=<?php echo $rowcourses['course_id'] ?> & name=<?php echo $rowcourses['course_name'] ?>
                                            "><i class="fa fa-edit"></i></a>
                                                    <a href="../crud/delete_course.php?id=<?php echo $rowcourses['course_id'] ?>" class="" id="trash"><i class="fa fa-trash"></i></a>
                                                <?php
                                            }
                                                ?>
                                                </td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>

                            </table>
                        </div>
                    <?php
                    } ?>
                </div>
            <?php
            }
            ?>
            <form action="" method="POST">
                <div class="modal fade" id="exampleModal" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h3>Do you really want to Log out?</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">No</button>
                                <a href="../actions/logout.php" class="btn btn-lg btn-primary">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form action="" method="POST">
                <div class="modal fade" id="addcourses" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h3 class=" text-black-50 fw-bold">Add Course</h3>
                                <button class=" btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="course_id" class=" small">Course Id</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="course_id" class=" form-control py-2" placeholder="eg:BCIT1100" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="course_name" class=" small">Course name</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="course_name" class=" form-control py-2" placeholder="eg:C Programming" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="dept_name" class=" small">Department name</label>
                                    </div>
                                    <div class="col-8">
                                        <select name="dept" class="form-select">

                                            <?php
                                            $query = mysqli_query($conn, "Select *from departments;");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                <option value="<?php echo $row['dep_id'] ?>"> <?php echo $row['dep_name'] ?></option>
                                            <?php  }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="year" class=" small">Year</label>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select" name="year">
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="semester" class=" small">Semester</label>
                                    </div>
                                    <div class="col-8">
                                        <select class="form-select" name="semester">
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="lecturer" class=" small">Lecturer</label>
                                    </div>
                                    <div class="col-8">
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
                            </div>
                            <div class="d-flex border-top-1 p-3 flex-row justify-content-end">

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- <input type="button" class="btn btn-primary" value="Update" name="update"> -->
                                    <button name="submit" data-bs-dismiss="modal" class="btn btn-primary w-100">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            if (isset($_POST['submit'])) {
                $cid = $_POST['course_id'];
                $cname = $_POST['course_name'];
                $depid = $_POST['dept'];
                $year = $_POST['year'];
                $semester = $_POST['semester'];
                $lecturer = $_POST['lecturer'];
                if (!empty($cid) && !empty($cname) && !empty($depid) && !empty($year) && !empty($semester)) {
                    $query = mysqli_query($conn, "insert into courses(course_id,course_name,dep_id,year,semester,lecturer) 
                    values ('$cid','$cname','$depid','$year','$semester','$lecturer'); ");
                    if ($query) {
                        // header("location:courses.php");
                        // echo "Successfull";
            ?>
                        <script type=text/javascript>
                            window.location.href = "courses.php";
                        </script>
                    <?php
                    } else { ?>
                        <script type="text/javascript">
                            alert("Some error occured");
                        </script>
                    <?php
                    }
                } else {
                    ?>

                    <script type="text/javascript">
                        alert("Please fill all data");
                    </script>
            <?php }
            }
            ?>
        </div>
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
</body>