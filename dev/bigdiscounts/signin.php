<?php
include './cors.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$email = $_POST['email'];
	$password = $_POST['pwd'];

	$sql = "SELECT * FROM vendors where email = '$email' AND password = '$password'";

  $result = $conn->query($sql);

  if($result->num_rows === 1) {
    $json = array("status" => 200, "message" => "Success", "vid" => $row["vid"]);
  }
  else {
    $json = array("status" => 400, "message" => "User not found");
  }

} else {
  $json = array("status" => 400, "message" => "Request method not accepted");
}

/* Output header */
  header('Content-type: application/json');
  echo json_encode($json);
?>
