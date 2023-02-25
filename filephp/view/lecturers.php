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
                    <img src="images/logo.png" class="img-container w-25">
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
                <a href="lecturers.php " class=" active nav-link"><i class="fas fa-chalkboard-teacher me-1"></i>Lecturers</a>
                <a href="courses.php" class=" nav-link"><i class="fas fa-book-reader me-1"></i>Courses</a>
                <a href="settings.php" class=" nav-link"><i class="fa fa-cog me-1"></i>Settings</a>
                <button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Log out
                </button>
            </div>
        </div>
        <div class="right">
            <div class="bg-light px-3 d-flex justify-content-between py-4">
                <h4 class="left me-auto  text-black">Lecturers:<span class="h3 text-primary fw-bold">
                        <?php
                        if ($_SESSION['title'] == 'admin') {
                            $query_count = mysqli_query($conn, "Select COUNT(lecturer_id) as num_lec from lecturers;");
                            $row_num_lec = mysqli_fetch_assoc($query_count);
                            echo $row_num_lec['num_lec'];
                        }
                        ?>
                    </span></h4>
                <?php
                if ($_SESSION['title'] == 'admin') {
                ?>
                    <input type="button" value="Add +" class="btn rounded-pill w-25 fw-bold btn-success " onclick="window.location.href='../crud/add_lecturer.php'">
                <?php
                }
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
                </style>
            </div>
            <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus mollitia necessitatibus quo voluptate assumenda ad dolorum fugit porro esse tempore! Libero amet obcaecati ab minus odio facere blanditiis adipisci eum!</p> -->
            <?php
            if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                $queryselec_dept = mysqli_query($conn, "Select *from departments");
            } else if ($_SESSION['title'] == 'student') {
                $sid = $_SESSION['userid'];
                $queryselec_std = mysqli_query($conn, "Select *from students where student_id='$sid'");
                $dep_fecth = mysqli_fetch_assoc($queryselec_std);
                $dep = $dep_fecth['dep_name'];
                $queryselec_dept = mysqli_query($conn, "Select *from departments where dep_id='$dep'");
            }

            while ($rowdepartments = mysqli_fetch_assoc($queryselec_dept)) {
            ?>
                <div class=" my-5 px-3">
                    <h3>Department of <span class=" text-success"><?php echo $rowdepartments['dep_name'] ?></span></h3>
                    <hr>
                    <?php
                    $depid = $rowdepartments['dep_id'];
                    $queryselec_lecturers = mysqli_query($conn, "Select *from lecturers where dep_id='$depid';");
                    $row_query_lecturers = $queryselec_lecturers->num_rows;
                    if ($row_query_lecturers > 0) {
                    ?>
                        <div class=" my-4 table-responsive-md">
                            <table class=" table table-dark table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th class="w-25">Lecturer Id</th>
                                        <th class="w-25">Lecturer Name</th>
                                        <!-- <th>Department Name</th> -->
                                        <th style=" width: 20%">Gender</th>
                                        <th style="width: 20%;">Contact</th>
                                        <?php
                                        if ($_SESSION['title'] == 'admin') {
                                        ?>
                                            <th class="text-center" style="width: 10%;">Actions</th>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($rowlecturers = mysqli_fetch_assoc($queryselec_lecturers)) {
                                    ?>
                                        <tr style="cursor: pointer;">
                                            <td><?php echo $rowlecturers['lecturer_id'] ?></td>
                                            <td><?php echo $rowlecturers['lecturer_name'] ?></td>
                                            <!-- <td><?php echo $rowcourses['co_id'] ?></td> -->
                                            <td><?php echo $rowlecturers['gender'] ?></td>
                                            <td><?php echo $rowlecturers['contact'] ?></td>
                                            <?php
                                            if ($_SESSION['title'] == 'admin') {
                                            ?>

                                                <td class="text-center">
                                                    <a class=" " id="edit" href="../crud/edit_lecturer.php?id=<?php echo $rowlecturers['lecturer_id'] ?> & name=<?php echo $rowlecturers['lecturer_name'] ?>
                                        "><i class="fa fa-edit"></i></a>
                                                    <a href="view_lecturer.php?id=<?php echo $rowlecturers['lecturer_id'] ?> " class="text-white"><i class="fa fa-eye"></i></a>
                                                    <!-- <button class="btn btn-outline-primary" onlick="window.location.href='../crud/edit_lecturer.php?id=<?php echo $rowlecturers['lecturer_id'] ?>'& name=<?php echo $rowlecturers['lecturer_name'] ?>"><i class="fa fa-edit"></i></button> -->
                                                    <a id="trash" href="../crud/delete_lecturer.php?id=<?php echo $rowlecturers['lecturer_id'] ?>" class=""><i class="fa fa-trash"></i></a>
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
    </div>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>