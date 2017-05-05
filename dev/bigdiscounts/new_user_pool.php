<?php
  include '../cors.php';

  $uid = $_GET["uid"];
  $pid = $_GET["pid"];
  $vid = $_GET["vid"];
  $discount = $_GET["discount"];

  $sql = "SELECT * from bargain_items where pid = '$pid' AND vendorid = '$vid'";

  $result = $conn->query($sql);
  if($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $goal = $row["goal"];

    $sql = "UPDATE bargain_items SET goal = $goal + 1 where pid = '$pid' AND vendorid = '$vid'";

    $conn->query($sql);

    $sql = "UPDATE bargain_items SET vals = vals + $discount where pid = '$pid' and vendorid = '$vid'";

    $sql = "INSERT into '$uid'(pid,vid,place,discount)
            VALUES('$pid','$vid',$goal+1,'$discount')";

    $conn->query($sql);

    $response = array('status' => 200, 'message' => 'Success', 'pid' => $pid, 'vid' => $vid, 'uid' => $uid);
  } else {
    $response = array('status' => 400, 'message' => 'Could not find Item');
  }
?>
