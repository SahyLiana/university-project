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
    // if (!isset($_SESSION['username']) && $_SESSION['title'] != 'admin') {
    //     header('location:admin.php');
    // }
    if (isset($_SESSION['title'])) {
        if ($_SESSION['title'] == 'student') {
            header('location:admin.php');
        }
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
                    <th scope="col">Actions</th>
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
                                // $queryRegisterSemester = null;
                                //if ($_SESSION['title'] == 'admin') {
                                $queryRegisterSemester = mysqli_query($conn, "Select *from register WHERE student_id='$stdId' AND year='$y' AND semester='$s'");
                                //}else if($_SESSION['title']=='lecturer'){
                                //    $queryRegisterSemester = mysqli_query($conn, "Select *from register WHERE student_id='$stdId' AND year='$y' AND semester='$s'");
                                //  }

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

                                                $total = 0;
                                                $status = $rowFetch['status'];
                                                if ($status == 'transfer') {
                                                    if ($rowFetch['total'] == null) {
                                                        echo "None";
                                                    } else {
                                                        echo $rowFetch['total'];
                                                    }
                                                } else {
                                                    if (empty($examMarks) && empty($courseworkMarks)) {
                                                        echo "None";
                                                    } else {
                                                        $total = ceil(floatval(($examMarks) * 0.7 + $courseworkMarks));
                                                        // $t = floatval($total);
                                                        $queryUpdateTotal = mysqli_query($conn, "Update register set total=$total  WHERE student_id='$stdId' and cu_id='$cuid'");
                                                        echo $total;
                                                        $i = $i + 1;
                                                        $total_i = $total_i + 1;
                                                        // echo $i;
                                                    }
                                                }

                                                ?></td>
                                            <td><?php
                                                if ($total != 0) {

                                                    $grade = null;
                                                    if ($total < 50) {
                                                        $grade = 'Fail';
                                                        if ($total < 40) {
                                                            $gp = 0;
                                                        } else if ($total < 45) {
                                                            $gp = 1.0;
                                                        } else {
                                                            $gp = 1.5;
                                                        }
                                                    } else {
                                                        if ($total >= 80) {
                                                            $grade = 'A';
                                                            $gp = 5;
                                                        } else if ($total >= 75) {
                                                            $grade = 'B+';
                                                            $gp = 4.5;
                                                        } else if ($total >= 70) {
                                                            $grade = 'B';
                                                            $gp = 4.0;
                                                        } else if ($total >= 65) {
                                                            $grade = 'B-';
                                                            $gp = 3.5;
                                                        } else if ($total >= 60) {
                                                            $grade = 'C+';
                                                            $gp = 3.0;
                                                        } else if ($total >= 55) {
                                                            $grade = 'C';
                                                            $gp = 2.5;
                                                        } else if ($total >= 50) {
                                                            $grade = 'C-';
                                                            $gp = 2.0;
                                                        }
                                                    }
                                                    $queryRegisterUpdate = mysqli_query($conn, "Update register set grade='$grade',gp=$gp where cu_id='$cuid' AND student_id='$stdId'");
                                                    echo $grade;
                                                } else {
                                                    echo "None";
                                                }

                                                ?></td>
                                            <td><?php echo $gp;
                                                if ($gp != null) {
                                                    $tgp = $tgp + $gp * 4;
                                                    $total_gp = $total_gp + $gp * 4;
                                                    $cgpa = $total_gp / ($total_i * 4.0);
                                                    $gpa = $tgp / ($i * 4.0);
                                                }
                                                // $gpa = ($gpa + ($gp * 4)) / ($i * 4.0);
                                                // echo $gpa; 
                                                ?>
                                            </td>
                                            <td><?php if ($rowFetch['status'] == 'retake') {
                                                    if ($rowFetch['grade'] != 'Fail') {
                                                        $queryRegisterUpdate = mysqli_query($conn, "Update register set remarks='Pass after retake' where cu_id='$cuid' AND student_id='$stdId'");
                                                        echo "Pass after retake";
                                                    } else if ($rowFetch['grade'] == 'Fail') {
                                                        echo $rowFetch['remarks'];
                                                    }
                                                } else if ($rowFetch['status'] == 'normal' && $total < 50 && !empty($total)) {
                                                    $queryRegisterUpdate = mysqli_query($conn, "Update register set remarks='retake' where cu_id='$cuid' AND student_id='$stdId'");
                                                    echo "Retake";
                                                } else if ($rowFetch['status'] == 'normal' || $rowFetch['status'] == 'retake') {
                                                    echo $rowFetch['remarks'];
                                                }
                                                ?></td>
                                            <td><a class="btn btn-success" href="input_result.php?stdId=<?php echo $stdId ?>&cu_id=<?php echo $rowFetch['cu_id'] ?>">Input</a></td>
                                        </tr>

                                    <?php

                                    }
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