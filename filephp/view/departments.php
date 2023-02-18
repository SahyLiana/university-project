<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <script src="alert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="alert/dist/sweetalert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .card {
            /* transition: .5s; */
            border-radius: 20px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3)
        }

        /* .card:hover {
            transform: scale(1.05);
        } */

        .card_violet,
        .card_violet .title .fa {
            background: linear-gradient(-45deg, #000, #9a4eff);
        }
    </style>
</head>

<body>
    <?php require('../config/config.php');
    // $title = $_SESSION['title'];
    if (!isset($_SESSION['username'])) {
        header('location:admin.php');
    }
    if ($_SESSION['title'] != 'admin') {
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
                <a href="dashboard.php" class=" nav-link ">Home</a>
                <a href="departments.php" class="active nav-link">Departments</a>
                <?php
                if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                ?><a href="students.php" class=" nav-link">Students</a>
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
        <div class="right  ">
            <div class="bg-light px-3 d-flex justify-content-between  py-4">
                <h4 class="left me-auto  text-black">Departements</h4>

                <input type="button" value="Add +" class="btn w-25 fw-bold btn-success rounded-pill " data-bs-toggle="modal" data-bs-target="#adddepartment">
            </div>
            <div class="px-4 py-5"> <?php
                                    if (isset($_POST['submit'])) {
                                        $dpt_id = $_POST['dep_id'];
                                        $dpt_name = $_POST['dep_name'];
                                        if (!empty($dpt_id) && !empty($dpt_name)) {
                                            $query = mysqli_query($conn, "insert into departments(dep_id,dep_name) values ('$dpt_id','$dpt_name');");
                                            if ($query) {
                                                echo "Added succussfull";
                                            } else {
                                                echo "Insert error";
                                            }
                                        } else {
                                            echo "Empty input";
                                        }
                                    }
                                    ?>
                <div class="d-flex  w-100 flex-wrap px-3 gap-2">
                    <style>
                        .test_flex {
                            width: 400px;
                            flex-grow: 1;
                        }

                        /* @media only screen and (max-width:1000px) {
                            .text_flex {
                                width: 100%;
                                flex-grow: 1;
                            }
                        } */
                    </style>
                    <?php
                    $query = mysqli_query($conn, "Select *from departments;");
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <form action="" class=" test_flex card p-0  mb-5  border" method="POST">

                            <!-- <div class="col-4"> -->
                            <!-- <div clas=""> -->
                            <div style="cursor: pointer;" class="card-body py-5">
                                <div class="card-text text-center  p-1 ">
                                    <h3 class=" "><span class="fw-bold text-black-50 me-1 ">Department ID:</span><span class=""><?php echo $row['dep_id'] ?></span></h3>
                                    <h3 class=" "><span class="fw-bold text-black-50 me-1 ">Department Name:</span><span class=""><?php echo $row['dep_name'] ?></span></h3>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center px-3 py-2">
                                <div class="me-auto">
                                    <p class="fw-bold p-0 m-0 text-black-50" style=" font-size:15px">Nbr of lecturers:<span class="h5 fw-bold text-success">
                                            <?php
                                            $did = $row['dep_id'];
                                            $querycount = mysqli_query($conn, "Select COUNT(lecturer_id) as number_lec from lecturers where dep_id='$did'");
                                            $count = mysqli_fetch_assoc($querycount);
                                            echo $count['number_lec'];
                                            ?></span></p>
                                    <p class="fw-bold text-black-50" style=" font-size:15px">Nbr of students:<span class="h5 fw-bold text-primary">
                                            <?php
                                            $dsid = $row['dep_id'];
                                            $querycountstudent = mysqli_query($conn, "Select COUNT(student_id) as number_std from students where dep_name='$dsid'");
                                            $countstd = mysqli_fetch_assoc($querycountstudent);
                                            echo $countstd['number_std'];
                                            ?>
                                        </span></p>
                                </div>
                                <div class=" p-2 d-flex flex-row">
                                    <!-- <input type="button" value="test" class="btn w-25 fw-bold btn-success " data-bs-toggle="modal" data-bs-target="#deletemodal"> -->
                                    <!-- <input type="button" class="btn btn-success w-50 me-1 btn" data-bs-toggle="modal" data-bs-target="#editmodal" value="Edit" /> -->
                                    <a href="../crud/update.php?id=<?php echo $row['dep_id'] ?> & name=<?php echo $row['dep_name'] ?>" class="btn btn-outline-success  border-2 rounded-pill w-50 me-1"><i class=" fa fa-edit"></i></a>
                                    <!-- <a href="delete.php?id=<?php echo $row['dep_id'] ?>" class="btn btn-success w-50 me-1">Delete</a> -->
                                    <a onclick="test()" href="../actions/delete.php?id=<?php echo $row['dep_id']; ?>" class="btn btn-outline-danger border-2 rounded-pill w-50 btn" name="delete"><i class="fa fa-trash"></i></a>
                                    <!-- <input type="button" value="Delete" class="btn w-50 fw-bold btn-danger " data-bs-toggle="modal" data-bs-target="#deletemodal"> -->
                                    <!-- <form action="" method="POST">
                                    <div class="modal fade" id="deletemodal" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <h3>Do you really want to delete <?php echo $row['dep_id']  ?>?</h3>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">No</button>
                                                    <a href="delete.php?id=<?php echo $row['dep_id']; ?>" class=" btn btn-lg btn-primary">Yes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form> -->
                                    <!-- <button onclick="window.location.href = 'delete.php?id=<?php echo $row['dep_id']; ?>;'" id="myButton" name="delete" class="btn btn-danger w-50 btn">Delete</button> -->
                                    <!-- </div> -->
                                </div>
                            </div>
                            <!-- </div> -->



                            <!-- <form action="" method="POST">
                                <div class="modal fade" id="editmodal" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class=" modal-header bg-light">
                                                <h3>Edit <?php echo "$row[dep_name]" ?></h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <label for="depname">Dept name:</label>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" name="deptmname" id="deptmname" class=" form-control" placeholder="Department name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer"> -->
                            <?php
                            // if (isset($_POST['sub'])) {
                            //     $_SESSION['dname'] = $_POST['deptmname'];
                            //     $_SESSION['ddid'] = $row['dep_id'];
                            //     // echo $_POST['depname'];
                            //     $v = $_SESSION['dname'];
                            //     // echo $v;
                            //     header('location:update.php');
                            // }
                            // if (isset($_POST['sub'])) {
                            //     // echo $row['dep_id'];
                            //     // $_SESSION['ddid'] = $row['dep_id'];
                            //     // echo $_SESSION['ddid'];
                            //     $vn = $_POST['deptmname'];
                            //     // $_SESSION['vname'] = $vn;
                            //     header('location:update.php');
                            // }
                            ?>
                            <!-- <button onclick="window.location.href='https://w3docs.com';">
                                                    Click Here
                                                </button> -->
                            <!-- <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Cancel</button> -->
                            <!-- <button class="text-white btn btn-lg btn-primary" name="sub">Submit</button> -->
                            <!-- <button name="sub" class="btn btn-lg btn-primary">
                                                    Submit</button> -->
                            <!-- <a href="#" class="text-white w-100 h-100">Submit</a></button> -->
                            <!-- <a href="update.php?id=<?php echo $row['dep_id']; ?> & dn=<?php echo $vn ?>" class="text-white btn-lg btn btn-primary">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </form> -->
                            <!-- </div> -->
                        </form>

                    <?php  } ?>
                </div>
            </div>
            <form action="" method="POST">
                <div class="modal fade" id="adddepartment" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h3 class=" text-black-50 fw-bold">Add department</h3>
                                <button class=" btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <!-- <div class="col-3">
                                        <label for="dep_id" class=" small">Department Id</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="dep_id" class=" form-control py-2" placeholder="eg:BCIT" />
                                    </div> -->
                                    <div class="form-floating">
                                        <input type="text" name="dep_id" placeholder="Nice" class=" form-control" id="dep_id" />
                                        <label for="dep_id" class="px-3 form-label">Department Id</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <!-- <div class="col-3">
                                        <label for="dep_name" class=" small">Department name</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="dep_name" class=" form-control py-2" placeholder="eg:Computer and IT" />
                                    </div> -->
                                    <div class="form-floating">
                                        <input type="text" name="dep_name" placeholder="Nice" class=" form-control" id="dep_name" />
                                        <label for="dep_name" class="px-3 form-label">Department name</label>
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

            <!-- <form action="" method="POST">
            <div class="modal fade" id="deletedept" data-bs-keyboard="true" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3>Do you really want to delete?</h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">No</button>
                            <button class="btn btn-lg btn-primary">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> -->
        </div>
    </div>

    <script type="text/javascript">
        function test() {

            var conf = confirm("Are you sure?");
            if (conf == false) {
                event.preventDefault();
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>