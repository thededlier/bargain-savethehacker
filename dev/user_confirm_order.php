<?php
    include './cors.php';

    $uid = $_REQUEST["uid"];
    $pid = $_REQUEST["pid"];
    $vemail = $_REQUEST["vemail"];

    $sql = "UPDATE bargainbin set reach = reach + 1, uids = CONCAT(uids,'$uid,')  where pid = '$pid' and vemail = '$vemail'";

    if($conn->query($sql));
        $response = array('status' => 200, 'message' => 'Updated');
    } else {
        $response = array('status' => 400, 'message' => 'Failed');
    }

    echo array(json_encode($response));
?>
