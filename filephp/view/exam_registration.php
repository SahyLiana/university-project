<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <style>
        .right .bg_top {
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
        <div class="h-100 sidebar align-items-stretch  navbar navbar-dark bg-dark ">
            <div class="nav flex-column w-100  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="w-100 d-flex bg-dark flex-row text-white align-items-center">
                    <img src="images/kulg.jpg" class="img-container w-25">
                    <h3 class="fw-bold w-100 text-center">School Panel</h3>
                </div>
                <div class="px-2 w-100 align-items-center d-flex mb-2">
                    <img src="../userimage/avatar.jpg" class="" width="30px">
                    <p class="ps-2 pt-3  text-white-50"> Welcome <?php echo $_SESSION['username'] ?></p>
                </div>
                <a href="dashboard.php" class=" nav-link "><i class="fa fa-home me-1"></i>Home</a>
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
                    <a href="exam_registration.php" class="active_link mx-2"><i class=" fa fa-registered me-1"></i>Register for exam</a>
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
        <div class="right">
            <div class="bg_top d-flex flex-row justify-content-between py-4 px-3 ">
                <h4 class=" text-white"><i class=" fa fa-registered me-1"></i>Registration</h4>
                <a class="btn btn-success " href="myRegistration.php?id=<?php echo $_SESSION['userid'] ?>">View my Registration</a>
            </div>
            <div class="px-3 py-5">
                <!-- <div class="mb-3 bg-light p-3">
                    <h2 class="bg-light text-primary text-center">New User,register here</h2>
                </div> -->
                <form action="" method="POST">
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="user_id" class=" small">Select your Year</label>
                        </div>
                        <div class="col-5">
                            <!-- <input type="text" name="user_id" class=" form-control py-2" /> -->
                            <select name="year" class="form-select">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="user_id" class=" small">Select your Semester</label>
                        </div>
                        <div class="col-5">
                            <!-- <input type="text" name="user_id" class=" form-control py-2" /> -->
                            <select name="semester" class="form-select">
                                <option value="1">One</option>
                                <option value="2">Two</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex border-top-1 p-3 flex-row justify-content-end">

                        <div class="d-flex gap-2">
                            <?php
                            $stdId = $_SESSION['userid'];
                            $queryCheckRegistrationAccount = mysqli_query($conn, "Select *from register where student_id='$stdId'");
                            $queryFecthAccountStatus = mysqli_fetch_assoc($queryCheckRegistrationAccount);
                            //echo $queryFecthAccountStatus['enable_registration'];

                            ?>
                            <button class="btn btn-primary" <?php
                                                            if ($queryFecthAccountStatus['enable_registration'] == 'no') {
                                                                echo "disabled";
                                                            }
                                                            ?> name="register">Register</button>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['register'])) {
                        $year = $_POST['year'];
                        $sem = $_POST['semester'];
                        // header('location:register_form.php?year=$year & semester=$sem');
                    ?>
                        <script>
                            window.location.href = "register_form.php?year=<?php echo $year ?>& semester=<?php echo $sem ?>";
                        </script>
                    <?php
                    }
                    ?>
                </form>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>