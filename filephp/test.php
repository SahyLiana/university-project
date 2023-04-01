<?php require('config/config.php'); ?>
<form action="" method="POST">
    <select name="language">
        <?php
        $query = mysqli_query($conn, "Select *from admin");
        // $i = sizeof($row);
        while ($row = mysqli_fetch_assoc($query)) {
            // echo $row['username'];
        ?><option value="<?php $row['username'] ?>"><?php echo $row['username'] ?></option><?php
                                                                                            // $i--;
                                                                                        }
                                                                                            ?>
        <!-- <option value="" disabled selected>Choose option</option>
                <option value="cs">Czech</option>
                <option value="de">German</option>
                <option value="en_GB">English (UK)</option>
                <option value="fr">French</option> -->
    </select>
    <!-- <button>Submit</button> -->
</form>
<?php
// if (isset($_POST['language'])) {
//     $select = $_POST['language'];
//     switch ($select) {
//         case 'cs':
//             echo 'Czech';
//             break;
//         case 'de':
//             echo 'German';
//             break;
//         case 'en_GB':
//             echo 'English (UK)';
//             break;
//         case 'fr':
//             echo 'French';
//             break;
//     }
// }
?>
<hr>
<form action="" method="POST">
    <select name="choices">
        <option value="" selected disabled>Choose option</option>
        <option value="banana">Banana</option>
        <option value="Mango">Mango</option>
        <option value="Coconut">Coconut</option>
    </select>
    <!-- <input type="submit" value="Submit" name="submit"> -->
</form>
<?php
// if (isset($_POST['submit'])) {
//     if (!empty($_POST['choices'])) {
//         echo $_POST['choices'];
//     } else {
//         echo 'No choice';
//     }
// }
?>
<h1>For multiple choices</h1>
<form action="" method="POST">
    <select name="more[]" multiple>
        <option value="football">Football</option>
        <option value="basketball">Basketball</option>
        <option value="others">Others</option>
    </select>
    <input type="submit" value="Submit" name="submit" />
</form>
<?php
// if (isset($_POST['submit'])) {
//     if (!empty($_POST['more'])) {
//         foreach ($_POST['more'] as $selected_choices) {
//             echo '  ' . $selected_choices;
//         }
//     } else {
//         echo 'Please select';
//     }
// }
?>
<h1>Radio button</h1>
<form action="" method="POST">
    <input type="radio" name="gender" value="male" required>Male
    <input type="radio" name="gender" value="female">Female
    <input type="submit" name="submit" value="Submit" />
</form>
<?php
// if (isset($_POST['submit'])) {
//     if (!empty($_POST['gender'])) {
//         echo $_POST['gender'];
//     }
// }
?>
<h1>Checkbox</h1>
<form action="" method="POST">
    <input type="checkbox" name="hobbies[]" value="foot">Football<br>
    <input type="checkbox" name="hobbies[]" value="game">Game<br>
    <input type="checkbox" name="hobbies[]" value="music">music<br>
    <input type="submit" name="submit" value="Submit">
</form>
<?php
if (isset($_POST['submit'])) {
    if (!empty($_POST['hobbies'])) {
        foreach ($_POST['hobbies'] as $hobby) {
            echo '  ' . $hobby;
        }
    }
}
?>
<button onclick="window.location.href='https://w3docs.com';">
    Click Here
</button>

<form action="" method="GET">
    <input type="text" name="name" />
    <input type="text" name="degree" />
    <button name="sub">Submit</button>
    <?php
    if (isset($_GET['sub'])) {
        echo $_GET['name'];
    }

    ?>

</form>
<button class="test">Click me!</button>
<script type="text/javascript">
    const but = document.querySelector(".test");
    but.addEventListener("click", function() {
        alert("It will redirect...");
        window.location.href = "admin.php";
    });
</script>
<?php
// echo $_SESSION['dname'];
// echo $_SESSION['ddid'];

?>

<h1>Test for registration</h1>
<form action="" method="POST">
    <?php
    $query = mysqli_query($conn, "Select *from test;");
    while ($row = mysqli_fetch_assoc($query)) {
    ?>
        <input type="checkbox" name="test[]" value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?><br>
    <?php
    }

    ?>
    <button name="test_marks">Click me!</button>
    <?php
    if (isset($_POST['test_marks'])) {
        if (!empty($_POST['test'])) {
            foreach ($_POST['test'] as $names) {
                echo $names;
            }
        }
    }

    ?>
</form>




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