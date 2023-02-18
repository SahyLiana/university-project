<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center">
    <?php require('../config/config.php');


    ?>
    <div class="container p-0 my-auto rounded shadow-sm">
        <div class="mb-3 bg-light p-3">
            <h2 class="bg-light text-primary text-center">New User,register here</h2>
        </div>
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

</body>