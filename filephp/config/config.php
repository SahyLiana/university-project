<head>
    <link rel="stylesheet" href="../cssfiles/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<?php
$conn = mysqli_connect("localhost", "root", "");
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
// echo "<span class='text-white'>Connected successfully</span>";
session_start();
mysqli_select_db($conn, "myproject");
