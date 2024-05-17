<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mini_education_game";
$conn = mysqli_connect($servername,$username,$password);
$db_conn = mysqli_select_db($conn,$dbname);
?>