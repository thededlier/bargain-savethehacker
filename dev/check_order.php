<?php
    include './cors.php';

    $uid = $_REQUEST["uid"];
    $pid = $_REQUEST["pid"];
    $vemail = $_REQUEST["vemail"];
    $check = false;
    $sql = "SELECT * from bargainbin where pid = '$pid' and vemail = '$vemail'";

    $result = $conn->query($sql);

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $uid_list = explode(",", $row["uids"]);

        foreach ($uid_list as $id) {
            if($uid === $id) {
                $check = true;
                break;
            }
        }
    }
    if($check == true) {
        $response = array('status' => 200, 'message' => 'success', 'check' => 1);
    } else {
        $response = array('status' => 200, 'message' => 'success', 'check' => 0);
    }

    echo json_encode($response);
?>
