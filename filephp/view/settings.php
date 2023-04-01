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

        <div class="h-100  sidebar align-items-stretch  navbar navbar-dark bg-dark ">
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
                if ($_SESSION['title'] == 'student') { ?>
                    <a href="exam_registration.php" class=" nav-link"><i class=" fa fa-registered me-1"></i>Register for exam</a>
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
                <a href="courses.php" class=" nav-link"><i class="fas fa-book-reader me-1"></i>Courses</a>
                <a href="settings.php " class="active_link mx-2"><i class="fa fa-cog me-1"></i>Settings</a>
                <button type="button" class="btn btn-danger my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Log out
                </button>

            </div>
        </div>
        <div class="right">
            <div class="bg_top py-4 px-3">
                <h3 class="text-white" style="font-family:Georgia, 'Times New Roman', Times, serif"><i class="fa fa-cog me-1"></i>Settings</h3>
            </div>
            <div class=" px-3 my-3">
                <p>Welcome Mr/Mrs <span class=" lead"><?php echo $_SESSION['username'] ?></span></p>
                <input type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateaccount" value="Update Account">

                <?php

                if (isset($_POST['update'])) {
                    $old = $_POST['old'];
                    $new = $_POST['new'];
                    $confirm = $_POST['confirm'];
                    $username = $_SESSION['username'];
                    if (!empty($new) && !empty($confirm)) {
                        if ($new != $confirm) {
                            echo " <p class=' me-auto fw-bold text-danger'>Password mismatched...</p>";
                ?>
                            <?php
                        } else {
                            //echo "<p class=' me-auto fw-bold text-success'> Update successfull!</p>";
                            if ($_SESSION['title'] == "admin") {
                                // $old = $_POST['old'];
                                // $new = $_POST['new'];
                                // $confirm = $_POST['confirm'];
                                $query_check = mysqli_query($conn, "Select *from admin where username='$username' AND password='$old'");
                                $row = $query_check->num_rows;
                                if ($row == 1) {
                                    $update = mysqli_query($conn, "Update admin set password='$new' where username='$username'");
                                    if ($update) {
                                        echo "<p class=' me-auto fw-bold text-success'> Update successfull!</p>";
                                    } else {
                                        echo "<p class=' me-auto fw-bold text-danger'>Some error occured</p>";
                                    }
                                } else {
                            ?>
                                    <script type="text/javascript">
                                        alert("Your old password is wrong...");
                                    </script>
                                <?php
                                }
                            } else if ($_SESSION['title'] == 'lecturer' || $_SESSION['title'] == 'student') {
                                $old = md5($_POST['old']);
                                $new = md5($_POST['new']);
                                $confirm = md5($_POST['confirm']);
                                $userid = $_SESSION['userid'];
                                $query_check = mysqli_query($conn, "Select *from users where userid='$userid' AND password='$old'");
                                $row = $query_check->num_rows;
                                if ($row == 1) {
                                    $update = mysqli_query($conn, "Update users set password='$new'");
                                    if ($update) {
                                        echo "<p class=' me-auto fw-bold text-success'>Update successfull!</p>";
                                    } else {
                                        echo "<p class=' me-auto fw-bold text-danger'>Some error occured</p>";
                                    }
                                } else {
                                ?>
                                    <script type="text/javascript">
                                        alert("Your old password is wrong...");
                                    </script>
                <?php
                                }
                            }
                        }
                    } else {
                        echo "<p class='fw-bold text-warning'>Empty</p>";
                    }
                }
                ?>
            </div>

            <form action="" method="POST">
                <div class="modal fade" id="updateaccount" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h3 class=" text-black-50 fw-bold">Update your account</h3>
                                <button class=" btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="old" class=" small">Old password</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="password" name="old" class=" form-control py-2" placeholder="Old password" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label for="new" class=" small">New password</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="password" name="new" class=" form-control py-2" placeholder="New password" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <label for="confirm" class=" small">Confirm password</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="password" name="confirm" class=" form-control py-2" placeholder="Confirm password" />
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex border-top-1 p-3 flex-row justify-content-end">

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- <input type="button" class="btn btn-primary" value="Update" name="update"> -->
                                    <button name="update" data-bs-dismiss="modal" class="btn btn-primary w-100">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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