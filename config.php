<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "randk";
$con = mysqli_connect($host,$user,$pass,$db);

foreach($_POST as $postkey=>$postvar){ //Az összes POST paramétert szűri
    $_POST[$postkey] = mysqli_real_escape_string($con,$postvar);
}

foreach($_GET as $getkey=>$getvar){ //Az 0sszes GET paramétert szűri
    $_GET[$getkey] = mysqli_real_escape_string($con,$getvar);
}

include "functions.php";
?>