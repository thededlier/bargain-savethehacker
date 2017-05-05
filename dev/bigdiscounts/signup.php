<?php
include './cors.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$name = $_POST['name'];
  $shop = $_POST['shop'];
  $address = $_POST['address'];
	$email = $_POST['email'];
	$password = $_POST['pwd'];
	$vid = uniqid("VD");

	$sql = "INSERT INTO vendors(vid, name, shop, address, email, password)
          VALUES ('$vid', '$name', '$shop', '$address', '$email', '$password')";

  if($conn->query($sql)){
		$json = array("status" => 200, "message" => "Success");
	}else{
		$json = array("status" => 400, "message" => $conn->error);
	}
}else{
	$json = array("status" => 400, "message" => "Request method not accepted");
}

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>
