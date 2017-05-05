<?php
  include '../cors.php';
  include '../credentials.php';

  $sql = "SELECT * from bargain_items where status=1 order by starttime limit 10";

  $result = $conn->query($sql);

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $r[] = $row;
    }
  }

  echo json_encode($r);
?>
