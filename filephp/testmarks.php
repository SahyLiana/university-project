<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php require('config/config.php'); ?>
    <table class="table tables table-hover table-striped">
        <tr>
            <th>Course_id</th>
            <th>Marks</th>
            <th>Grade</th>
            <th>remarks</th>
        </tr>
        <?php
        $query = mysqli_query($conn, "Select *from testmarks");
        while ($rows = mysqli_fetch_assoc($query)) {
        ?>
            <?php
            $cid = $rows['course_id'];
            if ($rows['cum'] < 50) {

                echo $cid;
                $query_update = mysqli_query($conn, "Update testmarks set remarks='R' where course_id='$cid'");
                $rows['remarks'] = 'R';
            } else {
                $query_update = mysqli_query($conn, "Update testmarks set remarks='P' where course_id='$cid'");
                $rows['remarks'] = 'P';
            }

            ?>
            <tr>
                <td><?php echo $rows['course_id'] ?></td>
                <td><?php echo $rows['cum'] ?></td>
                <td></td>
                <td><?php echo $rows['remarks'] ?></td>
            </tr>
        <?php
        }
        ?>

    </table>

    <p>Total:<span class="total"></span></p>
    <p>CGPA:<span class="cgpa"></span></p>
    <!-- <p>Total is:<span class="total"></span></p> -->
    <script type="text/javascript">
        let tb = document.querySelector(".tables");
        let total = 0;
        let CGPA = 0;
        let grade = 0;
        for (let i = 1; i < tb.rows.length; i++) {
            // console.log(i);
            // console.log(tb.rows[i].cells[1].innerText);
            if (parseInt(tb.rows[i].cells[1].innerText) < 50) {
                tb.rows[i].cells[2].innerText = 'Failed';
                if (parseInt(tb.rows[i].cells[1].innerText) < 40) {
                    grade = grade + 0 * 4;
                } else if (parseInt(tb.rows[i].cells[1].innerText) > 40 && parseInt(tb.rows[i].cells[1].innerText) < 45) {
                    grade = grade + 1.0 * 4;
                } else {
                    grade = grade + 1.5 * 4;
                }
            } else {
                // tb.rows[i].cells[2].innerText = 'Pass';
                if (parseInt(tb.rows[i].cells[1].innerText) >= 50 && parseInt(tb.rows[i].cells[1].innerText) < 55) {
                    tb.rows[i].cells[2].innerText = 'C-';
                    grade = grade + 2.0 * 4;
                } else if (parseInt(tb.rows[i].cells[1].innerText) >= 55 && parseInt(tb.rows[i].cells[1].innerText) < 60) {
                    tb.rows[i].cells[2].innerText = 'C';
                    grade = grade + 2.5 * 4;
                } else if (parseInt(tb.rows[i].cells[1].innerText) >= 60 && parseInt(tb.rows[i].cells[1].innerText) < 65) {
                    tb.rows[i].cells[2].innerText = 'C+';
                    grade = grade + 3.0 * 4;
                } else if (parseInt(tb.rows[i].cells[1].innerText) >= 65 && parseInt(tb.rows[i].cells[1].innerText) < 70) {
                    tb.rows[i].cells[2].innerText = 'B-';
                    grade = grade + 3.5 * 4;
                } else if (parseInt(tb.rows[i].cells[1].innerText) >= 70 && parseInt(tb.rows[i].cells[1].innerText) < 75) {
                    tb.rows[i].cells[2].innerText = 'B';
                    grade = grade + 4.0 * 4;
                } else if (parseInt(tb.rows[i].cells[1].innerText) >= 75 && parseInt(tb.rows[i].cells[1].innerText) < 80) {
                    tb.rows[i].cells[2].innerText = 'B+';
                    grade = grade + 4.5 * 4;
                } else {
                    tb.rows[i].cells[2].innerText = 'A';
                    grade = grade + 5.0 * 4;
                }
            }

            total = total + parseInt(tb.rows[i].cells[1].innerText);
            console.log(total);
        }
        CGPA = parseFloat(grade / (tb.rows.length * 4)).toFixed(2);
        console.log(CGPA);

        document.querySelector(".total").innerText = total;
        document.querySelector(".cgpa").innerText = CGPA;
    </script>
</body>