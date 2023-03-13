<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../cssfiles/style.css">
</head>

<body>
    <?php
    require_once("../config/config.php");
    // echo $_GET['stdId'] . $_GET['cu_id'];
    $stdId = $_GET['stdId'];
    $cuId = $_GET['cu_id'];
    $queryCheckCU = mysqli_query($conn, "Select *from courses where course_id='$cuId'");
    $queryStd = mysqli_query($conn, "Select *from students where student_id='$stdId'");
    $rowFetchInfoStd = mysqli_fetch_assoc($queryStd);
    $rowFetchCU = mysqli_fetch_assoc($queryCheckCU);
    ?>
    <div class="container shadow p-3">
        <form action="" method="POST">
            <p>Student name:<span class='fw-bold'><?php echo $rowFetchInfoStd['student_name']; ?></span></p>
            <p>Student ID:<span class='fw-bold'><?php echo $rowFetchInfoStd['student_id']; ?></span></p>
            <p>Course name:<span class='fw-bold'><?php echo $rowFetchCU['course_name']; ?></span></p>
            <p>Course ID:<span class='fw-bold'><?php echo $cuId; ?></span></p>
            <div class="d-flex flex-row align-items-center">
                <label for="coursework">CourseWork(out of 30):</label><input type="number" min="0" max="30" class="form-control w-25" id="coursework" name="coursework">
            </div>
            <div class="d-flex mt-2 flex-row align-items-center">
                <label for="exam">Exam marks(out of 100):</label><input type="number" min="0" max="100" class="form-control w-25" id="exam" name="exam">
            </div>
            <!-- <div class="d-flex flex-row align-items-center">
                <label for="total">Total(out of 100):</label><input type="number" min="0" max="100" class="form-control w-25" id="total" name="total">
            </div> -->
            <div class="d-flex gap-2 mt-2 flex-row justify-content-center">
                <button class="btn btn-success" name="submit">Submit</button>
                <button class="btn btn-secondary" name="cancel">Cancel</button>
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['submit'])) {

        $coursework = $_POST['coursework'];
        $exam = $_POST['exam'];
        if ($coursework >= 0 && $cousework <= 30 && $exam >= 0 && $exam <= 100) {
            $queryUpdate = mysqli_query($conn, "Update register set coursework='$coursework',exam_marks='$exam' WHERE student_id='$stdId' AND cu_id='$cuId'");
            header("location:view_result.php?id=$stdId");
        } else {
    ?>
            <script>
                alert("Error input");
            </script>
    <?php
        }
    } else if (isset($_POST['cancel'])) {
        header("location:view_result.php?id=$stdId");
    }

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>