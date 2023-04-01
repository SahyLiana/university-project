<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center">
    <?php require_once('../config/config.php');
    if (!isset($_SESSION['username'])) {
        header('location:../view/admin.php');
    }
    if ($_SESSION['title'] != 'admin') {
        header('location:../view/admin.php');
    }
    ?>
    <div class="container p-0 my-auto rounded shadow-sm">
        <div class="mb-3 bg-light p-3">
            <h2 class="bg-light text-primary text-center fw-bold">Add </h2>
        </div>
        <form action="" method="POST">
            <!-- <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="student_id" class=" small">Student Id</label>
                </div>
                <div class="col-5">
                    <input type="text" name="student_id" class=" form-control py-2" />
                </div>
            </div> -->
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="student_name" class=" small">Student name</label>
                </div>
                <div class="col-5">
                    <input type="text" name="student_name" class=" form-control py-2" placeholder="eg:John Doe" />
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
                    <input type="radio" checked name="gender" value="M">Male
                    <input type="radio" name="gender" value="F">Female
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="dob" class=" small">Date Of birth</label>
                </div>
                <div class="col-5">
                    <input type="date" class=" form-control" name="dob" />
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="year" class=" small">Year</label>
                </div>
                <div class="col-5">
                    <select name="year" class="form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="semester" class=" small">Semester</label>
                </div>
                <div class="col-5">
                    <select name="semester" class="form-select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="contact" class=" small">Contact</label>
                </div>
                <div class="col-5">
                    <input type="text" name="contact" class="  form-control py-2" placeholder="eg:+86-1234567" />
                </div>
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
                window.location.href = "../view/students.php";
            </script>
            <?php
        } else if (isset($_POST['submit'])) {
            // $student_id = $_POST['student_id'];
            $id = substr(uniqid(), 7);
            // $prefix = "BCSIT";

            // $newid = $prefix . $id;
            $student_name = $_POST['student_name'];
            $dep_name = $_POST['dep_name'];
            $gender = $_POST['gender'];
            $contact = $_POST['contact'];
            $dob = date('Y-m-d', strtotime($_POST['dob']));
            $year = $_POST['year'];
            $semester = $_POST['semester'];
            $datejoined = date('Y-m-d');
            $newid = date('Y') . "/" . $dep_name . "/" . $id;
            // echo $newid . "," . $student_name . "," . $dep_name . "," . $gender . "," . $contact . "," . $dob . "," . $year . "," . $semester . "," . $datejoined;
            if (
                !empty($newid) && !empty($student_name) && !empty($dep_name) &&
                !empty($gender) && !empty($contact) && !empty($dob) && !empty($year) && !empty($semester)
            ) {
                $query = mysqli_query($conn, "Insert into students(student_id,
                student_name,dep_name,gender,contact,dob,year,semester,date_joined) values ('$newid','$student_name','$dep_name','$gender','$contact','$dob','$year','$semester','$datejoined');");

                if ($query) {
            ?>
                    <script type="text/javascript">
                        alert("Added successfully");
                        window.location.href = "../view/students.php";
                    </script>
                <?php
                } else {
                ?>
                    <script type="text/javascript">
                        alert("Failed...");
                    </script>
                <?php
                }
            } else {
                ?>
                <script type="text/javascript">
                    alert("Please fill all information...");
                </script>
        <?php
            }
        } ?>
    </div>
</body>