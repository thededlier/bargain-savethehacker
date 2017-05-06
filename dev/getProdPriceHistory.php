<?php

include 'cors.php';

$pid = $_REQUEST["pid"];

$sql = "SELECT price,time_stamp from bargainmastertable where pid='$pid'";

$result = $conn->query($sql);

if ($result->num_rows >0) {
	while ($row = $result->fetch_assoc()) {
		$response[]=$row;
	}

	echo json_encode($response);
} else{
	echo json_encode(array('message' => 'Process Failed'));
}


?>