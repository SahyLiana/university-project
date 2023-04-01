<head>
    <title>School Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../cssfiles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
        .bg-panel {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .bg-input {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .university {
            font-family: Georgia, serif;
        }
    </style>
</head>


<body class=" d-flex justify-content-center align-items-center" style=" background-image: url('images/bg-body.png'); background-repeat:no-repeat; background-attachment:fixed;background-size:cover">
    <div style="border-top:aqua solid 1px; border-bottom:aqua solid 1px" class="small-box bg-panel my-auto text-white px-5 rounded-5 py-3 ">
        <div class=" text-center m-5">
            <img class="w-50 rounded img-thumbnail img-fluid" src="images/kulg.jpg" />
            <h2 class="mt-2 fw-bolder university">KAMPALA UNIVERSITY</h2>
            <p class=" text-white-50">Control panel login</p>
        </div>
        <form action="" method="POST">
            <div class="row gap-3 my-4">
                <div class="col-1">
                    <label for="username">
                        <span class="fa fa-user fs-2 text-white"></span></label>
                </div>
                <div class="col-10">
                    <input type="text" name="username" id="username" style="cursor:pointer" class=" fs-4 form-control border-top-0 border-start-0 border-end-0 bg-body-emphasis px-1 py-2  " placeholder="Username" />
                </div>
            </div>
            <div class="row gap-3 my-4">
                <div class="col-1">
                    <label for="password">
                        <span class="fa fa-lock fs-2 text-white"></span></label>
                </div>
                <div class="col-10">
                    <input type="password" name="password" id="password" style="cursor:pointer" class=" fs-4  form-control border-top-0 border-start-0 bg-body-emphasis border-end-0 px-1 py-2  " placeholder="Password" />
                </div>
            </div>
            <div class="row gap-3 my-2">
                <div class="col-1"></div>
                <div class="col-3">

                    <?php

                    require('../config/config.php');
                    if (isset($_SESSION['username'])) {
                        header('location:dashboard.php');
                    } else if (isset($_POST['login'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $login = mysqli_query($conn, "Select *from admin where username='$username' and password='$password'");
                        $count = $login->num_rows;
                        if ($count == 1) {
                            $row = mysqli_fetch_assoc($login);
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['title'] = $row['title'];
                            header("location:dashboard.php");
                        } else {
                            $username = $_POST['username'];
                            $password = md5($_POST['password']);
                            $login = mysqli_query($conn, "Select *from users where userid='$username' and password='$password'");
                            $count = $login->num_rows;
                            if ($count == 1) {
                                $row = mysqli_fetch_assoc($login);
                                $_SESSION['username'] = $row['username'];
                                $_SESSION['userid'] = $username;
                                $_SESSION['title'] = $row['title'];
                                header("location:dashboard.php");
                            } else {
                                echo "<p class='text-warning'>Login failed</p>";
                            }
                            //echo "<p class='text-warning'>Login failed</p>";
                        }
                    } else if (isset($_POST['register'])) {
                        header("location:register.php");
                    }

                    ?>
                </div>
            </div>
            <div class="row gap-3 my-2">
                <!-- <div class="col-1">

                </div> -->
                <div class="col-12">
                    <button name="login" class="w-100 rounded-5 px-4 btn py-2 fw-bolder btn-lg  btn-success">Login</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button name="register" class="w-100 rounded-5 px-4 btn py-2 fw-bolder btn-lg  btn-primary">Register</button>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>