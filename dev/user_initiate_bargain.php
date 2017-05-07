<?php
    include './cors.php';

    $uid = $_REQUEST["uid"];
    $pid = $_REQUEST["pid"];
    $discount = $_REQUEST["discount"];

    $sql = "INSERT INTO discounts(pid,uid,discount) values('$pid', $uid, $discount)";

    if($conn->query($sql)) {
        $response = array('status' => 200, 'message' => 'success', 'discount' => $discount);
    } else {
        $response = array('status' => 200, 'message' => 'fail');
    }

    echo json_encode($response);
?>
