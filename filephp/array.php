<form method="post">
    <?php
    $rows = 1;
    if (isset($_GET['number_of_rows'])) {
        $rows = $_GET['number_of_rows'];
    }

    for ($i = 0; $i < $rows; $i++) {

    ?>
        <div>
            <input placeholder="fname" type="text" name="fname<?= $i ?>" required>
            <input placeholder="lname" type="text" name="lname<?= $i ?>" required>
        </div>
    <?php
    }
    ?>

    <input type="submit" name="submit">
</form>

<form method="get">
    <input type="number" value=<?= $rows ?> max=10 min="1" name="number_of_rows" required>
    <input type="submit" name="submit2">
</form>
<?php
function insert_into_db($data)
{
    foreach ($data as $key => $value) {
        $k[] = $key;
        $v[] = "'" . $value . "'";
    }
    $k = implode(",", $k);
    // echo $k;
    $v = implode(",", $v);
    echo $v;
    $conn = mysqli_connect("localhost", "root", "");
    // if ($conn->connect_error) {
    //     die("Connection failed:" . $conn->connect_error);
    // }
    mysqli_select_db($conn, "myproject");
    $sql = "insert into testarray(fname,lname) values($v)";
    $run_query = mysqli_query($conn, $sql);
    // if ($run_query) {
    //     echo "success";
    // } else {
    //     echo "failed";
    // }
}
if (isset($_POST['submit'])) {
    for ($i = 0; $i < $rows; $i++) {
        $data = array(
            // 'fname' => 'asok',
            // 'lname' => 'kumar'
            'fname' => $_POST['fname' . $i],
            'lname' => $_POST['lname' . $i]
        );

        insert_into_db($data);
    }
} ?>