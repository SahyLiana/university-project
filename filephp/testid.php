<?php

$id = substr(uniqid(), 7);
$prefix = "BCSIT";

$newid = $prefix . $id;
// echo $id . "<br>";
echo $newid . "<br>";
$string1 = "Welcome to w3resource.com";
echo $string1;
echo '<br>';
echo substr($string1, 1);
echo '<br>';
echo substr($string1, 5);
echo '<br>';
// echo substr($string1, 0, 10);
// echo '<br>';
// echo substr($string1, -1, 1);
// echo '<br>';
