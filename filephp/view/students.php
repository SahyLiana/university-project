<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../cssfiles/style.css">

</head>

<body style=" width:100%">
    <div class="d-flex">
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


            /* .left {
    width: 25%;
    } */

            .right {
                width: 75%;
                padding: 0;
                margin-left: 25%;
            }

            .active_link {
                background-color: darkseagreen;
                padding: 10px 10px;
                border-radius: 20px;
                text-decoration: none;
                color: white
            }

            /* .cont {
            max-width: 1200px;
        } */
        </style>
        <?php require('../config/config.php');
        if (!isset($_SESSION['username']) || $_SESSION['title'] == 'student') {
            header('location:admin.php');
        }

        ?>
        <!-- <h1>Welcome <?php echo $_SESSION['username'] ?></h1> -->
        <!-- <div class="d-flex"> -->
        <?php
        // if (isset($_POST['logout'])) {
        //     session_unset();
        //     header('location:admin.php');
        // }
        ?>

        <div class="h-100  sidebar align-items-stretch  navbar navbar-dark bg-dark ">
            <div class="nav flex-column w-100 nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
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
                <a href="students.php" class="active_link mx-2"><i class="fas fa-graduation-cap me-1"></i>Students</a>
                <a href="lecturers.php" class=" nav-link"><i class="fas fa-chalkboard-teacher me-1"></i>Lecturers</a>
                <a href="courses.php" class=" nav-link"><i class="fas fa-book-reader me-1"></i>Courses</a>
                <a href="settings.php" class=" nav-link"><i class="fa fa-cog me-1"></i>Settings</a>
                <button type="button" class="btn btn-danger my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Log out
                </button>
            </div>
        </div>
        <div class="right">
            <div class="bg_top py-4 px-3 d-flex justify-content-between">
                <h3 style=" font-family:Georgia, 'Times New Roman', Times, serif" class="left me-auto  text-white"><i class="fas fa-graduation-cap me-1"></i>Students:<span class="h3 text-primary fw-bold">
                        <?php
                        if ($_SESSION['title'] == 'admin') {
                            $query_count = mysqli_query($conn, "Select COUNT(student_id) as num_std from students;");
                            $row_num_std = mysqli_fetch_assoc($query_count);
                            echo $row_num_std['num_std'];
                        }
                        ?>
                    </span></h3>
                <?php
                if ($_SESSION['title'] == 'admin') {
                ?>
                    <input type="button" class="btn btn-success rounded-pill fw-bold w-25" onclick="window.location.href='../crud/add_student.php'" value="Add +" />
                <?php
                }
                ?>
            </div>
            <div class="py-5 px-4">
                <?php
                if ($_SESSION['title'] == 'admin' || $_SESSION['title'] == 'lecturer') {
                    $queryselec_dept = mysqli_query($conn, "Select *from departments");

                    // $depid = $rowdepartments['dep_id'];
                    // $queryselec_students = mysqli_query($conn, "Select *from students where dep_name='$depid';");
                    // $row_query_students = $queryselec_students->num_rows;
                    while ($rowdepartments = mysqli_fetch_assoc($queryselec_dept)) {

                ?>
                        <div class=" my-5 px-3">
                            <h3>Department of <span class=" text-success"><?php echo $rowdepartments['dep_name'] ?></span></h3>
                            <hr>
                            <?php
                            $ddp = $rowdepartments['dep_id'];
                            $row_std = mysqli_query($conn, "Select *from students where dep_name='$ddp'");
                            // $row_st=mysqli_fetch_assoc($row_std);
                            $row_query_students = $row_std->num_rows;
                            if ($row_query_students > 0) {
                            ?>
                                <div class=" my-4 table-responsive-md">
                                    <table class=" table table-dark table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th class="">Student Id</th>
                                                <th class="">Student Name</th>
                                                <!-- <th>Department Name</th> -->
                                                <th>Gender</th>
                                                <th>DOB</th>
                                                <th>Year</th>
                                                <th>Semester</th>
                                                <th>Date joined</th>
                                                <th>Contact</th>
                                                <?php
                                                // if ($_SESSION['title'] == 'admin') {
                                                ?>
                                                <th>Actions</th>
                                                <?php
                                                // }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            while ($rowstudents = mysqli_fetch_assoc($row_std)) {
                                            ?>
                                                <tr style="cursor: pointer;">
                                                    <td><?php echo $rowstudents['student_id'] ?></td>
                                                    <td><?php echo $rowstudents['student_name'] ?></td>
                                                    <!-- <td><?php echo $rowstudents['dep_name'] ?></td> -->
                                                    <td><?php echo $rowstudents['gender'] ?></td>
                                                    <td><?php echo $rowstudents['dob'] ?></td>
                                                    <td><?php echo $rowstudents['year'] ?></td>
                                                    <td><?php echo $rowstudents['semester'] ?></td>
                                                    <td><?php echo $rowstudents['date_joined'] ?></td>
                                                    <td><?php echo $rowstudents['contact'] ?></td>
                                                    <?php
                                                    if ($_SESSION['title'] == 'admin') {
                                                    ?>
                                                        <td><a id="edit" href="../crud/edit_student.php?id=<?php echo $rowstudents['student_id'] ?> & name=<?php echo $rowstudents['student_name'] ?> & dep_name=<?php echo $rowstudents['dep_name'] ?>
                                "><i class="fa fa-edit"></i></a>
                                                            <a href="view_student.php?id=<?php echo $rowstudents['student_id'] ?> " class="text-white"><i class="fa fa-eye"></i></a>
                                                            <a href="../crud/delete_student.php?id=<?php echo $rowstudents['student_id'] ?> " id="trash" class=""><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    <?php
                                                    } else if ($_SESSION['title'] == 'lecturer') {
                                                        $lec_id = $_SESSION['userid'];
                                                    ?>
                                                        <td><a href="view_result.php?id=<?php echo $rowstudents['student_id'] ?>&lec_id=<?php echo $lec_id; ?>" class="btn btn-success">Marks</a></td>
                                                    <?php
                                                    }
                                                    ?>
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
                }
                        ?><?php
                            // } else if ($_SESSION['title'] == 'lecturer') {
                            //     $uid = $_SESSION['userid'];
                            //     $lec_name = $_SESSION['username'];
                            //     $queryselec_courses = mysqli_query($conn, "Select *from courses WHERE lecturer='$lec_name' ORDER BY dep_id ASC");
                            //     $rows_lec = ($queryselec_courses->num_rows);
                            //     while ($row_course_taught = mysqli_fetch_assoc($queryselec_courses)) {
                            //         // $row_course_taught = mysqli_fetch_assoc($queryselec_courses);
                            //         $year_course = $row_course_taught['year'];
                            //         $semester_course = $row_course_taught['semester'];
                            //         $row_dep = $row_course_taught['dep_id'];
                            //         // $queryselec_lec = mysqli_query($conn, "Select *from lecturers where lecturer_id='$uid'");
                            //         // $row_search = mysqli_fetch_assoc($queryselec_lec);
                            //         // $row_dep = $row_search['dep_id'];
                            //         // $queryselec_dept = mysqli_query($conn, "Select *from departments where dep_id='$row_dep';");
                            //         $queryselec_dept = mysqli_query($conn, "Select * from departments where dep_id='$row_dep' ORDER BY dep_name ASC");

                            //         while ($rowdepartments = mysqli_fetch_assoc($queryselec_dept)) {

                            //     
                            ?>
                        <!-- // <div class=" my-5 px-3">
                        //     <h3>Department of <span class=" text-success"><?php echo $rowdepartments['dep_name'] . ",Course name: " . $row_course_taught['course_name'] . ", year " . $year_course . " semester " . $semester_course ?></span></h3>
                        //     <hr> -->
                        <!-- //     <?php
                                    //             $ddp = $rowdepartments['dep_id'];
                                    //             $row_std = mysqli_query($conn, "Select *from students where dep_name='$ddp' and year='$year_course' and semester='$semester_course'");
                                    //             // $row_st=mysqli_fetch_assoc($row_std);
                                    //             $row_query_students = $row_std->num_rows;
                                    //             if ($row_query_students > 0) {
                                    //     
                                    ?>
                        //         <div class=" my-4 table-responsive-md" style=" overflow:scroll">
                        //             <table class=" table table-dark table-hover table-striped">
                        //                 <thead>
                        //                     <tr>
                        //                         <th class="" style=" width: 20%">Student Id</th>
                        //                         <th class="" style="width:20%">Student Name</th>
                        //                         <!-- <th>Department Name</th> -->
                        <!-- //                         <th style="width:5%">Gender</th>
                        //                         <th style="width:10%">DOB</th>
                        //                         <th style="width:10%">Year</th>
                        //                         <th style="width:5%">Semester</th>
                        //                         <th style="width:10%">Date joined</th>
                        //                         <th style="width:10%">Contact</th>
                        //                         <?php

                                                    //                         
                                                    ?>
                        //                         <th style="width:10%">Actions</th>
                        //                         <?php

                                                    //                         
                                                    ?>
                        //                     </tr>
                        //                 </thead>
                        //                 <tbody>
                        //                     <?php

                                                //                     while ($rowstudents = mysqli_fetch_assoc($row_std)) {
                                                //                     
                                                ?>
                        //                         <tr style="cursor: pointer;">
                        //                             <td style="width:20%"><?php echo $rowstudents['student_id'] ?></td>
                        //                             <td style="width:20%"><?php echo $rowstudents['student_name'] ?></td>
                        //                             <!-- <td><?php echo $rowstudents['dep_name'] ?></td> -->
                        <!-- //                             <td style="width:5%"><?php echo $rowstudents['gender'] ?></td>
                        //                             <td style="width:10%"><?php echo $rowstudents['dob'] ?></td>
                        //                             <td style="width:10%"><?php echo $rowstudents['year'] ?></td>
                        //                             <td style="width:5%"><?php echo $rowstudents['semester'] ?></td>
                        //                             <td style="width:10%"><?php echo $rowstudents['date_joined'] ?></td>
                        //                             <td style="width:10%"><?php echo $rowstudents['contact'] ?></td>-->
                        <!-- //                             <?php

                                                            //                             
                                                            ?>
                        //                             <td style="width:10%">
                        //                                 <a href="view_result.php?id=<?php echo $rowstudents['student_id'] ?>&cuid=<?php echo $row_course_taught['course_id'] ?>" class="btn btn-success">Marks</a>
                        //                             </td>
                        //                             <?php

                                                        //                             
                                                        ?>
                        //                         </tr>
                        //                     <?php
                                                //                     } 
                                                ?>
                        //                 </tbody>
                        //             </table>
                        //         </div>
                        //     <?php
                                //             } 
                                ?>
                        // </div>
                        // <?php
                            //         }
                            // 
                            ?><?php

                                //     }
                                // }

                                //     
                                ?>
            </div>
        </div>
    </div> -->
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