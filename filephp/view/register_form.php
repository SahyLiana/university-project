<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="">
    <?php require('../config/config.php');
    if (!isset($_SESSION['username'])) {
        header('location:../view/admin.php');
    }
    ?>
    <?php
    $year = $_GET['year'];
    $semester = $_GET['semester'];
    $id = $_SESSION['userid'];
    // echo $year . "," . $semester;
    if ($year == 1) {
        $yeardisplay = "First";
    }
    if ($year == 2) {
        $yeardisplay = "Second";
    }
    if ($year == 3) {
        $yeardisplay = "Third";
    }
    if ($semester == 1) {
        $semdisplay = "First";
    }
    if ($semester == 2) {
        $semdisplay = "Second";
    }
    echo $id;
    ?>
    <div class="container p-0 my-auto rounded shadow-sm">
        <div class="mb-3 bg-light justify-content-between d-flex px-3 py-5">
            <h3 class="bg-light fw-bold">Courses to Register for<span class="text-primary"> <?php echo $yeardisplay ?> year <?php echo $semdisplay ?> semester </h3>

        </div>
        <form action="" method="POST">
            <div class="mt-5 px-5 mb-3">
                <div class="d-flex mb-5 flex-row justify-content-between">
                    <h3 class="  me-auto w-100 ">Select your courses:</h3>
                    <select name="status" class="form-select flex-shrink-1">
                        <option value="normal">Normal</option>
                        <option value="transfer">Transfer</option>
                        <option value="retake">Retake</option>
                    </select>
                </div>
                <?php

                $query_checkdep = mysqli_query($conn, "Select *from students where student_id='$id'");
                $row_fecth = mysqli_fetch_assoc($query_checkdep);
                $dpt = $row_fecth['dep_name'];
                // echo $dpt;
                $query_courses = mysqli_query($conn, "Select *from courses where dep_id='$dpt' AND year='$year' AND semester='$semester'");

                while ($row_courses = mysqli_fetch_assoc($query_courses)) {
                ?>

                    <input type="checkbox" class="form-check-input" name="courses[]" value="<?php echo $row_courses['course_id'] ?>"><span class=" ms-2 fs-5"><?php echo $row_courses['course_id'] . " " . $row_courses['course_name'] ?></span>
                    <hr><br>
                <?php
                }
                ?>
            </div>
            <div class="d-flex border-top-1 p-3 flex-row justify-content-end">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-lg" name="submit">Submit</button>
                    <button name="cancel" class="btn btn-lg btn-secondary w-100">Cancel</button>
                </div>
            </div>
        </form>
        <?php
        if (isset($_POST['cancel'])) {
            // header('location:students.php');
        ?>
            <script type="text/javascript">
                window.location.href = "exam_registration.php";
            </script>
            <?php
        } else if (isset($_POST['submit'])) {
            $date = date('Y-m-d');
            // $month = date('m');
            // $year = date('Y');
            $academic_year =  strval(date('Y') . "-20" . (date('y') + 1));
            $status = $_POST['status'];
            echo $status;
            $i = 1;
            // echo date('Y');
            // echo $academic_year;
            echo $date;

            if (!empty($_POST['courses'])) {
                foreach ($_POST['courses'] as $course) {
                    echo $course;
                    // $query_insert = mysqli_query($conn, "Insert into register (student_id,cu_id,status,year,semester,date_registered)
                    //  values('$id','$course','$status','$year','$semester','$date')");

                    $queryCheckRegistration = mysqli_query($conn, "Select *from register where cu_id='$course' AND student_id='$id'");
                    $rowCheckRegistration = $queryCheckRegistration->num_rows;
                    if ($rowCheckRegistration != 0) {
                        $fecthDataChecked = mysqli_fetch_assoc($queryCheckRegistration);

                        if ($fecthDataChecked['exam_marks'] >= 50 && $fecthDataChecked['remarks'] != 'retake') {
            ?>
                            <script>
                                alert("You have been registered some of selected course unit,please check carefully");
                                window.location.href = "myRegistration.php?id=<?php echo $id ?>";
                            </script>
                        <?php
                        } else if (($fecthDataChecked['exam_marks'] < 50 && $fecthDataChecked['exam_marks'] != null) || $fecthDataChecked['remarks'] == 'retake') {
                            $query_update = mysqli_query($conn, "Update register set status='retake',academic_year='$academic_year' 
                            WHERE student_id='$id' AND cu_id='$course'");
                        }
                        ?>
                        <?php

                    } else {
                        if ($status == 'retake') {
                            $query_insert = mysqli_query($conn, "Insert into register(student_id,cu_id,status,year,semester,date_registered,academic_year)
                         values('$id','$course','normal','$year','$semester','$date','$academic_year')");
                        } else {
                            $query_insert = mysqli_query($conn, "Insert into register(student_id,cu_id,status,year,semester,date_registered,academic_year)
                         values('$id','$course','$status','$year','$semester','$date','$academic_year')");

                            if (!$query_insert) {
                                // $i = 0;
                        ?>
                                <script>
                                    alert("Some of your courses may not be inserted, please check carefully and re enter them again...");
                                    window.location.href = "myRegistration.php?id=<?php echo $id ?>";
                                </script>
                        <?php
                            }
                        }
                        ?>
                <?php
                    }
                }
                ?>
                <script>
                    // alert("Register successfully");
                    window.location.href = "myRegistration.php?id=<?php echo $id ?>";
                </script>
            <?php
            } else {
                // echo "failed";
            ?>
                <script>
                    alert("Please fill your course Unit");
                </script>
            <?php
            }
            ?>
        <?php
        }
        ?>
    </div>
</body>