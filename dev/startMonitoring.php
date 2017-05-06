<?php

include 'cors.php';
// include 'checkLoggedIn.php';

$pid = $_REQUEST["pid"];
$price = $_REQUEST["price"];

$sql = "INSERT INTO bargainmastertable (pid,price) VALUES ('$pid','$price')";

if($result = $conn->query($sql)){
	echo "done";
} else{
	echo "Failed";
	
}



?>