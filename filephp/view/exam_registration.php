<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
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
                <div class="w-100 d-flex bg-black flex-row text-white align-items-end">
                    <img src="images/logo.png" class="img-container w-25">
                    <h3 class="fw-bold w-100 text-center">School Panel</h3>
                </div>
                <p class=" ps-3 pt-3 text-white-50"> Welcome <?php echo $_SESSION['username'] ?></p>
                <a href="dashboard.php" class=" nav-link ">Home</a>
                <?php
                if ($_SESSION['title'] == "admin") {
                ?>
                    <a href="departments.php" class=" nav-link">Departments</a>
                <?php
                } ?>
                <?php
                if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                ?><a href="students.php" class=" nav-link">Students</a>
                <?php
                }
                ?>
                <?php
                if ($_SESSION['title'] == 'student') { ?>
                    <a href="exam_registration.php" class="active nav-link">Register for exam</a>
                <?php
                }
                ?>
                <a href="lecturers.php" class=" nav-link">Lecturers</a>
                <a href="courses.php" class=" nav-link">Courses</a>
                <a href="settings.php" class=" nav-link">Settings</a>
                <button type="button" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Log out
                </button>
            </div>
        </div>
        <div class="right">
            <div class="bg-light py-4 px-3 ">
                <h4 class=" text-black">Registration</h4>
            </div>
            <div class="px-3 py-5">
                <!-- <div class="mb-3 bg-light p-3">
                    <h2 class="bg-light text-primary text-center">New User,register here</h2>
                </div> -->
                <form action="" method="POST">
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="user_id" class=" small">User Id</label>
                        </div>
                        <div class="col-5">
                            <input type="text" name="user_id" class=" form-control py-2" />
                        </div>
                    </div>
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="username" class=" small">User name</label>
                        </div>
                        <div class="col-5">
                            <input type="text" name="username" class=" form-control py-2" placeholder="eg:John Doe" />
                        </div>
                    </div>
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="dep_name" class=" small">Department name</label>
                        </div>
                        <div class="col-5">
                            <select name="dep_name" class="form-select">
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
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="gender" class=" small">Gender</label>
                        </div>
                        <div class="col-5">
                            <input type="radio" name="gender" value="M">Male
                            <input type="radio" name="gender" value="F">Female
                        </div>
                    </div>
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="password" class=" small">Password</label>
                        </div>
                        <div class="col-5">
                            <input type="password" name="password" class=" form-control py-2" />
                        </div>
                    </div>
                    <div class="row ps-3 mb-3">
                        <div class="col-2">
                            <label for="confirm_password" class=" small">Confirm password</label>
                        </div>
                        <div class="col-5">
                            <input type="password" name="confirm_password" class=" form-control py-2" />
                        </div>
                    </div>

                    <!-- <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="contact" class=" small">Contact</label>
                </div>
                <div class="col-5">
                    <input type="text" name="contact" required class="  form-control py-2" placeholder="eg:+86-1234567" />
                </div>
            </div> -->
                    <div class="d-flex border-top-1 p-3 flex-row justify-content-end">

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" name="register">Register</button>
                            <button name="cancel" class="btn btn-secondary w-100">Cancel</button>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['cancel'])) {
                        // header("location:admin.php");
                    ?>
                        <script type="text/javascript">
                            window.location.href = "admin.php";
                        </script>
                        <?php
                    } else if (isset($_POST['register'])) {
                        $userid = $_POST['user_id'];
                        $username = $_POST['username'];
                        $dep_name = $_POST['dep_name'];
                        $gender = $_POST['gender'];
                        $password = md5($_POST['password']);
                        $confirm_password = md5($_POST['confirm_password']);
                        if (
                            !empty($userid) && !empty($username) && !empty($dep_name)
                            && !empty($gender) && !empty($password) && !empty($confirm_password)
                        ) {
                            // echo $userid . "," . $username . "," . $dep_name . "," . $gender . "," . $password . "," . $confirm_password;
                            $checklecturer = mysqli_query($conn, "Select *from lecturers where lecturer_id='$userid'
                    AND lecturer_name='$username' AND dep_id='$dep_name' AND gender='$gender'");
                            $checkstudents = mysqli_query($conn, "Select *from students where student_id='$userid'
                    AND student_name='$username' AND dep_name='$dep_name' AND gender='$gender'");
                            $row_count_lecturer = $checklecturer->num_rows;
                            $row_count_student = $checkstudents->num_rows;
                            if ($row_count_lecturer == 1) {
                                //$row = mysqli_fetch_assoc($checklecturer);
                                if ($password == $confirm_password) {
                                    $insert_lecturer = mysqli_query($conn, "Insert into users(userid,username,dep_id,gender,password,title) 
                            values('$userid','$username','$dep_name',
                            '$gender','$password','lecturer');");
                                    if ($insert_lecturer) {
                                        // header("location:admin.php");
                        ?>
                                        <script type="text/javascript">
                                            window.location.href = "admin.php";
                                        </script>
                                    <?php
                                    } else {
                                    ?>
                                        <script type="text/javascript">
                                            alert("This user already exist");
                                        </script>
                                    <?php
                                    }
                                } else {
                                    echo "Password and confirm password mismatched";
                                }
                            } else if ($row_count_student == 1) {
                                //$row = mysqli_fetch_assoc($checkstudents);
                                if ($password == $confirm_password) {
                                    echo $userid . ',' . $username . ',' . $dep_name . ',' . $gender . ',' . $password;
                                    $insert_student = mysqli_query($conn, "Insert into users(userid,username,dep_id,gender,password,title)
                            values('$userid','$username','$dep_name','$gender','$password','student');");
                                    if ($insert_student) {
                                        // header("location:admin.php");
                                    ?>
                                        <script type="text/javascript">
                                            window.location.href = "admin.php";
                                        </script>
                                    <?php
                                    } else {
                                    ?>
                                        <script type="text/javascript">
                                            alert("This user already exists");
                                        </script>
                                <?php
                                    }
                                } else {
                                    echo "Password and confirm password mismatched";
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("User doesn't exist in our system,please go to our office.");
                                </script>
                    <?php
                            }
                        }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>