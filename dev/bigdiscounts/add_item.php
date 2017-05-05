<?php
  include '../cors.php';

  $pid = $_GET["pid"];
  $vendor_id = $_GET["vid"];
  $discount = $_GET["discount"];
  $goal = $_GET["goal"];

  $sql = "INSERT INTO bargain_items(pid,vendorid,discount,goal) values('$pid','$vendor_id','$discount','$goal')";

  if($conn->query($sql)){
    $obj -> status = 200;
    $obj -> message = "Success";
    $obj -> pid = $pid;
    $obj -> discount = $discount;
  } else {
    $obj -> status = 400;
    $obj -> message = $conn->error;
    $obj -> pid = $pid;
    $obj -> discount = $discount;
  }

  echo json_encode($obj);
?>
