<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center">
    <?php
    require('../config/config.php');
    if (!isset($_SESSION['username'])) {
        header('location:../view/admin.php');
    }
    if ($_SESSION['title'] != 'admin') {
        header('location:../view/admin.php');
    }
    //else {
    //     echo "Update";
    //     echo $_GET['id'] . ":" . $_GET['name'];
    //     //     // echo $_SESSION['vname'];
    //     //     // echo "Update page";
    //     //     // $id = $_GET['id'];
    //     //     // echo "Update";
    //     //     // echo $_SESSION['dname'];
    //     //     // $va = $_SESSION['dname'];
    //     //     // $vid = $_SESSION['ddid'];
    //     //     // $queryupdate = mysqli_query($conn, "Update departments set dep_name='$va' where dep_id='$vid'");
    // } 
    ?>
    <div class="container p-0 my-auto rounded shadow-sm">
        <div class="mb-3 bg-light p-3">
            <h2 class="bg-light text-primary text-center">Update department</h2>
        </div>
        <form action="" method="POST">
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="depid" class="fw-bold">Department ID:</label>
                </div>
                <div class="col-5">
                    <input type="text" disabled name="depid" id="depid" class="fs-5 p-3 form-control w-100" value='<?php echo $_GET["id"] ?>' placeholder="eg:BCSIT">
                </div>
            </div>
            <div class="row ps-3 mb-3">
                <div class="col-2">
                    <label for="depname" class="fw-bold">Department name:</label>
                </div>
                <div class="col-5">
                    <input type="text" name="depname" id="depname" class="p-3 fs-5 form-control w-100" value='<?php echo $_GET["name"] ?>' placeholder="eg:Computer Science">
                </div>
            </div>
            <div class="row me-3 mb-3">
                <div class="col d-flex gap-3 justify-content-end">
                    <button class=" btn btn-primary btn-lg " name="submit">Submit</button>
                    <button class="btn btn-secondary btn-lg" name="cancel">Cancel</button>
                </div>
            </div>
            <?php
            if (isset($_POST['cancel'])) {
                header('location:../view/departments.php');
            }
            if (isset($_POST['submit'])) {
                $dname = $_POST['depname'];
                $did = $_GET['id'];
                //echo $did;
                $queryupdate = mysqli_query($conn, "Update departments set dep_name='$dname' where dep_id='$did';");
                if ($queryupdate) { ?>
                    <script type="text/javascript">
                        alert('Update successful.');
                        window.location.href = '../view/departments.php';
                    </script>
                <?php
                    // echo "<script> alert('Update successful.')</script>";
                    // echo "window.location.href='departments.php'";
                } else { ?>
                    <script type="text/javascript">
                        alert('Update successful.');
                        window.location.href = '../view/departments.php';
                    </script><?php
                                // echo "<script> alert('Update failed.')</script>";
                                // // echo "<p>Update failed</p>";
                                // echo "window.location.href='departments.php'";
                            }
                        }
                                ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>