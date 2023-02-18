<head>

</head>
<title>School Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<body>
    <?php
    require('config.php');
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>How to insert date values into database in php</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Date of Birth</label>
                                <input type="date" name="dateofbirth" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="save_date" class="btn btn-primary">Save data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_POST['save_date'])) {
                $name = $_POST['name'];
                //check the format of the date in db
                //in the db it was year-mm-d
                //$dob = $_POST['dateofbirth'];
                $dob = date('Y-m-d', strtotime($_POST['dateofbirth']));

                echo $dob;
                echo DATE('Y', strtotime($dob));
                // $query = "INSERT INTO test (name,dob) VALUES ('$name','$dob')";
                // $query_run = mysqli_query($conn, $query);
                $datejoined = date('Y-m-d');
                $query_run = mysqli_query($conn, "Insert into test values('$name','$dob','$datejoined');");
                if ($query_run) {
                    echo "Inserted successfully<br/>";
                    echo date('Y-m-d<br/>');
                    echo date('m-d-y<br/>');
                    echo "The time is " . date('h:i:s<br/>'); //h hour i minutes s seconds
                    echo "Time:" . date('h:i:s:a<br/>'); //am or pm
                    echo "Time and date:" . date('Y-m-d') . ":" . date('h:i:s');
                } else {
                    echo "Failed";
                }
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>