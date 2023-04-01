<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="../../../myproject/cssfiles/style.css"> -->

</head>

<body>
    <style>
        .bg_top {
            background-color: darkseagreen;
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

        .active_link {
            background-color: darkseagreen;
            padding: 10px 10px;
            border-radius: 20px;
            text-decoration: none;
            color: white
        }
    </style>
    <?php require('../config/config.php');
    if (!isset($_SESSION['username']) && !isset($_SESSION['title'])) {
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
        <div class="h-100 sidebar align-items-stretch navbar navbar-dark bg-dark ">
            <div class="nav flex-column w-100  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="w-100 d-flex bg-dark flex-row text-white align-items-center">
                    <img src="images/kulg.jpg" class="img-container w-25">
                    <h3 class="fw-bold w-100  text-center">School Panel</h3>
                </div>
                <div class="px-2 w-100 align-items-center d-flex mb-2">
                    <img src="../userimage/avatar.jpg" class="" width="30px">
                    <p class="ps-2 pt-3  text-white-50"> Welcome <?php echo $_SESSION['username'] ?></p>
                </div>
                <a href="dashboard.php" class="mx-2 active_link"><i class="fa fa-home me-1"></i>Home</a>
                <?php
                if ($_SESSION['title'] == "admin") {
                ?>
                    <a href="departments.php" class=" nav-link"><i class="fas fa-school me-1"></i>Departments</a>
                <?php
                } ?>
                <?php
                if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                ?><a href="students.php" class=" nav-link"><i class="fas fa-graduation-cap me-1"></i>Students</a>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['title'] == 'student') { ?>
                    <a href="exam_registration.php" class=" nav-link"><i class=" fa fa-registered me-1"></i>Register for exam</a>
                <?php
                }
                ?>
                <a href="lecturers.php" class=" nav-link"><i class="fas fa-chalkboard-teacher me-1"></i>Lecturers</a>
                <a href="courses.php" class=" nav-link"><i class="fas fa-book-reader me-1"></i>Courses</a>
                <a href="settings.php" class=" nav-link"><i class="fa fa-cog me-1"></i>Settings</a>
                <button type="button" class="btn btn-danger my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Log out
                </button>
            </div>
        </div>
        <div class="right ">
            <div class="bg_top py-4 d-flex  justify-content-between px-3 ">
                <h3 class=" text-white" style="font-family:Georgia, 'Times New Roman', Times, serif"><i class="fa fa-home me-1"></i>Home</h3>
                <?php

                if ($_SESSION['title'] == 'student') {
                    $stdId = $_SESSION['userid'];
                ?>
                <?php
                }
                ?>
            </div>
            <div class="px-3 py-5 h-100 ">
                <p class="text-center fw-bold text-success h1" style="font-family:Georgia, 'Times New Roman', Times, serif">
                    KAMPALA UNIVERSITY WELCOMES YOU!</p>
                <div class=" w-50 bg-success  mx-auto" style=" height:3px;"></div>

                <div class="d-flex flex-wrap mx-auto mt-5 align-items-start gap-3 w-100" style="font-family:Georgia, 'Times New Roman', Times, serif">
                    <div class="bg-primary card px-4 py-2" style="width:250px; height:150px">
                        <?php
                        $query_dept = mysqli_query($conn, "Select *from departments;");
                        $total_dept = $query_dept->num_rows;
                        ?>
                        <p class="text-white p-0 m-0 fw-bold fs-3"><?php echo $total_dept ?></p>
                        <p class="text-white" style=" font-family:'Courier New', Courier, monospace">Total Departments</p>
                    </div>
                    <div class="bg-success card px-4 py-2" style="width:250px; height:150px">
                        <?php
                        if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                            $query_lec = mysqli_query($conn, "Select *from lecturers;");
                            $total_lec = $query_lec->num_rows;
                        } else if ($_SESSION['title'] == 'student') {
                            $stdid = $_SESSION['userid'];
                            $query_check_std = mysqli_query($conn, "Select *from students where student_id='$stdid'");
                            $rows_std_fetch = mysqli_fetch_assoc($query_check_std);
                            $depid = $rows_std_fetch['dep_name'];
                            $query_lec = mysqli_query($conn, "Select *from lecturers where dep_id='$depid'");
                            $total_lec = $query_lec->num_rows;
                        }
                        ?>
                        <p class="text-white p-0 m-0 fw-bold fs-3"><?php echo $total_lec ?></p>
                        <p class="text-white" style=" font-family:'Courier New', Courier, monospace">Total Lecturers</p>
                    </div>
                    <div class=" card " style="width:250px; height:150px;background-color: orange">
                        <div class="px-4 py-2 card-body">
                            <div class="card-text">
                                <?php
                                if ($_SESSION['title'] == 'admin') {
                                    $query_std = mysqli_query($conn, "Select *from students;");
                                    $total_std = $query_std->num_rows;
                                } else if ($_SESSION['title'] == 'lecturer') {
                                    $lecid = $_SESSION['userid'];
                                    $query_check_lec = mysqli_query($conn, "Select *from lecturers where lecturer_id='$lecid'");
                                    $rows_lec_fetch = mysqli_fetch_assoc($query_check_lec);
                                    $depid = $rows_lec_fetch['dep_id'];
                                    $query_std = mysqli_query($conn, "Select *from students where dep_name='$depid'");
                                    $total_std = $query_std->num_rows;
                                } else if ($_SESSION['title'] == 'student') {
                                    $query_std = mysqli_query($conn, "Select *from students;");
                                    $total_std = $query_std->num_rows;
                                }
                                ?>
                                <p class="text-white p-0 m-0 fw-bold fs-3"><?php echo $total_std ?></p>
                                <p class="text-white" style=" font-family:'Courier New', Courier, monospace">Total Students</p>
                            </div>
                        </div>
                        <?php
                        if ($_SESSION['title'] == 'admin') {
                        ?>
                            <div class="card-footer p-1 d-flex bg-white gap-1 text-black text-center">
                                <button onclick="window.location.href='../actions/enable_registration.php'" class="btn btn-success flex-grow-1" style="font-size:10px">Enable Account</button>
                                <button onclick="window.location.href='../actions/disable_registration.php'" class="btn btn-danger flex-grow-1" style="font-size:10px">Disable Account</button>
                            </div><?php
                                } ?>
                    </div>
                    <div class="bg-danger card px-4 py-2" style="width:250px; height:150px">
                        <p class="text-white p-0 m-0 fw-bold fs-3">0</p>
                        <p class="text-white" style=" font-family:'Courier New', Courier, monospace">Warnings</p>
                    </div>
                    <div class=" card" style="width:250px; height:150px;background-color: rgb(13, 10, 110)">
                        <div class="card-body d-flex align-items-center justify-content-center px-4 py-2">
                            <div class="card-text fs-3  text-center  text-white">
                                <p><i class="fab fa-facebook-f"></i></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-black text-center">
                            ku@fb.ac
                        </div>
                    </div>
                    <div class="card " style="width:250px; height:150px;background-color:rgb(16, 242, 16)">
                        <div class="card-body d-flex align-items-center justify-content-center px-4 py-2">
                            <div class="card-text fs-2 text-center text-white">
                                <p><i class="fab fa-whatsapp"></i></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-black text-center">
                            ku.ac.whatsapp
                        </div>
                    </div>
                    <?php
                    if ($_SESSION['title'] == 'student') {
                    ?>
                        <div class="card " style="width:250px; height:150px;background-color:white">
                            <div class="card-body d-flex align-items-center justify-content-center px-4 py-2">
                                <div class="card-text fs-2 text-center text-success">
                                    <p><i class="fas fa-book-reader"></i></p>
                                </div>
                            </div>
                            <div class="card-footer p-1 bg-white text-black">
                                <a href="myResult.php?id=<?php echo $stdId ?>" class="btn h-100 w-100 btn-success">View my Result</a>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                </div>
            </div>
        </div>
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
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>