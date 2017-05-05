<?php
include './cors.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['pwd'];
	$vid = uniqid("VD");

	$sql = "INSERT INTO vendors(vid, name, email, password) VALUES ('$vid', '$name', '$email', '$password')";

  if($conn->query($sql)){
		$json = array("status" => 200, "msg" => "Success");
	}else{
		$json = array("status" => 400, "msg" => $conn->error);
	}
}else{
	$json = array("status" => 400, "msg" => "Request method not accepted");
}

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);
?>
