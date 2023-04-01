<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../cssfiles/style.css">
</head>

<body>
    <?php
    require('../config/config.php');
    if (!isset($_SESSION['username'])) {
        header('location:dashboard.php');
    }
    // echo $_GET['id'];
    $stdId = $_GET['id'];

    $queryStudent = mysqli_query($conn, "Select *from students where student_id='$stdId'");
    $fetchStdData = mysqli_fetch_assoc($queryStudent);
    $departmentId = $fetchStdData['dep_name'];
    $queryCheckDpt = mysqli_query($conn, "Select *from departments where dep_id='$departmentId'");
    $fetchDptData = mysqli_fetch_assoc($queryCheckDpt);


    ?>


    <div class="container rounded p-4 shadow-sm">
        <table class="table" style="max-width:400px">
            <tr>
                <td style="border:none">Student Name:</td>
                <td style="border:none"> <span class="fw-bold"><?php echo $fetchStdData['student_name'] ?></span></td>
                </td>
            <tr>
                <td style="border:none">Student ID:</td>
                <td style="border:none"> <span class="fw-bold"><?php echo $fetchStdData['student_id'] ?></span></td>
            </tr>
            <tr>
                <td style="border:none">Department Name:</td>
                <td style="border:none"> <span class="fw-bold"><?php echo $fetchDptData['dep_name'] ?></span></td>
            </tr>
            <tr>
                <td style="border:none">Gender:</td>
                <td style="border:none"> <span class="fw-bold"><?php echo $fetchStdData['gender'] ?></span></td>
            </tr>
        </table>
        <h1 class="fw-bold" style="text-align:center;padding:5px;color:green;border-bottom:3px solid green">My Registration</h1>
        <div class="mt-5">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead class="bg-dark text-bg-dark">
                    <th scope="col">Subject Code</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Date registered</th>
                    <th scope="col">Academic year</th>
                    <th scope="col">GP</th>
                    <th scope="col">Status</th>
                </thead>

                <!--            -->

                <tbody>
                    <?php
                    for ($y = 1; $y <= 3; $y++) {
                        $queryRegister = mysqli_query($conn, "Select *from register where student_id='$stdId' AND year='$y'");
                        $rowQueryRegister = $queryRegister->num_rows;
                        if ($rowQueryRegister > 0) {
                    ?>
                            <?php
                            for ($s = 1; $s <= 2; $s++) {

                                $queryRegisterSemester = mysqli_query($conn, "Select *from register where student_id='$stdId' AND semester='$s' AND year='$y'");
                                $rowQueryRegisterSemester = $queryRegisterSemester->num_rows;
                                if ($rowQueryRegisterSemester > 0) { ?>
                                    <tr>
                                        <td colspan="6"><span class="fw-bold text-primary"><?php echo "Year " . $y . " Semester " . $s ?></span></td>
                                    </tr>
                                    <?php
                                    while ($fetchRegistrationSemester = mysqli_fetch_assoc($queryRegisterSemester)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $fetchRegistrationSemester['cu_id'];
                                                $cuid = $fetchRegistrationSemester['cu_id']; ?></td>
                                            <td><?php $queryCourses = mysqli_query($conn, "Select *from courses where course_id='$cuid';");
                                                $rowCourses = mysqli_fetch_assoc($queryCourses);
                                                echo $rowCourses['course_name']; ?>
                                            <td><?php
                                                echo $fetchRegistrationSemester['date_registered'];
                                                ?></td>
                                            <td><?php
                                                echo $fetchRegistrationSemester['academic_year'];
                                                ?></td>

                                            <td>4.0</td>
                                            <td><?php echo $fetchRegistrationSemester['status'] ?></td>
                        <?php
                                    }
                                }
                            }
                        }
                    }
                        ?>

                </tbody>

                <!--     -->

            </table>

            <div class="mt-3 d-flex justify-content-end">
                <button class="btn btn-secondary" onclick="window.location.href='exam_registration.php'">Back</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>