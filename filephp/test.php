<?php require('config.php'); ?>
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
echo $_SESSION['dname'];
echo $_SESSION['ddid'];

?>