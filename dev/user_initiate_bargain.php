<?php
    include './cors.php';
    
    $uid = $_POST["uid"];
    $pid = $_POST["pid"];
    $discount = $_POST["discount"];

    $sql = "SELECT * from discounts where uid = '$uid' and pid = '$pid'";

    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $sql = "UPDATE discounts set discount = $discount where uid = '$uid' and pid = '$pid'";
        $conn->query($sql);
        $response = array('status' => 200, 'message' => 'Updated');
    } else {
        $sql = "INSERT INTO discounts(pid,uid,discount) values('$pid', '$uid', $discount)";
        $response = array('status' => 200, 'message' => 'Inserted');
        $conn->query($sql);
    }

    echo array(json_encode($response));
?>
