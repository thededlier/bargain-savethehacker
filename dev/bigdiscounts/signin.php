<?php
include './cors.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$email = $_POST['email'];
	$password = $_POST['pwd'];

	$sql = "SELECT * FROM retailers where email = '$email' AND password = '$password'";

  	$result = $conn->query($sql);

  	if($result->num_rows === 1) {
    	$_SESSION["useremail"] = $email;
  	}
  	else {
    	header("Location: ../../retailer/login.php");
  	}
}
?>
