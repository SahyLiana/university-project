<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../cssfiles/style.css">

    <style>
        @media print {


            .btn {
                display: none;
            }

            .upload {
                display: none;
            }
        }
    </style>
</head>

<body class="">
    <?php require('../config/config.php');
    // require('../actions/upload_img.php');
    $id = $_GET['id'];
    if (!isset($_SESSION['username']) || $_SESSION['title'] == 'student' || $_SESSION['title'] == 'lecturer') {
        header('location:admin.php');
    }
    // $id = $_GET['id'];
    $query = mysqli_query($conn, "Select *from lecturers where lecturer_id='$id'");

    $row_lecturer = mysqli_fetch_assoc($query);
    $dep_id = $row_lecturer['dep_id'];
    $user_img = $row_lecturer['profile'];
    $query_dep = mysqli_query($conn, "Select *from departments where dep_id='$dep_id'");
    $row_dep = mysqli_fetch_assoc($query_dep);
    ?>


    <div class="border  container mx-auto rounded p-5">
        <h1 class="text-center mb-5">Lecturer profile</h1>
        <div class="d-flex">
            <div class=" w-25" style=" height:50%;">
                <?php
                if (empty($user_img)) {

                ?>
                    <img src="../userimage/avatar.jpg" class="rounded mb-1" width="100%">
                <?php
                } else { ?>

                    <img src="<?php echo $user_img ?>" class="rounded mb-1" width="100%">
                <?php
                }
                ?>
                <form action="../actions/upload_img.php?id=<?php echo $id ?>" method="POST" enctype='multipart/form-data'>
                    <input type='file' name='photo' class="form-control upload" />
                    <button class=" btn btn-primary w-100" type="submit" name="upload_photo">Upload photo</button>
                </form>
            </div>
            <div class="w-75 border p-3 rounded-3 ms-3">
                <p class="p-0 m-1"><span class="fw-bold ">Lecturer name:</span>
                    <?php echo $row_lecturer['lecturer_name'] ?></p>
                <p class="p-0 m-1"><span class="fw-bold ">Lecturer id:</span>
                    <?php echo $row_lecturer['lecturer_id'] ?></p>
                <p class="p-0 m-1"><span class="fw-bold ">Dep name:</span>
                    <?php echo $row_dep['dep_name'] ?></p>
                <p class="p-0 m-1"><span class="fw-bold ">Gender:</span>
                    <?php echo $row_lecturer['gender'] ?></p>
                <p class="p-0 m-1"><span class="fw-bold ">Contact:</span>
                    <?php echo $row_lecturer['contact'] ?></p>
            </div>
        </div>

        <!-- <p><span class=" fw-bold">Gender:</span><?php echo $row_student['gender'] ?></p>
            <p>This is a test</p>
            <button onclick="window.print()">Print</button> -->
        <div class=" d-flex gap-2 w-100 justify-content-end mt-2">
            <button onclick="window.print()" class="btn btn-lg btn-success">Print</button>
            <button onclick="location.href='lecturers.php'" class="btn btn-lg btn-secondary">Cancel</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>