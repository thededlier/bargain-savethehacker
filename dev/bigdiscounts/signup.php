<?php
include './connect.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$name = $_POST['username'];
  	$shop = $_POST['shop'];
  	$address = $_POST['address'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$vid = uniqid("VD");

	$sql = "INSERT INTO retailers(vid, username, shop, address, email, password)
          VALUES ('$vid', '$name', '$shop', '$address', '$email', '$password')";

  	if($conn->query($sql)){
		header('Location: ../../index.php?register=200');
	}
}
?>
