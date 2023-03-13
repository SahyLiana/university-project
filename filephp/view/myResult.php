<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../cssfiles/style.css">
</head>
<style>
    td {
        /* height: 50px; */
        vertical-align: middle;
    }
</style>

<body>
    <?php
    require('../config/config.php');
    if (!isset($_SESSION['userid'])) {
        header('location:admin.php');
    }
    // echo $_GET['id'];
    $stdId = $_GET['id'];
    // echo $stdId;

    $queryStudent = mysqli_query($conn, "Select *from students where student_id='$stdId'");
    $fetchStdData = mysqli_fetch_assoc($queryStudent);
    $departmentId = $fetchStdData['dep_name'];
    $queryCheckDpt = mysqli_query($conn, "Select *from departments where dep_id='$departmentId'");
    $fetchDptData = mysqli_fetch_assoc($queryCheckDpt);


    ?>


    <div class="container rounded p-4 shadow-sm">
        <div class="">
            <p>Student Name: <span class="fw-bold"><?php echo $fetchStdData['student_name'] ?></span></p>
            <p>Student ID: <span class="fw-bold"><?php echo $fetchStdData['student_id'] ?></span></p>
            <p>Department Name: <span class="fw-bold"><?php echo $fetchDptData['dep_name'] ?></span></p>
            <p>Gender: <span class="fw-bold"><?php echo $fetchStdData['gender'] ?></span></p>
        </div>

        <div class="">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead class="bg-dark text-bg-dark">
                    <th scope="col">Subject Code</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Exam marks</th>
                    <th scope="col">Coursework marks</th>
                    <th scope="col">Total</th>
                    <th scope="col">Grade</th>
                    <th scope="col">GP</th>
                    <th scope="col">Remarks</th>
                    <!-- <th scope="col">Actions</th> -->
                </thead>
                <tbody>
                    <?php
                    $total_i = 0;
                    $cgpa = 0;
                    $total_gp = 0;
                    for ($y = 1; $y <= 3; $y++) {

                        $queryRegister = mysqli_query($conn, "Select *from register WHERE student_id='$stdId' AND year='$y'");
                        $rowCheckRegisterYear = $queryRegister->num_rows;
                        if ($rowCheckRegisterYear > 0) {
                            for ($s = 1; $s <= 2; $s++) {
                                $queryRegisterSemester = mysqli_query($conn, "Select *from register WHERE student_id='$stdId' AND year='$y' AND semester='$s' AND total IS NOT NULL");
                                $rowCheckRegisterSemester = $queryRegisterSemester->num_rows;
                                if ($rowCheckRegisterSemester > 0) {
                                    echo "<tr><td colspan='9' class='text-primary fw-bold py-3'>Year " . $y . " Semester " . $s . "</td></tr>";
                                    $gpa = 0.0;
                                    $tgp = 0;
                                    $i = 0;
                                    while ($rowFetch = mysqli_fetch_assoc($queryRegisterSemester)) {
                                        $gp = null;
                    ?>
                                        <tr>
                                            <td><?php echo $rowFetch['cu_id'];
                                                $cuid = $rowFetch['cu_id']; ?></td>
                                            <td><?php $queryCourses = mysqli_query($conn, "Select *from courses where course_id='$cuid';");
                                                $rowCourses = mysqli_fetch_assoc($queryCourses);
                                                echo $rowCourses['course_name']; ?></td>
                                            <td><?php
                                                $examMarks = $rowFetch['exam_marks'];
                                                if (empty($examMarks)) {
                                                    echo "None";
                                                } else {
                                                    echo $examMarks;
                                                }
                                                ?></td>
                                            <td><?php
                                                $courseworkMarks = $rowFetch['coursework'];
                                                if (empty($courseworkMarks)) {
                                                    echo "None";
                                                } else {
                                                    echo $courseworkMarks;
                                                }
                                                ?></td>
                                            <td><?php
                                                // $status = $rowFetch['status'];
                                                // if ($rowFetch['total'] == null) {
                                                //     echo "None";
                                                // } else {
                                                echo $rowFetch['total'];
                                                $i = $i + 1;
                                                $total_i = $total_i + 1;
                                                // }
                                                ?></td>
                                            <td><?php
                                                // $total = $rowFetch['total'];
                                                // if ($total != null) {
                                                echo $rowFetch['grade'];
                                                // } else {
                                                //     echo "None";
                                                // }
                                                ?></td>
                                            <td><?php echo $rowFetch['GP'];
                                                $gp = $rowFetch['GP'];
                                                if ($gp != null) {
                                                    $tgp = $tgp + $gp * 4;
                                                    $total_gp = $total_gp + $gp * 4;
                                                    $cgpa = $total_gp / ($total_i * 4.0);
                                                    $gpa = $tgp / ($i * 4.0);
                                                } ?></td>
                                            <td><?php
                                                echo $rowFetch['remarks'];
                                                ?></td>
                                        </tr>
                                    <?php

                                    }

                                    //             }
                                    //         }
                                    //     }
                                    // }
                                    ?>
                                    <tr>
                                        <td colspan="9"><?php
                                                        echo "GPA:" . $gpa ?><span style="float:right;" class="">CGPA:<?php echo number_format($cgpa, 2, '.', '') ?></span>
                                <?php }
                            }
                        } ?></td>
                                    </tr><?php
                                        }
                                            ?>

                </tbody>
            </table>
            <div class="mt-3 d-flex justify-content-end">
                <button class="btn btn-secondary" onclick="window.location.href=' students.php'">Back</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>