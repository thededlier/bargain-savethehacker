<?php

header("Access-Control-Allow-Origin: *");
$conn = new mysqli("localhost","root","");
mysqli_select_db($conn,'bargain');

?>
